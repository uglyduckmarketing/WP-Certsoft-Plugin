<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' ); ?>
<?php
/*
Plugin Name: CertSoft Plugin
Plugin URI: http://certsoft.net/
Description: Just another contact form plugin. Simple but flexible.
Author: CertSoft
Author URI: http://certsoft.net/
Version: 1.1
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
	if(@mysqli_connect_error()){
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
function certsoft_package_button_func( $atts, $content = "" ) {
	global $cert_db;
	$account = get_option('certsoft_account',1);
	$result = $cert_db->query("SELECT * FROM ts_schools WHERE schoolID = ".$account);
	$row = $result->fetch_assoc();
	$cs_school_url = $row["schoolURL"];
	$cs_school_dir = 'ts-school';
	$cs_mod_dir = 'modules';
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
		$string .= $cs_school_dir.'/'.$cs_mod_dir.'/school/signup/';
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
?>