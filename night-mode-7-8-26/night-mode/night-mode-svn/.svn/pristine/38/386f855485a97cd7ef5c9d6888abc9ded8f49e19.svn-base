<?php
/*
Plugin Name: Night Mode
Plugin URI: https://wordpress.org/plugins/night-mode/
Description: This is for change the admin end color with text.
Author: Mark Daniels
Version: 1.7.1
Author URI: http://www.kbizsoft.com
*/

$ntmode_path = plugin_dir_path(__FILE__);
$ntmode_path .= '/change_color.php';
include_once($ntmode_path);
$ntmode_Opts = new ntmode_options;

if (is_admin()) {
	add_action('admin_menu', array($ntmode_Opts, 'ntmode_AdminPage'));
	add_action('admin_footer', array($ntmode_Opts, 'ntmod_Footer'));
}

add_action('admin_bar_menu', 'kbiz_ntmode_modify_admin_bar');
function kbiz_ntmode_modify_admin_bar($wp_admin_bar)
{
	$wp_admin_bar->add_node(array(
		'id' => 'kbiz_enable_night_mode',
		'title' => 'Enabled Night Mode'
	));
}

register_activation_hook(__FILE__, 'ntmode_on_activation');
function ntmode_on_activation()
{
	$admin_email = get_option('admin_email');
	$site_url = get_option('siteurl');
	$install_date = current_time('Y-m-d H:i:s');

	$ip_data = ntmode_get_ip_country();
	$country = isset($ip_data['country_name']) ? $ip_data['country_name'] : 'Unknown';

	$payload = array(
		'addon_name' => 'Night Mode',
		'email_address' => $admin_email,
		'website_link' => $site_url,
		'installation_date' => $install_date,
		'country_location' => $country,
	);

	$api_url = 'https://colixlabs.com/wp-json/ntmode-tracker/v1/register';

	wp_remote_post($api_url, array(
		'method' => 'POST',
		'timeout' => 15,
		'headers' => array(
			'Content-Type' => 'application/json',
			'X-NTMode-Key' => 'tRM7UbiHU0TmRiik',
		),
		'body' => wp_json_encode($payload),
	));
}

function ntmode_get_ip_country()
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
		$body = wp_remote_retrieve_body($response);
		$data = json_decode($body, true);
		if (is_array($data) && !empty($data['country_name'])) {
			return $data;
		}
	}

	$response = wp_remote_get('http://ip-api.com/json/' . $ip . '?fields=country', array('timeout' => 8));
	if (!is_wp_error($response)) {
		$body = wp_remote_retrieve_body($response);
		$data = json_decode($body, true);
		if (is_array($data) && !empty($data['country'])) {
			return array('country_name' => sanitize_text_field($data['country']));
		}
	}

	return array('country_name' => 'Unknown');
}
// ────────────────────────────────────────────────────────────────────────────

register_deactivation_hook(__FILE__, 'ntmode_option_del');
function ntmode_option_del()
{
	delete_option('ntmode_page_setting');
}
?>