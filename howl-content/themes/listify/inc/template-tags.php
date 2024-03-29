<?php
/**
 * Custom template tags for this theme.
 *
 * If the function is called directly in the theme or via
 * another function, it is wrapped to check if a child theme has
 * redefined it. Otherwise a child theme can unhook what is being attached.
 *
 * @package Listify
 */

function listify_is_widgetized_page() {
	$widgetized = false;

	$page_templates = apply_filters( 'listify_widgetized_page_templates', array(
		'page-templates/template-home.php',
		'page-templates/template-home-vc.php',
		'page-templates/template-home-slider.php',
		'page-templates/template-widgetized.php',
	) );

	foreach ( $page_templates as $template ) {
		if ( is_page_template( $template ) ) {
			$widgetized = true;

			break;
		}
	}

	return apply_filters( 'listify_is_widgetized_page', $widgetized );
}

/**
 * Check if we ar on a WP Job Manager page.
 *
 * This needs to be outside of the integration since it's called
 * in standard template files.
 *
 * @since Listify 1.0.0
 *
 * @return boolean
 */
function listify_is_job_manager_archive() {
	if ( ! listify_has_integration( 'wp-job-manager' ) ) {
		return false;
	}

	$page = ( is_singular() && has_shortcode( get_post()->post_content, 'jobs' ) ) || is_page_template( 'page-templates/template-archive-job_listing.php' );

	$cpt = is_post_type_archive( 'job_listing' );

	$single = is_singular( 'job_listing' );

	$tax = array(
		'job_listing_category',
		'job_listing_tag',
		'job_listing_type',
		'job_listing_region'
	);

	$tax = is_tax( $tax );

	$search = is_search() && isset( $_GET[ 'listings' ] );

	return ( $page || $cpt || /*$single ||*/ $tax || $search );
}

function listify_job_listing_archive_has_sidebar() {
	global $listify_job_manager;

	$sidebar = is_active_sidebar( 'archive-job_listing' );
	$map     = 'side' == $listify_job_manager->map->template->position();
	$facetwp = false;

	if ( listify_has_integration( 'facetwp' ) ) {
		global $listify_facetwp;

		if ( 'side' == $listify_facetwp->template->position() ) {
			$facetwp = true;
		}
	}

	if (
		$sidebar ||
		$facetwp ||
		has_action( 'listify_sidebar_archive_job_listing_after' ) &&
		! $map
	) {
		return true;
	}

	return false;
}

function listify_get_top_level_taxonomy() {
	$categories_enabled = get_option( 'job_manager_enable_categories' );
	$categories_only = listify_theme_mod( 'categories-only' );

	if ( $categories_enabled && $categories_only ) {
		$tax = 'job_listing_category';
	} else {
		$tax = 'job_listing_type';
	}

	return $tax;
}

if ( ! function_exists( 'listify_get_theme_menu' ) ) :
/**
 * Get a nav menu object.
 *
 * @uses get_nav_menu_locations To get all available locations
 * @uses get_term To get the specific theme location
 *
 * @since Listify 1.0.0
 *
 * @param string $theme_location The slug of the theme location
 * @return object $menu_obj The found menu object
 */
function listify_get_theme_menu( $theme_location ) {
	$theme_locations = get_nav_menu_locations();

	if( ! isset( $theme_locations[$theme_location] ) )
		return false;

	$menu_obj = get_term( $theme_locations[$theme_location], 'nav_menu' );

	if( ! $menu_obj )
		return false;

	return $menu_obj;
}
endif;

if ( ! function_exists( 'listify_get_theme_menu_name' ) ) :
/**
 * Get a nav menu name
 *
 * @uses listify_get_theme_menu To get the menu object
 *
 * @since Listify 1.0.0
 *
 * @param string $theme_location The slug of the theme location
 * @return string The name of the nav menu location
 */
function listify_get_theme_menu_name( $theme_location ) {
	$menu_obj = listify_get_theme_menu( $theme_location );
	$default  = _x( 'Menu', 'noun', 'listify' );

	if( ! $menu_obj )
		return $default;

	if( ! isset( $menu_obj->name ) )
		return $default;

	return $menu_obj->name;
}
endif;

