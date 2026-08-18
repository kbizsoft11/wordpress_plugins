<?php

	if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
	
	/* frontend form */
	class kbcfForm{

		function kbcf_contact_form() {
			echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
			wp_nonce_field( 'kbcf_submit_form', 'kbcf_nonce' );
			echo '<p>';
			_e('Name (required)', 'contact-form-made-easy');
			echo '<input type="text" name="kbcf_name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["kbcf_name"] ) ? esc_attr( $_POST["kbcf_name"] ) : '' ) . '" size="40" required />';
			echo '</p>';
			echo '<p>';
			_e('Email (required)', 'contact-form-made-easy');
			echo '<input type="email" name="kbcf_email" value="' . ( isset( $_POST["kbcf_email"] ) ? esc_attr( $_POST["kbcf_email"] ) : '' ) . '" size="50" required />';
			echo '</p>';
			echo '<p>';
			_e('Phone Number (required)', 'contact-form-made-easy');
			echo '<input type="number" name="kbcf_phone" pattern="[0-9 ]+" value="' . ( isset( $_POST["kbcf_phone"] ) ? esc_attr( $_POST["kbcf_phone"] ) : '' ) . '" size="15" required />';
			echo '</p>';
			echo '<p>';
			_e('Comment (required)', 'contact-form-made-easy');
			echo '<textarea rows="10" cols="35" name="kbcf_message" required>' . ( isset( $_POST["kbcf_message"] ) ? esc_attr( $_POST["kbcf_message"] ) : '' ) . '</textarea>';
			echo '</p>';
			echo '<p><input type="submit" name="kbcf_submitted" value="Send"/></p>';
			echo '</form>';
		}
	}
?>
