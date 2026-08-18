<?php

defined('ABSPATH') or die;

class ntmode_options{
	
	public function ntmode_AdminPage(){
		 add_submenu_page('options-general.php','Night Mode','Night Mode','manage_options','admin-custom-color',array(&$this, 'ntmod_init'));
	}

	function ntmod_init(){ 
		if( isset( $_GET[ 'tab' ] ) || !isset($_GET['tab'])) {
			$active_tab = isset( $_GET[ 'tab' ] ) ? sanitize_text_field($_GET[ 'tab' ]) : 'admin-custom-color';
		}
		$ntmode_tablink = admin_url() . 'admin.php?page=admin-custom-color&tab=admin-custom-color';
		$active_tab = ( $active_tab == 'admin-custom-color') ? 'nav-tab-active' : '';
		?>
		<h2 class="nav-tab-wrapper"><a href="<?php esc_html_e(esc_url($ntmode_tablink)) ?>" class="nav-tab <?php esc_html_e($active_tab); ?>">Night Mode</a></h2> 
		<?php
		$is_nightmd_on = isset(get_option('ntmode_page_setting') ['enable-me'] ) ? get_option('ntmode_page_setting') ['enable-me'] : "off";
		if( $is_nightmd_on =='on') $check='checked="checked"'; else $check=''; 
		?>
		<div class="container">
			<form method="post" action="options.php" style="margin-top:25px;">
			<?php wp_nonce_field("update-options"); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php  _e('Night Mode Settings','night-mode') ; ?></th>
					<td><input type="checkbox" <?php  esc_html_e($check); ?> class="form-control chkinp" id="input-checkbox" name="ntmode_page_setting[enable-me]" ></td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php  _e('Background Color','night-mode') ; ?> </th>
					<td><input type="text" class="form-control text-bg-color jscolor {width:101, padding:0, shadow:false, borderWidth:0, backgroundColor:'transparent', insetColor:'#000'}" id="back-colors" value = "<?php  esc_html_e(get_option('ntmode_page_setting')['bg-color']); ?>" name="ntmode_page_setting[bg-color]" placeholder="eg. #ffffff"></td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php  _e('Text Color','night-mode') ; ?></th>
					<td><input type="text" class="form-control text-color jscolor {width:101, padding:0, shadow:false, borderWidth:0, backgroundColor:'transparent', insetColor:'#000'}"  value ="<?php  esc_html_e(get_option('ntmode_page_setting')['txt-color']); ?>"  name="ntmode_page_setting[txt-color]" id="text-color" placeholder="eg. #000000"></td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php  _e('Anchor Color','night-mode') ; ?></th>
					<td><input type="text" class="form-control text-color jscolor" value = "<?php  esc_html_e(get_option('ntmode_page_setting')['anc_color']); ?>" name="ntmode_page_setting[anc_color]" id="nitmod-anch-color" class="anc_color" /></td>
				</tr>
			</table>

			<input type="submit" class="btm button-primary" name="Submit" value="<?php  _e('Save Options','night-mode') ; ?>" />
			
			<input type="hidden" name="action" value="<?php  _e('update','night-mode') ; ?>" />
			<input type="hidden" name="page_options" value="<?php  _e('ntmode_page_setting','night-mode') ; ?>" />
			</form>
		</div>
		<?php	
	}
	
	// add file to admin footer
	function ntmod_Footer(){
		wp_enqueue_script("jquery");
		
		$is_nightmd_on = isset(get_option('ntmode_page_setting') ['enable-me'] ) ? get_option('ntmode_page_setting') ['enable-me'] : "off";
		if( $is_nightmd_on =='on'){  ?>
			<input type="hidden" class="hidtex_color" value="<?php  esc_html_e(get_option('ntmode_page_setting')['txt-color']); ?>" />
			<input type="hidden" class="hid_back_color" value="<?php  esc_html_e(get_option('ntmode_page_setting')['bg-color']); ?>" />
			<input type="hidden" class="hidtexv2" value="<?php  esc_html_e(get_option('ntmode_page_setting')['enable-me']); ?>" />
			<input type="hidden" class="hid_acolor" value="<?php  esc_html_e(get_option('ntmode_page_setting')['anc_color']); ?>" />';
			<?php
			wp_enqueue_script( 'ava-test-js', plugin_dir_url( __FILE__ ) . 'js/body_color.js', array( 'jquery' ) );
		}
		wp_enqueue_script( 'jscolor-js', plugin_dir_url( __FILE__ ) . 'js/jscolor.js', array( 'jquery' ) );
	}
	
}

?>