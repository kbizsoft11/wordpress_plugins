<?php
// If uninstall not called from WordPress, exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

delete_option( 'AIA_settings' );

// Clean up any rate-limit transients we created.
global $wpdb;
$wpdb->query(
    "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_AIA_rl_%' OR option_name LIKE '_transient_timeout_AIA_rl_%'"
);
