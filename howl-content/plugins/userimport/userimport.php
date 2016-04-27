<?php
/*
Plugin Name: User Import
Plugin URI:  http://howl.co/
Description: Import user and designate to group
Version:     1.0
Author:      Toybox Media
Author URI:  http://toyboxmedia.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: howl
*/
ini_set('memory_limit', '1000M');

add_action('admin_menu', 'userimport_menu');

function html_upload_csv(){ ?>
 <h3><?php echo __('Upload CSV'); ?></h3>

 <form class="form" action="" method="post" enctype="multipart/form-data">
  <table class="form-table">
  	<tbody>
     <tr><td width="80%"><input type="file" name="file" id="file"/><input class="button-primary" type="submit" name="submit"/></td></tr>
    </tbody>
   </table>
 </form>
<?php
}


function import_username_abbrv($business_name){
  $clean_business = preg_replace("/[^A-Za-z0-9 ]/", '', $business_name);
  $lwr_clean_business = strtolower($clean_business);
  $username = "";
  $tmp_username = explode(" ", $lwr_clean_business);
  foreach ($tmp_username as $words_of_business) {
    $username .= substr($words_of_business, 0, 3);
  }
  return $username;
}

function html_user_table_head($num, $trow){
 /*SL,Category,Business Name,Street Address,City,State ,Zip,PhoneNumber,Email,*/
 $num_th = "Number";
 $sl_th = $trow[0];
 $category_th = $trow[1];
 $business_name_th = $trow[2];
 $user_name_th = "User Name";
 $street_address_th = $trow[3];
 $city_th = $trow[4];
 $state_th = $trow[5];
 $zip_th = $trow[6];
 $phone_number_th = $trow[7];
 $email_th = $trow[8];

 $mc = "manage-column column-";
 echo "<thead><tr>";
 echo "<th class='" . $mc . "num column-primary'>" . $num_th . "</th>";
 echo "<th class='" . $mc . "sl'>" . $sl_th . "</th>";
 echo "<th class='" . $mc . "last-name'>" . $category_th . "</th>";
 echo "<th class='" . $mc . "business-name'>" . $business_name_th . "</th>";
 echo "<th class='" . $mc . "user-name'>" . $user_name_th . "</th>";
 echo "<th class='" . $mc . "street-address'>" . $street_address_th . "</th>";
 echo "<th class='" . $mc . "city'>" . $city_th . "</th>";
 echo "<th class='" . $mc . "state'>" . $state_th . "</th>";
 echo "<th class='" . $mc . "zip'>" . $zip_th . "</th>";
 echo "<th class='" . $mc . "phone-number'>" . $phone_number_th . "</th>";
 echo "<th class='" . $mc . "email'>" . $email_th . "</th>";
 echo "</tr></thead>";
}

function html_user_table_head_json(){
 $mc = "manage-column column-";
 echo "<thead><tr>";
 echo "<th class='" . $mc . "num column-primary'>#</th>";
 echo "<th class='" . $mc . "sl'>SL</th>";
 echo "<th class='" . $mc . "category'>Category</th>";
 echo "<th class='" . $mc . "business-name'>Business Name</th>";
 echo "<th class='" . $mc . "user-name'>Username</th>";
 echo "<th class='" . $mc . "street-address'>Street</th>";
 echo "<th class='" . $mc . "city'>City</th>";
 echo "<th class='" . $mc . "state'>State</th>";
 echo "<th class='" . $mc . "zip'>Zip</th>";
 echo "<th class='" . $mc . "phone-number'>Phone</th>";
 echo "<th class='" . $mc . "email'>Email</th>";
 echo "</tr></thead>";
}

