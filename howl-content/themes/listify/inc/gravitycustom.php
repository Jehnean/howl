<?php 
// update the "1" to the ID of your form
add_action( 'gform_after_submission_1', 'launch_flexible_modal', 10, 2 );
function launch_flexible_modal(){ ?>
    
    <script type="text/javascript">
    jQuery(document).ready(function($){
        
        if($('#gforms_confirmation_message_1').length != 0) {
            
        $('#flexFormModal').modal('show')
            
        }
        
    });
    </script>
    
    <?php
}

add_action( 'gform_after_submission_2', 'launch_contact_modal', 10, 2 );
function launch_contact_modal(){ ?>
    
    <script type="text/javascript">
    jQuery(document).ready(function($){
        
        if($('#gforms_confirmation_message_2').length != 0) {
            
        $('#callModal').modal('show')
            
        }
        
    });
    </script>
    
    <?php
}

add_filter( 'gform_submit_button_3', 'add_paragraph_below_submit', 10, 2 );
function add_paragraph_below_submit( $button, $form ) {

    return $button .= "<div class='terms-condition-wrapper'><p>By clicking Match Me With Pros, you agree to the <a href='/terms-of-service/'>Terms & Conditions</a>.</p></div>";
}


/**
 * Fix Gravity Form Tabindex Conflicts
 * http://gravitywiz.com/fix-gravity-form-tabindex-conflicts/
 */
add_filter( 'gform_tabindex', 'gform_tabindexer', 10, 2 );
function gform_tabindexer( $tab_index, $form = false ) {
    $starting_index = 1000; // if you need a higher tabindex, update this number
    if( $form )
        add_filter( 'gform_tabindex_' . $form['id'], 'gform_tabindexer' );
    return GFCommon::$tab_index >= $starting_index ? GFCommon::$tab_index : $starting_index;
}

/**
* Merge Tags as Dynamic Population Parameters
* http://gravitywiz.com/use-merge-tags-as-dynamic-population-parameters/
*/
add_filter('gform_pre_render', 'gw_prepopluate_merge_tags');
function gw_prepopluate_merge_tags($form) {
    
    $filter_names = array();
    
    foreach($form['fields'] as &$field) {
        
        if(!rgar($field, 'allowsPrepopulate'))
            continue;
        
        // complex fields store inputName in the "name" property of the inputs array
        if(is_array(rgar($field, 'inputs')) && $field['type'] != 'checkbox') {
            foreach($field['inputs'] as $input) {
                if(rgar($input, 'name'))
                    $filter_names[] = array('type' => $field['type'], 'name' => rgar($input, 'name'));
            }
        } else {
            $filter_names[] = array('type' => $field['type'], 'name' => rgar($field, 'inputName'));
        }
        
    }
    
    foreach($filter_names as $filter_name) {
        
        $filtered_name = GFCommon::replace_variables_prepopulate($filter_name['name']);
        
        if($filter_name['name'] == $filtered_name)
            continue;
        
        add_filter("gform_field_value_{$filter_name['name']}", create_function("", "return '$filtered_name';"));
    }
    
    return $form;
}

// add_filter( 'gform_get_input_value_2_3', 'get_feedback_phone_number', 10, 4 );
// function get_feedback_phone_number($fields){
//   return $fields;
// }

/**
* Gravity Wiz // Multi-File Merge Tag for Post Content Templates
* 
* Enhance the merge tag for multi-file upload fields by adding support for outputting markup that corresponds to the 
* uploaded file. Example: image files will be wrapped in an <img> tag. Out of the box, this snippet only supports 
* images and is limited to the 'jpg', 'png', and 'gif'.
* 
* The default merge tag for the multi-file upload field will output the URL for each of the files.
* 
* @version   1.2
* @author    David Smith <david@gravitywiz.com>
* @license   GPL-2.0+
* @link      http://gravitywiz.com/...
* @copyright 2013 Gravity Wiz
*/
class GW_Multi_File_Merge_Tag {
    
    private static $instance = null;
    /**
     * Temporarily stores the values of the 'gform_merge_tag_filter' filter for use in the 'gform_replace_merge_tags' filter.
     *
     * @var array
     */
    private $_merge_tag_args = array();
    private $_settings = array();
    
    private function __construct() {
        add_filter( 'gform_pre_replace_merge_tags', array( $this, 'replace_merge_tag' ), 10, 7 );
    }
    
    public static function get_instance() {
        
        if( null == self::$instance )
            self::$instance = new self;
            
        return self::$instance;
    }
    public function get_default_args() {
        return array(
            'form_id' => false,
            'exclude_forms' => array(),
            'default_markup' => '<li><a href="{url}">{filename}.{ext}</a></li>',
            'markup' => array(
                array(
                    'file_types' => array( 'jpg', 'png', 'gif', 'jpeg' ),
                    'markup' => '<img src="{url}" width="33%" />'
                ),
                array(
                    'file_types' => array( 'mp4', 'ogg', 'webm' ),
                    'markup' => '<video width="320" height="240" controls>
                                    <source src="{url}" type="video/{ext}">
                                    Your browser does not support the video tag.
                                 </video>'
                ),
                array(
                    'file_types' => array( 'ogv' ),
                    'markup' => '<video width="320" height="240" controls>
                                    <source src="{url}" type="video/ogg">
                                    Your browser does not support the video tag.
                                 </video>'
                )
            )
        );
    }
    public function register_settings( $args = array() ) {
        $args = wp_parse_args( $args, $this->get_default_args() );
        if( ! $args['form_id'] ) {
            $this->_settings['global'] = $args;
        } else {
            $this->_settings[$args['form_id']] = $args;
        }
    }
    
