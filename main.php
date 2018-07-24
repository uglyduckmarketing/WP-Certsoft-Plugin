<h1>CertSoft</h1>
<h2>Connection Information</h2>
<div id="certsoft_save_connection_results"></div>
<p>
	<label for="db_name">Database Name</label>
	<input type="text" name="db_name" id="db_name" value="<?php echo get_option('certsoft_db_name', '' ); ?>" />
</p>
<p>
	<label for="db_user">Database User</label>
	<input type="text" name="db_user" id="db_user" value="<?php echo get_option('certsoft_db_user', '' ); ?>" />
</p>
<p>
	<label for="db_pass">Database Password</label>
	<input type="password" name="db_pass" id="db_pass" value="<?php echo get_option('certsoft_db_pass', '' ); ?>" />
</p>
<p>
	<label for="db_host">Database Host</label>
	<input type="text" name="db_host" id="db_host" value="<?php echo get_option('certsoft_db_host', 'localhost' ); ?>" />
</p>
<p>
	<label for="account">Account ID</label>
	<input type="text" name="account" id="account" value="<?php echo get_option('certsoft_account', 'school' ); ?>" />
</p>
<hr />
<p>
	<label for="account">School Module Directory</label>
	<input type="text" name="school_mod_dir" id="school_mod_dir" value="<?php echo get_option('certsoft_school_mod_dir', 'school' ); ?>" />
</p>
<p><a id="certsoft_save_connection_info" class="button button-primary" href="#">Save</a></p>
<h2>Account Information</h2>
<table>
<?php
global $cert_db;
$account = get_option('certsoft_account',1);
$result = $cert_db->query("SELECT * FROM ts_schools WHERE schoolID = ".$account);

if($result->num_rows > 0){
	$school_info = $result->fetch_assoc();
  print '<tr><td><strong>Account Name:</strong> </td><td>'.do_shortcode('[certsoft_school_name]').'</td><td>[certsoft_school_name]</td></tr>';
  print '<tr><td><strong>URL</strong>: </td><td>'.do_shortcode('[certsoft_school_url]').'</td><td>[certsoft_school_url]</td></tr>';
  print '<tr><td><strong>Email</strong>: </td><td>'.do_shortcode('[certsoft_school_email]').'</td><td>[certsoft_school_email]</td></tr>';
  print '<tr><td><strong>Phone</strong>: </td><td>'.do_shortcode('[certsoft_school_phone]').'</td><td>[certsoft_school_phone]</td></tr>';
  print '<tr><td><strong>Tolle Free #</strong>: </td><td>'.do_shortcode('[certsoft_school_phone_tollfree]').'</td><td>[certsoft_school_phone_tollfree]</td></tr>';
  print '<tr><td><strong>Fax</strong>: </td><td>'.do_shortcode('[certsoft_school_fax]').'</td><td>[certsoft_school_fax]</td></tr>';
  print '<tr><td><strong>Address</strong>: </td><td>'.do_shortcode('[certsoft_school_address]').'</td><td>[certsoft_school_address]</td></tr>';
  print '<tr><td><strong>City</strong>: </td><td>'.do_shortcode('[certsoft_school_address_city]').'</td><td>[certsoft_school_address_city]</td></tr>';
  print '<tr><td><strong>State</strong>: </td><td>'.do_shortcode('[certsoft_school_address_state]').'</td><td>[certsoft_school_address_state]</td></tr>';
  print '<tr><td><strong>Zipcode</strong>: </td><td>'.do_shortcode('[certsoft_school_address_zip]').'</td><td>[certsoft_school_address_zip]</td></tr>';
  print '<tr><td><strong>License</strong>: </td><td>'.do_shortcode('[certsoft_school_license]').'</td><td>[certsoft_school_license]</td></tr>';
  print '<tr><td><strong>License Linked</strong>: </td><td>'.do_shortcode('[certsoft_school_license_linked]').'</td><td>[certsoft_school_license_linked]</td></tr>';
  print '<tr><td><strong>Homepage</strong>: </td><td>'.do_shortcode('[certsoft_school_homepage]').'</td><td>[certsoft_school_homepage]</td></tr>';
  print '<tr><td><strong>Instructor First Name</strong>: </td><td>'.do_shortcode('[certsoft_school_instructor_first_name]').'</td><td>[certsoft_school_instructor_first_name]</td></tr>';
  print '<tr><td><strong>Instructor Last Name</strong>: </td><td>'.do_shortcode('[certsoft_school_instructor_last_name]').'</td><td>[certsoft_school_instructor_last_name]</td></tr>';
	print '<tr><td><strong>Lowest Package Price</strong>: </td><td>'.do_shortcode('[certsoft_lowest_package_price]').'</td><td>[certsoft_lowest_package_price]</td></tr>';
	print '<tr><td><strong>DMV URL</strong>: </td><td>'.do_shortcode('[certsoft_dmv_url]').'</td><td>[certsoft_dmv_url]</td></tr>';
	print '<tr><td><strong>DMV Link</strong>: </td><td>'.do_shortcode('[certsoft_dmv_link]').'</td><td>[certsoft_dmv_link]</td></tr>';
}

?>
</table>
<h2>Packages</h2>
<?php
$cs_school_url = $school_info["schoolURL"];
$cs_school_dir = 'cs-content';
$cs_mod_dir = 'modules';
$cs_school_mod = get_option('certsoft_school_mod_dir', 'school' );

if(is_object($cert_db)){
	$result = $cert_db->query("SELECT * FROM cs_options WHERE option_name = 'school_signup_template' AND account_id = ".$account);
	if($result->num_rows > 0){
		$row = $result->fetch_assoc();
	}
	$cs_signup_template = $row['option_value'];

	$result = $cert_db->query("SELECT * FROM cs_options WHERE option_name = 'school_signup_style' AND account_id = ".$account);
	if($result->num_rows > 0){
		$row = $result->fetch_assoc();
	}
	$cs_signup_style = $row['option_value'];
	//
	$result = $cert_db->query("SELECT * FROM ts_packages");
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()) {

			echo '<h3>'.$row['packageTitle'].'</h3><textarea id="html" class="full" style="width: 500px; height: 200px" rows="4">';
			echo '<form action="';
			//DIRECTORY_SEPARATOR
			echo $cs_school_url.'/';
			echo $cs_school_dir.'/'.$cs_mod_dir.'/'.$cs_school_mod.'/signup/';
			echo $cs_signup_template;
			echo '/register_actions.php';
			echo '" method="post">';
			echo "<input type=\"hidden\" name=\"package\" value=\"{$row['packageID']}\" />";
			echo '<input type="hidden" name="action" value="package-button" />';
			echo '<input type="hidden" name="item_type" value="package" />';
			echo '<input type="submit" value="select package" />';
			echo '</form>';
			echo '</textarea><p>[certsoft_package_button package="'.$row['packageID'].'"]</p>';
		}
	}
}
?>
<script>
jQuery(document).ready(function($){
	$('#certsoft_save_connection_info').click(function(){
		$.post(
		    ajaxurl,
		    {
		        'action': 'certsoft_save_connection_ajax',
		        'db_name':   $('#db_name').val(),
		        'db_user':   $('#db_user').val(),
		        'db_pass':   $('#db_pass').val(),
		        'db_host':   $('#db_host').val(),
		        'account':   $('#account').val(),
						'school_mod_dir':   $('#school_mod_dir').val()
		    },
		    function(response){
				$('#certsoft_save_connection_results').html(response);
		    }
		);
		return false;
	});
});
</script>
