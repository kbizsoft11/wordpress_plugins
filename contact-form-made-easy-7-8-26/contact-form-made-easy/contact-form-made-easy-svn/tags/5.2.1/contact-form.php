<?php 
   /*
    Plugin Name: Contact Form Made Easy
    Description: Contact Form Made Easy is the Wordpress plugin which makes it easier to integrate the contact form on your pages, also with this contact form specifically, you can categorize the mailing lists and can distribute it across the different pages of the website
    Author: Raj
	Version: 1.3
    Author URI: https://kbizsoft.com
	Text Domain: contact-form-made-easy
	Domain Path: /languages/
    */

	if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
	
	/* include different files */
	include("functions.php");
	include("includes/form.php");
	include("includes/deliver_mail.php");
	
	
	/* include style.css */
	wp_enqueue_style('style', plugin_dir_url( __FILE__ ) . 'assets/css/style.css' );
	
	/* adding admin menu on plugin activation */
	function kbcf_add_contact_plugin_admin_menu() {
		add_menu_page('Easy Contact Form', 'Easy Contact Form', 'manage_options', 'edit.php?post_type=formcategories','',plugins_url('contact-form-made-easy/assets/images/contact_icon.png',__DIR__));
		
		add_submenu_page( 
			'edit.php?post_type=formcategories'   // -> Set to null - will hide menu link
			, 'Settings'    // -> Page Title
			, 'Settings'    // -> Title that would otherwise appear in the menu
			, 'manage_options' // -> Capability level
			, 'settings'   // -> Still accessible via admin.php?page=menu_handle
			, 'get_form_settings' // -> To render the page
		); 
		
		add_submenu_page( 
			null           // -> Set to null - will hide menu link
			, 'Form Users'    // -> Page Title
			, 'Form Users'    // -> Title that would otherwise appear in the menu
			, 'manage_options' // -> Capability level
			, 'form_users'   // -> Still accessible via admin.php?page=menu_handle
			, 'get_form_users' // -> To render the page
		); 
	}
	add_action('admin_menu', 'kbcf_add_contact_plugin_admin_menu');
	
	/*get users page*/
	function get_form_users(){
		include("includes/form_users.php");
	}
	
	/*get users page*/
	function get_form_settings(){
		include("includes/settings.php");
	}
	
	/* create shortcode column */
	function kbcf_columns_head($columns) {		
		$columns['short_code'] = __('shortcode', 'contact-form-made-easy');
		$columns['view_users'] = __('View Users', 'contact-form-made-easy');
		$columns['users_count'] = __('Total Users', 'contact-form-made-easy');
		unset($columns['date']);
		return $columns;
		
	}
	add_filter('manage_posts_columns', 'kbcf_columns_head');
	
	
	/* shortcode column value in admin */
	function kbcf_columns_content($column_name, $post_id) {
		global $wpdb;
		$user_table = $wpdb->prefix . "kbcf_cform";
		$sql =  "SELECT count(Distinct email) as count FROM $user_table where cat_id = $post_id";
		$result = $wpdb->get_results( $sql ); 
		
		if ($column_name == 'short_code'){
			echo '[kb_contact_form id = "'.$post_id.'"]';		
		}
		
		if ($column_name == 'view_users'){
			echo '<a href="admin.php?page=form_users&cat='.$post_id.'">View Users</a>';		
		}
		
		if ($column_name == 'users_count'){
			if($result){
				echo '<a id="'.$post_id.'" href="">'.$result[0]->count.'</a>';
			}else{
				echo '<a id="'.$post_id.'" href="">0</a>';
			}				
		}
	}
	add_action('manage_posts_custom_column', 'kbcf_columns_content', 10, 2);
   
   
	/* create form and send mail call on adding shortcode to post/page */
	function kbcf_shortcode($kbcf_atts) {
		
		$kbcf_att_arr = shortcode_atts( array(
			'id' => '0'
		), $kbcf_atts );
		$form_id = $kbcf_att_arr['id'];
		ob_start();
		$kbcf_form = new kbcfForm;
		$kbcf_form->kbcf_contact_form();
		$kbcf_mail = new kbcfDeliverMail;
		$kbcf_mail->kbcf_deliver_mail($form_id);
		return ob_get_clean();
		
	}
	add_shortcode( 'kb_contact_form', 'kbcf_shortcode' );
	
	/* create tables on plugin activation */
	function kbcf_create_plugin_database_table(){
		global $wpdb;
		global $wnm_db_version;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		
		$cat_table = $wpdb->prefix . "kbcf_cat";
		if($wpdb->get_var("show tables like '". $cat_table . "'") != $cat_table){ 
			$sql_cat_table = "CREATE TABLE ". $cat_table . "     (
			id int(11) NOT NULL,
			name varchar(128) NOT NULL,
			email varchar(256) NOT NULL,
			PRIMARY KEY (id)
			) ";
		}

		$user_table = $wpdb->prefix . "kbcf_cform";
		if($wpdb->get_var("show tables like '". $user_table . "'") != $user_table){ 
			$sql_form_table = "CREATE TABLE ". $user_table . "   (
			id int(11) NOT NULL AUTO_INCREMENT,
			cat_id int(11) NOT NULL,
			name varchar(128) NOT NULL,
			email varchar(256) NOT NULL,
			phone_no varchar(128) NOT NULL,
			message varchar(500) NOT NULL,
			last_updated datetime  NOT NULL,
			PRIMARY KEY (id),
			FOREIGN KEY(cat_id) REFERENCES  $cat_table(id)
			) ";
		}		
		
		dbDelta($sql_cat_table);
		dbDelta($sql_form_table);
		add_option("wnm_db_version", $wnm_db_version);
	}
	register_activation_hook( __FILE__, 'kbcf_create_plugin_database_table' );
	
	
	/* save new form to cat table */
	function kbcf_add_new_post_id_to_table($post_id) {
		global $wpdb;
		global $post; 
		$cat_table = $wpdb->prefix . "kbcf_cat";	
		
		$post_type = get_post_type( $post_id );
		if($post_type != 'formcategories'){
			return;
		}else{
			$post_status = get_post_status( $post_id );
		
			if ( 'publish' != $post_status ){
				return false;
			}else{
				$cat_name = get_the_title( $post_id );
				if(get_option('kbcf_settings_email') != ''){
					$contact_email = get_option( 'kbcf_settings_email' );
				}else{
					$contact_email = get_option( 'admin_email' );
				}
				$wpdb->insert( $cat_table, array( 'id' => $post_id, 'name' => $cat_name,  'email' => $contact_email ) );
			}			
		}		
	}
	add_action( 'wp_insert_post', 'kbcf_add_new_post_id_to_table' );
	
	/**
	 * Redirect to the edit.php on post save or publish.
	 */
	function kbcf_redirect_post_location( $location ) {

		if ( 'formcategories' == get_post_type() ) {

		/* Custom code for 'formcategories' post type. */

			if ( isset( $_POST['save'] ) || isset( $_POST['publish'] ) )
				return admin_url( "edit.php?post_type=formcategories" );

		} 
		return $location;
	}  
	add_filter( 'redirect_post_location', 'kbcf_redirect_post_location' );
	
	
	/* update post hook for custom table*/
	function kbcf_update_database_with_info( $post_id ) {
		global $wpdb;
		// global $post;
		$cat_name = get_the_title( $post_id );	
		$cat_table = $wpdb->prefix . "kbcf_cat";
		$post_type = get_post_type( $post_id );
		$slug = "formcategories";
		if($post_type != $slug){
			return;
		}else{
			$wpdb->query( 
				$wpdb->prepare( 
					"UPDATE $cat_table
					 SET `name` = %s 
					  WHERE id = $post_id;",
					 $cat_name
				)
			);		
		}
	}
	add_action( 'save_post', 'kbcf_update_database_with_info' );
	
	
	/*------------------------------------------------------------------------------------
    remove quick edit for custom post type videos just to check if less mem consumption
	------------------------------------------------------------------------------------*/
	add_filter( 'post_row_actions', 'kbcf_remove_row_actions', 10, 2 );
	function kbcf_remove_row_actions( $actions, $post )
	{
		global $current_screen;
		if( $current_screen->post_type != 'formcategories' ) 
			return $actions;
		unset( $actions['view'] );
		unset( $actions['inline hide-if-no-js'] );
		
		return $actions;
	}
	
	/*---------------------------------------------
      drop custom tables on plugin deactivation
	----------------------------------------------*/
	function kbcf_delete_custom_table() {
		global $wpdb;
		$cat_table = $wpdb->prefix . "kbcf_cat";
		$user_table = $wpdb->prefix . "kbcf_cform";
		$wpdb->prefix .
		$sql = "DROP TABLE IF EXISTS $user_table, $cat_table";
		$wpdb->query($sql);
	}
	register_deactivation_hook( __FILE__, 'kbcf_delete_custom_table' );
	
	
	function plugin_name_i18n() {
		load_plugin_textdomain( 'contact-form-made-easy', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}//end plugin_name_i18n()
	add_action( 'plugins_loaded', 'plugin_name_i18n' );
	
	
?>

