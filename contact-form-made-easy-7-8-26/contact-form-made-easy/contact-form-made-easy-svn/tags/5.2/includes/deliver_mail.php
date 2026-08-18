<?php

	if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
	
	/* deliver mail class */
	class kbcfDeliverMail{
		
		function kbcf_deliver_mail($form_id) {
			
			global $wpdb;
			$user_table = $wpdb->prefix . "kbcf_cform";
			$cat_table = $wpdb->prefix . "kbcf_cat";
			
			// if the submit button is clicked, send the email
			if ( isset( $_POST['kbcf_submitted'] ) ) {
		
				// ini_set("SMTP","ssl://smtp.gmail.com");
				// ini_set("smtp_port","465");
				$msg = '';
				// echo 'Got Here';
				// sanitize form values
				$name    = sanitize_text_field( $_POST["kbcf_name"] );
				$email   = sanitize_email( $_POST["kbcf_email"] );
				$subject = "Contact Form Alert";
				$message = sanitize_text_field( $_POST["kbcf_message"] );
				$phone   = sanitize_text_field( $_POST["kbcf_phone"] );

				// get the setting or blog administrator's email address
				$cat_sql =  "SELECT email FROM $cat_table";
				$cat_rows = $wpdb->get_results( $cat_sql, ARRAY_A );
				if($cat_rows[0]['email'] != ''){
					$to = $cat_rows[0]['email'];
				}else{
					$to = get_option( 'admin_email' );
				}
				
				$headers = "From: ".$email. "\r\n";
				$headers .= "cc: ".$email. "\r\n";
				
				// If email has been process for sending, display a success message
				if ( wp_mail( $to, $subject, $message, $headers ) ) {
					
					$wpdb->insert( $user_table, array( 
									'cat_id' => $form_id,
									'name' => $name,
									'email' => $email,
									'phone_no' => $phone,
									'message' => $message,
									'last_updated' => date('Y-m-d H:i:s')
								) );		
					
					$msg .= '<div>';
					$msg .= "Mail Sent. Thank you " . $name . ", we will contact you shortly.";
					$msg .= '</div>';
				} else {
					$msg .= 'An unexpected error occurred';
				} 	
				
				echo $msg;
			} 
		}
    }
	
?>