function html_user_table_body($num, $trow, $total){
 $sl = $trow[0];
 $category = $trow[1];
 $business_name = $trow[2];
 $user_name = "";
 $user_name = import_username_abbrv($business_name);
 $street_address = $trow[3];
 $city = $trow[4];
 $state = $trow[5];
 $zip = $trow[6];
 $phone_number = $trow[7];
 $email = $trow[8];

 $rowstyle = "";
 $tdstyle = "";
 $error_html = "";
 if(email_exists($email)){
   $rowstyle = "background-color: #FFEBEB !important;";
   $tdstyle = "border: 1px solid red; background-color: pink !important; position: relative;";
   $error_html = "<span style='";
   $error_html .= "margin:2px;padding:2px; background-color:red; color: white; position:absolute;";
   $error_html .= "top: 3px; right: 0;";
   $error_html .= "'>email exists</span>";
 }
 if($num == 1) echo "<tbody>";
 echo "<tr style='".$rowstyle."'>";
 echo "<td>" . $num . "</td>";
 echo "<td>" . $sl . "</td>";
 echo "<td>" . $category . "</td>";
 echo "<td>" . $business_name . "</td>";
 echo "<td><pre>" . $user_name . "</pre></td>";
 echo "<td>" . $street_address . "</td>";
 echo "<td>" . $city . "</td>";
 echo "<td>" . $state . "</td>";
 echo "<td>" . $zip . "</td>";
 echo "<td>" . $phone_number . "</td>";
 echo "<td style='".$tdstyle."'>" . $error_html . $email . "</td>";
 echo "</tr>";
 if($num == $total) echo "</tbody>";
}

function html_user_table_body_json($num, $trow, $total){

 $sl = $trow["sl"];
 $category = $trow["category"];
 $business_name = $trow["businessName"];
 $user_name = "";
 $user_name = import_username_abbrv($business_name);
 $street_address = $trow["streetAddress"];
 $city = $trow["city"];
 $state = $trow["state"];
 $zip = $trow["zip"];
 $phone_number = $trow["phonenumber"];
 $email = $trow["email"];

 $rowstyle = "";
 $tdstyle = "";
 $error_html = "";
 if(email_exists($email)){
   $rowstyle = "background-color: #FFEBEB !important;";
   $tdstyle = "border: 1px solid red; background-color: pink !important; position: relative;";
   $error_html = "<span style='";
   $error_html .= "margin:2px;padding:2px; background-color:red; color: white; position:absolute;";
   $error_html .= "top: 3px; right: 0;";
   $error_html .= "'>email exists</span>";
 }
 if($num == 1) echo "<tbody>";
 echo "<tr style='".$rowstyle."'>";
 echo "<td>" . $num . "</td>";
 echo "<td>" . $sl . "</td>";
 echo "<td>" . $category . "</td>";
 echo "<td>" . $business_name . "</td>";
 echo "<td><pre>" . $user_name . "</pre></td>";
 echo "<td>" . $street_address . "</td>";
 echo "<td>" . $city . "</td>";
 echo "<td>" . $state . "</td>";
 echo "<td>" . $zip . "</td>";
 echo "<td>" . $phone_number . "</td>";
 echo "<td style='".$tdstyle."'>" . $error_html . $email . "</td>";
 echo "</tr>";
 if($num == $total) echo "</tbody>";
}



function import_howl_create_user($newuser, $try){
	$sl = $newuser[0];
	$category = $newuser[1];
	$business_name = $newuser[2];
	$street_address = $newuser[3];
	$city = $newuser[4];
	$state = $newuser[5];
	$zip = $newuser[6];
	$phone_number = $newuser[7];
	$email = ($newuser[8]) ? $newuser[8] : "";
	$lat = false;
	$lon = false;
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
      }
    }
  }

  $user_name = import_username_abbrv($business_name);

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

    update_user_meta( $user_id, 'review_count', 0);
    update_user_meta( $user_id, 'rating', 3);


    // Set the role
    $user = new WP_User( $user_id );
    $user->set_role("professional");

  //}
  /*else{
    $try = $try++;
    import_howl_create_user($newuser, $try);
  }*/
}

