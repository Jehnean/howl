<?php 

/*
Title: Post Project Meta Fields
Post type: customer_projects
Priority: high
Order: 1

*/

// Let's create a text box field
 piklist('field', array(
   'type' => 'text'
   ,'scope' => 'post_meta'
   ,'field' => 'project_type'
   ,'label' => __('What service do you need help with?')
   ,'description' => __('Field Description')
   ,'attributes' => array(
     'class' => 'text'
   )
   ,'position' => 'wrap'
 ));

 piklist('field', array(
   'type' => 'text'
   ,'scope' => 'user_meta'
   ,'field' => 'billing_address_1'
   ,'label' => __('Street Address')
   ,'description' => __('Field Description')
   ,'attributes' => array(
     'class' => 'text'
   )
   ,'position' => 'wrap'
 ));

 piklist('field', array(
   'type' => 'text'
   ,'scope' => 'user_meta'
   ,'field' => 'billing_state'
   ,'label' => __('State')
   ,'description' => __('Field Description')
   ,'attributes' => array(
     'class' => 'text'
   )
   ,'position' => 'wrap'
 )); 


 piklist('field', array(
  'type' => 'file'
  ,'field' => 'upload_media'
  ,'scope' => 'post_meta'
  ,'label' => __('Would you like to share any pictures','piklist')
  ,'description' => __('','piklist')
  ,'options' => array(
    'modal_title' => __('Add images(s)','piklist')
    ,'button' => __('Add','piklist')
  )
));
?>
