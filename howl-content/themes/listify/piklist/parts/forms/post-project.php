<?php
/*  
Title: Post a Project
Method: post
Message: Data saved.
Redirect: /customer-dashboard/
*/


// Where to save this form
piklist('field', array(
  'type' => 'hidden',
  'scope' => 'post',
  'field' => 'post_type',
  'value' => 'customer_projects' // post type form should be saved to
  )
);


// Rest of your form boxes....

 piklist('field', array(
   'type' => 'text'
   ,'scope' => 'post_meta'
   ,'field' => 'project_type'
   ,'label' => __('What service do you need help with?')
   ,'description' => __('')
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
   ,'description' => __('')
   ,'attributes' => array(
     'class' => 'text'
   )
   ,'position' => 'wrap'
 ));



 piklist('field', array(
   'type' => 'select'
   ,'scope' => 'user_meta'
   ,'field' => 'billing_state'
   ,'label' => __('State')
   ,'description' => __('')
    ,'choices' => array(
      'Florida' => __('Florida', 'howl')
      ,'Alabama' => __('Second Choice', 'howl')
      ,'third' => __('Third Choice', 'howl')
    )
 ));

 piklist('field', array(
   'type' => 'textarea'
   ,'scope' => 'post'
   ,'field' => 'post_content'
   ,'label' => __('what seems to be happening?')
   ,'description' => __('')
   ,'attributes' => array(
     'class' => 'project-description-text'
   )
   ,'position' => 'wrap'
 ));

 piklist('field', array(
  'type' => 'file'
  ,'field' => 'upload_media'
  ,'scope' => 'post_meta'
  ,'label' => __('Add File(s)','howl')
  ,'description' => __('','howl')
  ,'options' => array(
    'modal_title' => __('Add File(s)','howl')
    ,'button' => __('Add','howl')
  )
));

piklist('field', array(
  'type' => 'submit',
  'field' => 'submit',
  'value' => 'Submit'
));

// set post status on save
piklist(
  'field', array(
    'scope' => 'post',
    'type'  => 'hidden',
    'field' => 'post_status',
    'value' => 'ongoing'
  ) 
);