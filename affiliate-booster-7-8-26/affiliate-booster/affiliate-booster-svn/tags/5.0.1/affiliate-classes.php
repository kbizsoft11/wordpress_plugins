<?php

defined( 'ABSPATH' ) or die();

class AFBT_Options
{	
	private $json_arr;
	private $style;
	private $linkarray;
	public function __construct()
	{
		global $wpdb;
		$this->wpdb = $wpdb;
		$this->table_name = $afbt_table_name = $this->wpdb->prefix . 'affiliate_boost';
		$this->table_name2 = $afbt_table_name2 = $this->wpdb->prefix . 'affiliate_boost_website';
		$this->posts = $afbt_table_name3 = $this->wpdb->prefix . 'posts';
	}
	
	public function afbt_AddAdminPage() 
    {
        $abOptionsPage = add_submenu_page('options-general.php','Affiliate Booster','Affiliate Booster','manage_options','affiliate-boost-options',array(&$this, 'afbtGetOptionsScreen'));
        $abStylePage = add_submenu_page('affiliate-boost-options','Style Editor','Style','manage_options','affiliate-boost-style',array(&$this, 'afbtGetOptionsScreen'));
    }
	
	public function afbtGetOptionsScreen() 
    {
        // Settings navigation tabs
        if( isset( $_GET[ 'tab' ] ) || !isset($_GET['tab'])) {
            $active_tab = isset( $_GET[ 'tab' ] ) ? sanitize_text_field($_GET[ 'tab' ]) : 'affiliate_retrieval_section';
        }
        $afbtRetrieveLink = admin_url() . 'admin.php?page=affiliate-boost-options&tab=affiliate_retrieval_section';
        $afbtTestsLink    = admin_url() . 'admin.php?page=affiliate-boost-options&tab=affiliate_style';
        
        echo '<h2 class="nav-tab-wrapper"><a href="' . esc_url($afbtRetrieveLink) .'" class="nav-tab ';
        echo $active_tab == 'affiliate_retrieval_section' ? 'nav-tab-active' : '';
        echo '">Affiliate Booster</a><a href="' . esc_url($afbtTestsLink) .'" class="nav-tab ';
        echo $active_tab == 'affiliate_style' ? 'nav-tab-active' : '';
        echo '">Style Editor</a></h2>';

        // Settings form
       if($_GET[ 'tab' ] == 'affiliate_retrieval_section' || !isset($_GET['tab'])){  ?>
				<div class="container">
				  <div class="">
					<h1></h1>
					<div class="col-sm-12">
						<table id="affiliate_grid" class="table table-condensed table-hover table-striped" width="60%" cellspacing="0" data-toggle="bootgrid">
							<div class="pull-left records-add"><button type="button" class="btn btn-xs btn-primary" id="command-add" data-row-id="0">
							<span class="glyphicon glyphicon-plus"></span><?php echo _e('Add Record','affiliate-booster') ; ?></button></div>
							<thead>
								<tr>
									<th data-column-id="w_id" data-type="numeric" data-identifier="true"><?php echo _e('S.No.','affiliate-booster') ; ?></th>
									<th data-column-id="website"><?php echo _e('Website Page Link','affiliate-booster') ; ?></th>
									<th data-column-id="commands" data-formatter="commands" data-sortable="false"><?php echo _e('Action','affiliate-booster') ; ?></th>
								</tr>
							</thead>
						</table>
					</div>
				  </div>
				</div>
				<div id="add_model" class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title"><?php echo _e('Add Keyword','affiliate-booster') ; ?></h4>
							</div>
							<div class="modal-body">
								<form method="post" id="frm_add">
									<input type="hidden" value="add" name="actions" id="actions">
									<div class="form-group">
									    <label for="page-type" class="control-label"><?php echo _e('Page Type','affiliate-booster') ; ?></label><br>
										<label class="radio-inline">
										  <input type="radio" name="type_page" id="page" value="page" class="radio" checked><?php echo _e('Page','affiliate-booster') ; ?>
										</label>
										<label class="radio-inline">
										  <input type="radio" name="type_page" id="post" value="post" class="radio"><?php echo _e('Post','affiliate-booster') ; ?> 
										</label>
									</div>
									<div class="form-group">
										<label for="website-page-link" class="control-label"><?php echo _e('Website Page Link:','affiliate-booster') ; ?></label>
										<select id="selectBox" name="add_website" style="width:100%">
											<option value=""><?php echo _e('Select Option','affiliate-booster') ; ?></option>
										</select><br><br>
										<!--<input type="text" class="form-control" id="website" name="add_website"/>-->
									</div>
									<label for="keywords" class="control-label"><?php echo _e('Keywords & Affiliate Link:','affiliate-booster') ; ?></label><br>
									<div class="form-group input_fields_wrap">
										<div class="ddd">
											
											<input type="text" id="keywords_1" class="keywords" placeholder="Keyword: 1" name="keywords[]"/>

											<input type="text" id="affiliate_link_1" class="affiliate_link" placeholder="http:// or https://" name="affiliate_link[]"/>

											<button class="btn add_field_button btn-primary"><?php echo _e('Add More Fields','affiliate-booster') ; ?></button>
										</div>
										<div class="input_fields_wraps"></div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default close_btn " data-dismiss="modal"><?php echo _e('Close','affiliate-booster') ; ?></button>
										<button type="button" id="btn_add" class="btn btn-primary"><?php echo _e('Save','affiliate-booster') ; ?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div id="edit_model" class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title"><?php echo _e('Edit Keywords','affiliate-booster') ; ?></h4>
							</div>
							<div class="modal-body">
								<form method="post" id="frm_edit">
									<input type="hidden" value="edit" name="actions" id="actions">
									<input type="hidden" value="0" name="edit_id" id="edit_id">
									<div class="form-group">
									    <label for="page-type" class="control-label"><?php echo _e('Page Type','affiliate-booster') ; ?></label><br>
										<label class="radio-inline">
										 <input type="radio" name="type_page_edit" id="page_edit" value="page" class="radio_edit" checked><?php echo _e('Page','affiliate-booster') ; ?>
										</label>
										<label class="radio-inline">
										  <input type="radio" name="type_page_edit" id="post_edit" value="post" class="radio_edit"><?php echo _e('Post','affiliate-booster') ; ?>
										</label>
									</div>
									<div class="form-group">
										<label for="website-page-link" class="control-label"><?php echo _e('Website Page Link:','affiliate-booster') ; ?></label>
										<select id="edit_website" name="edit_website" style="width:100%"></select>
									</div>
									<div class="form-group">
									 <button class="btn add_field_edit btn-primary"><?php echo _e('Add More Fields','affiliate-booster') ; ?></button>
									</div>
									<label for="keywords" class="control-label"><?php echo _e('Keywords &amp; Affiliate Link:','affiliate-booster') ; ?></label><br>
									<div class="form-group input_fields_edit" id="form-group"></div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default close_btn" data-dismiss="modal"><?php echo _e('Close','affiliate-booster') ; ?></button>
										<button type="button" id="btn_edit" class="btn btn-primary"><?php echo _e('Save','affiliate-booster') ; ?></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div> 	
			<script type="text/javascript">
			jQuery.noConflict();
			jQuery( document ).ready(function(jQuey) { 
				var grid = jQuery("#affiliate_grid").bootgrid({
					ajax: true,
					rowSelect: true,
					url: "<?php echo admin_url("admin-ajax.php?action=afbt_db_function", null); ?>",
					formatters: {
						"commands": function(column, row)
						{
						return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.web_id + "\"><span class=\"glyphicon glyphicon-edit\"></span></button> " + 
		                "<button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.web_id + "\"><span class=\"glyphicon glyphicon-trash\"></span></button>";
						}
					}
					
				}).on("loaded.rs.jquery.bootgrid", function(){
					/* Executes after data is loaded and rendered */
					grid.find(".command-edit").on("click", function(e){
						var ele =jQuery(this).parent();
						jQuery("#edit_model").modal("show");
						if(jQuery(this).data("row-id") >0) {
							// collect the data
							var id = jQuery(this).data("row-id");
							jQuery("#edit_id").val(jQuery(this).data("row-id"));
							jQuery("#form-group").html("");
							jQuery("#edit_website").html("");
							jQuery.ajax({
								type: "POST",  
								url: "<?php echo admin_url("admin-ajax.php", null); ?>",  
								data: { action: "afbt_db_function", 'actions':'edit_all','id': id},      
								success: function(response){
									var split_res =  response.split('++');
									jQuery("input[name=type_page_edit][value='"+jQuery.trim(split_res[2])+"']").prop("checked",true);
									jQuery("#form-group").append(split_res[0]);
									jQuery("#edit_website").append(split_res[1]);
								}   
							});
						} else {
							alert("Now row selected! First select row, then click edit button");
						}
					}).end().find(".command-delete").on("click", function(e){

						var conf = confirm("Are you sure want to delete");
						if(conf){
						jQuery.post("<?php echo admin_url("admin-ajax.php", null); ?>", { id: jQuery(this).data("row-id"), action:"afbt_db_function",actions:"delete"}
						, function(){
							jQuery("#affiliate_grid").bootgrid("reload");
						}); 
						}
					});
				});
				/*
				*
				*/
				function addError(current_id,err_class){ // show error on add blank fields
					jQuery("#"+current_id).css("border", "2px solid red");
					jQuery("#"+current_id).addClass(err_class);
				}
				function removeError(current_id,err_class){ // show error on edit blank fields
					jQuery("#"+current_id).css("border", "1px solid #ddd");
					jQuery("#"+current_id).removeClass(err_class);
				}
				jQuery(document).on("change",".keywords",function(event) {
					var key = jQuery(this).val().trim();
					var current_id  = jQuery(this).attr("id");
					var website_val= jQuery("select[name=add_website]").val();
					if(website_val){
						removeError("selectBox","error_ab");
						jQuery('.keywords').each(function(){
							var loop_id  = jQuery(this).attr("id");
							var old_key = jQuery(this).val().trim();
							if(current_id == loop_id){
								if(!jQuery(".error_ab").is(":visible")){
									jQuery.ajax({
										type: "POST",  
										url: "<?php echo admin_url("admin-ajax.php", null); ?>",  
										data: { action:'afbt_db_function',actions:"get_match",'page_val': website_val,'value':key},    
										success: function(response){	
											var res = response.trim();
											if(res == 'Exists'){
												addError(current_id,'error_ab');
												jQuery("#"+current_id).css("border", "2px solid red");
												alert("Keyword "+key+" Allready Exist In Database");
												jQuery("#"+current_id).val("");
											}else{
												removeError(current_id,"error_ab");
											}
										}   
									})
								}
							}else{
								if(key == old_key){
									addError(current_id,'error_ab');
									alert("Keyword "+key+" Allready Exist");
									jQuery("#"+current_id).val("");
								}else{
									removeError(loop_id,"error_ab");
								}
							}
						});
					}else{
						alert("Please Select Website Page Link");
						jQuery("#"+current_id).val("");
						addError("selectBox","error_ab");
					}
				});
				/*
				*
				*/
				jQuery(document).on("change",".keywords_edit",function(event) {
					var key_edit = jQuery(this).val().trim();;
					var currentedit_id  = jQuery(this).attr("id");
					jQuery('.keywords_edit').each(function(){
						var loopedit_id  = jQuery(this).attr("id");
						var oldedit_key = jQuery(this).val().trim();;
						
						if(currentedit_id == loopedit_id){
							removeError(loopedit_id,"error_edit");
						}
						else{
							
							if(key_edit == oldedit_key){
								addError(currentedit_id,"error_edit");
								alert("Keyword "+key_edit+" Allready Exist");
								jQuery("#"+currentedit_id).val("");
							}else{
								removeError(loopedit_id,"error_edit");
							}
						}
						
					});
				});
				// validate fileds
				function validate_field(field_n){
					 if(field_n == "input[name='keywords[]']" ||  field_n =="input[name='affiliate_link[]']"){
						 var err_cls='error_ab';
					 }else{
						 var err_cls='error_edit';
					 }
					 jQuery(field_n).each(function() {
						var value = jQuery(this).val();
						var id = jQuery(this).attr("id");
						if (value.length === 0) {
							jQuery("#"+id).css("border", "2px solid red");
							jQuery("#"+id).addClass(err_cls);
						}else{
							jQuery("#"+id).removeClass(err_cls);
							jQuery("#"+id).css("border", "1px solid #ddd");
						}
					});
				}
				// save fileds
				function ajaxAction(action) {
					data = jQuery("#frm_"+action).serializeArray();
					jQuery.ajax({
						type: "POST",  
						url: "<?php echo admin_url("admin-ajax.php?action=afbt_db_function", null); ?>",  
						data: data,
						dataType: "json",       
						success: function(response){
							jQuery("#"+action+"_model").modal("hide");
							jQuery("#affiliate_grid").bootgrid("reload"); 
						}   
					});
				}

				jQuery( ".close_btn" ).click(function() {
					jQuery("#affiliate_grid").bootgrid("reload");
				});
				
				jQuery( "#command-add" ).click(function() {
					jQuery(".input_fields_wraps").html("");
					jQuery('#frm_add input[type="text"]').val('');
					jQuery("#add_model").modal("show");
					var page_type = jQuery('input[name=type_page]:checked').val();
					jQuery.ajax({
						type: "POST",  
						url: "<?php echo admin_url("admin-ajax.php", null); ?>",  
						data: { action:'afbt_db_function',actions:"get_posts",'page_type': page_type},    
						success: function(response){
							jQuery("#selectBox").html("");
							jQuery("#selectBox").append(response);
						}   
					});
				});
				
				jQuery( "#btn_add" ).click(function() {
					var website_val= jQuery("select[name=add_website]").val();
					if(!website_val){
						addError("selectBox","error_ab");
						false;
					 }else{
						 removeError("selectBox","error_ab");
					 }
					 
					 validate_field("input[name='keywords[]']");
					 validate_field("input[name='affiliate_link[]']");
					 
					if(!jQuery("body").find(".error_ab").length){
						ajaxAction("add");
					}
				});
				jQuery( "#btn_edit" ).click(function() {
					jQuery("#affiliate_grid").bootgrid("reload");
					
					 var edit_website= jQuery("select[name=edit_website]").val();
					 if(!edit_website){
						 addError("edit_website","error_edit");
					 }else{
						 removeError("edit_website","error_edit");
					 }
					 validate_field("input[name='keywords_edit[]']");
					 validate_field("input[name='affiliate_link_edit[]']");
					 validate_field("input[name='keywords_edit_new[]']");
					 validate_field("input[name='affiliate_link_edit_new[]']");
					 
					 if(!jQuery("body").find(".error_edit").length){
						 ajaxAction("edit");
					 }	
				});

				/*
				* add extra keyword input to new records
				*/
				var max_fields      = 60; //maximum input boxes allowed
				var wrapper         = jQuery(".input_fields_wraps"); //Fields wrapper
				var add_button      = jQuery(".add_field_button"); //Add button ID
				
				var x = 1; //initlal text box count
				jQuery(add_button).click(function(e){ //on add input button click
					e.preventDefault();
					if(x < max_fields){ //max input box allowed
						x++; //text box increment
						jQuery(wrapper).append('<div><input type="text" id="keywords_'+x+'" class="keywords" placeholder="Keywords" name="keywords[]"/><br><input type="text" id="affiliate_link_'+x+'" placeholder="http:// or https://" class="affiliate_link" name="affiliate_link[]"/><a href="#" class="remove_field"><sapn class="remove_keywords">x</sapn></a></div>'); //add input box
						
					}
				});
				
				jQuery(wrapper).on("click",".remove_field", function(e){ //user click on remove text
					e.preventDefault(); var conf = confirm("Are you sure want to delete");
					if(conf){
						jQuery(this).parent('div').remove();
					}
					
				})
				/*
				* add more filed to edit form
				*/
				var add_field_edit = jQuery(".add_field_edit"); //Add button ID
				var input_fields_edit = jQuery(".input_fields_edit");
				var max_fields =60;
				
				jQuery(add_field_edit).click(function(e){ 
					e.preventDefault();
					var y = jQuery('#form-group .keywords_edit').length;
					if(y < max_fields){ 
						y++; 
						jQuery(input_fields_edit).append('<div><input type="hidden" value="" name="keys_id[]" class="keys_id"><input type="text" id="edit_keywords_'+y+'" placeholder="keywords" class="keywords_edit" value=""  name="keywords_edit_new[]"/><br><input type="text" id="edit_affiliate_link_'+y+'" value="" class="affiliate_link" name="affiliate_link_edit_new[]" placeholder="http:// or https://" /><a href="#" class="remove_field_edit"><sapn class="remove_keywords">x</sapn></a></div>'); 
					}
				});
				jQuery(".input_fields_edit").on("click",".remove_field_edit", function(e){ //user click on remove text
					e.preventDefault(); var conf = confirm("Are you sure want to delete");
					var get_id = jQuery(this).attr("id");
					if(conf){
						jQuery(this).parent('div').remove();
						jQuery.post("<?php echo admin_url("admin-ajax.php", null); ?>", { key_id: get_id, action:"afbt_db_function",actions:"delete"}
						, function(){
							
						}); 
					}
					
				})
				/*
				* get the post type
				*/
				jQuery(".radio").click(function(){
					var page_type = jQuery('input[name=type_page]:checked').val();
					jQuery.ajax({
						type: "POST",  
						url: "<?php echo admin_url("admin-ajax.php", null); ?>",  
						data: { 'page_type': page_type,action:"afbt_db_function",actions:"get_posts"},       
						success: function(response){
							jQuery("#selectBox").html("");
							jQuery("#selectBox").append(response);
						}   
					});
				});
				jQuery(".radio_edit").click(function(){
					var page_type = jQuery(this).val();
					jQuery.ajax({
						type: "POST",  
						url: "<?php echo admin_url("admin-ajax.php", null); ?>",  
						data: { 'page_type': page_type,action:"afbt_db_function",actions:"get_posts"},    
						success: function(response){
							jQuery("#edit_website").html("");
							jQuery("#edit_website").append(response);
						}   
					});
				});
			});
			</script>
	   <?php 
	   }
		if($_GET[ 'tab' ] == 'affiliate_style'){ 
			echo'<div class="wrap">
				<h2>Link Setting Options</h2>
				<form method="post" action="options.php">';
					wp_nonce_field("update-options");?>
					<table class="form-table">
						<tr valign="top">
						<th scope="row"><?php echo _e('Font Size','affiliate-booster') ; ?></th>
						<td><input type="text" name="affiliate_boost_setting[font-size]" placeholder="10px" value="<?php get_option('affiliate_boost_setting')['font-size']?>" /></td>
						</tr>
						<tr valign="top">
						<th scope="row"><?php echo _e('Link Color','affiliate-booster') ; ?></th>
						<td><input type="text" name="affiliate_boost_setting[font-color]" value="<?php get_option('affiliate_boost_setting')['font-color'] ?>" class="my-color-field"/></td>
						</tr>
					</table>
					<p><input type="submit" class="btm button-primary" name="Submit" value="<?php echo _e('Save Options','affiliate-booster') ; ?>" /></p>
					<input type="hidden" name="action" value="<?php echo _e('update','affiliate-booster') ; ?>" />
					<input type="hidden" name="page_options" value="<?php echo _e('affiliate_boost_setting','affiliate-booster') ; ?>" />
				<?php echo'
				</form>
			</div>';
	   }
	}
	
