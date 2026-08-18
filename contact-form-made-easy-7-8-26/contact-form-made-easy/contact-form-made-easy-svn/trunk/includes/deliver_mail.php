<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Deliver mail and record contact form submissions. */
class kbcfDeliverMail {

	public function kbcf_deliver_mail( $form_id ) {
		if ( ! isset( $_POST['kbcf_submitted'] ) ) {
			return;
		}

		if ( ! isset( $_POST['kbcf_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kbcf_nonce'] ) ), 'kbcf_submit_form' ) ) {
			echo '<div class="kbcf-error">Security check failed. Please refresh the page and try again.</div>';
			return;
		}

		global $wpdb;
		$user_table = $wpdb->prefix . 'kbcf_cform';
		$cat_table  = $wpdb->prefix . 'kbcf_cat';

		$name    = isset( $_POST['kbcf_name'] ) ? sanitize_text_field( wp_unslash( $_POST['kbcf_name'] ) ) : '';
		$email   = isset( $_POST['kbcf_email'] ) ? sanitize_email( wp_unslash( $_POST['kbcf_email'] ) ) : '';
		$phone   = isset( $_POST['kbcf_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['kbcf_phone'] ) ) : '';
		$message = isset( $_POST['kbcf_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['kbcf_message'] ) ) : '';

		if ( '' === $name || ! is_email( $email ) || '' === $phone || '' === $message ) {
			echo '<div class="kbcf-error">Please complete all fields with valid information.</div>';
			return;
		}

		$to = $wpdb->get_var(
			$wpdb->prepare( "SELECT email FROM {$cat_table} WHERE id = %d LIMIT 1", absint( $form_id ) )
		);
		$to = is_email( $to ) ? $to : get_option( 'kbcf_settings_email' );
		$to = is_email( $to ) ? $to : get_option( 'admin_email' );

		if ( ! is_email( $to ) ) {
			echo '<div class="kbcf-error">The contact email is not configured. Please ask the site administrator to set it.</div>';
			return;
		}

		// Store the lead before sending so a temporary mail-server failure does not lose it.
		$inserted = $wpdb->insert(
			$user_table,
			array(
				'cat_id'       => absint( $form_id ),
				'name'         => $name,
				'email'        => $email,
				'phone_no'     => $phone,
				'message'      => $message,
				'last_updated' => current_time( 'mysql' ),
			),
			array( '%d', '%s', '%s', '%s', '%s', '%s' )
		);

		if ( false === $inserted ) {
			error_log( 'Contact Form Made Easy: could not save submission: ' . $wpdb->last_error );
			echo '<div class="kbcf-error">Your message could not be saved. Please try again.</div>';
			return;
		}

		$headers = array(
			'Content-Type: text/plain; charset=UTF-8',
			'From: ' . wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) . ' <' . get_option( 'admin_email' ) . '>',
			'Reply-To: ' . $email,
		);
		$body = "Name: {$name}\nEmail: {$email}\nPhone: {$phone}\n\nMessage:\n{$message}";
		$sent = wp_mail( $to, 'Contact Form Alert', $body, $headers );

		if ( $sent ) {
			echo '<div class="kbcf-success">Mail sent. Thank you ' . esc_html( $name ) . ', we will contact you shortly.</div>';
			return;
		}

		error_log( 'Contact Form Made Easy: wp_mail() returned false. Configure WordPress SMTP/mail transport.' );
		echo '<div class="kbcf-error">Your message was saved, but email delivery is not configured on this site yet. Please contact the site administrator.</div>';
	}
}
