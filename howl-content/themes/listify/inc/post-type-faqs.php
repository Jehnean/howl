<?php 

add_filter('piklist_post_types', 'faqs_post_type');

function faqs_post_type($post_types) {
  $post_types['faq'] = array(
    'labels' => piklist('post_type_labels', 'Faqs')
    ,'title' => __('Add new Faq')
    ,'public' => true
    ,'rewrite' => array(
      'slug' => 'faq'
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

add_filter('piklist_taxonomies', 'howl_faq_taxonomies');
function howl_faq_taxonomies($taxonomies) {
  $taxonomies[] = array(
    'post_type' => 'faq'
    ,'name' => 'customer-faq'
    ,'configuration' => array(
      'hierarchical' => false
      ,'labels' => piklist('taxonomy_labels', 'Customer Faq')
      ,'show_ui' => true
      ,'public' => true
      ,'query_var' => true
      ,'rewrite' => array(
        'slug' => 'demo-type'
      )      
      ,'show_admin_column' => true
      ,'list_table_filter' => true
      ,'meta_box_filter' => true
      ,'comments' => true
    )
  );

  $taxonomies[] = array(
    'post_type' => 'faq'
    ,'name' => 'pro-faq'
    ,'configuration' => array(
      'hierarchical' => false
      ,'labels' => piklist('taxonomy_labels', 'Professional Faq')
      ,'show_ui' => true
      ,'query_var' => true
      ,'show_admin_column' => true
      ,'list_table_filter' => true
      ,'meta_box_filter' => true
      ,'comments' => true
    )
  );

  return $taxonomies;
}