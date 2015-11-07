<?php
/**
 * application_bottom.php
 * Common actions carried out at the end of each page invocation.
 *
 * @package initSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: application_bottom.php 5658 2007-01-21 19:39:51Z wilt $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
//#################Begin:collect keyword that searched by customer############
//Added by john 2010-07-07
if (isset($_GET['keyword']) && zen_not_null(trim($_GET['keyword'])) && isset($has_search_result_this_keyword) && $has_search_result_this_keyword) {
	$chk_keyword_sql = "select id,search_cnt from " . TABLE_CUSTOMERS_SEARCHES . " 
					    where keyword = '". trim($_GET['keyword']) . "' 
					    and   language_id ='" . (int)$_SESSION['languages_id'] . "'";
	if(isset($_GET['categories_id']) && zen_not_null($_GET['categories_id']) && is_numeric($_GET['categories_id'])){
	   $chk_keyword_sql.=" and categories_id=".(int)$_GET['categories_id'];
	}else{
	   $chk_keyword_sql.=" and categories_id=0 ";
	}			
						
	$chk_keyword_db=$db->Execute($chk_keyword_sql);
	
	if ($chk_keyword_db->RecordCount()>0) {
		$search_count = $chk_keyword_db->fields['search_cnt'];
		$record_id=$chk_keyword_db->fields['id'];
		
		$db->Execute("update " . TABLE_CUSTOMERS_SEARCHES . " set search_cnt = " . ($search_count+1) . " 
		              where id = '".$record_id. "'");
	} else {		
	    $search_cate_id=(isset($_GET['categories_id']) && zen_not_null($_GET['categories_id']) && is_numeric($_GET['categories_id']))?$_GET['categories_id']:0;
		$db->Execute("insert into " . TABLE_CUSTOMERS_SEARCHES . " 
		                     (keyword,categories_id,language_id, search_cnt) 
					  values ('".trim($_GET['keyword'])."',".$search_cate_id.",'". (int)$_SESSION['languages_id'] ."',1)");
	}
}
//#################Eof:collect keyword that searched by customer##############
// close session (store variables)
session_write_close();

// breaks things
// pconnect disabled (safety switch)
// $db->close();

if ( (GZIP_LEVEL == '1') && ($ext_zlib_loaded == true) && ($ini_zlib_output_compression < 1) ) {
  if ( (PHP_VERSION < '4.0.4') && (PHP_VERSION >= '4') ) {
    zen_gzip_output(GZIP_LEVEL);
  }
}
?>