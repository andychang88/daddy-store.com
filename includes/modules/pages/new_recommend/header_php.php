<?php
/**
 * products_new header_php.php
 *
 * @package page
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 6912 2007-09-02 02:23:45Z drbyte $
 */
$html_file_name = './html/new_recommend/'.date('Ymd').'.html';
$gen_url = HTTP_SERVER.'/index.php?main_page=new_recommend&is_gen=1&test=a';
$is_gen = $_REQUEST['is_gen'];

$is_debug = true;

if(!$is_debug){
	

if(empty($is_gen)){
	if(!is_file($html_file_name)){
		$data = file_get_contents($gen_url);
		file_put_contents($html_file_name, $data);
	}else{
		$data = file_get_contents($html_file_name);
	}
	
	echo $data;
	//header('location: '.HTTP_SERVER.'/'.substr($html_file_name,2));
	exit;
}else{
	if(is_file($html_file_name)){
		@unlink($html_file_name);
	}
}


}

  require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
  $breadcrumb->add(NAVBAR_TITLE);
// display order dropdown
  $disp_order_default = PRODUCT_NEW_LIST_SORT_DEFAULT;
  
  require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_LISTING_DISPLAY_ORDER));//var $order_by
  $products_new_array = array();
// display limits
//  $display_limit = zen_get_products_new_timelimit();
  
  
  
  //#################category filter###################
  
	  $products_new_query_raw = "SELECT p.products_id, p.products_type, pd.products_name, p.products_image, p.products_price,
										p.products_tax_class_id, p.products_date_added, p.products_model,
										p.products_quantity, p.products_weight, p.product_is_call,
										p.product_is_always_free_shipping, p.products_qty_box_status,
										p.master_categories_id
								 FROM " . TABLE_PRODUCTS . " p
								 LEFT JOIN " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
								 ON (p.products_id = p2c.products_id ), " . TABLE_PRODUCTS_DESCRIPTION . " pd
								 WHERE p.products_status = 1
								 AND   p.products_id = pd.products_id 
								 AND   p.master_categories_id=p2c.categories_id 
								  :category_fitler_str  						 
								 AND   pd.language_id = :languageID order by rand() limit 5";
  
  $products_new_query_raw = $db->bindVars($products_new_query_raw, ':languageID', $_SESSION['languages_id'], 'integer');
  
  $recommend_products_result = array();
  $recommend_products_cat_name = array();
  
  foreach ($recommend_new_products_listing_filtered_categories as $parent_cat_id){
  	
  	  $allowed_cate_sql='select distinct categories_id from '.TABLE_CATEGORIES.'
						  where  categories_status=1 
						  and    parent_id = '.$parent_cat_id.' ';
	  $allowed_cate_db=$db->Execute($allowed_cate_sql);
	  $allowed_cate_id=array($parent_cat_id);
	  
	  while(!$allowed_cate_db->EOF){
		 $allowed_cate_id[]=$allowed_cate_db->fields['categories_id'];
		 $allowed_cate_db->MoveNext();
	  }
	  
	  $category_fitler_str=' and p.master_categories_id in('.implode(',',$allowed_cate_id).') ';
	  
	  $sql = str_replace(':category_fitler_str', $category_fitler_str, $products_new_query_raw);
	  if($_GET['test']){
	  	//echo $sql.'<br><br><br>';
	  }
  	  $check_products_all = $db->Execute($sql);
  	  
  	  $recommend_products_result[]=$check_products_all;
  	  
  	  $recommend_products_cat_name[]=array('cat_name'=>zen_get_categories_name($parent_cat_id),
  	  'link'=>zen_href_link(FILENAME_DEFAULT,'&cPath='.$parent_cat_id)
  	  );
  }
  
  

?>