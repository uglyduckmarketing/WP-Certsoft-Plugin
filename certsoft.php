<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' ); ?>
<?php
/*
Plugin Name: CertSoft Plugin
Plugin URI: http://certsoft.net/
Description: This plugin integrates WordPress with the CertSoft System
Author: CertSoft
Author URI: http://certsoft.net/
Version: 1.5.3.4
GitHub Plugin URI: https://github.com/uglyduckmarketing/WP-Certsoft-Plugin
*/

/**
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
 */
if(true){
	$cert_db = @new mysqli(
		get_option('certsoft_db_host'),
		get_option('certsoft_db_user'),
		get_option('certsoft_db_pass'),
		get_option('certsoft_db_name')
	);
	if($cert_db->connect_errno){
	    //die('Connect Error ('.mysqli_connect_errno().')'.mysqli_connect_error());
	}
	//$cert_db->close();
}
//
add_action( 'admin_init', 'remove_dashboard_meta' );
function remove_dashboard_meta(){
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
        //remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');//since 3.8
}

add_action( 'wp_ajax_certsoft_save_connection_ajax', 'certsoft_save_connection_ajax' );
function certsoft_save_connection_ajax(){
	global $wpdb;
	update_option('certsoft_db_name', $_POST['db_name'] );
	update_option('certsoft_db_user', $_POST['db_user'] );
	update_option('certsoft_db_pass', $_POST['db_pass'] );
	update_option('certsoft_db_host', $_POST['db_host'] );
	update_option('certsoft_account', $_POST['account'] );
	update_option('certsoft_school_mod_dir', $_POST['school_mod_dir'] );
	echo "Updated.";
	die();
}

add_action( 'wp_dashboard_setup', 'certsoft_add_dashboard_widgets' );
function certsoft_add_dashboard_widgets() {

	wp_add_dashboard_widget(
		 'certsoft_dashboard_widget',        	// Widget slug.
		 'CertSoft',         					// Title.
		 'certsoft_dashboard_widget_function' 	// Display function.
    );
}
function certsoft_dashboard_widget_function(){


}

//Add Menu Items
add_action('admin_menu', 'certsoft_plugin_menu');
function certsoft_plugin_menu(){
	add_menu_page('CertSoft', 'CertSoft', 'manage_options', 'certsoft', 'certsoft_page');
	//add_submenu_page('udm-company-info','Company Info', 'Company Info', 'manage_options', 'udm-company-info-page', array($this, 'company_info_page'));
	//add_submenu_page('udm-company-info','Company Info | Slider', 'Slider', 'manage_options', 'udm-company-info-slider', array($this, 'slider_page'));
	//add_submenu_page('udm-company-info','Company Info | Help', 'Help', 'manage_options', 'udm-company-info-help', array($this, 'help_page'));
}
function certsoft_page(){
	// Help Page
	//$this->permissions();
	include('main.php');
}