	function array_intersect_fixed($array1, $array2) { 
		$result = array(); 
		foreach ($array1 as $val) { 
			if(!in_array($val['keywords'], $array2)){
				$results[] = $val ;
			}
		} 
		return $results; 
	}	
	/*
	* check the keywords in contents
	*/
	function afbt_replace_for_keywords( $content ) { 
		global $wp;
		$current_page= home_url( $wp->request );
		$page_title = get_the_title();
		$font_size = get_option('affiliate_boost_setting')['font-size'];
		$font_color = get_option('affiliate_boost_setting')['font-color'];

		if($font_color){ $style_color="color:".$font_color.";"; }
		if(strpos($font_size, 'px') !== false){ $style_color.="font-size:".$font_size.";"; }
		else{ if($font_size){ $style_color.="font-size:".$font_size."px;"; }}

		$this->style = $style = "style='".$style_color."'";
		$qtot = $this->wpdb->get_results("SELECT keywords,affiliate_link FROM ".$this->table_name2." INNER JOIN ".$this->table_name." ON parent_id = w_id WHERE website = '".$page_title."'");
		$this->linkarray = $arrqtotay = json_decode( json_encode($qtot), true);

		if($arrqtotay){
			foreach($arrqtotay as $getRecords){
				if(strpos($getRecords['keywords'], ',') !== false){
					$explode_keywords = explode(",",$getRecords['keywords']);
					foreach($explode_keywords as $keywords){
						if (strpos($content, $keywords) !== false) {
							$content = preg_replace("/\b".$keywords."\b/", '<a class="afbt_link" '.$style. 'href="'.esc_url($getRecords['affiliate_link']).'">'.esc_html($keywords).'</a>',$content);
						}
					}
				}else{
					if (strpos($content, $getRecords['keywords']) !== false) {
						$content =  preg_replace("/\b".$getRecords['keywords']."\b/", '<a class="afbt_link"  '.$style. 'href="'.esc_url($getRecords['affiliate_link']).'">'.esc_html($getRecords['keywords']).'</a>',$content);
						
					}
				}
			}
			libxml_use_internal_errors(true);
			$dom = new DOMDocument;
			$dom->loadHTML($content);
			$array_link =array();
			foreach ($dom->getElementsByTagName('a') as $node){
				if($node->getattribute('class') == 'afbt_link') {
					   $array_link[] = trim($node->nodeValue);
				 }
			} 
			$unique_arr = array_map("unserialize", array_unique(array_map("serialize", $array_link)));
			$array_end = $this->array_intersect_fixed($arrqtotay,$unique_arr);
			$this->json_arr = json_encode($array_end);
			return  $content;
		}else{
			return  $content;
		}
	}
	
