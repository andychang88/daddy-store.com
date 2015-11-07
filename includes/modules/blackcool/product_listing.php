<?php
/**
 * product_listing module
 *
 * @package modules
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: product_listing.php 6787 2007-08-24 14:06:33Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}//echo "===================================================$current_category_id".$current_category_id;



//require(DIR_WS_MODULES . zen_get_module_directory('category_row.php'));
/**
echo '<pre>===============------------------------------';
echo $current_category_id;
print_r(getChildCategoryId($current_category_id));
exit;
/**/

if(isset($current_category_id) && $current_category_id > 0 ){
  //check if the current category  is parent category, if yes, find its child category
  
  //$where_cat_in_array = getChildCategoryId($current_category_id);
  zen_get_subcategories($where_cat_in_array,$current_category_id);
  
  if(empty($where_cat_in_array)){
    
    $where_cat_in_str = "c.categories_id=".(int)$current_category_id;
    
  }else{
    $where_cat_in_array[] = $current_category_id;
    $where_cat_in_str = implode(",",  $where_cat_in_array);
    
    $where_cat_in_str = "c.categories_id in (".$where_cat_in_str.") ";
    
  }
  
  
  
  
  
    
    
    
    $products_listing_sql='select distinct p.products_id,p.products_image,
	                                       pd.products_name,pd.products_short_description,
										   p.products_afterbuy_model,p.products_weight
	                       from '.TABLE_PRODUCTS.' p,
						        '.TABLE_PRODUCTS_TO_CATEGORIES.' p2c,
								'.TABLE_PRODUCTS_DESCRIPTION. ' pd,
								'.TABLE_CATEGORIES.' c
						   where p.products_status=1 						  
						   and   p.products_id=p2c.products_id 
						   and   p.products_id = pd.products_id
						   and   p2c.categories_id=c.categories_id
						   and   '.$where_cat_in_str.' 
						   and   c.categories_status=1 
						   and   pd.language_id = ' .(int)$_SESSION['languages_id'];
						   //order by p.products_ordered DESC';
	/*******enable function: price fitler*********************************/
	//john 2010-11-01 
	if($need_filter){
	  $products_listing_sql.=$price_filter_sql;
	}
	$products_listing_sql.=$order_by;
	/*******enable function: price fitler*********************************/
	//echo $products_listing_sql;exit;
	$show_split_page=false;		//echo $products_listing_sql;exit;			

    $listing_split = new splitPageResults($products_listing_sql, MAX_DISPLAY_PRODUCTS_LISTING, 'p.products_id', 'page');
	$zco_notifier->notify('NOTIFY_MODULE_PRODUCT_LISTING_RESULTCOUNT', $listing_split->number_of_rows);
	
	if ($listing_split->number_of_rows > 0) {
	  
	  if($listing_split->number_of_rows > MAX_DISPLAY_PRODUCTS_LISTING) $show_split_page=true;
	  
	  if(isset($products)) unset($products);
	  $products=array();
	  
	  $current_listing = $db->Execute($listing_split->sql_query);
	  
	  while (!$current_listing->EOF) {
		
		$tmp_id=$current_listing->fields['products_id'];
		$products_price=zen_get_products_display_price($tmp_id);
		
		$products[]=array('products_name'=>$current_listing->fields['products_name'],
		                  'products_afterbuy_model'=>$current_listing->fields['products_afterbuy_model'],
			              'products_short_description'=>$current_listing->fields['products_short_description'],
						  'products_price'=>$products_price,
						  'products_image'=>$current_listing->fields['products_image'],
						  'buy_link'=>zen_href_link(FILENAME_DEFAULT,
									zen_get_all_get_params(array('action','products_id')).'action=buy_now&products_id='.$tmp_id),
		                  'products_url_link'=>zen_href_link(zen_get_info_page($tmp_id),'products_id='.$tmp_id),
						  'products_weight'=>$current_listing->fields['products_weight']
						 );		
		$current_listing->MoveNext();
	  }
	  
	  
	  $has_avaiable_products = true;
	}

}

/**
function getChildCategoryId($current_category_id){
  global $db;
  
      $categories_query = "SELECT distinct c.categories_id 

                         FROM    " . TABLE_CATEGORIES . " c,

						         " . TABLE_CATEGORIES_DESCRIPTION . " cd

                         WHERE      c.parent_id = :parentID

                         AND        c.categories_id = cd.categories_id 

                         AND        cd.language_id = :languagesID

                         AND        c.categories_status= '1'

                         ORDER BY   sort_order, cd.categories_name";



    $categories_query = $db->bindVars($categories_query, ':parentID', $current_category_id, 'integer');

    $categories_query = $db->bindVars($categories_query, ':languagesID', $_SESSION['languages_id'], 'integer');

  

  $categories = $db->Execute($categories_query);

  $number_of_categories = $categories->RecordCount();
  
  $arr = array();
  
  if($number_of_categories>0){
      while (!$categories->EOF) {
	
	$arr[] = $categories->fields['categories_id'];
	$categories->MoveNext();
      }
  }
  
  return $arr;
}
/**/

?>