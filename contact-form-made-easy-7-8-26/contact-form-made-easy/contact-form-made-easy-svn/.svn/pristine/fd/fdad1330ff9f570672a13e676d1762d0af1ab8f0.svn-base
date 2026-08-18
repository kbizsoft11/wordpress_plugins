<?php 
	
	if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
	
	if(isset($_GET['cat']) && $_GET['cat'] != ''){
		global $wpdb;
		$html = '';
		$page_html = '';
		$cat_table = $wpdb->prefix . "kbcf_cat";
		$user_table = $wpdb->prefix . "kbcf_cform";
		$cat_id = $_GET['cat'];
		
		/* Including class */
		$ds = DIRECTORY_SEPARATOR;
		$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
		include("{$base_dir}includes{$ds}pager.php");
		
		/* Instantiate class */
		$p = new kbcfPager; 
		 
		/* Show many results per page? */
		$limit = 5; 
		 
		/* Find the start depending on $_GET['paging'] (declared if it's null) */
		$start = $p->kbcf_findStart($limit); 
		 
		/* Find the number of rows returned from a query; Note: Do NOT use a LIMIT clause in this query */
		$count_sql =  "SELECT count(Distinct email) as e_count FROM $user_table where cat_id = $cat_id";
		$result = $wpdb->get_results( $count_sql );
		$count = $result[0]->e_count;
		
		/* Find the number of pages based on $count and $limit */
		$pages = $p->kbcf_findPages($count, $limit);
		 
		/* Now get the page list and echo it */
		$pagelist = $p->kbcf_pageList($_GET['paging'], $pages); 
		 
		/* Or you can use a simple "Previous | Next" listing if you don't want the numeric page listing */
		/* $next_prev = $p->kbcf_nextPrev($_GET['paging'], $pages); 
		echo $next_prev; */ 
	 
		/* get form category name */		
		$cat_sql =  "SELECT name FROM $cat_table where id = $cat_id";
		$cat_rows = $wpdb->get_results( $cat_sql, ARRAY_A );
		
		/* Now we use the LIMIT clause to grab a range of rows */
		$sql =  "SELECT * FROM $user_table where cat_id = $cat_id GROUP BY(email) LIMIT $start, $limit";
		// echo $sql;
		$rows = $wpdb->get_results( $sql, ARRAY_A );
		
		if($start == 0){
			$srno = 1;
		}else{
			$srno = $start + 1 ;
		}
		echo '<div class="wrap">
					<div class="export_button">
						<h1 class="wp-heading-inline">'.$cat_rows[0]['name'].' Users</h1>
						<a id="back" href="edit.php?post_type=formcategories" class="page-title-action">Back</a>
					</div>';
					
		if($count){
			$html .= '<table class="wp-list-table widefat fixed striped posts">
						<thead>
							<tr>
								<th>Srno</th>
								<th>Name</th>
								<th>Email</th>
								<th>Phone</th>
							</tr>
						</thead>';
			foreach($rows as $row){
				
				$html .= '<tbody>
					<tr>
						<td>'.$srno.'</td>
						<td>'.$row['name'].'</td>
						<td>'.$row['email'].'</td>
						<td>'.$row['phone_no'].'</td>
					</tr>';
				
				$srno++;
			}
			$html .= '</tbody></table>';
		}else{
			$html .= '<h3>No Results Found</h3>';
		}
		echo $html;
		$page_html .= '<div class="tablenav">'.$pagelist.'</div></div>';
		echo $page_html;
	}
?>