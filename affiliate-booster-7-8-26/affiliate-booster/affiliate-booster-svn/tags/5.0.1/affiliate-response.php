<?php
defined( 'ABSPATH' ) or die();

$params = $_REQUEST;  // data array

$action = isset($params['actions']) != '' ? $params['actions'] : '';
$afbt_cls = new AFBT_Sql;

switch($action) {
	case 'add':
		$afbt_cls->afbt_insertKeywords($params);
		break;
	case 'edit':
		$afbt_cls->afbt_updateKeywords($params); 
		break;
	case 'delete':
		$afbt_cls->afbt_deleteKeywords($params);
		break;
	case 'edit_all':
		$afbt_cls->afbt_editKeywords($params);
		break;
	case 'get_posts':
		$afbt_cls->afbt_get_post_pages($params);
		break;
	case 'get_match':
		$afbt_cls->afbt_get_match($params);
		break;	
	default:
		$afbt_cls->afbt_getKeywords($params);
		return;
}
	
class AFBT_Sql {
	
	protected $data = array();
	
	public function afbt_getKeywords($params) {

		$this->data = $this->getRecords($params);
		
		echo json_encode($this->data);
	}
	
	public function __construct()
	{
		global $wpdb;
		$this->wpdb = $wpdb;
		$this->table_name = $afbt_table_name = $this->wpdb->prefix . 'affiliate_boost';
		$this->table_name2 = $afbt_table_name2 = $this->wpdb->prefix . 'affiliate_boost_website';
		$this->posts = $afbt_table_name3 = $this->wpdb->prefix . 'posts';
	}
	
	function afbt_check_weblink($params,$type){

		$params = sanitize_text_field($params);
		$check_web =  $this->wpdb->get_row("SELECT * from ".$this->table_name2." WHERE website='" .$params. "'");	
		$check_webs = json_decode( json_encode($check_web), true);
		if (isset($check_webs)) {
			$lastid = $check_webs['w_id'];
		}else{
			$insert_web = $this->wpdb->query( $this->wpdb->prepare("INSERT INTO ".$this->table_name2." (w_id,	post_type,website) VALUES(null, '".sanitize_text_field($type)."', '".$params."')"));
			$lastid = $this->wpdb->insert_id;		
		}
		return $lastid;
	}
	
	// Insert the new record
	function afbt_insertKeywords($params) {
		
		$lastid = $this->afbt_check_weblink($params["add_website"],$params["type_page"]);
		
		if(!empty($lastid)){
			foreach($params["keywords"] as $key =>$key_link){
				 $affl_link = preg_replace('/ /', '', $params["affiliate_link"][$key]);
				 $sql = $this->wpdb->query( $this->wpdb->prepare("INSERT INTO ".$this->table_name." (parent_id, keywords, affiliate_link) VALUES('" . sanitize_text_field($lastid) . "', '" . sanitize_text_field($key_link) . "','" . sanitize_text_field($affl_link) . "')"));	
				echo $sql;
			}	
		}
	}
	
	// Get the all records from the db
	function getRecords($params) {

		$rp = isset($params['rowCount']) ? $params['rowCount'] : 10;
		
		if (isset($params['current'])) { $page  = $params['current']; } else { $page=1; };  
        $start_from = ($page-1) * $rp;
		
		$insert_sql = $sqlRec = $sqlTotal = $where = '';
		
		if( !empty($params['searchPhrase']) ) {   
			$where .=" WHERE ";
			$where .=" ( website LIKE '".$params['searchPhrase']."%' )";  
	   }
	   if( !empty($params['sort']) ) {  
			$where .=" ORDER By ".key($params['sort']) .' '.current($params['sort'])." ";
		}

	   // getting total number records without any search
	    
		$insert_sql = "SELECT * FROM ".$this->table_name2."";
		$sqlTotal .= $insert_sql;
		$sqlRec .= $insert_sql;
		
		//concatenate search sql if value exist
		if(isset($where) && $where != '') {
			$sqlTotal .= $where;
			$sqlRec .= $where;
		}else{
			$sqlRec .= ' ORDER By w_id DESC';
		}
		
		if ($rp!=-1)
		$sqlRec .= " LIMIT ". $start_from .",".$rp;
		
		$qtot = $this->wpdb->get_results($sqlTotal);
		$queryRecords = $this->wpdb->get_results($sqlRec);
		$count=1;

		if(!empty($queryRecords)){
			foreach($queryRecords as $row){
				$array_count ='';
				$array_count= array("w_id" => $count );
				$rows = json_decode( json_encode($row), true);
				$title = "<sapn style='font-size:10px;' class='title_link'>(<a href=".home_url(sanitize_title( $rows['website'] ))." target='_blank'>".home_url(sanitize_title( $rows['website'] ))."</a>)</span>"; 
			    $new_rowarray= array('website'=>$rows['website']." ".$title,'web_id'=>$rows['w_id']);
				$array_merge = array_merge($array_count, $new_rowarray);
				$data[] = $array_merge;
				$count++;
			}
		
			$json_data = array(
				"current"            => intval($params['current']), 
				"rowCount"            => 10, 			
				"total"    => intval(count($qtot)),
				"rows"            => $data   // total data array
				);
				
		    return $json_data;
		}
	}
	