//Shortcodes


		add_shortcode( 'certsoft_school_name', 'certsoft_school_name_func');
		function certsoft_school_name_func(){
			global $cert_db;
			$account = get_option('certsoft_account',1);
			$result = $cert_db->query("SELECT * FROM ts_schools WHERE schoolID = ".$account);
			if($result->num_rows > 0){
				$school = $result->fetch_assoc();
				return $school['schoolName'];
			}
		}

		add_shortcode( 'certsoft_school_url', 'certsoft_school_url_func');
		function certsoft_school_url_func(){
			global $cert_db;
			$account = get_option('certsoft_account',1);
			$result = $cert_db->query("SELECT * FROM ts_schools WHERE schoolID = ".$account);
			if($result->num_rows > 0){
				$school = $result->fetch_assoc();
				return $school['schoolURL'];
			}
		}

		add_shortcode( 'certsoft_school_email', 'certsoft_school_email_func');
		function certsoft_school_email_func(){
			global $cert_db;
			$account = get_option('certsoft_account',1);
			$result = $cert_db->query("SELECT * FROM ts_schools WHERE schoolID = ".$account);
			if($result->num_rows > 0){
				$school = $result->fetch_assoc();
				return $school['schoolEmail'];
			}
		}

		add_shortcode( 'certsoft_school_phone', 'certsoft_school_phone_func');
		function certsoft_school_phone_func(){
			global $cert_db;
			$account = get_option('certsoft_account',1);
			$result = $cert_db->query("SELECT * FROM ts_schools WHERE schoolID = ".$account);
			if($result->num_rows > 0){
				$school = $result->fetch_assoc();
				return $school['phone'];
			}
		}

		add_shortcode( 'certsoft_school_phone_tollfree', 'certsoft_school_phone_tollfree_func');
		function certsoft_school_phone_tollfree_func(){
			global $cert_db;
			$account = get_option('certsoft_account',1);
			$result = $cert_db->query("SELECT * FROM ts_schools WHERE schoolID = ".$account);
			if($result->num_rows > 0){
				$school = $result->fetch_assoc();
				return $school['tollFree'];
			}
		}

		add_shortcode( 'certsoft_school_fax', 'certsoft_school_fax_func');
		function certsoft_school_fax_func(){
			global $cert_db;
			$account = get_option('certsoft_account',1);
			$result = $cert_db->query("SELECT * FROM ts_schools WHERE schoolID = ".$account);
			if($result->num_rows > 0){
				$school = $result->fetch_assoc();
				return $school['fax'];
			}
		}

		add_shortcode( 'certsoft_school_address', 'certsoft_school_address_func');
		function certsoft_school_address_func(){
			global $cert_db;
			$account = get_option('certsoft_account',1);
			$result = $cert_db->query("SELECT * FROM ts_schools WHERE schoolID = ".$account);
			if($result->num_rows > 0){
				$school = $result->fetch_assoc();
				return $school['address'];
			}
		}
		add_shortcode( 'certsoft_school_address2', 'certsoft_school_address_func2');
		function certsoft_school_address_func2(){
			global $cert_db;
			$account = get_option('certsoft_account',1);
			$result = $cert_db->query("SELECT * FROM ts_schools WHERE schoolID = ".$account);
			if($result->num_rows > 0){
				$school = $result->fetch_assoc();
				return $school['address2'];
			}
		}
		add_shortcode( 'certsoft_school_address_city', 'certsoft_school_address_city_func');
		function certsoft_school_address_city_func(){
			global $cert_db;
			$account = get_option('certsoft_account',1);
			$result = $cert_db->query("SELECT * FROM ts_schools WHERE schoolID = ".$account);
			if($result->num_rows > 0){
				$school = $result->fetch_assoc();
				return $school['city'];
			}
		}
		add_shortcode( 'certsoft_school_address_state', 'certsoft_school_address_state_func');
		function certsoft_school_address_state_func(){
			global $cert_db;
			$account = get_option('certsoft_account',1);
			$result = $cert_db->query("SELECT * FROM ts_schools WHERE schoolID = ".$account);
			if($result->num_rows > 0){
				$school = $result->fetch_assoc();
				return $school['state'];
			}
		}
		add_shortcode( 'certsoft_school_address_zip', 'certsoft_school_address_zip_func');
		function certsoft_school_address_zip_func(){
			global $cert_db;
			$account = get_option('certsoft_account',1);
			$result = $cert_db->query("SELECT * FROM ts_schools WHERE schoolID = ".$account);
			if($result->num_rows > 0){
				$school = $result->fetch_assoc();
				return $school['zip'];
			}
		}
		add_shortcode( 'certsoft_school_license', 'certsoft_school_license_func');
		function certsoft_school_license_func(){
			global $cert_db;
			$account = get_option('certsoft_account',1);
			$result = $cert_db->query("SELECT * FROM ts_schools WHERE schoolID = ".$account);
			if($result->num_rows > 0){
				$school = $result->fetch_assoc();
				return $school['license'];
			}
		}
		add_shortcode( 'certsoft_school_homepage', 'certsoft_school_homepage_func');
		function certsoft_school_homepage_func(){
			global $cert_db;
			$account = get_option('certsoft_account',1);
			$result = $cert_db->query("SELECT * FROM ts_schools WHERE schoolID = ".$account);
			if($result->num_rows > 0){
				$school = $result->fetch_assoc();
				return $school['homepage'];
			}
		}
		add_shortcode( 'certsoft_school_instructor_first_name', 'certsoft_school_instructor_first_name_func');
		function certsoft_school_instructor_first_name_func(){
			global $cert_db;
			$account = get_option('certsoft_account',1);
			$result = $cert_db->query("SELECT * FROM ts_schools WHERE schoolID = ".$account);
			if($result->num_rows > 0){
				$school = $result->fetch_assoc();
				return $school['instructorFirstName'];
			}
		}
		add_shortcode( 'certsoft_school_instructor_last_name', 'certsoft_school_instructor_last_name_func');
		function certsoft_school_instructor_last_name_func(){
			global $cert_db;
			$account = get_option('certsoft_account',1);
			$result = $cert_db->query("SELECT * FROM ts_schools WHERE schoolID = ".$account);
			if($result->num_rows > 0){
				$school = $result->fetch_assoc();
				return $school['instructorLastName'];
			}
		}



