<?php
/**
 * Listify functions and definitions
 *
 * @package Listify
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 750;

if ( ! function_exists( 'listify_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Listify 1.0.0
 *
 * @return void
 */
function listify_setup() {
	/**
	 * Translations can be filed in the /languages/ directory.
	 */
	$locale = apply_filters( 'plugin_locale', get_locale(), 'listify' );
	load_textdomain( 'listify', WP_LANG_DIR . "/listify-$locale.mo" );
	load_theme_textdomain( 'listify', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Let WP set the title
	 */
	add_theme_support( 'title-tag' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu (header)', 'listify' ),
		// 'secondary' => __( 'Secondary Menu', 'listify' ),
		// 'tertiary' => __( 'Tertiary Menu', 'listify' ),
		'mini-menu'  => __( 'Mini Menu', 'listify' ),
		'social'  => __( 'Social Menu (footer)', 'listify' ),
		'footer1' => __( 'Footer Menu 1', 'listify' ),
		'footer2' => __( 'Footer Menu 2', 'listify' ),
		'footer3' => __( 'Footer Menu 3', 'listify' ),
		'footer4' => __( 'Footer Menu 4', 'listify' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'commentlist', 'gallery', 'caption'
	) );

	/**
	 * Editor Style
	 */
	add_editor_style( 'css/editor-style.css' );

	/**
	 * Setup the WordPress core custom background feature.
	 */
	add_theme_support( 'custom-background', apply_filters( 'listify_custom_background_args', array(
		'default-color' => 'f0f3f6',
		'default-image' => '',
	) ) );

	/**
	 * Post thumbnails
	 */
	set_post_thumbnail_size( 100, 100, true );
}
endif;
add_action( 'after_setup_theme', 'listify_setup' );

/**
 * Sidebars and Widgets
 *
 * @since Listify 1.0.0
 *
 * @return void
 */
function listify_widgets_init() {
	register_widget( 'Listify_Widget_Ad' );
	register_widget( 'Listify_Widget_Features' );
	register_widget( 'Listify_Widget_Feature_Callout' );

	/* Standard Sidebar */
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'listify' ),
		'id'            => 'widget-area-sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	/* Custom Homepage */
	register_sidebar( array(
		'name'          => __( 'Homepage', 'listify' ),
		'description'   => __( 'Widgets that appear on the "Homepage" Page Template', 'listify' ),
		'id'            => 'widget-area-home',
		'before_widget' => '<aside id="%1$s" class="home-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="home-widget-section-title"><h2 class="home-widget-title">',
		'after_title'   => '</h2></div>',
	) );

	/* Find Professionals */
	register_sidebar( array(
		'name'          => __( 'Find Professionals', 'listify' ),
		'description'   => __( 'Widgets that appear on the "Find Professionals" Page Template', 'listify' ),
		'id'            => 'widget-area-findpro',
		'before_widget' => '<aside id="%1$s" class="home-widget find-pro-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="home-widget-section-title find-pro-widget"><h2 class="home-widget-title find-pro-widget">',
		'after_title'   => '</h2></div>',
	) );

	/* Footer Column 1 */
	register_sidebar( array(
		'name'          => __( 'Footer Column 1', 'listify' ),
		'id'            => 'widget-area-footer-1',
		'before_widget' => '<aside id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="footer-widget-title">',
		'after_title'   => '</h4>',
	) );

	/* Footer Column 2 */
	register_sidebar( array(
		'name'          => __( 'Footer Column 2', 'listify' ),
		'id'            => 'widget-area-footer-2',
		'before_widget' => '<aside id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="footer-widget-title">',
		'after_title'   => '</h4>',
	) );

	/* Footer Column 3 */
	register_sidebar( array(
		'name'          => __( 'Footer Column 3', 'listify' ),
		'id'            => 'widget-area-footer-3',
		'before_widget' => '<aside id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="footer-widget-title">',
		'after_title'   => '</h4>',
	) );

	/* Footer Column 4 */
	register_sidebar( array(
		'name'          => __( 'Footer Column 4', 'listify' ),
		'id'            => 'widget-area-footer-4',
		'before_widget' => '<aside id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="footer-widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'listify_widgets_init' );

/**
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of Source Sans Pro and Varela Round by default is localized. For languages
 * that use characters not supported by the font, the font can be disabled.
 *
 * @since Listify 1.0.0
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function listify_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Montserrat, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$montserrat = _x( 'on', 'Montserrat font: on or off', 'listify' );

	if ( 'off' !== $montserrat ) {
		$font_families = array();

		if ( 'off' !== $montserrat )
			$font_families[] = apply_filters( 'listify_font_montserrat', 'Montserrat:400,700' );

		$query_args = array(
			'family' => urlencode( implode( '|', apply_filters( 'listify_font_families', $font_families ) ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = esc_url_raw( add_query_arg( $query_args, "//fonts.googleapis.com/css" ) );
	}

	return $fonts_url;
}

/**
 * Load fonts in TinyMCE
 *
 * @since Listify 1.0.0
 *
 * @return string $css
 */
function listify_mce_css( $css ) {
	$css .= ', ' . listify_fonts_url();

	return $css;
}
add_filter( 'mce_css', 'listify_mce_css' );

/**
 * Scripts and Styles
 *
 * Load Styles and Scripts depending on certain conditions. Not all assets
 * will be loaded on every page.
 *
 * @since Listify 1.0.0
 *
 * @return void
 */
function listify_scripts() {
	/*
	 * Styles
	 */
	do_action( 'listify_output_customizer_css' );

	/* Supplimentary CSS */
	wp_enqueue_style( 'listify-fonts', listify_fonts_url() );

	/* Custom CSS */
	wp_enqueue_style( 'listify', get_template_directory_uri() . '/css/style.min.css', array(), 20151124 );
	wp_style_add_data( 'listify', 'rtl', 'replace' );

	/* Output customizer CSS after theme CSS */
	$listify_customizer_css = new Listify_Customizer_CSS();
	$listify_customizer_css->output();

	/*
	 * Scripts
	 */

	/* Comments */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	$deps = array( 'jquery' );

	if ( listify_has_integration( 'wp-job-manager-regions' ) && get_option( 'job_manager_regions_filter' ) ) {
		$deps[] = 'job-regions';
	}

	wp_enqueue_script( 'listify', get_template_directory_uri() . '/js/app.min.js', $deps, 20141204, true );
	wp_enqueue_script( 'salvattore', get_template_directory_uri() . '/js/vendor/salvattore.min.js', array(), '', true );

	wp_localize_script( 'listify', 'listifySettings', apply_filters( 'listify_js_settings', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'homeurl' => home_url( '/' ),
		'archiveurl' => get_post_type_archive_link( 'job_listing' ),
        'is_job_manager_archive' => listify_is_job_manager_archive(),
        'megamenu' => array(
            'taxonomy' => listify_theme_mod( 'nav-megamenu' )
        ),
		'l10n' => array(
			'closed' => __( 'Closed', 'listify' ),
			'timeFormat' => get_option( 'time_format' )
		)
	) ) );
}
add_action( 'wp_enqueue_scripts', 'listify_scripts' );

/**
 * Adds custom classes to the array of body classes.
 */
function listify_body_classes( $classes ) {
	global $wp_query, $post;

	if ( is_page_template( 'page-templates/template-archive-job_listing.php' ) ) {
		$classes[] = 'template-archive-job_listing';
	}

	if ( listify_is_widgetized_page() ) {
		$classes[] = 'template-home';
	}

	if (
		is_page_template( 'page-templates/template-full-width-blank.php' ) ||
		( isset( $post ) && has_shortcode( get_post()->post_content, 'jobs' ) )
	) {
		$classes[] = 'unboxed';
	}

	if ( is_singular() && get_post()->enable_tertiary_navigation ) {
		$classes[] = 'tertiary-enabled';
	}

	if ( listify_theme_mod( 'fixed-header' ) ) {
		$classes[] = 'fixed-header';
	}

	if ( listify_theme_mod( 'custom-submission' ) ) {
		$classes[] = 'directory-fields';
	}

	$classes[] = 'color-scheme-' . sanitize_title( listify_theme_mod( 'color-scheme' ) );

	$classes[] = 'footer-' . listify_theme_mod( 'footer-display' );

	$theme = wp_get_theme( 'listify' );

	if ( $theme->get( 'Name' ) ) {
		$classes[] = sanitize_title( $theme->get( 'Name' ) );
		$classes[] = sanitize_title( $theme->get( 'Name' ) . '-' . str_replace( '.', '', $theme->get( 'Version' ) ) );
	}

	return $classes;
}
add_filter( 'body_class', 'listify_body_classes' );

/**
 * Adds custom classes to the array of post classes.
 */
function listify_post_classes( $classes ) {
	global $post;

	if (
		in_array( $post->post_type, array( 'post', 'page' ) ) ||
		is_search() &&
		! has_shortcode( $post->post_content, 'jobs' )
	) {
		$classes[] = 'content-box content-box-wrapper';
	}

	return $classes;
}
add_filter( 'post_class', 'listify_post_classes' );

/**
 * "Cover" images for pages and other content.
 *
 * If on an archive the current query will be used. Otherwise it will
 * look for a single item's featured image or an image from its gallery.
 *
 * @since Listify 1.0.0
 *
 * @param string $class
 * @return string $atts
 */
function listify_cover( $class, $args = array() ) {
	$defaults = apply_filters( 'listify_cover_defaults', array(
		'images' => false,
		'object_ids' => false,
		'size' => 'large'
	) );

	$args  = wp_parse_args( $args, $defaults );
	$image = false;
	$atts  = array();

	global $post, $wp_query;

	// special for WooCommerce
	if ( ( function_exists( 'is_shop' ) && is_shop() ) || is_singular( 'product' )) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( wc_get_page_id( 'shop' ) ), $args[ 'size' ] );
	} else if ( is_home() && ! in_the_loop() ) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_option( 'page_for_posts' ) ), $args[ 'size' ] );
	} else if ( ( ! did_action( 'loop_start' ) && is_archive() ) || ( $args[ 'images' ] || $args[ 'object_ids' ] ) ) {
		$image = listify_get_cover_from_group( $args );
	} else if ( is_a( $post, 'WP_Post' ) ) {
		if ( ! listify_has_integration( 'wp-job-manager' ) || has_post_thumbnail( $post->ID ) ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id(), $args[ 'size' ] );
		} else  {
			$gallery = Listify_WP_Job_Manager_Gallery::get( $post->ID );

			$args[ 'images' ] = $gallery;
			unset( $args[ 'object_ids' ] );

			if ( $gallery ) {
				$image = listify_get_cover_from_group( $args );
			}
		}
	}

	$image = apply_filters( 'listify_cover_image', $image, $args );

	if ( ! $image ) {
		$class .= ' no-image';

		return sprintf( 'class="%s"', $class );
	}

	$class .= ' has-image';

	$atts[] = sprintf( 'style="background-image: url(%s);"', $image[0] );
	$atts[] = sprintf( 'class="%s"', $class );

	return implode( ' ', $atts );
}
add_filter( 'listify_cover', 'listify_cover', 10, 2 );

