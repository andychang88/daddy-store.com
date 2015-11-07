<?php
    if (!defined('IS_ADMIN_FLAG')) {
	  die('Illegal Access');
	}
	$hot_keywords_query ="select distinct keyword
						   from " . TABLE_CUSTOMERS_SEARCHES . "
						   where language_id = '" . (int)$_SESSION['languages_id'] . "'
						   order by search_cnt desc
						   limit 30";
	$hot_keywords_db = $db->Execute($hot_keywords_query);
	
	if($hot_keywords_db->RecordCount()>0){
	    $hot_keywords=array();
		
		while (!$hot_keywords_db->EOF) {
		    $tmp_keyword=$hot_keywords_db->fields['keyword'];
		    $hot_keywords[]=array('keyword_name'=>trim($tmp_keyword),
			                      'keyword_link'=>zen_href_link(FILENAME_ADVANCED_SEARCH_RESULT, 
															   'keyword=' .trim($tmp_keyword)
															   )
							     );
			
			$hot_keywords_db->MoveNext();
		}
	    $show_hot_keywords=true;
	}
	
?>