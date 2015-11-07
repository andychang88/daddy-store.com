<?php
/**
 * special_products module - prepares content for display
 *
 * @package modules
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: special_products.php 6424 2010-04-09 05:59:21Z john $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

// initialize vars
$categories_products_id_list = '';
$list_of_products = '';
$special_products_query = '';
$display_limit = '';

if ( (($manufacturers_id > 0 && $_GET['filter_id'] == 0) || $_GET['music_genre_id'] > 0 || $_GET['record_company_id'] > 0) || (!isset($new_products_category_id) || $new_products_category_id == '0') ) {
  $special_products_query = "select distinct p.products_id, p.products_image, pd.products_name, p.master_categories_id
							   from (" . TABLE_PRODUCTS . " p
							   left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id
							   left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
							   where p.products_id = s.products_id
							   and p.products_id = pd.products_id
							   and p.products_status = 1 
							   and s.status = 1 
							   and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' 
							   ORDER BY s.specials_date_added DESC limit ".MAX_DISPLAY_SPECIAL_PRODUCTS_INDEX;
} else {
  // get all products and cPaths in this subcat tree
  $productsInCategory = zen_get_categories_products_list( (($manufacturers_id > 0 && $_GET['filter_id'] > 0) ? zen_get_generated_category_path_rev($_GET['filter_id']) : $cPath), false, true, 0, $display_limit);

  if (is_array($productsInCategory) && sizeof($productsInCategory) > 0) {
    // build products-list string to insert into SQL query
    foreach($productsInCategory as $key => $value) {
      $list_of_products .= $key . ', ';
    }
    $list_of_products = substr($list_of_products, 0, -2); // remove trailing comma
    $special_products_query = " select distinct p.products_id, p.products_image, 
	                                           pd.products_name,p.master_categories_id
                                from (" . TABLE_PRODUCTS . " p
                                left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id
                                left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id)
                                where p.products_id = s.products_id
                                and p.products_id = pd.products_id
                                and p.products_status = 1 
								and s.status = 1
                                and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                                and p.products_id in (" . $list_of_products . ") 
								ORDER BY s.specials_date_added DESC	";
  }
}
if ($special_products_query != '') $special_products_db = $db->ExecuteRandomMulti($special_products_query, MAX_DISPLAY_SEARCH_RESULTS_FEATURED);

$num_products_count = ($special_products_query == '') ? 0 : $special_products_db->RecordCount();

// show only when 1 or more
if ($num_products_count > 0) {
  
  $special_products=array();
  while (!$special_products_db->EOF) {
         $tmp_id=$special_products_db->fields['products_id'];  
         $products_price = zen_get_products_display_price($tmp_id);
		 
		 $special_products[]=array('products_name'=>$special_products_db->fields['products_name'],
		                           'products_image'=>$special_products_db->fields['products_image'],
								   'products_price'=>$products_price,
								   'buy_link'=>zen_href_link(FILENAME_DEFAULT,
															 zen_get_all_get_params(array('action','products_id')).'action=buy_now&products_id='.$tmp_id),
									'products_url_link'=>zen_href_link(zen_get_info_page($tmp_id), 
									                                   'cPath=' . $productsInCategory[$tmp_id] . 
																	   '&products_id=' .$tmp_id)
									);
    
         $special_products_db->MoveNextRandom();
  }
  $zc_show_special = true;

}
?>