<?php
/**
 * unsubscribe header_php.php 
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 3000 2006-02-09 21:11:37Z wilt $
 */

// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_GROSSHANDEL');

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$breadcrumb->add(NAVBAR_TITLE, zen_href_link(FILENAME_WHOLESALE, '', 'NONSSL'));

$products_wholesale=array();
$define_page = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_GROSSHANDEL, 'false');

/*$all_wholesale_sql ='SELECT p.products_id,pd.products_name, p.products_image,
							p.products_tax_class_id,p.products_model,
							p.products_quantity_order_min, p.products_weight,
							p.products_discount_type,p.products_discount_type_from
					 FROM ' . TABLE_PRODUCTS_DISCOUNT_QUANTITY . ' pdq
					 LEFT JOIN ' . TABLE_PRODUCTS . ' p
					 ON (pdq.products_id = p.products_id),
					      ' . TABLE_PRODUCTS_DESCRIPTION . ' pd
					 WHERE p.products_status = 1
					 AND   p.products_id = pd.products_id
					 AND   pd.language_id ='.(int)$_SESSION['languages_id'];

$all_wholesale_split = new splitPageResults($all_wholesale_sql, MAX_DISPLAY_PRODUCTS_LISTING);

if($all_wholesale_split->number_of_rows > 0){

	$all_wholesale_db = $db->Execute($all_wholesale_split->sql_query);
	
	while(!$all_wholesale_db->EOF){	 
	  $tmp_w_pid=$all_wholesale_db->fields['products_id']; 
	  $products_wholesale[$tmp_w_pid]=array('product_name'=>$all_wholesale_db->fields['products_name'],
										    'product_image'=>$all_wholesale_db->fields['products_image'],
										    'product_tax_class_id'=>$all_wholesale_db->fields['products_tax_class_id'],
										    'product_url_link'=>zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$tmp_w_pid)
											);
	  $all_wholesale_db->MoveNext();
	}

}*/
// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_GROSSHANDEL');
?>