<?php 

add_filter('piklist_post_types', 'customer_pojects_post_type');

 function customer_pojects_post_type($post_types)
 {
  $post_types['customer_projects'] = array(
    'labels' => piklist('post_type_labels', 'Customer Projects')
    ,'title' => __('Enter a new Project')
    ,'public' => true
    ,'rewrite' => array(
      'slug' => 'customer_pojects'
    )
    ,'capability_type' => 'post'
    // ,'menu_icon' => plugins_url('piklist/parts/img/piklist-icon.png')
    ,'status' => array(
      'draft' => array(
        'label' => 'Draft'
      )
      ,'ongoing' => array(
        'label' => 'Ongoing'
      )
      ,'completed' => array(
        'label' => 'Completed'
      )
      ,'paused' => array(
        'label' => 'Paused'
      )
    )
    ,'supports' => array(
      'author'
      ,'editor'
      ,'thumbnail'
      ,'excerpt'
      ,'revisions'
      ,'comments'
      ,'commentstatus'
    )
    ,'hide_meta_box' => array(
      'slug'
    )
  );
return $post_types;
}

