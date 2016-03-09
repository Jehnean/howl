<?php

function custom_login() {
  echo '<link rel="stylesheet" href="'. get_template_directory_uri() .'/inc/assets/login.css">';
  // echo '<script src="'. get_template_directory_uri() .'/inc/assets/packages/branding/assets/login.js"></script>';
}
add_action('login_head', 'custom_login');

function change_wp_login_title()  {
    echo get_option('blogname'); // OR ECHO YOUR OWN ALT TEXT
}
add_filter('login_headertitle', 'change_wp_login_title');

// disable default dashboard widgets
function disable_default_dashboard_widgets() {

  // remove_meta_box('dashboard_right_now', 'dashboard', 'core');
  remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
  remove_meta_box('dashboard_plugins', 'dashboard', 'core');
  remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
  remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
  remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
  remove_meta_box('dashboard_primary', 'dashboard', 'core');
  remove_meta_box('dashboard_secondary', 'dashboard', 'core');
}
if (!current_user_can('manage_options')) {
        add_action('admin_menu', 'disable_default_dashboard_widgets');
}
add_action('admin_menu', 'disable_default_dashboard_widgets');

// Add a widget in WordPress Dashboard
// function atmosphere_dashboard_widget_function() {
//   // Entering the text between the quotes
//   echo "
//   <ul>
//     <li>Release Date: March 21, 2015</li>
//     <li>Author: Sevenality</li>
//   </ul>
  
//   ";
// }
// function atmosphere_add_dashboard_widgets() {
//   wp_add_dashboard_widget('wp_dashboard_widget', 'Technical information', 'atmosphere_dashboard_widget_function');
// }
// add_action('wp_dashboard_setup', 'atmosphere_add_dashboard_widgets' );


// ADD CUSTOM POST TYPES TO THE 'RIGHT NOW' DASHBOARD WIDGET
function wph_right_now_content_table_end() {
 $args = array(
  'public' => true ,
  '_builtin' => false
 );
 $output = 'object';
 $operator = 'and';
 $post_types = get_post_types( $args , $output , $operator );
 foreach( $post_types as $post_type ) {
  $num_posts = wp_count_posts( $post_type->name );
  $num = number_format_i18n( $num_posts->publish );
  $text = _n( $post_type->labels->singular_name, $post_type->labels->name , intval( $num_posts->publish ) );
  if ( current_user_can( 'edit_posts' ) ) {
   $num = "<a href='edit.php?post_type=$post_type->name'>$num</a>";
   $text = "<a href='edit.php?post_type=$post_type->name'>$text</a>";
  }
  echo '<tr><td class="first num b b-' . $post_type->name . '">' . $num . '</td>';
  echo '<td class="text t ' . $post_type->name . '">' . $text . '</td></tr>';
 }
 $taxonomies = get_taxonomies( $args , $output , $operator );
 foreach( $taxonomies as $taxonomy ) {
  $num_terms  = wp_count_terms( $taxonomy->name );
  $num = number_format_i18n( $num_terms );
  $text = _n( $taxonomy->labels->singular_name, $taxonomy->labels->name , intval( $num_terms ));
  if ( current_user_can( 'manage_categories' ) ) {
   $num = "<a href='edit-tags.php?taxonomy=$taxonomy->name'>$num</a>";
   $text = "<a href='edit-tags.php?taxonomy=$taxonomy->name'>$text</a>";
  }
  echo '<tr><td class="first b b-' . $taxonomy->name . '">' . $num . '</td>';
  echo '<td class="t ' . $taxonomy->name . '">' . $text . '</td></tr>';
 }
}
add_action( 'right_now_content_table_end' , 'wph_right_now_content_table_end' );

// spam & delete links for all versions of wordpress
function delete_comment_link($id) {
    if (current_user_can('edit_post')) {
        echo '| <a href="'.get_bloginfo('wpurl').'/wp-admin/comment.php?action=cdc&c='.$id.'">del</a> ';
        echo '| <a href="'.get_bloginfo('wpurl').'/wp-admin/comment.php?action=cdc&dt=spam&c='.$id.'">spam</a>';
    }
}

// Custom WordPress Footer
// function remove_footer_admin () {
//   echo '&copy; 2009 - 2015 | Sevenality, LLC';
// }
// add_filter('admin_footer_text', 'remove_footer_admin');