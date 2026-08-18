<?php

namespace Woo\SaveForLater;

if (!defined('WSFLLA_PLUGIN_URL')) {
	define('WSFLLA_PLUGIN_URL', plugin_dir_url(__FILE__));
}
class WSFLLA_SaveForLater
{

	public $product;
	public $counter = 0;
	public $message;
	public $showtoken = false;
	public $hidetoken = true;


	public function __construct()
	{

		$this->wsflla_add_wp_add_actons();
		$this->wsflla_handle_posts_request();
	}
	/*
		Install Database.
	*/
	static function wsflla_install()
	{

		global $wpdb;
		$table_name = $wpdb->prefix . 'save_for_later';
		//$table_name = $this->table_name;
		$sql = "CREATE TABLE $table_name (
		                id int(11) NOT NULL auto_increment,
		                user_id int(11) NOT NULL,
						product_id int(11) NOT NULL,
						status int(11) NOT NULL,
						guest_id varchar(100) NOT NULL,
		                time_update timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
		                UNIQUE KEY id (id)
		        ) $charset_collate;";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

	public function wsflla_check_activation()
	{

		$activation = get_option('server_allow');
		$requested_activation_key = get_option('requested_activation_key');
		$enable_disable_plugin = get_option('enable_disable_plugin');
		if ($activation == 'false') {
			return "not_activated";
		}
		if ($requested_activation_key == 0) {

			return "no_activation_key";
		}
		if ($enable_disable_plugin == 0) {

			return "disabled";
		}
		return $activation;
	}
	/*
		Handle post request
	*/
	public function wsflla_handle_posts_request()
	{

		if (isset($_POST['submit_kbiz_form']) && !empty($_POST['option_label'])) {

			$this->wsflla_update_option_name($_POST);
		}

		if (isset($_POST['requested_email']) && !empty($_POST['requested_email'])) {

			$email = sanitize_text_field($_POST['requested_email']);
			$kabiz_button_text = sanitize_text_field($_POST['token_field']);;
			update_option('user_end_code_to_check', $kabiz_button_text);
			update_option('requested_activation_key', '1');
			update_option('kbiz_registration_email', $email);
			$this->message = 'Please Check Your Email for a Message with your Activation Code !';
			$this->showtoken = true;
			$this->hidetoken = false;
		}
		if (isset($_POST['kbiz_activation_key']) && !empty($_POST['kbiz_activation_key'])) {

			$kbiz_activation_key = sanitize_text_field($_POST['kbiz_activation_key']);
			$user_end_code_to_check = get_option('user_end_code_to_check');

			if ($user_end_code_to_check == $kbiz_activation_key) {

				update_option('server_allow', 'true');
				update_option('enable_disable_plugin', '1');
			}
		}

		if (isset($_POST['submit_enable_plugin_form']) && !empty($_POST['submit_enable_plugin_form'])) {

			if (isset($_POST['enable_check_box'])) {

				update_option('enable_disable_plugin', '1');
			} else {
				update_option('enable_disable_plugin', '0');
			}
		}
		$test_server_allow = get_option('server_allow');
		if ($test_server_allow == 'true') {
			$this->wsflla_plugin_go();
		}
	}