    public function replace_merge_tag( $text, $form, $entry, $url_encode, $esc_html, $nl2br, $format ) {
        preg_match_all( '/{[^{]*?:(\d+(\.\d+)?)(:(.*?))?}/mi', $text, $matches, PREG_SET_ORDER );
        
        foreach( $matches as $match ) {
            
            $input_id = $match[1];
            $field = GFFormsModel::get_field( $form, $input_id );
            
            if( ! $this->is_applicable_field( $field ) )
                continue;
            
            if( $format != 'html' ) {
                
                $value = $this->_merge_tag_args['value'];
                
            } else {
              if( $entry['id'] == null && is_callable( array( 'GWPreviewConfirmation', 'preview_image_value' ) ) ) {
                $files = GWPreviewConfirmation::preview_image_value( 'input_' . $field->id, $field, $form, $entry );
              } else {
                $value = GFFormsModel::get_lead_field_value( $entry, $field );
                $files = empty( $value ) ? array() : json_decode( $value, true );
              }
                $value = '';
                foreach( $files as &$file ){
                    $value .= $this->get_file_markup( $file, $form['id'] );
                }
                
            }
            
            $text = str_replace( $match[0], $value, $text );
            
        }
        return $text;
    }
    
    public function get_file_markup( $file, $form_id ) {
        
        $value = str_replace( " ", "%20", $file );
        $file_info = pathinfo( $value );
        
        extract( $file_info ); // gives us $dirname, $basename, $extension, $filename
        if( ! $extension )
            return $value;
        $markup_settings = $this->get_markup_settings( $form_id );
        if( empty( $markup_settings ) )
            return $value;
        $markup_found = false;
        foreach( $markup_settings as $file_type_markup ) {
            $file_types = array_map( 'strtolower', $file_type_markup['file_types'] );
            if( ! in_array( strtolower( $extension ), $file_types ) )
                continue;
            $markup_found = true;
            $markup = $file_type_markup['markup'];
            $tags = array(
                '{url}' => $file,
                '{filename}' => $filename,
                '{basename}' => $basename,
                '{ext}' => $extension
            );
            foreach( $tags as $tag => $tag_value ) {
                $markup = str_replace( $tag, $tag_value, $markup );
            }
            $value = $markup;
            break;
        }
        if( ! $markup_found && $default_markup = $this->get_default_markup( $form_id ) ) {
            $tags = array(
                '{url}' => $file,
                '{filename}' => $filename,
                '{basename}' => $basename,
                '{ext}' => $extension
            );
            foreach( $tags as $tag => $tag_value ) {
                $default_markup = str_replace( $tag, $tag_value, $default_markup );
            }
            $value = $default_markup;
        }
        
        return $value;
    }
    public function get_markup_settings( $form_id ) {
        $form_markup_settings = rgars( $this->_settings, "$form_id/markup" ) ? rgars( $this->_settings, "$form_id/markup" ) : array();
        $global_markup_settings = rgars( $this->_settings, 'global/markup' ) ? rgars( $this->_settings, 'global/markup' ) : array();
        return array_merge( $form_markup_settings, $global_markup_settings );
    }
    public function get_default_markup( $form_id ) {
        $default_markup = rgars( $this->_settings, "$form_id/default_markup" );
        if( ! $default_markup )
            $default_markup = rgars( $this->_settings, 'global/default_markup' );
        return $default_markup;
    }
    public function is_excluded_form( $form_id ) {
        $has_global_settings = isset( $this->_settings['global'] );
        $excluded_forms = (array) rgars( $this->_settings, 'global/exclude_forms' );
        $explicity_excluded = $has_global_settings && in_array( $form_id, $excluded_forms );
        $passively_excluded = ! $has_global_settings && ! isset( $this->_settings[$form_id] );
        return $explicity_excluded || $passively_excluded;
    }
    public function is_applicable_field( $field ) {
        $is_valid_form = ! $this->is_excluded_form( $field['formId'] );
        $is_file_upload_filed = GFFormsModel::get_input_type( $field ) == 'fileupload';
        $is_multi = rgar( $field, 'multipleFiles' );
        return $is_valid_form && $is_file_upload_filed && $is_multi;
    }
    
}
function gw_multi_file_merge_tag() {
    return GW_Multi_File_Merge_Tag::get_instance();
}

gw_multi_file_merge_tag()->register_settings();

// add custom post statuses to the post status drop down on the Properties tab of post fields.
// https://www.gravityhelp.com/documentation/article/gform_post_status_options/
add_filter( 'gform_post_status_options', 'add_custom_post_status' );
function add_custom_post_status( $post_status_options ) {
    $post_status_options['ongoing'] = 'Ongoing';
    $post_status_options['paused'] = 'Paused';
    $post_status_options['completed'] = 'Completed';
    unset( $post_status_options['draft'] );
    unset( $post_status_options['published'] );
    unset( $post_status_options['pending_review'] );    
    return $post_status_options;
    // print_r($post_status_options);
}