	function afbt_frontscript() { 
		?>
		<script>
		jQuery(document).ready(function(){
			var key_aff = <?php echo $this->json_arr ?>;
			var key_aff_link = <?php echo json_encode($this->linkarray); ?>;
			var key_css= "<?php echo $this->style ?>";
			jQuery.each(key_aff, function(idx, obj) { // get the json keywords
				var names = [obj.keywords];
				var update_text = '';
				jQuery('.afbt_link').each(function(){
					var cntn = jQuery(this).text();
					var str_key = ""+names+""; 
					var str = str_key; 
					var re = new RegExp("\\b" + cntn + "\\b", "g");
					var matchk = str.match(re) ? str.match(re).length : 0;
					
					if(matchk > 0){ // match the key in the content
						var str_updaptes =  document.getElementById("main").innerHTML;	
						var oldUrl = jQuery(this).attr("href");
						jQuery(this).text("ccc "+cntn);
						jQuery(this).contents().unwrap();
						var str_updapte =  document.getElementById("main").innerHTML;	
						var str_names = ''+names+'';
						var key_names = str_names.replace(cntn,"ccc "+cntn);
						var re = new RegExp("\\b" + key_names + "\\b", "g");
						var matchk_key = str_updapte.match(re) ? str_updapte.match(re).length : 0;
						if(matchk_key > 0){
							 update_text = str_updapte.replace(new RegExp(key_names, 'gi'), '<a '+key_css+' class="afbt_link" href="'+obj.affiliate_link+'">'+names+'</a>');
							
						}else{
							  update_text = str_updapte.replace(new RegExp("ccc "+cntn, 'gi'), '<a '+key_css+' class="afbt_link" href="'+obj.affiliate_link+'">'+cntn+'</a>');
						}
					}
				});
				if(update_text){
					document.getElementById("main").innerHTML = update_text;
				}
			});
			
			jQuery.each(key_aff_link, function(idx, obj) {
				var str =  document.getElementById("main").innerHTML;
				var names = [obj.keywords];
				updatenew = str.replace(new RegExp("ccc "+names, 'gi'), '<a '+key_css+' class="afbt_link" href="'+obj.affiliate_link+'">'+names+'</a>');
				document.getElementById("main").innerHTML = updatenew;
			});
			var str_rep =  document.getElementById("main").innerHTML;	
			update_rep = str_rep.replace(new RegExp("ccc", 'gi'), '');
			document.getElementById("main").innerHTML = update_rep;
		});
		</script>
<?php }
}