	public function wsflla_add_wp_add_actons()
	{

		$check_enable_disable = get_option('enable_disable_plugin');
		if ($check_enable_disable == 1) {

			add_action('woocommerce_after_shop_loop_item', array($this, 'wsflla_add_save_for_later_button'));
			add_action('woocommerce_after_shop_loop_item', array($this, 'wsflla_add_save_for_later_button_without_login'));
			add_action('wp_login', array($this, 'get_all_save_for_later_product'));
			add_action('wp_logout', array($this, 'unset_cookie_function_logout'));
			//add_action('woocommerce_after_add_to_cart_button', array($this, 'add_save_for_later_button'));
			add_action('wp_ajax_nopriv_wsflla_register_ajax_requests_remove_save_to_later', array($this, 'wsflla_register_ajax_requests_remove_save_to_later'));
			add_action('wp_ajax_wsflla_move_to_cart', array($this, 'wsflla_move_to_cart'));
			add_action('wp_ajax_nopriv_wsflla_move_to_cart', array($this, 'move_to_cart'));
			add_action('wp_ajax_wsflla_register_ajax_requests_remove_save_to_later', array($this, 'wsflla_register_ajax_requests_remove_save_to_later'));
			add_action('wp_ajax_nopriv_wsflla_register_ajax_requests_save_to_later', array($this, 'wsflla_register_ajax_requests_save_to_later'));
			add_action('wp_ajax_wsflla_register_ajax_requests_save_to_later', array($this, 'wsflla_register_ajax_requests_save_to_later'));
			add_action('wp_enqueue_scripts', array($this, 'wsflla_enclude_scripts'));
			add_action('woocommerce_after_cart_table', array($this, 'wsflla_footer_html'));
			add_action('woocommerce_after_cart_item_name', array($this, 'wsflla_add_save_for_later_button_cart'));
			remove_action('woocommerce_cart_is_empty', 'wc_empty_cart_message', 1);
			add_action('woocommerce_cart_is_empty', array($this, 'wsflla_footer_html'), 10);
			add_option('kabiz_button_text', 'Save For Later', '', 'yes');
			add_option('kabiz_move_to_cart_button_text', 'move to cart', '', 'yes');
			add_option('get_option_save_for_list', 'Save For Later List', '', 'yes');
		}
		add_action('admin_enqueue_scripts', array($this, 'wsflla_enclude_scripts'));
		add_action('wp_ajax_wsflla_request_activation_token', array($this, 'wsflla_request_activation_token'));
		add_action('admin_menu', array($this, 'wsflla_register_save_for_later_menu_page'));
		add_option('user_end_code_to_check', '', '', 'yes');
		add_option('requested_activation_key', '0', '', 'yes');
		add_option('server_allow', 'false', '', 'yes');
		add_option('enable_disable_plugin', '0', '', 'yes');
		add_option('kbiz_activation_key', '', '', 'yes');
		// add_option('api_url_for_activation', 'http://kbizsoft.com/dev/saveforlater/activation.php', '', 'yes');
		add_option('api_url_for_activation', 'https://leadforest.net/do_not_delete/affilate/activation.php', '', 'yes');
		add_option('get_option_save_for_list', 'Save For Later List', '', 'yes');
		add_option('kbiz_registration_email', '', '', 'yes');
	}

	/*
		Creates admin menu options.
	*/
	public function wsflla_register_save_for_later_menu_page()
	{

		//add_menu_page('Save For Later', 'Save For Later Like Amazon', 'manage_options', 'shop-for-later',  array($this, 'wsflla_options_html'));
		add_menu_page('Save For Later', 'Save For Later Like Amazon', 'manage_options', 'shop-for-later',  array($this, 'wsflla_options_html'));
		add_submenu_page('shop-for-later', 'Settings', 'Settings', 'manage_options', 'settings-for-later-like-amazon',  array($this, 'wsflla_options_admin'));
	}

	public function wsflla_options_admin()
	{

		if ($this->wsflla_check_activation() == "not_activated") {
			if ($this->message != "") {
				$message = $this->message;
			} else {
				$message = 'Get Your Ativation Key';
			}

			$reg_email = get_option('kbiz_registration_email');
			if ($reg_email == "") {

				$reg_email = get_option('admin_email');
			} ?>

			<?php if ($this->hidetoken) { ?>
				<div class="activate_key" style="font-size: 15px; padding: 28px;">
					<div>
						<h2><?php _e($message, 'Save-For-Later') ?></h2>
					</div>
					<div>
						<form id="request_activation" style="text-align: initial;" method="post">
							<table>
								<tr>
									<th><?php _e('Enter Email', 'Save-For-Later') ?> </th>
									<td><input name="requested_email" id="requested_email" type="Text" value="<?php echo $reg_email ?>" /><input name="site_url" id="site_url" type="hidden" value="<?php echo get_site_url(); ?>"><input name="token_field" type="hidden" id="token_field" /><input name="kbiz_api_url" id="kbiz_api_url" type="hidden" value="<?php echo get_option('api_url_for_activation'); ?>"></td>
								</tr>
							</table>
							<span style="padding: 5px; margin: 13px;"><input onclick="activate_kbiz()" type="button" value="Submit" name="submit_activation_plugin" /></span>
						</form>
					</div>
				</div>
			<?php } ?>

			<?php if ($this->showtoken) { ?>

				<div style="font-size: 15px; padding: 28px; " class="enter_activate_key">
					<h2 style="text-align: center; color: Green; margin: 35px;"><?php _e($message, 'Save-For-Later') ?></h2>
					<div>
						<h2><?php _e('Enter Activation Key If Have', 'Save-For-Later') ?> </h2>
					</div>
					<div>
						<form style="text-align: initial;" method="post">
							<table>
								<tr>
									<th><?php _e('Enter Activation Key', 'Save-For-Later') ?> </th>
									<td><input name="kbiz_activation_key" type="Text" value="<?php get_option('kbiz_activation_key'); ?>" /></td>
								</tr>
							</table>
							<span style="padding: 5px; margin: 13px;"><input type="submit" value="Submit" name="submit_activation_plugin" /></span>

						</form>
					</div>
				</div>

			<?php } ?>

		<?php
			die();
		} else {

			echo '<h1>Your plugin is Activated</h1>';
		}
	}