/**
 * Get a cover image from a "group" (WP_Query or array of IDS)
 *
 * @see listify_cover()
 *
 * @since Listify 1.0.0
 *
 * @param array|object $group
 * @return array $image
 */
function listify_get_cover_from_group( $args ) {
	$image = false;

	if ( empty( $args[ 'object_ids' ] ) && ( ! isset( $args[ 'images' ] ) || empty( $args[ 'images' ] ) ) ) {
		global $wp_query, $wpdb;

		if ( empty( $wp_query->posts ) ) {
			return $image;
		}

		$args[ 'object_ids' ] = wp_list_pluck( $wp_query->posts, 'ID' );
	}

	if ( ( ! isset( $args[ 'images' ] ) || empty( $args[ 'images' ] ) ) && ( isset( $args[ 'object_ids' ] ) && ! empty( $args[ 'object_ids' ] ) ) ) {

		$objects_key = md5( json_encode( $args[ 'object_ids' ] ) );

		if ( false === ( $image = get_transient( $objects_key ) ) ) {
			global $wpdb;

			$args[ 'object_ids' ] = implode( ',', $args[ 'object_ids' ] );
			$ids = $args[ 'object_ids' ];

			$published = $wpdb->get_results( "SELECT ID FROM $wpdb->posts WHERE post_status = 'publish' and ID IN ($ids)" );

			if ( empty( $published ) ) {
				return $image;
			}

			$published = wp_list_pluck( $published, 'ID' );

			$attachments = new WP_Query( array(
				'post_parent__in' => $published,
				'post_type' => 'attachment',
				'post_status' => 'inherit',
				'fields' => 'ids',
				'posts_per_page' => 1,
				'orderby' => 'rand',
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
				'no_found_rows' => true
			) );

			if ( $attachments->have_posts() ) {
				$image = wp_get_attachment_image_src( $attachments->posts[0], $args[ 'size' ] );

				if ( file_exists( $image[0] ) ) {
					set_transient( $objects_key, $image, 3 * HOUR_IN_SECONDS );
				}
			}
		}
	} elseif ( isset( $args[ 'images' ] ) && ! empty( $args[ 'images' ] ) ) {
		shuffle( $args[ 'images' ] );

		$image = wp_get_attachment_image_src( current( $args[ 'images' ] ), $args[ 'size' ] );
	}

	return $image;
}