// add js file to the admin

function afbt_admin_load_js($hook){
	if($hook != 'settings_page_affiliate-boost-options') {
		return;
	}
	wp_register_style('bootstrap_css', plugin_dir_url( __FILE__ ) . 'dist/bootstrap.min.css');  
	wp_register_style('jquery_tablegrid', plugin_dir_url( __FILE__ ) . 'dist/jquery.tablegrid.css'); 
	wp_enqueue_script( 'bootstrap.min', plugin_dir_url( __FILE__ ) . 'dist/bootstrap.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'jquery.tablegrid', plugin_dir_url( __FILE__ ) . 'dist/jquery.tablegrid.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'custom', plugins_url('dist/custom.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
	wp_enqueue_script("jquery");
	wp_enqueue_style('bootstrap_css');
	wp_enqueue_style('jquery_tablegrid');
	wp_enqueue_style( 'wp-color-picker' );   		 
}
add_action('admin_enqueue_scripts', 'afbt_admin_load_js');


// Get the function template using ajax

add_action('wp_ajax_afbt_db_function', 'afbt_db_function');
add_action('wp_ajax_nopriv_afbt_db_function', 'afbt_db_function');

function afbt_db_function() {

	include_once(plugin_dir_path( __FILE__ ) . "affiliate-response.php");	
	 wp_die(); 
}