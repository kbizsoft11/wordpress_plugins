<?php

	if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
	
	class kbcfPager{
		
		function kbcf_findStart($limit) { 
			if ((!isset($_GET['paging'])) || ($_GET['paging'] == "1")) {
				$start = 0; 
				$_GET['paging'] = 1; 
			} else { 
				$start = ($_GET['paging']-1) * $limit; 
			} 
			return $start; 
		}
	  
	  /*
	   * int findPages (int count, int limit) 
	   * Returns the number of pages needed based on a count and a limit 
	   */
		function kbcf_findPages($count, $limit) { 
			 $pages = (($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1; 
		 
			 return $pages; 
		} 
	 
		/* 
		* string pageList (int curpage, int pages) 
		* Returns a list of pages in the format of "« < [pages] > »" 
		**/
		function kbcf_pageList($curpage, $pages) 
		{			
			$page_list  = '<div class="tablenav-pages"><span class="pagination-links">'; 
		 
			$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			
		 
			/* Print the first and previous paging links if necessary */
			if (($curpage != 1) && ($curpage)) { 
			   $page_list .= "  <a class='tablenav-pages-navspan' href=\" ".$url."&paging=1\" title=\"First Page\">«</a> "; 
			} 
		 
			if (($curpage-1) > 0) { 
			   $page_list .= "<a class='tablenav-pages-navspan' href=\" ".$url."&paging=".($curpage-1)."\" title=\"Previous Page\"><</a> "; 
			} 
		 
			/* Print the numeric paging list; make the current paging unlinked and bold */
			for ($i=1; $i<=$pages; $i++) { 
				if ($i == $curpage) { 
					$page_list .= "<span class='tablenav-paging-text'>".$i." of ".$pages."</span>"; 
				} else { 
					$page_list .= "<a href=\" ".$url."&paging=".$i."\" title=\"Page ".$i."\">".$i."</a>"; 
				} 
				$page_list .= " "; 
			  } 
		 
			 /* Print the Next and Last paging links if necessary */
			 if (($curpage+1) <= $pages) { 
				$page_list .= "<a class='tablenav-pages-navspan' href=\"".$url."&paging=".($curpage+1)."\" title=\"Next Page\">></a> "; 
			 } 
		 
			 if (($curpage != $pages) && ($pages != 0)) { 
				$page_list .= "<a class='tablenav-pages-navspan' href=\"".$url."&paging=".$pages."\" title=\"Last Page\">»</a> "; 
			 } 
			 $page_list .= "</span></div>\n"; 
		 
			 return $page_list; 
		}
		  
		/*
		* string nextPrev (int curpage, int pages) 
		* Returns "Previous | Next" string for individual pagination (it's a word!) 
		*/
		function kbcf_nextPrev($curpage, $pages) { 
		 $next_prev  = ""; 
		 
			if (($curpage-1) <= 0) { 
				$next_prev .= "Previous"; 
			} else { 
				$next_prev .= "<a href=\"".$url."&paging=".($curpage-1)."\">Previous</a>"; 
			} 
		 
				$next_prev .= " | "; 
		 
			if (($curpage+1) > $pages) { 
				$next_prev .= "Next"; 
			} else { 
				$next_prev .= "<a href=\"".$url."&paging=".($curpage+1)."\">Next</a>"; 
			} 
				return $next_prev; 
		}
	}		
?> 