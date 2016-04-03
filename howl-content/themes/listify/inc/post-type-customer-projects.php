<?php 

// add_filter('piklist_post_types', 'customer_pojects_post_type');

//  function customer_pojects_post_type($post_types)
//  {
//   $post_types['customer_projects'] = array(
//     'labels' => piklist('post_type_labels', 'Customer Projects')
//     ,'title' => __('Enter a new Project')
//     ,'public' => true
//     ,'rewrite' => array(
//       'slug' => 'customer_pojects'
//     )
//     ,'capability_type' => 'post'
//     // ,'menu_icon' => plugins_url('piklist/parts/img/piklist-icon.png')
//     ,'status' => array(
//       'draft' => array(
//         'label' => 'Draft'
//       )
//       ,'ongoing' => array(
//         'label' => 'Ongoing'
//       )
//       ,'completed' => array(
//         'label' => 'Completed'
//       )
//       ,'paused' => array(
//         'label' => 'Paused'
//       )
//     )
//     ,'supports' => array(
//       'author'
//       ,'editor'
//       ,'thumbnail'
//       ,'excerpt'
//       ,'revisions'
//       ,'comments'
//       ,'commentstatus'
//     )
//     ,'hide_meta_box' => array(
//       'slug'
//     )
//   );
// return $post_types;
// }

function custom_post_status_ongoing(){
  register_post_status( 'ongoing', array(
    'label'                     => _x( 'Ongoing', 'customer_projects' ),
    'public'                    => true,
    'exclude_from_search'       => false,
    'show_in_admin_all_list'    => true,
    'show_in_admin_status_list' => true,
    'label_count'               => _n_noop( 'Ongoing <span class="count">(%s)</span>', 'Ongoing <span class="count">(%s)</span>' ),
  ) );
}
add_action( 'init', 'custom_post_status_ongoing' );

function custom_post_status_paused(){
  register_post_status( 'paused', array(
    'label'                     => _x( 'Paused', 'customer_projects' ),
    'public'                    => true,
    'exclude_from_search'       => false,
    'show_in_admin_all_list'    => true,
    'show_in_admin_status_list' => true,
    'label_count'               => _n_noop( 'Paused <span class="count">(%s)</span>', 'Paused <span class="count">(%s)</span>' ),
  ) );
}
add_action( 'init', 'custom_post_status_paused' );

function custom_post_status_completed(){
  register_post_status( 'completed', array(
    'label'                     => _x( 'Completed', 'customer_projects' ),
    'public'                    => true,
    'exclude_from_search'       => false,
    'show_in_admin_all_list'    => true,
    'show_in_admin_status_list' => true,
    'label_count'               => _n_noop( 'Completed <span class="count">(%s)</span>', 'Completed <span class="count">(%s)</span>' ),
  ) );
}
add_action( 'init', 'custom_post_status_completed' );

// add_action('admin_footer-post.php', 'jc_append_post_status_list');
// function jc_append_post_status_list(){
//  global $post;
//  $complete = '';
//  $label = '';
//  if($post->post_type == 'customer_projects'){
//   if($post->post_status == 'ongoing'){
//    $complete = ' selected=\"selected\"';
//    $label = '<span id=\"post-status-display\"> Ongoing</span>';
//   }
//   echo '
//   <script>
//   jQuery(document).ready(function($){
//        $("select#post_status").append("<option value=\"ongoing\" '.$complete.'>Ongoing</option>");
//        $(".misc-pub-section label").append("'.$label.'");
//   });
//   </script>
//   ';
//   }
// }