	public function wsflla_options_html()
	{
		//echo $this->check_activation();


		/*if($this->wsflla_check_activation() == "disabled" ){ ?>

			 <div style="font-size: 15px; padding: 28px;"><div><h2><?php  _e( 'Plugin is disabled', 'Save-For-Later' ) ?></h2></div> <div> <form id = "check_form_submit" style = "text-align: initial;" method ="post"> <table>
				<tr><th><?php  _e( 'Enable Plugin Functionality', 'Save-For-Later' ) ?>:- </th><td><input onclick ="submit_check_form()" name = "enable_check_box" type="checkbox" /></td></tr>
		        </table>
		        <span><input style = "display:none"  id = "form_submit_checkbox" type = "submit" name ="submit_enable_plugin_form"/></span>

				 </form> </div></div>
			<?php
			die();

		} */

		if ($this->wsflla_check_activation() == "not_activated") { ?>

			<div style="font-size: 15px; padding: 28px; " class="enter_activate_key">
				<h2 style="text-align: center; color: ; margin: 35px;"><?php _e('To Activate Please check your Plugin ', 'Save-For-Later') ?><a href="admin.php?page=settings-for-later-like-amazon"><?php _e('Settings ', 'Save-For-Later') ?></a> Or <a href="admin.php?page=settings-for-later-like-amazon"><?php _e('Click Here', 'Save-For-Later') ?></a>

				</h2>
			</div>

		<?php
			die();
		} else {

			$get_option = get_option('kabiz_button_text');
			$get_option_save_for_list = get_option('get_option_save_for_list');
			$get_option_move_to_cart_text = get_option('kabiz_move_to_cart_button_text'); ?>
			<!--div style = "text-align:center"><div><h2>Plugin is Enabled</h2></div> <div> <form id = "check_form_submit" style = "text-align: initial;" method ="post"> <table>
				<tr><th><?php _e('Enable Plugin Functionality', 'Save-For-Later') ?>Disable Plugin Functionality:- </th><td><input onclick ="submit_check_form()" name = "enable_check_box" type="checkbox" checked /></td></tr>
		        </table>
		        <span><input style = "display:none" id = "form_submit_checkbox" type = "submit" name ="submit_enable_plugin_form"/></span>

				 </form> </div></div-->

			<div style="text-align:center">
				<div>
					<h2><?php _e('Settings for plugin', 'Save-For-Later') ?></h2>
				</div>
				<div>
					<form style="text-align: initial;" method="post">
						<table style="font-size: 13px; padding: 40px; margin: 22px;">
							<tr>
								<th><?php _e('Save For Later List Label', 'Save-For-Later') ?></th>
								<td><input name="get_option_save_for_list" type="Text" value="<?php echo $get_option_save_for_list ?> " /></td>
							</tr>
							<tr>
								<th><?php _e('Save For Later Label', 'Save-For-Later') ?></th>
								<td><input name="option_label" type="Text" value="<?php echo $get_option; ?>" /></td>
							</tr>
							<tr>
								<th><?php _e('Move To cart Button Label', 'Save-For-Later') ?></th>
								<td><input name="option_label_move_to_cart" type="Text" value="<?php echo $get_option_move_to_cart_text; ?>" /></td>
							</tr>
							<tr></tr>

						</table>
						<span style="margin-left: 63px;"><input type="submit" name="submit_kbiz_form" /></span>

					</form>
				</div>
			</div>
			<?php
		}
	}

	/*
		Add Style Sheets and js
	*/