function import_howl_create_user_json($newuser, $try){
  $sl = $trow["sl"];
  $category = $trow["category"];
  $business_name = $trow["businessName"];
  $street_address = $trow["streetAddress"];
  $city = $trow["city"];
  $state = $trow["state"];
  $zip = $trow["zip"];
  $phone_number = $trow["phonenumber"];
  $email = $trow["email"];

  $user_name = import_username_abbrv($business_name);

  if($try > 1){
    $user_name = $user_name . $try;
  }

  if(true ) {

    // Generate the password and create the user
    $password = wp_generate_password( 12, false );

    $user_custom_fields = array(
      'nickname'          => $user_name,
      'company_category'  => !empty($category) ? $category : $sl,
      'billing_company'   =>	$business_name
    );

    if(empty($street_address)){
      $user_custom_fields['billing_address_1'] = $street_address;
    }

    if(empty($city)){
      $user_custom_fields['billing_city'] = $city;
    }

    if(empty($zip)){
      $user_custom_fields['billing_postcode'] = $zip;
    }

    if(empty($state)){
      $user_custom_fields['billing_state'] = $state;
    }

    if(empty($phone_number)){
      $user_custom_fields['billing_phone'] = $phone_number;
    }

    if(empty($email)){
      $user_id = wp_create_user( $user_name, $password);
    }else{
      if(email_exists($email)){
        $user_id = wp_create_user( $user_name, $password);
      }else{
        $user_id = wp_create_user( $user_name, $password, $email );
      }
      $user_custom_fields['billing_email'] = $email;
    }

    $user_custom_fields['ID'] = $user_id;

    wp_update_user($user_custom_fields);

    // Set the role
    $user = new WP_User( $user_id );
    $user->set_role("professional");

  }else{
    $try = $try++;
    import_howl_create_user($newuser, $try);
  }
}

function array_divide($array, $segmentCount) {
    $dataCount = count($array);
    if ($dataCount == 0) return false;
    $segmentLimit = ceil($dataCount / $segmentCount);
    $outputArray = array_chunk($array, $segmentLimit);

    return $outputArray;
}

function html_user_table($trows){
 echo "<form>";
 if(count($trows)){
    echo "<table class='wp-list-table widefat fixed striped posts'>";
    for ($i=0; $i < count($trows); $i++) {
      if($j == 0 && $i == 0){
        html_user_table_head($i, $trows[$i]);
      }else{
        html_user_table_body($i, $trows[$i], count($trows[$j]));
        import_howl_create_user($trows[$i], 1);
      }
    }
    echo "</table>";
 }
 echo "</form>";
}

function csv_prep_array($f){
  $fh = fopen($f['file']['tmp_name'], 'r+');
  $lines = array();

  while( ($row = fgetcsv($fh, 8192)) !== FALSE ) {
    $lines[] = $row;
  }

  return $lines;
}

function create_slug($string){
   $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
   return $slug;
}

function html_parse_json(){
  $dir = plugin_dir_path( __FILE__ );
  $json_path = $dir . "pros.json";
  $json_string = file_get_contents($json_path);
  $json_pros = json_decode($json_string, true);

  echo "<form>";
  if(count($json_pros)){
     echo "<table class='wp-list-table widefat fixed striped posts'>";
     html_user_table_head_json();
     for ($i=0; $i < count($json_pros); $i++) {
        html_user_table_body_json($i, $json_pros[$i], count($json_pros[$j]));
        import_howl_create_user_json($json_pros[$i], 1);
     }
     echo "</table>";
  }
  echo "</form>";
}

function userimport_options() {
 	if ( !current_user_can( 'manage_options' ) )  {
 		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
 	}
 	echo '<div class="wrap">';
  echo "<h2>" . __( 'User Importer', 'userimport' ) . "</h2>";



  //html_parse_json();

  html_upload_csv();
  if ($_FILES) {
      // Get the type of the uploaded file. This is returned as "type/extension"
      $arr_file_type      = wp_check_filetype($_FILES['file']['tmp_name']);
      $uploaded_file_type = $arr_file_type['type'];

      // Set an array containing a list of acceptable formats
      $csv_file_types = array('text/csv', 'text/plain', 'application/csv');
      if (!function_exists('wp_handle_upload')) {
          require_once(ABSPATH . 'wp-admin/includes/file.php');
      }

      $uploadedfile = $_FILES['file'];
      if ($_FILES['file']['type'] !== 'text/csv'){
          echo '<pre>ERROR, Only upload files in the CSV format!</pre>';
      } else {
          $csv = csv_prep_array($_FILES);
          html_user_table($csv);
      }
  } //end else of file type check

 	echo '</div>';
}

function userimport_menu() {
	 add_users_page('User Import', 'Import', 'read', 'user-import', 'userimport_options');
}

?>
