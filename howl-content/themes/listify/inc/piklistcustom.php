<?php
/**
 * Custom Piklist.
 */

// Add a custom parameter to the Piklist comment block.
add_filter('piklist_get_file_data', 'hide_metabox_comment_block', 10, 2);
function hide_metabox_comment_block($data, $type) {
  // If not a Meta-box section than bail
  if($type != 'meta-boxes') {
    return $data;
  }
 
  // Allow Piklist to read our custom comment block attribute: "Hide for Template", and set it to hide_for_template
  $data['hide_for_template'] = 'Hide for Template';
 
  return $data;
}