/**
 * Count the number of posts for a specific user.
 *
 * @since Listify 1.0.0
 *
 * @param string $post_type
 * @param int $user_id
 * @return int $count
 */
function listify_count_posts( $post_type, $user_id ) {
	global $wpdb;

	if ( false === ( $count = get_transient( $post_type . $user_id ) ) ) {
		$count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_author = '$user_id' AND post_type = '$post_type' and post_status = 'publish'" );

		set_transient( $post_type . $user_id, $count );
	}

	return $count;
}

/**
 * Check if a specific integration is active.
 *
 * @since Listify 1.0.0
 *
 * @param string $integration
 * @return boolean
 */
function listify_has_integration( $integration ) {
	return array_key_exists( $integration, Listify_Integration::get_integrations() );
}

/** Standard Includes */
$includes = array(
	'class-activation.php',
	'customizer/class-customizer.php',
	'class-setup.php',
	'class-navigation.php',
	'class-strings.php',
	'class-tgmpa.php',
	'class-integration.php',
	'class-widget.php',
	'class-page-settings.php',
	'class-widgetized-pages.php',
	'class-search.php',
	'widgets/class-widget-ad.php',
	'widgets/class-widget-home-features.php',
	'widgets/class-widget-home-feature-callout.php',
	'custom-header.php',
	'template-tags.php',
	'gravitycustom.php',
	'extras.php',
	'branding.php',
	'woocustom.php',
	'post-type-customer-projects.php',
	'post-type-faqs.php',
	'api-faq.php'
);

