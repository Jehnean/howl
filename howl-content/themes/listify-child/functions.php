<?php
/**
 * Listify child theme.
 */

function listify_child_styles() {
  wp_enqueue_style( 'listify-child', get_stylesheet_uri() );
  $deps = array( 'jquery' );

  // wp_dequeue_script('listify');
  // wp_deregister_script( 'listify' );
  // wp_enqueue_script( 'da-js', get_stylesheet_directory_uri() . '/js/app2.js', $deps, 20141204, true );
}
add_action( 'wp_enqueue_scripts', 'listify_child_styles', 999 );

/** Place any new code below this line */

/**
 * Plugin Name: Listify - Disable Default Google Fonts and Enqueue Custom
 */

function custom_listify_fonts() {
  wp_dequeue_style( 'listify-fonts' );
  
  wp_enqueue_style( 'listify-custom-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400,600' );
}
add_action( 'wp_enqueue_scripts', 'custom_listify_fonts', 20 );

// add_filter( 'wp_edit_nav_menu_walker', 'sample_edit_nav_menu_walker');
// function sample_edit_nav_menu_walker( $walker ) {
//     return 'Walker_Nav_Menu_Edit_Roles'; // this is the class name
// }

// add_action('wp_enqueue_scripts', 'listify_script_override', 100);

// function listify_script_override() {
//   $deps = array( 'jquery' );

//   wp_dequeue_script('listify');
//   wp_enqueue_script( 'listify-child-js', get_template_directory_uri() . '/js/app.min.js', $deps, 20141204, true );
// }