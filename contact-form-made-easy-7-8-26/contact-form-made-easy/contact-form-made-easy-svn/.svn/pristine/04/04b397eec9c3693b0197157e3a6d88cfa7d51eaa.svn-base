<?php

	if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
	
	global $wpdb;
	$cat_table = $wpdb->prefix . "kbcf_cat";
	$cat_sql =  "SELECT email FROM $cat_table";
	$cat_rows = $wpdb->get_results( $cat_sql, ARRAY_A );
	if ( ! empty( $cat_rows[0]['email'] ) ) {
		$contact_email = $cat_rows[0]['email'];
	}elseif(get_option( 'kbcf_settings_email' ) != ''){
		$contact_email = get_option( 'kbcf_settings_email' );
	}else{
		$contact_email = get_option( 'admin_email' );
	}
	if ( isset( $_POST['kbcf_email_submitted'] )) {
		$contact_email   = sanitize_email( $_POST["kbcf_contact_email"] );
		add_option( 'kbcf_settings_email', $contact_email );
		$wpdb->query( 
			$wpdb->prepare( 
				"UPDATE $cat_table
				 SET `email` = %s",
				 $contact_email
			)
		);
		$msg  = "submitted";							
	}else{
		$msg  = "not submitted";	
	}	
	echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
	echo '<p>';
	echo 'Contact Email <br />';
	echo '<input type="email" name="kbcf_contact_email" value="' .$contact_email. '" size="50" required />';
	echo '</p>';
	echo '<p><input type="submit" name="kbcf_email_submitted" value="Submit"/></p>';
	echo '</form>';

?>