foreach ( $includes as $file ) {
	require( get_template_directory() . '/inc/' . $file );
}

/** Integrations */
$integrations = apply_filters( 'listify_integrations', array(
	'wp-job-manager' => defined( 'JOB_MANAGER_VERSION' ),
	'wp-job-manager-bookmarks' => defined( 'JOB_MANAGER_BOOKMARKS_VERSION' ),
	'wp-job-manager-wc-paid-listings' => defined( 'JOB_MANAGER_WCPL_VERSION' ),
	'wp-job-manager-tags' => defined( 'JOB_MANAGER_TAGS_PLUGIN_URL' ),

	'wp-job-manager-field-editor' => defined( 'WPJM_FIELD_EDITOR_VERSION' ),

	'wp-job-manager-regions' => class_exists( 'Astoundify_Job_Manager_Regions' ),
	'wp-job-manager-reviews' => class_exists( 'WP_Job_Manager_Reviews' ),
	'wp-job-manager-products' => class_exists( 'WP_Job_Manager_Products' ),
	'wp-job-manager-claim-listing' => class_exists( 'WP_Job_Manager_Claim_Listing' ),

	'woocommerce' => class_exists( 'Woocommerce' ),
	'woocommerce-bookings' => class_exists( 'WC_Bookings' ),

	'facetwp' => class_exists( 'FacetWP' ),
	'jetpack' => defined( 'JETPACK__VERSION' ),
	'polylang' => defined( 'POLYLANG_VERSION' ),

	'ratings' => true
) );

foreach ( $integrations as $file => $dependancy ) {
	if ( $dependancy ) {
		require( get_template_directory() . sprintf( '/inc/integrations/%1$s/class-%1$s.php', $file ) );
	}
}


function findpros_autocomplete_init() {
    // Register our jQuery UI style and our custom javascript file
				wp_enqueue_script( 'jquery' );
				wp_enqueue_script( 'jquery-ui-autocomplete' );
				wp_register_style( 'jquery-ui-styles',get_template_directory_uri() . '/js/jquery-ui.css' );
				wp_enqueue_style(  'jquery-ui-styles' );
				wp_register_script( 'findpros-autocomplete', get_template_directory_uri() . '/js/findpros-autocomplete.js', array( 'jquery', 'jquery-ui-autocomplete' ), '1.0', false );

				wp_localize_script( 'findpros-autocomplete', 'FindPros', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
				wp_enqueue_script( 'findpros-autocomplete' );
}

add_action( 'wp_enqueue_scripts', 'findpros_autocomplete_init' );

function findpros_search() {
		$term = strtolower( $_GET['term'] );
		$pros = array();
		$terms = get_terms("project_tags", array(
			"name__like" => $term,
			"hide_empty" => false
		));
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
		    foreach ( $terms as $term ) {
										$pro = array();
		        $pro["label"] = htmlspecialchars_decode($term->name);
		        $pro["link"] = get_term_link( $term );
										$pros[] = $pro;
		    }
		}

 	$response = json_encode( $pros );
 	echo $response;
 	exit();

}

