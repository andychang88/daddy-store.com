<?php
/**
 * featured_products module - prepares content for display
 *
 * @package modules
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: featured_products.php 6424 2007-05-31 05:59:21Z ajeh $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

$featured_products_query = "select distinct p.products_id, p.products_image,
                                            pd.products_name
						    from (" . TABLE_FEATURED . " f
						    left join " . TABLE_PRODUCTS . " p on f.products_id = p.products_id
						    left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
						    where p.products_status = 1 
							and   f.status = 1
						    and   pd.language_id = '" . (int)$_SESSION['languages_id'] . "' 
							order by p.products_ordered";

if ($featured_products_query != '') $featured_products_db = $db->Execute($featured_products_query,MAX_DISPLAY_SEARCH_RESULTS_FEATURED);

$num_products_count = ($featured_products_query == '') ? 0 : $featured_products_db->RecordCount();

// show only when 1 or more
if ($num_products_count > 0) {
  
  while (!$featured_products_db->EOF) {
    $f_pid=$featured_products_db->fields['products_id'];
    $products_price = zen_get_products_display_price($f_pid);
	
	$featured_products[]=array('product_name'=>zen_trunc_string($featured_products_db->fields['products_name'],40,true),
	                           'product_price'=>$products_price,
							   'product_image'=>$featured_products_db->fields['products_image'],
							   'product_url_link'=>zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$f_pid)
							   );	
   
    $featured_products_db->MoveNext();
  }
  
  $zc_show_featured = true;

}
