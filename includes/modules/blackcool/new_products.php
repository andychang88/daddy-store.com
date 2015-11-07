<?php
/**
 * new_products.php module
 *
 * @package modules
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: new_products.php 6424 2007-05-31 05:59:21Z ajeh $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
// initialize vars
$categories_products_id_list = '';
$list_of_products = '';
$new_products_query = '';

$display_limit = zen_get_new_date_range();

if ( (($manufacturers_id > 0 && $_GET['filter_id'] == 0) || $_GET['music_genre_id'] > 0 || $_GET['record_company_id'] > 0) || (!isset($new_products_category_id) || $new_products_category_id == '0') ) {
   //############check filter some categories or not ##################
  if(defined('NEW_PRODUCTS_LISTING_FITLERED_BY_CATEGORIES') && NEW_PRODUCTS_LISTING_FITLERED_BY_CATEGORIES && isset($new_products_listing_filtered_categories)){
       $allowed_cate_sql='select distinct categories_id from '.TABLE_CATEGORIES.'
						  where  categories_status=1 
						  and    parent_id in('.implode(',',$new_products_listing_filtered_categories).')';
	   $allowed_cate_db=$db->Execute($allowed_cate_sql);
	   $allowed_cate_id=array();
	   while(!$allowed_cate_db->EOF){
			$allowed_cate_id[]=$allowed_cate_db->fields['categories_id'];
		 
			$allowed_cate_db->MoveNext();
	   }
	   $category_fitler_str=' and p.master_categories_id in('.implode(',',$allowed_cate_id).') ';
	   
       $new_products_query ="select distinct p.products_id, p.products_image, 
											 pd.products_name,
											 p.master_categories_id
							 from  " . TABLE_PRODUCTS . " p, 
								   " . TABLE_PRODUCTS_DESCRIPTION . " pd,
								   " . TABLE_PRODUCTS_TO_CATEGORIES." p2c
							 where p.products_id = pd.products_id
							 and   pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
							 and   p2c.products_id=p.products_id 
							 and   p2c.categories_id=p.master_categories_id  
								 ".$category_fitler_str."
							 and   p.products_status = 1 " . $display_limit.' 
							 order by p.products_date_added desc,p.products_ordered desc
							 limit 0,'.MAX_DISPLAY_NEW_PRODUCTS;
  }else{
      $frist_get_pid_query3=" select distinct products_id
		                      from products 
							  where products_status = 1 
							  order by products_date_added desc
							  limit 0,".MAX_DISPLAY_NEW_PRODUCTS;
      $frist_get_pid_db3=$db->Execute($frist_get_pid_query3);
	  $frist_get_pid3=array();
	  if($frist_get_pid_db3->RecordCount()>0){
		   
		  while(!$frist_get_pid_db3->EOF){
		       $frist_get_pid3[]=$frist_get_pid_db3->fields['products_id'];
			   $frist_get_pid_db3->MoveNext();
		  }
		  $frist_pid_str3=implode(',',$frist_get_pid3);
		  $new_products_query = "select distinct p.products_id, p.products_image, 
												 pd.products_name,
												 p.master_categories_id
								 from  " . TABLE_PRODUCTS . " p, 
									   " . TABLE_PRODUCTS_DESCRIPTION . " pd
								 where p.products_id = pd.products_id
								 and   pd.language_id = " . (int)$_SESSION['languages_id'] . "
								 and   p.products_id in(".$frist_pid_str3.")
								  " ;//. $display_limit;
		  
	  }
 }
} else {
  // get all products and cPaths in this subcat tree
  $productsInCategory = zen_get_categories_products_list( (($manufacturers_id > 0 && $_GET['filter_id'] > 0) ? zen_get_generated_category_path_rev($_GET['filter_id']) : $cPath), false, true, 0, $display_limit);

  if (is_array($productsInCategory) && sizeof($productsInCategory) > 0) {
    // build products-list string to insert into SQL query
    foreach($productsInCategory as $key => $value) {
      $list_of_products .= $key . ', ';
    }
    $list_of_products = substr($list_of_products, 0, -2); // remove trailing comma

    $new_products_query = "select distinct p.products_id, p.products_image, 
	                                       pd.products_name,
                                           p.master_categories_id
                           from " . TABLE_PRODUCTS . " p, 
						        " . TABLE_PRODUCTS_DESCRIPTION . " pd
                           where p.products_id = pd.products_id 
						   and   p.products_status = 1 
                           and   pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                           and   p.products_id in (" . $list_of_products . ") 
						   order by p.products_ordered desc,p.products_date_added desc limit 0,".MAX_DISPLAY_NEW_PRODUCTS;
  }
}

if ($new_products_query != '') $new_products_db = $db->Execute($new_products_query);

$num_products_count = ($new_products_query == '') ? 0 : $new_products_db->RecordCount();

// show only when 1 or more
if ($num_products_count > 0) {
  
  $new_products=array();
  
  while (!$new_products_db->EOF) {
	$tmp_id=$new_products_db->fields['products_id'];  
    $products_price = zen_get_products_display_price($tmp_id);
    
	$new_products[]=array('products_name'=>$new_products_db->fields['products_name'],
						  'products_image'=>$new_products_db->fields['products_image'],
						  'products_price'=>$products_price,
						  'buy_link'=>zen_href_link(FILENAME_DEFAULT,
													zen_get_all_get_params(array('action','products_id')).'action=buy_now&products_id='.$tmp_id),
						  'products_url_link'=>zen_href_link(zen_get_info_page($tmp_id), 
														     'cPath=' . $productsInCategory[$tmp_id] . 
														     '&products_id=' .$tmp_id)
						  );	
    $new_products_db->MoveNext();
  }
  $zc_show_new_products = true;  
}
?>