add_action( 'wp_ajax_findpros_search', 'findpros_search' );
add_action( 'wp_ajax_nopriv_findpros_search', 'findpros_search' );


add_filter( 'gform_field_value_project_tags', 'populate_project_tags' );
function populate_project_tags( $value ) {
			if(isset($_POST)){
					if(!empty($_POST)){
							if(isset($_POST["search_keywords"])){
									if(!empty($_POST["search_keywords"])){
											$value = $_POST["search_keywords"];
									}
							}
					}
			}

			return $value;

}

add_filter( 'gform_field_value_street_address', 'populate_street_address' );
function populate_street_address( $value ) {
			if(isset($_POST)){
					if(!empty($_POST)){
							if(isset($_POST["street_address"])){
									if(!empty($_POST["street_address"])){
											$value = $_POST["street_address"];
									}
							}
					}
			}

			return $value;
}


add_filter( 'gform_field_value_address_line_2', 'populate_address_line_2' );
function populate_address_line_2( $value ) {
			if(isset($_POST)){
					if(!empty($_POST)){
							if(isset($_POST["address_line_2"])){
									if(!empty($_POST["address_line_2"])){
											$value = $_POST["address_line_2"];
									}
							}
					}
			}

			return $value;

}


add_filter( 'gform_field_value_city', 'populate_city' );
function populate_city( $value ) {
			if(isset($_POST)){
					if(!empty($_POST)){
							if(isset($_POST["city"])){
									if(!empty($_POST["city"])){
											$value = $_POST["city"];
									}
							}
					}
			}

			return $value;

}


add_filter( 'gform_field_value_state', 'populate_state' );
function populate_state( $value ) {
			if(isset($_POST)){
					if(!empty($_POST)){
							if(isset($_POST["state"])){
									if(!empty($_POST["state"])){
											$value = $_POST["state"];
									}
							}
					}
			}
			return $value;
}


add_filter( 'gform_field_value_zip', 'populate_zip' );
function populate_zip( $value ) {
			if(isset($_POST)){
					if(!empty($_POST)){
							if(isset($_POST["zip"])){
									if(!empty($_POST["zip"])){
											$value = $_POST["zip"];
									}
							}
					}
			}
			return $value;
}


add_filter( 'gform_field_value_country', 'populate_country' );
function populate_country( $value ) {
			if(isset($_POST)){
					if(!empty($_POST)){
							if(isset($_POST["country"])){
									if(!empty($_POST["country"])){
											$value = $_POST["country"];
									}
							}
					}
			}
			return $value;
}

add_action( 'show_user_profile', 'user_business_image' );
add_action( 'edit_user_profile', 'user_business_image' );

function user_business_image( $user ) { ?>

	<h3>Business Image</h3>

	<table class="form-table">

		<tr>
			<th><label for="business_image">Business Image</label></th>
			<td>
				<input disabled type="text" name="business_image" id="business_image" value="<?php echo esc_attr( get_the_author_meta( 'business_image', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Business Image.</span>
			</td>
		</tr>

	</table>
<?php }

add_action( 'show_user_profile', 'user_coordinates_fields' );
add_action( 'edit_user_profile', 'user_coordinates_fields' );

