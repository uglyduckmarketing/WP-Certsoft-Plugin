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
	<input type="text" name="account" id="account" value="<?php echo get_option('certsoft_account', '' ); ?>" />
</p>
<p><a id="certsoft_save_connection_info" class="button button-primary" href="#">Save</a></p>
<h2>Account Information</h2>
<table>
<?php
global $cert_db;
$account = get_option('certsoft_account',1);
$result = $cert_db->query("SELECT * FROM ts_schools WHERE schoolID = ".$account);
//var_dump($result->num_rows);
if($result->num_rows > 0){
	while($row = $result->fetch_assoc()) {
	    print '<tr><td><strong>Account Name:</strong> </td><td>'.$row["schoolName"].'</td><td>[certsoft_]</td></tr>';
	    print '<tr><td><strong>URL</strong>: </td><td>'.$row["schoolURL"].'</td><td>[certsoft_]</td></tr>';
	    print '<tr><td><strong>Email</strong>: </td><td>'.$row["schoolEmail"].'</td><td>[certsoft_]</td></tr>';
	    print '<tr><td><strong>Phone</strong>: </td><td>'.$row["phone"].'</td><td>[certsoft_]</td></tr>';
	    print '<tr><td><strong>Tolle Free #</strong>: </td><td>'.$row["tollFree"].'</td><td>[certsoft_]</td></tr>';
	    print '<tr><td><strong>Fax</strong>: </td><td>'.$row["fax"].'</td><td>[certsoft_]</td></tr>';
	    print '<tr><td><strong>Address</strong>: </td><td>'.$row["address"].'</td><td>[certsoft_]</td></tr>';
	    print '<tr><td><strong>City</strong>: </td><td>'.$row["city"].'</td><td>[certsoft_]</td></tr>';
	    print '<tr><td><strong>State</strong>: </td><td>'.$row["state"].'</td><td>[certsoft_]</td></tr>';
	    print '<tr><td><strong>Zipcode</strong>: </td><td>'.$row["zip"].'</td><td>[certsoft_]</td></tr>';
	    print '<tr><td><strong>License</strong>: </td><td>'.$row["license"].'</td><td>[certsoft_]</td></tr>';
	    print '<tr><td><strong>Homepage</strong>: </td><td>'.$row["homepage"].'</td><td>[certsoft_]</td></tr>';
	    print '<tr><td><strong>Instructor First Name</strong>: </td><td>'.$row["instructorFirstName"].'</td><td>[certsoft_]</td></tr>';
	    print '<tr><td><strong>Instructor Last Name</strong>: </td><td>'.$row["instructorLastName"].'</td><td>[certsoft_]</td></tr>';
			print '<tr><td><strong>Lowest Package Price</strong>: </td><td>'.do_shortcode('[certsoft_lowest_package_price]').'</td><td>[certsoft_lowest_package_price]</td></tr>';

	}
}

?>
</table>
<h2>Packages</h2>
<?php
$cs_school_url = $row["schoolURL"];
$cs_school_dir = 'ts-school';
$cs_mod_dir = 'modules';
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
		echo $cs_school_dir.'/'.$cs_mod_dir.'/school/signup/';
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
		        'account':   $('#account').val()
		    },
		    function(response){
				$('#certsoft_save_connection_results').html(response);
		    }
		);
		return false;
	});
});
</script>