	public function wsflla_enclude_scripts()
	{

		wp_enqueue_script('plugin', WSFLLA_PLUGIN_URL . '/js/plugin.js', array('jquery'));

		wp_localize_script(
			'plugin',
			'my_ajax_object',
			array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'activation_nonce' => wp_create_nonce('wsflla_request_activation_token'),
			)
		);
		wp_enqueue_style('plugin', WSFLLA_PLUGIN_URL . 'css/plugin.css');
		wp_enqueue_style('font-awesome', WSFLLA_PLUGIN_URL . 'css/font-awesome.min.css');
	}

	public function wsflla_request_activation_token()
	{
		check_ajax_referer('wsflla_request_activation_token', 'nonce');

		if (!current_user_can('manage_options')) {
			wp_send_json_error(array('message' => __('You are not allowed to activate this plugin.', 'Save-For-Later')), 403);
		}

		$email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
		$site_url = isset($_POST['site_url']) ? esc_url_raw(wp_unslash($_POST['site_url'])) : home_url('/');
		$api_url = esc_url_raw(get_option('api_url_for_activation'));

		if (!is_email($email) || empty($api_url)) {
			wp_send_json_error(array('message' => __('Please provide a valid email address and activation URL.', 'Save-For-Later')), 400);
		}

		$response = wp_remote_post($api_url, array(
			'timeout' => 15,
			'body' => array('email' => $email, 'site_url' => $site_url),
		));

		if (is_wp_error($response)) {
			wp_send_json_error(array('message' => $response->get_error_message()), 502);
		}

		$status_code = wp_remote_retrieve_response_code($response);
		$response_body = wp_remote_retrieve_body($response);
		$response_data = json_decode($response_body, true);
		$token = is_array($response_data) && !empty($response_data['success']) && !empty($response_data['token'])
			? sanitize_text_field($response_data['token'])
			: '';

		if ($status_code < 200 || $status_code >= 300 || $token === '') {
			$message = is_array($response_data) && !empty($response_data['message'])
				? sanitize_text_field($response_data['message'])
				: __('The activation server did not return a valid token.', 'Save-For-Later');
			wp_send_json_error(array('message' => $message), 502);
		}

		wp_send_json_success(array('token' => $token));
	}



	/*
		Creates Add to Cart Button on cart page.
	*/
	public function wsflla_add_save_for_later_button_cart()
	{


		global $woocommerce;
		global $wpdb;
		$current_user_id = get_current_user_id();
		if ($current_user_id > 0) {
			$current_product_id = get_the_ID();
			$button_text = get_option('kabiz_button_text');
			$loader = WSFLLA_PLUGIN_URL . 'images/ajax-loader.gif';
			foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {

				$this->product[] = $cart_item['product_id'];
			}
			echo '<br><a id ="loader_' . $this->product[$this->counter] . '"  onclick = "save_for_later(' . $this->product[$this->counter] . ')" class="" style="button" href="javascript:void(0);">' . $button_text . '</a>
			<a  href="#" class="modal-link" class="js-open-modal" href="#" data-modal-id="popup" id ="view_loader_' . $this->product[$this->counter] . '"   onclick = "view_saved(' . $this->product[$this->counter] . ')" class="" style="display:none" href="javascript:void(0);"></a>
			<div id = "sloader_' . $this->product[$this->counter] . '" style ="display:none" class="loader"></div>';

			$this->counter++;
		} else if (!is_user_logged_in()) {
			$current_product_id = get_the_ID();
			$button_text = get_option('kabiz_button_text');
			$loader = WSFLLA_PLUGIN_URL . 'images/ajax-loader.gif';
			foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {

				$this->product[] = $cart_item['product_id'];
			}
			echo '<br><a id ="loader_' . $this->product[$this->counter] . '"  onclick = "save_for_later(' . $this->product[$this->counter] . ')" class="" style="button" href="javascript:void(0);">' . $button_text . '</a>
			<a  href="#" class="modal-link" class="js-open-modal" href="#" data-modal-id="popup" id ="view_loader_' . $this->product[$this->counter] . '"   onclick = "view_saved(' . $this->product[$this->counter] . ')" class="" style="display:none" href="javascript:void(0);"></a>
			<div id = "sloader_' . $this->product[$this->counter] . '" style ="display:none" class="loader"></div>';
			$this->counter++;
		}
	}
	/*
		Creates star for save fore later on each product.
	*/
	public function wsflla_add_save_for_later_button()
	{
		global $wpdb;
		$current_user_id = get_current_user_id();
		if ($current_user_id > 0) {
			$current_product_id = get_the_ID();
			if ($this->wsflla_check_product_id($current_product_id)) {
				$loader = WSFLLA_PLUGIN_URL . 'images/ajax-loader.gif';
				echo '<span class = "star"><a id ="loader_' . $current_product_id . '"  onclick = "save_for_later(' . $current_product_id . ')" class="" style="button" href="javascript:void(0);"><span class="fa fa-star"></span></a>
					<a  href="javascript:void(0);" class="modal-link" class="js-open-modal" href="javascript:void(0);" data-modal-id="popup" id ="view_loader_' . $current_product_id . '"   onclick = "view_saved(' . $current_product_id . ')" class="" style="display:none" href="javascript:void(0);"> <span class="fa fa-star checked"></span></a>
					<div id = "sloader_' . $current_product_id . '" style ="display:none" class="loader"></div></span>';
			} else {
				echo '<span class = "star"><a  href="javascript:void(0);" class="modal-link" class="js-open-modal"  data-modal-id="popup" id ="loader_' . $current_product_id . '"  onclick = "open_pop_up(' . $current_product_id . ')" class="" style="button" ><span class="fa fa-star checked"></span></span>';
			}
		}
	}

	public function wsflla_add_save_for_later_button_without_login()
	{
		global $wpdb;
		// $current_user_id = get_current_user_id();
		//if($current_user_id == ""){
		if (!is_user_logged_in()) {
			$current_product_id = get_the_ID();
			if ($this->wsflla_check_product_id($current_product_id)) {
				$loader = WSFLLA_PLUGIN_URL . 'images/ajax-loader.gif';
				echo '<span class = "star"><a id ="loader_' . $current_product_id . '" onclick = "save_for_later(' . $current_product_id . ')" class="get_products" potsids ="' . $current_product_id . '" style="button" href="javascript:void(0);"><span class="fa fa-star"></span></a>
					<a  href="javascript:void(0);" class="modal-link" class="js-open-modal" href="javascript:void(0);" data-modal-id="popup" id ="view_loader_' . $current_product_id . '"   onclick = "view_saved(' . $current_product_id . ')" class="" style="display:none" href="javascript:void(0);"> <span class="fa fa-star checked"></span></a>
					<div id = "sloader_' . $current_product_id . '" style ="display:none" class="loader"></div></span>';
			} else {
				echo '<span class = "star"><a  href="javascript:void(0);" class="modal-link" class="js-open-modal"  data-modal-id="popup" id ="loader_' . $current_product_id . '"  onclick = "open_pop_up(' . $current_product_id . ')" class="" style="button" ><span class="fa fa-star checked"></span></span>';
			}
		}
	}


	/*
		Creates Add to Cart Button on cart page.
	*/
	public function wsflla_check_product_id($current_product_id)
	{

		global $wpdb;
		$current_user_id = get_current_user_id();
		$table_name = $wpdb->prefix . 'save_for_later';
		$result1 = $wpdb->get_results("SELECT COUNT(*) as cp_count FROM $table_name WHERE product_id=$current_product_id AND user_id = $current_user_id");
		if ($result1[0]->cp_count) {
			return false;
		} else {
			return true;
		}
	}


	/*
		Get Saved Product
	*/
	public function wsflla_get_products_saved()
	{

		global $wpdb;
		$current_user_id = get_current_user_id();
		$table_name = $wpdb->prefix . 'save_for_later';
		$result1 = $wpdb->get_results("SELECT * FROM $table_name Where user_id = '$current_user_id'");
		return $result1;
	}

	/* Get Saved product with random id */
	public function wsflla_get_products_cookie_saved()
	{

		global $wpdb;
		//$current_user_id = get_current_user_id();
		$get_random_user = $_COOKIE["random_user_id"];
		$table_name = $wpdb->prefix . 'save_for_later';
		$result1 = $wpdb->get_results("SELECT * FROM $table_name Where guest_id = '" . $get_random_user . "'");
		return $result1;
	}

	public function wsflla_get_user_cookie()
	{
		global $wpdb;
		$get_random_user = $_COOKIE["random_user_id"];
		return $get_random_user;
	}


	/*
		update options
	*/
	public function wsflla_update_option_name($new_value)
	{

		$kabiz_button_text = sanitize_text_field($_POST['option_label']);
		$option_label_move_to_cart = sanitize_text_field($_POST['option_label_move_to_cart']);
		$get_option_save_for_list = sanitize_text_field($_POST['get_option_save_for_list']);
		update_option('kabiz_button_text', $kabiz_button_text);
		update_option('get_option_save_for_list', $get_option_save_for_list);
		update_option('kabiz_move_to_cart_button_text', $option_label_move_to_cart);
	}


	/*
		Creates Add to Cart Button on cart page.
	*/
	public function wsflla_register_ajax_requests_save_to_later()
	{

		global $wpdb;
		$current_user_id = get_current_user_id();
		if ($current_user_id > 0) {
			$table_name = $wpdb->prefix . 'save_for_later';
			$id = sanitize_text_field($_POST['id']);
			$status = 1;
			$cartId = WC()->cart->generate_cart_id($id);
			$cartItemKey = WC()->cart->find_product_in_cart($cartId);
			WC()->cart->remove_cart_item($cartId);
			$query_results = $wpdb->get_results("SELECT * FROM $table_name WHERE user_id = '" . $current_user_id . "' AND product_id = '" . $id . "'");
			//$query = "SELECT * FROM $table_name WHERE 'product_id'= '$id' AND 'user_id' = '$current_user_id'";
			//$query_results = $wpdb->get_results($query);

			if (count($query_results) == 0) {

				$result = $wpdb->query("INSERT INTO " . $table_name . "( `user_id`, `product_id`, `status`) 
																	VALUES ('$current_user_id', '$id', '$status')");
			} else {
				echo json_encode(['status' => '0', 'msg' => 'Not Added SuccessFully']);
			}

			if ($result) {
				echo json_encode(['status' => '0', 'msg' => 'Added SuccessFully']);
			} else {
				echo json_encode(['status' => '0', 'msg' => 'somthing happend wrong']);
			}
			wp_die();
		} elseif (!is_user_logged_in()) {
			/* Add without login insert data with cookie ids Start */
			$table_name = $wpdb->prefix . 'save_for_later';
			$id = sanitize_text_field($_POST['id']);
			//$get_userid = sanitize_text_field( $_POST['user_id'] );			
			$status = 1;
			$cartId = WC()->cart->generate_cart_id($id);
			$cartItemKey = WC()->cart->find_product_in_cart($cartId);
			WC()->cart->remove_cart_item($cartId);
			//$get_random_user = $_COOKIE["random_user_id"];	
			$idddd	= $this->wsflla_get_user_cookie();
			$query_results = $wpdb->get_results("SELECT * FROM $table_name WHERE guest_id = '" . $idddd . "' AND product_id = '" . $id . "'");
			if (count($query_results) == 0) {

				$result = $wpdb->query("INSERT INTO " . $table_name . "( `guest_id`, `product_id`, `status`) 
																	VALUES ('$idddd', '$id', '$status')");
			} else {
				echo json_encode(['status' => '0', 'msg' => 'Not Added SuccessFully']);
			}

			if ($result) {
				echo json_encode(['status' => '0', 'msg' => 'Added SuccessFully']);
			} else {
				echo json_encode(['status' => '0', 'msg' => 'somthing happend wrong']);
			}
			wp_die();

			/* Add without login insert data with cookie ids  end  */
		} else {
			echo json_encode(['status' => '0', 'msg' => 'Please Login']);
		}
	}

	/* After login save product with cookie function */

	public function get_all_save_for_later_product($user)
	{
		global $wpdb;
		$table_data_name = $wpdb->prefix . "users";
		$user_data = $wpdb->get_results("SELECT * FROM $table_data_name WHERE user_nicename = '" . $user . "'");
		$current_user_id = $user_data[0]->ID;
		if ($current_user_id > 0) {
			$table_name = $wpdb->prefix . 'save_for_later';
			$id = sanitize_text_field($_COOKIE["random_user_id"]);
			$status = 1;
			$cartId = WC()->cart->generate_cart_id($id);
			$cartItemKey = WC()->cart->find_product_in_cart($cartId);
			WC()->cart->remove_cart_item($cartId);
			$query_results = $wpdb->get_results("SELECT * FROM $table_name WHERE guest_id = '" . $id . "'");
			if (count($query_results) != 0) {
				$sql = "UPDATE $table_name SET `user_id`= '" . $current_user_id . "' WHERE  `guest_id` = '" . $id . "'";
				$rez = $wpdb->query($sql);
			}
		} else {
			echo json_encode(['status' => '0', 'msg' => 'Please Login']);
		}
	}

	public function unset_cookie_function_logout()
	{
		//unset($_COOKIE['Product_ids']);
		if (isset($_COOKIE['Product_ids'])) {
			unset($_COOKIE['Product_ids']);
			setcookie('Product_ids', null, -1, '/');
			return true;
		} else {
			return false;
		}
	}

	/*
		delete itoms form saved list
	*/
	public function wsflla_register_ajax_requests_remove_save_to_later()
	{

		global $wpdb;
		global $woocommerce;
		$current_user_id = get_current_user_id();
		if ($current_user_id > 0) {
			$table_name = $wpdb->prefix . 'save_for_later';
			$product_id = sanitize_text_field($_POST['id']);
			if (isset($_POST['move_to_cart'])) {


				$product_id = sanitize_text_field($_POST['id']);
				$woocommerce->cart->add_to_cart($product_id, 1);

				if (!empty($product_id) && is_numeric($product_id)) {

					if ($wpdb->delete($table_name, array('product_id' => $product_id, 'user_id' => $current_user_id))) {
						echo "deleted";
					} else {
						echo "error";
					}
				}
				die();
			}
			if (isset($_POST['delete_record'])) {

				if (!empty($product_id) && is_numeric($product_id)) {

					if ($wpdb->delete($table_name, array('product_id' => $product_id, 'user_id' => $current_user_id))) {
						echo "deleted";
					} else {
						echo "error";
					}
				}
				die();
			}
		} elseif (!is_user_logged_in()) {
			$table_name = $wpdb->prefix . 'save_for_later';
			$product_id = sanitize_text_field($_POST['id']);
			$rondom_user_id = sanitize_text_field($_COOKIE["random_user_id"]);
			if (isset($_POST['move_to_cart'])) {

				$product_id = sanitize_text_field($_POST['id']);
				$woocommerce->cart->add_to_cart($product_id, 1);

				if (!empty($product_id) && is_numeric($product_id)) {

					if ($wpdb->delete($table_name, array('product_id' => $product_id, 'guest_id' => $rondom_user_id))) {
						echo "deleted";
					} else {
						echo "error";
					}
				}
				die();
			}
			if (isset($_POST['delete_record'])) {

				if (!empty($product_id) && is_numeric($product_id)) {

					if ($wpdb->delete($table_name, array('product_id' => $product_id, 'guest_id' => $rondom_user_id))) {
						echo "deleted";
					} else {
						echo "error";
					}
				}
				die();
			} // End without login delete  record on the cart page			

		}
	}
	/*
		move to cart.
	*/
	public function wsflla_move_to_cart()
	{

		global $woocommerce;
		$product_id = sanitize_text_field($_POST['id']);
		$woocommerce->cart->add_to_cart($product_id, 1);
		global $wpdb;
		$table_name = $wpdb->prefix . 'save_for_later';
		$current_user_id = get_current_user_id();
		if ($current_user_id > 0) {
			if (!empty($product_id && is_numeric($product_id))) {

				if ($wpdb->delete($table_name, array('product_id' => $product_id, 'user_id' => $current_user_id))) {
					echo "deleted";
				} else {
					echo "error";
				}
			}
		}
	}

	public function curl_post($url, $postVars = array(1, 2, 3))
	{
		//Transform our POST array into a URL-encoded query string.
		$postStr = http_build_query($postVars);
		//Create an $options array that can be passed into stream_context_create.
		$options = array(
			'http' =>
			array(
				'method'  => 'POST', //We are using the POST HTTP method.
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $postStr //Our URL-encoded query string.
			)
		);
		//Pass our $options array into stream_context_create.
		//This will return a stream context resource.
		$streamContext  = stream_context_create($options);
		//Use PHP's file_get_contents function to carry out the request.
		//We pass the $streamContext variable in as a third parameter.
		$result = file_get_contents($url, false, $streamContext);
		//If $result is FALSE, then the request has failed.
		if ($result === false) {
			//If the request failed, throw an Exception containing
			//the error.
			$error = error_get_last();
			throw new Exception('POST request failed: ' . $error['message']);
		}
		//If everything went OK, return the response.
		return $result;
	}

	public function wsflla_plugin_go()
	{

		$reg_email = get_option('kbiz_registration_email');
		if ($reg_email == "") {

			$reg_email = get_option('admin_email');
		}
		$site_url = get_site_url();
		$api = get_option('api_url_for_activation');
		$user_end_code_to_check = get_option('user_end_code_to_check');
		$curl = curl_init();

		$status = $this->curl_post($api, array('action' => 'check_activation', 'xxemail' => $reg_email, 'site' => $site_url, 'to_check' => $user_end_code_to_check));
		$status_data = json_decode(trim($status), true);
		$is_active = is_array($status_data) && !empty($status_data['success']) && !empty($status_data['active']);
		if (!$is_active) {

			delete_option('user_end_code_to_check');
			delete_option('requested_activation_key');
			delete_option('server_allow');
			delete_option('enable_disable_plugin');
			delete_option('kbiz_activation_key');
		}
	}

	public function wsflla_footer_html()
	{
		global $wpdb;
		$current_user_id = get_current_user_id();
		$save_for_list = get_option('get_option_save_for_list');
		$get_option = get_option('kabiz_move_to_cart_button_text');
		if ($current_user_id > 0) {
			global  $woocommerce;
			$products = $this->wsflla_get_products_saved();
			if (count($products) > 0) {
			?>
				<h2 class="close" style="text-align:center;"> <?php _e($save_for_list, 'Save-For-Later') ?></h2>
				<div class="">
					<table>
						<?php

						if (count($products) > 0) {

							foreach ($products as $key => $value) {

								$product_id = $value->product_id;
								$product = wc_get_product($value->product_id);
								if ($product) {

									$get_name = $product->get_name();
									$get_price = $product->get_price();
									$get_image = $product->get_image();
								}

						?>
								<tr>
									<th><i onclick="delete_record(<?php echo $product_id; ?>)" class="fa fa-close" style="font-size:24px;color:red"></i></th>
									<th style="width:50px"><?php echo $get_image ?></th>
									<th><a href="<?php echo get_permalink($product_id); ?>"><?php echo $get_name ?></a></th>
									<th><?php echo get_woocommerce_currency_symbol() . $get_price ?></th>
									<th><a href="javascript::void(0)" onclick="add_to_cart(<?php echo $product_id; ?>)"><?php _e($get_option, 'Save-For-Later') ?></a></th>
								</tr>
						<?php }
						} else {
							echo '<tr><th>' . _e('No records Found !', 'Save-For-Later') . '</th></tr>';
						}
					} // THis IS not showing product areas save for later 
				} else if (!is_user_logged_in()) {
					global  $woocommerce;
					$Set_products = $this->wsflla_get_products_cookie_saved();
					if (count($Set_products) > 0) {
						?>
						<h2 class="close" style="text-align:center;"> <?php _e($save_for_list, 'Save-For-Later') ?></h2>
						<div class="">
							<table>
								<?php

								if (count($Set_products) > 0) {

									foreach ($Set_products as $key => $value) {

										$product_id = $value->product_id;
										$product = wc_get_product($value->product_id);
										if ($product) {
											$get_name = $product->get_name();
											$get_price = $product->get_price();
											$get_image = $product->get_image();
										}

								?>
										<tr>
											<th><i onclick="delete_record(<?php echo $product_id; ?>)" class="fa fa-close" style="font-size:24px;color:red"></i></th>
											<th style="width:50px"><?php echo $get_image ?></th>
											<th><a href="<?php echo get_permalink($product_id); ?>"><?php echo $get_name ?></a></th>
											<th><?php echo get_woocommerce_currency_symbol() . $get_price ?></th>
											<th><a href="javascript::void(0)" onclick="add_to_cart(<?php echo $product_id; ?>)"><?php _e($get_option, 'Save-For-Later') ?></a></th>
										</tr>
						<?php }
								} else {
									echo '<tr><th>' . _e('No records Found !', 'Save-For-Later') . '</th></tr>';
								}
							} // Hide no record on plugin 	
						}


						?>
							</table>
							</p>

						</div>
						<div class="modal-bg" style="display: none;"></div>
				<?php }
		}


				?>