function user_coordinates_fields( $user ) { ?>
	<?php
	$lat = esc_attr( get_the_author_meta( 'lat', $user->ID ) );
	$lon = esc_attr( get_the_author_meta( 'lon', $user->ID ) );

	$street_address = get_user_meta( $user->ID, 'billing_address_1', true);
	$street_address = ($street_address) ? $street_address : "";
	$city = get_user_meta( $user->ID, 'billing_city', true);
	$city = ($city) ? $city : "";
	$zip = get_user_meta( $user->ID, 'billing_postcode', true);
	$zip = ($zip) ? $zip : "";
	$state = get_user_meta( $user->ID, 'billing_state', true);
	$state = ($state) ? $state : "";

	if(!empty($street_address) && !empty($city) && !empty($state)  && !empty($zip)){
    $full_address = $street_address . ", " . $city . ", " . $state  . ", " . $zip;
    $use_address = urlencode($full_address);
    $request_url = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$use_address."&sensor=true";
    $xml = simplexml_load_file($request_url);
    //sleep(1);
    if(!empty($xml)){
      $status = $xml->status;
      if ($status=="OK") {
        $lat = (string)$xml->result->geometry->location->lat;
        $lon = (string)$xml->result->geometry->location->lng;

					if($lat){
						update_user_meta( $user->ID, 'lat', $lat);
					}

					if($lon){
						update_user_meta( $user->ID, 'lon', $lon);
					}

      }
    }
  }

	?>
	<h3>Coordinates</h3>

	<table class="form-table">

		<tr>
			<th><label for="lat">Latitude</label></th>
			<td>
				<input disabled type="text" name="lat" id="lat" value="<?php echo $lat; ?>" class="regular-text" /><br />
				<span class="description">Latitude generated by address.</span>
			</td>
		</tr>

		<tr>
			<th><label for="lon">Longitude</label></th>
			<td>
				<input disabled type="text" name="lon" id="lon" value="<?php echo $lon; ?>" class="regular-text" /><br />
				<span class="description">Longitude generated by address.</span>
			</td>
		</tr>

	</table>
<?php }

add_action( 'show_user_profile', 'user_business_metrics' );
add_action( 'edit_user_profile', 'user_business_metrics' );

function user_business_metrics( $user ) { ?>

	<h3>Metric</h3>

	<table class="form-table">

		<tr>
			<th><label for="review_count">Reviews</label></th>
			<td>
				<input disabled type="text" name="review_count" id="review_count" value="<?php echo esc_attr( get_the_author_meta( 'review_count', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">review count</span>
			</td>
		</tr>

		<tr>
			<th><label for="rating">Rating</label></th>
			<td>
				<input disabled type="text" name="rating" id="rating" value="<?php echo esc_attr( get_the_author_meta( 'rating', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">rating</span>
			</td>
		</tr>

	</table>
<?php }

function convert_yelp_to_howl($business, $category){
	$user = array();
	$business_name = $business->name;
	$business_phone = $business->phone;
	$business_rating = $business->rating;
	$business_review_count = $business->review_count;
	$business_image = $business->image_url;
	$business_image = media_sideload_image($business_image, false, false, "src");
	$business_category = $category;
	$business_category_slug = false;
	// if(!empty($business->categories)){
	// 	if(!empty($business->categories[0])){
	// 		if(!empty($business->categories[0][0])){
	// 			$business_category = $business->categories[0][0];
	// 		}
	// 		if(!empty($business->categories[0][1])){
	// 			$business_category_slug = $business->categories[0][1];
	// 		}
	// 	}
	// }

	$business_address = false;
	$business_city = false;
	$business_state = false;
	$business_zip = false;
	$business_lat = false;
	$business_lon = false;
	$business_location = $business->location;
	if(!empty($business_location)){
		$b_address = $business_location->address;
		if(!empty($b_address)){
			if(!empty($b_address[0])){
				$business_address = $b_address[0];
			}
		}
		if(!empty($business_location->city)){
			$business_city = $business_location->city;
		}
		if(!empty($business_location->state_code)){
			$business_state = $business_location->state_code;
		}
		if(!empty($business_location->postal_code)){
			$business_zip = $business_location->postal_code;
		}
		$business_coords = $business_location->coordinate;
		if(!empty($business_coords)){
			if(!empty($business_coords->latitude)){
				$business_lat = $business_coords->latitude;
			}
			if(!empty($business_coords->longitude)){
				$business_lon = $business_coords->longitude;
			}
		}
	}

	$business_phone = !empty($business->phone) ? $business->phone : false;

	$user[0] = $business_category;
	$user[1] = $business_category;
	$user[2] = $business_name;
	$user[3] = $business_address;
	$user[4] = $business_city;
	$user[5] = $business_state;
	$user[6] = $business_zip;
	$user[7] = $business_phone;
	$user[8] = false; // yelp doesnt provide email
	$user[9] = $business_lat;
	$user[10] = $business_lon;
	$user[11] = $business_rating;
	$user[12] = $business_review_count;
	$user[13] = $business_image;
	//die(var_export(array($user[9], $user[10])));
	return $user;
}

