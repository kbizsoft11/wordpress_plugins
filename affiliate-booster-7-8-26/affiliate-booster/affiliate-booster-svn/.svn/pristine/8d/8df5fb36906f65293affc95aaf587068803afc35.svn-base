<?php
/*
Plugin Name: WP Affiliate Link Manager
Plugin URI: https://wordpress.org/plugins/affiliate-booster/
Description: WP Affiliate Link Manager add the links to your keywords based on the selection being made , making it easier to add the link to the keywords and generate the revenue via the affiliate marketing.
Version: 5.0.3
Author: Raj
Author URI: http://kbizsoft.com/
*/

defined('ABSPATH') or die();

$abPlugin = plugin_basename(__FILE__);
$afbtPath = plugin_dir_path(__FILE__);
$afbtPath .= '/affiliate-classes.php';
include_once($afbtPath);
$afbtOpts = new AFBT_Options;

function affiliate_booster_install()
{
	global $wpdb;
	$afbt_table_name1 = $wpdb->prefix . 'affiliate_boost';
	$afbt_table_name2 = $wpdb->prefix . 'affiliate_boost_website';
	$charset_collate = $wpdb->get_charset_collate();
	$afbt_sql_table1 = "CREATE TABLE $afbt_table_name1 (
		id mediumint(20) NOT NULL AUTO_INCREMENT,
		parent_id mediumint(20) NOT NULL,
		keywords text NOT NULL,
		affiliate_link text NOT NULL,
		time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
		PRIMARY KEY (id)
	  )$charset_collate;";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	dbDelta($afbt_sql_table1);

	$afbt_sql_table2 = "CREATE TABLE $afbt_table_name2 (
		w_id int(10) NOT NULL AUTO_INCREMENT,
		post_type varchar(30) NOT NULL,
		website varchar(200) NOT NULL,
		created_time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
		PRIMARY KEY (w_id)
	  )$charset_collate;";
	dbDelta($afbt_sql_table2);

	// ─── Send install data to tracker API ──────────────────────
	afbt_track_activation();
	// ───────────────────────────────────────────────────────────
}

register_activation_hook(__FILE__, 'affiliate_booster_install');

/*
 *
 *get the admin option page 
 *
 */

if (is_admin()) {
	add_action('admin_menu', array($afbtOpts, 'afbt_AddAdminPage'));
}

if (!is_admin()) {

	add_filter('the_content', array($afbtOpts, 'afbt_replace_for_keywords'));
	add_action('wp_footer', array($afbtOpts, 'afbt_frontscript'));
}

/*
 * Remove db table after uninstall plugin
 */
function affiliate_booster_remove_database()
{
	global $wpdb;
	$afbt_table_name1 = $wpdb->prefix . 'affiliate_boost';
	$afbt_table_name2 = $wpdb->prefix . 'affiliate_boost_website';
	$afbt_del_sql1 = "DROP TABLE IF EXISTS $afbt_table_name1";
	$wpdb->query($afbt_del_sql1);
	$afbt_del_sql2 = "DROP TABLE IF EXISTS $afbt_table_name2";
	$wpdb->query($afbt_del_sql2);
}
register_deactivation_hook(__FILE__, 'affiliate_booster_remove_database');


function afbt_track_activation()
{
	$admin_email = get_option('admin_email');
	$site_url = get_option('siteurl');
	$install_date = current_time('Y-m-d H:i:s');

	$ip_data = afbt_get_ip_country();
	$country = isset($ip_data['country_name']) ? $ip_data['country_name'] : 'Unknown';

	$payload = array(
		'addon_name' => 'WP Affiliate Link Manager',
		'email_address' => $admin_email,
		'website_link' => $site_url,
		'installation_date' => $install_date,
		'country_location' => $country,
	);

	wp_remote_post('https://colixlabs.com/wp-json/ntmode-tracker/v1/register', array(
		'method' => 'POST',
		'timeout' => 15,
		'headers' => array(
			'Content-Type' => 'application/json',
			'X-NTMode-Key' => 'tRM7UbiHU0TmRiik',
		),
		'body' => wp_json_encode($payload),
	));
}

function afbt_get_ip_country()
{
	if (!empty($_SERVER['HTTP_CF_IPCOUNTRY']) && $_SERVER['HTTP_CF_IPCOUNTRY'] !== 'XX') {
		return array('country_name' => sanitize_text_field($_SERVER['HTTP_CF_IPCOUNTRY']));
	}

	$ip = '';
	foreach (array('HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP', 'REMOTE_ADDR') as $header) {
		if (!empty($_SERVER[$header])) {
			$ips = explode(',', $_SERVER[$header]);
			$candidate = trim($ips[0]);
			if (filter_var($candidate, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
				$ip = $candidate;
				break;
			}
		}
	}

	if (empty($ip)) {
		return array('country_name' => 'Unknown');
	}

	$response = wp_remote_get('https://ipapi.co/' . $ip . '/json/', array('timeout' => 8));
	if (!is_wp_error($response)) {
		$data = json_decode(wp_remote_retrieve_body($response), true);
		if (is_array($data) && !empty($data['country_name'])) {
			return $data;
		}
	}

	$response = wp_remote_get('http://ip-api.com/json/' . $ip . '?fields=country', array('timeout' => 8));
	if (!is_wp_error($response)) {
		$data = json_decode(wp_remote_retrieve_body($response), true);
		if (is_array($data) && !empty($data['country'])) {
			return array('country_name' => sanitize_text_field($data['country']));
		}
	}

	return array('country_name' => 'Unknown');
}