function certsoft_package_button_func( $atts, $content = "" ) {
	global $cert_db;
	$account = get_option('certsoft_account',1);
	$result = $cert_db->query("SELECT * FROM ts_schools WHERE schoolID = ".$account);
	$row = $result->fetch_assoc();
	$cs_school_url = $row["schoolURL"];
	$cs_school_dir = 'cs-content';
	$cs_mod_dir = 'modules';
	$cs_school_mod = get_option('certsoft_school_mod_dir', 'school' );

	$result = $cert_db->query("SELECT * FROM cs_options WHERE option_name = 'school_signup_template' AND account_id = ".$account);
	$row = $result->fetch_assoc();
	$cs_signup_template = $row['option_value'];
	$result = $cert_db->query("SELECT * FROM cs_options WHERE option_name = 'school_signup_style' AND account_id = ".$account);
	$row = $result->fetch_assoc();
	$cs_signup_style = $row['option_value'];
	//
	$result = $cert_db->query("SELECT * FROM ts_packages WHERE packageID = {$atts['package']}");
	$string = '';

	while($row = $result->fetch_assoc()) {
		$string .= '<form action="';
		$string .= $cs_school_url.'/';
		$string .= $cs_school_dir.'/'.$cs_mod_dir.'/'.$cs_school_mod.'/signup/';
		$string .= $cs_signup_template;
		$string .= '/register_actions.php';
		$string .= '" method="post">';
		$string .= "<input type=\"hidden\" name=\"package\" value=\"{$row['packageID']}\" />";
		$string .= '<input type="hidden" name="action" value="package-button" />';
		$string .= '<input type="hidden" name="item_type" value="package" />';
		$string .= '<input type="submit" value="select package" />';
		$string .= '</form>';
	}

	return $string;
}
add_shortcode( 'certsoft_package_button', 'certsoft_package_button_func' );

function certsoft_lowest_package_price_func($atts, $content = ""){
	global $cert_db;
	$result = $cert_db->query("SELECT MIN(`packagePrice`) as price FROM ts_packages WHERE `packageActive` = 1");
	if(is_object($result)){
		$row = $result->fetch_assoc();
		return $row['price'];
	}
}
add_shortcode( 'certsoft_lowest_package_price', 'certsoft_lowest_package_price_func' );

add_shortcode( 'certsoft_dmv_url', 'certsoft_dmv_url_func' );
function certsoft_dmv_url_func($atts, $content = ""){
	global $cert_db;

	$account = get_option('certsoft_account',1);
	$result = $cert_db->query("SELECT * FROM ts_schools WHERE schoolID = ".$account);
	if(is_object($result)){
		$row = $result->fetch_assoc();
		$id = $row['license'];
		return "https://www.dmv.ca.gov/wasapp/olinq2/display.do?submitName=Display&ol={$id}~T~{$id}~00";
	}
}

add_shortcode( 'certsoft_dmv_link', 'certsoft_dmv_link_func' );
function certsoft_dmv_link_func($atts, $content = ""){
	global $cert_db;

	$account = get_option('certsoft_account',1);
	$result = $cert_db->query("SELECT * FROM ts_schools WHERE schoolID = ".$account);
	if(is_object($result)){
		$row = $result->fetch_assoc();
		$id = $row['license'];
		return "<a href=\"https://www.dmv.ca.gov/wasapp/olinq2/display.do?submitName=Display&ol={$id}~T~{$id}~00\">Click Here To Verify License</a>";
	}
}


add_shortcode( 'certsoft_license_linked', 'certsoft_license_linked_func' );
function certsoft_license_linked_func($atts, $content = ""){
	global $cert_db;

	$account = get_option('certsoft_account',1);
	$result = $cert_db->query("SELECT * FROM ts_schools WHERE schoolID = ".$account);
	if(is_object($result)){
		$row = $result->fetch_assoc();
		$id = $row['license'];
		return "<a href=\"https://www.dmv.ca.gov/wasapp/olinq2/display.do?submitName=Display&ol={$id}~T~{$id}~00\">#{$id}</a>";
	}
}


?>