function username_abbrv($business_name){
  $clean_business = preg_replace("/[^A-Za-z0-9 ]/", '', $business_name);
  $lwr_clean_business = strtolower($clean_business);
  $username = "";
  $tmp_username = explode(" ", $lwr_clean_business);
  foreach ($tmp_username as $words_of_business) {
    $username .= substr($words_of_business, 0, 3);
  }
  return $username;
}

function howl_create_user($newuser, $try){
	$sl = $newuser[0];
	$category = $newuser[1];
	$business_name = $newuser[2];
	$street_address = $newuser[3];
	$city = $newuser[4];
	$state = $newuser[5];
	$zip = $newuser[6];
	$phone_number = $newuser[7];
	$email = ($newuser[8]) ? $newuser[8] : "";
	$lat = $newuser[9];
	$lon = $newuser[10];
	$business_rating = $newuser[11];
	$business_review_count = $newuser[12];
	$business_image = $newuser[13];
	//die(var_export(array($lat, $lon)));

  $user_name = username_abbrv($business_name);

  /*if($try > 1){
    $user_name = $user_name . $try;
  }*/

  //if(!username_exists($user_name) ) {

    // Generate the password and create the user
    $password = wp_generate_password( 12, false );

    $user_custom_fields = array(
      'nickname'          => $user_name,
      'first_name'          => $business_name,
      'company_category'  => !empty($category) ? $category : $sl
    );

    if(empty($email)){
      $user_id = wp_create_user( $user_name, $password);
    }else{
      if(email_exists($email)){
        $user_id = wp_create_user( $user_name, $password);
      }else{
        $user_id = wp_create_user( $user_name, $password, $email );
      }
    }

    $user_custom_fields['ID'] = $user_id;

    wp_update_user($user_custom_fields);
		 update_user_meta( $user_id, 'billing_company', $business_name);
		 update_user_meta( $user_id, 'shipping_company', $business_name);

		 if(!empty($street_address)){
			 	update_user_meta( $user_id, 'billing_address_1', $street_address);
    }

    if(!empty($city)){
			 	update_user_meta( $user_id, 'billing_city', $city);
    }

    if(!empty($zip)){
			 	update_user_meta( $user_id, 'billing_postcode', $zip);
    }

    if(!empty($state)){
			 	update_user_meta( $user_id, 'billing_state', $state);
    }

    if(!empty($phone_number)){
			 	update_user_meta( $user_id, 'billing_phone', $phone_number);
    }

    if(!empty($email)){
      update_user_meta( $user_id, 'billing_email', $email);
    }

		 if(!empty($lat)){
			 	update_user_meta( $user_id, 'lat', $lat);
    }

		 if(!empty($lon)){
			 	update_user_meta( $user_id, 'lon', $lon);
    }

		 if(!empty($business_review_count)){
				update_user_meta( $user_id, 'review_count', $business_review_count);
    }

		 if(!empty($business_rating)){
				update_user_meta( $user_id, 'rating', $business_rating);
    }

		 if(!empty($business_image)){
				update_user_meta( $user_id, 'business_image', $business_image);
    }


    // Set the role
    $user = new WP_User( $user_id );
    $user->set_role("professional");

  //}
  /*else{
    $try = $try++;
    import_howl_create_user($newuser, $try);
  }*/
}


function display_client_dashboard_pro($business){
	// echo "<pre>";
	// var_export($business);
	// echo "</pre>";
  $name = $business["billing_company"];
	 $html = "";
  if(strlen($name) > 23){
    $name = mb_strimwidth($name, 0, 22, "...");
  }
  $image_url = !empty($business["business_image"]) ? $business["business_image"] : get_template_directory_uri() . '/images/user-default.png';
  $rating = $business["rating"];
  $rating_img_url = get_template_directory_uri() . '/images/stars/'. $rating . '.png';
  $review_count = $business["reviews"];
  $id = $business["ID"];
  $distance = $business["distance"];
  $html .= "<div class='client-dashboard-pro'>";
  $html .= "<img class='pro-image' src='" . $image_url . "'/>";
  $html .= "<h4>" . $name . "</h4>";
  $html .= "<img src='" . $rating_img_url . "'/>";
  $html .= "<p>" . $review_count . " reviews</h4>";
  $html .= "</div>";
	 return $html;
}