function listify_get_days_of_week() {
	$days = array(0, 1, 2, 3, 4, 5, 6);
	$start = get_option( 'start_of_week' );

	$first = array_splice( $days, $start, count( $days ) - $start );
	$second = array_splice( $days, 0, $start );
	$days = array_merge( $first, $second );

	return $days;
}

if ( ! function_exists( 'listify_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentytwelve_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Listify 1.0.0
 */
function listify_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	global $post;
?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>" itemprop="review" itemscope itemtype="http://schema.org/Review">
		<article id="comment-<?php comment_ID(); ?>" class="comment row">
			<header class="comment-author vcard col-md-2 col-sm-3 col-xs-12">
				<?php do_action( 'listify_comment_author_start', $comment ); ?>

				<?php echo get_avatar( $comment, 100 ); ?>

				<?php do_action( 'listify_comment_author_end', $comment ); ?>
			</header><!-- .comment-meta -->

			<section class="comment-content comment col-md-10 col-sm-9 col-xs-12">
				<?php
					$user_id = $comment->user_id;
					printf( '<cite itemprop="author" itemscope itemtype="http://schema.org/Person"><b class="fn" itemprop="name">%1$s</b> %2$s</cite>',
						$user_id > 0 ? '<a href="' . get_author_posts_url( $comment->user_id ) . '">' . get_comment_author() . '</a>' : get_comment_author(),
						'job_listing' == $post->post_type ?
							( $comment->user_id === $post->post_author ) ? '<span class="listing-owner">' . __( 'Listing Owner', 'listify' ) . '</span>' : ''
						: ''
					);
				?>

				<div class="comment-meta">
					<?php comment_reply_link( array_merge( $args, array( 'reply_text' => '<i class="ion-ios-chatboxes-outline"></i>', 'after' => ' ', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

					<?php edit_comment_link( __( '<span class="ion-edit"></span>', 'listify' ) ); ?>
				</div>

				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'listify' ); ?></p>
				<?php endif; ?>

				<div itemprop="reviewBody"><?php comment_text(); ?></div>

				<?php
					printf( '<a href="%1$s" class="comment-ago"><time datetime="%2$s" itemprop="datePublished">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						sprintf( __( '%s ago', 'listify' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) )
					);
				?>
			</section><!-- .comment-content -->
		</article><!-- #comment-## -->
	<?php
}
endif;

if ( ! function_exists( 'listify_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function listify_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'listify' ); ?></h1>

		<?php
			$big = 999999999;

			echo paginate_links( array(
				'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'  => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total'   => $wp_query->max_num_pages
			) );
		?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif;

// function howl_get_pagination($args = null) {
//   global $wp_query;
    
//   // Custom pagination query
//   // Otherwise WP would display pages in the pagination that have nothing
  
//   $total_pages = $wp_query->max_num_pages;
//   $big = 999999999; // need an unlikely integer
//   $translated = __( 'Page', 'atmosphere' ); // Supply translatable string

//   $paginate_links = paginate_links( array(
//     'base' => add_query_arg('paged','%#%'),
//     'format' => '?paged=%#%',
//     'current' => max( 1, get_query_var('paged') ),
//     'total' => $wp_query->max_num_pages,
//     'type' => 'list',
//     'prev_text' => 'Previous',
//     'next_text' => 'Next',
//     // 'before_page_number' => '<span class="screen-reader-text">'.$translated.' </span>'
//   ));    

//   $paginate_links = str_replace( "<ul class='page-numbers'>", "<ul class='pagination text-center'>", $paginate_links );
//   $paginate_links = str_replace( '<li><span class="page-numbers dots">', "<li><a href='#'>", $paginate_links );
//   $paginate_links = str_replace( "<li><span class='page-numbers current'>", "<li class='current'><a href='#'>", $paginate_links );
//   $paginate_links = str_replace( '</span>', '</a>', $paginate_links );
//   $paginate_links = str_replace( "<li><a href='#'>&hellip;</a></li>", "<li><span class='dots'>&hellip;</span></li>", $paginate_links );
//   $paginate_links = preg_replace( '/\s*page-numbers/', '', $paginate_links );    

// // Display the pagination if more than one page is found.
//   if ( $paginate_links ) {
//     echo '<div class="pagination-centered">';
//     echo $paginate_links;
//     echo '</div><!--// end .pagination -->';
//   } 
    
// }