	// Update the record into db
	function afbt_updateKeywords($params) {
		
		$lastid = $this->afbt_check_weblink($params["edit_website"],$params["type_page_edit"]); // check the website url
		
		if(!empty($lastid)){
			foreach($params["keys_id"] as $key_id=>$ids){
				$affl_link = preg_replace('/ /', '', $params["affiliate_link_edit"][$key_id]);
				$update_sql = $this->wpdb->query( $this->wpdb->prepare("Update ".$this->table_name." set parent_id = '" . $lastid . "', keywords='" .sanitize_text_field($params["keywords_edit"][$key_id])."', affiliate_link='" . sanitize_text_field($affl_link) . "' WHERE id='".$ids."'"));
			}
			if(!empty($params["keywords_edit_new"])){
				foreach($params["keywords_edit_new"] as $key =>$key_val){
					$affl_linkn = preg_replace('/ /', '', $params["affiliate_link_edit_new"][$key]);
					$update_sql = $this->wpdb->query( $this->wpdb->prepare("INSERT INTO ".$this->table_name." (parent_id, keywords, affiliate_link) VALUES('" .$lastid . "', '" . sanitize_text_field($key_val) . "','" . sanitize_text_field($affl_linkn) . "')"));
				}
			}
			echo $update_sql;			
		}	
	}
	
	// Delete record from tables
	function afbt_deleteKeywords($params) {

		if(!empty($params["key_id"])){
			$delete_sql = $this->wpdb->query( $this->wpdb->prepare("delete from ".$this->table_name." WHERE id='".$params["key_id"]."'"));
		}else{
			$delete_sql = $this->wpdb->query( $this->wpdb->prepare("delete from ".$this->table_name." WHERE parent_id='".$params["id"]."'"));
			$del_web_link= $this->wpdb->query( $this->wpdb->prepare("delete from ".$this->table_name2." WHERE w_id='".$params["id"]."'"));
		}
		
		
		
		echo $delete_sql;
	}
	
	// Edit records
	function afbt_editKeywords($params) {
        
		$query_weblink= $this->wpdb->get_results("SELECT * from ".$this->table_name2." WHERE w_id='" .$params['id'] . "'");
        $get_weblink = json_decode( json_encode($query_weblink), true);

		$queryRecords = $this->wpdb->get_results("SELECT * from ".$this->table_name." WHERE parent_id='" .$params['id'] . "'");		
		$check_webs = json_decode( json_encode($queryRecords), true);

		$count=1;
		
		$queryRecords_type = $this->wpdb->get_results("SELECT * from ".$this->posts." WHERE post_status='publish' AND post_type='" . $get_weblink[0]['post_type'] . "'");		
		$check_records= json_decode( json_encode($queryRecords_type), true);
		if(!empty($check_records)){
			$html_option='<option value="">Select Option</option>';
			foreach($check_records as $row){
				if($row['post_title'] == $get_weblink[0]['website']){
					$html_option.='<option value="'.$row['post_title'].'" selected="selected">'.$row['post_title'].'</option>';
				}else{
					$html_option.='<option value="'.$row['post_title'].'">'.$row['post_title'].'</option>';
				}
				
			}
		}
		$html='';
		if(!empty($check_webs)){
			$html = '';
			foreach($check_webs as $row){
				$html.='<div><input type="hidden" value="'.$row['id'].'" name="keys_id[]" class="keys_id"><input type="text" id="edit_keywords_'.$count.'" class="keywords_edit" value="'.$row['keywords'].'"  name="keywords_edit[]" placeholder="keywords: '.$count.'" /><br><input type="text" id="edit_affiliate_link_'.$count.'" value="'.$row['affiliate_link'].'" class="affiliate_link" name="affiliate_link_edit[]" placeholder="http:// or https://"/><a href="#" id="'.$row['id'].'" class="remove_field_edit"><sapn class="remove_keywords">x</sapn></a></div>';
				$count++;
			}
			echo $html."++".$html_option."++".$get_weblink[0]['post_type'];
		}else{
			echo $html."++".$html_option."++".$get_weblink[0]['post_type'];
		}
	}
	/*
	* get the post type 
	*/
	function afbt_get_post_pages($params){
		
		$queryRecords_type = $this->wpdb->get_results("SELECT * from ".$this->posts." WHERE post_status='publish' AND post_type='" .$params['page_type'] . "'");		
		$get_post_page= json_decode( json_encode($queryRecords_type), true);

		if(!empty($get_post_page)){
			$html='<option value="">Select Option</option>';
			foreach($get_post_page as $row){
				$html.='<option value="'.$row['post_title'].'">'.$row['post_title'].'</option>';
			}
			echo $html;
		}
	}
	
	function afbt_get_match($params){
		$query_weblink= $this->wpdb->get_results("SELECT * from ".$this->table_name2." WHERE website='" .$params['page_val'] . "'");
        $get_weblink = json_decode( json_encode($query_weblink), true);
		if($get_weblink){
			$query_weblink_check= $this->wpdb->get_results("SELECT keywords from ".$this->table_name." WHERE parent_id='" .$get_weblink[0]['w_id'] . "' AND keywords='".$params['value']."'");
			$get_weblink_check = json_decode( json_encode($query_weblink_check), true);
			if($get_weblink_check){
				echo "Exists";
			}else{
				echo "not exists";
			}
		}else{
			echo "not exists";
		}
	}
}
?>
	