function display_client_dashboard_5_pro($businesses){
	// echo "<pre>";
	// var_export($businesses);
	// echo "</pre>";
	// //die();
	if($businesses){
		$html = "";
   $html .= "<div class='client-dashboard-pro-container'>";
   foreach ($businesses as $business) {
     $html .= display_client_dashboard_pro($business);
   }
   $html .= "<div class='clearfix'></div>";
   $html .= "</div>";
 		return $html;
	}
}

function save_howl_pro($business, $category){
	$newuser = convert_yelp_to_howl($business, $category);
	howl_create_user($newuser, 1);
}

function save_howl_pros($businesses, $category){
	if($businesses){
   foreach ($businesses as $business) {
     save_howl_pro($business, $category);
   }
	}
}

add_action( 'wp_ajax_nopriv_save_dashboard_pros', 'save_dashboard_pros' );
add_action( 'wp_ajax_save_dashboard_pros', 'save_dashboard_pros' );

function save_dashboard_pros() {
	$html = "";

	$query_vars = json_decode( stripslashes( $_POST['query_vars'] ), true );

	$query_vars['paged'] = $_POST['page'];

	$action = sanitize_text_field($_POST['action']);
	$postId = sanitize_text_field($_POST['postId']);
	$current_user = sanitize_text_field($_POST['currentUser']);
	$projectType = sanitize_text_field($_POST['projectType']);
	$location = sanitize_text_field($_POST['location']);

	if($action === "save_dashboard_pros"){
		 if(!empty($postId)){
					$how_query = howl_query_api($projectType, $location);
					$businesses = $how_query->businesses;
					save_howl_pros($businesses, $projectType);
					//$encoded_business = wp_slash(json_encode($businesses));
					global $wpdb;
		 			$lat = get_user_meta( $current_user, 'lat', true);
					$lat = ($lat) ? $lat : 0;
		 			$lon = get_user_meta( $current_user, 'lon', true);
					$lon = ($lon) ? $lon : 0;
	      $ssql = "SELECT u1.ID,
	           m1.meta_value AS billing_company,
	           m2.meta_value AS lat,
	           m3.meta_value AS lon,
	           m4.meta_value AS subscription,
	           m5.meta_value AS rating,
	           m6.meta_value AS reviews,
	           m7.meta_value AS business_image,
	           m8.meta_value AS company_category,
	           ( 3959 * acos( cos( radians(".$lat.") ) * cos( radians( m2.meta_value ) ) * cos( radians( m3.meta_value ) - radians(".$lon.") ) + sin( radians(".$lat.") ) * sin( radians( m2.meta_value ) ) ) ) AS distance
	      FROM hwl_users u1
	      JOIN hwl_usermeta m1 ON (m1.user_id = u1.ID AND m1.meta_key = 'billing_company')
	      JOIN hwl_usermeta m2 ON (m2.user_id = u1.ID AND m2.meta_key = 'lat')
	      JOIN hwl_usermeta m3 ON (m3.user_id = u1.ID AND m3.meta_key = 'lon')
	      JOIN hwl_usermeta m4 ON (m4.user_id = u1.ID AND m4.meta_key = 'hwl_capabilities')
	      JOIN hwl_usermeta m5 ON (m5.user_id = u1.ID AND m5.meta_key = 'rating')
	      JOIN hwl_usermeta m6 ON (m6.user_id = u1.ID AND m6.meta_key = 'review_count')
	      JOIN hwl_usermeta m7 ON (m7.user_id = u1.ID AND m7.meta_key = 'business_image')
	      JOIN hwl_usermeta m8 ON (m8.user_id = u1.ID AND m8.meta_key = 'company_category')
	      WHERE m4.meta_key = 'hwl_capabilities' AND m4.meta_value LIKE '%professional%'" .
	      "AND m8.meta_key = 'company_category'".
					"AND m8.meta_value LIKE '%".$projectType."%'" .
	      "ORDER BY distance
	      LIMIT 0 , 5";

					$closest_business = $wpdb->get_results($ssql, ARRAY_A);
					$has_saved_meta = update_post_meta($postId, 'pro_options', $closest_business);

					$pros = get_post_meta($postId, 'pro_options', true);
					$html .= display_client_dashboard_5_pro($pros);
			}
	}

	die($html);
}


/* Howl Custom functions */

//  function post_project_template_redirect() {
//     if( is_page( 'post-a-project' ) && ! is_user_logged_in() ) {
//         wp_redirect( home_url( '/sign-up/' ) );
//         exit();
//     }
// }
// add_action( 'template_redirect', 'post_project_template_redirect' );
