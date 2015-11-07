<?php
/**
 * also_purchased_products_db.php
 *
 * @package modules
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: also_purchased_products_db.php 5369 2006-12-23 10:55:52Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

//if (isset($_GET['products_id']) && SHOW_PRODUCT_INFO_COLUMNS_also_purchased_products_db > 0 && MIN_DISPLAY_ALSO_PURCHASED > 0) {
if (isset($_GET['products_id']) && is_numeric($_GET['products_id']) && SHOW_PRODUCT_INFO_COLUMNS_ALSO_PURCHASED_PRODUCTS>0 && MIN_DISPLAY_ALSO_PURCHASED>0){
	
  //$also_purchased_products_db = $db->Execute(sprintf(SQL_ALSO_PURCHASED, (int)$_GET['products_id'], (int)$_GET['products_id']));
  $also_purchased_products_db_sql=' SELECT  p.products_id,                                            
										    p.products_image
									FROM '.TABLE_ORDERS_PRODUCTS.' opa, 
										 '.TABLE_ORDERS_PRODUCTS.' opb, 
										 '.TABLE_ORDERS.' o, 
										 '.TABLE_PRODUCTS.' p
									WHERE opa.products_id ='.(int)$_GET['products_id'].'
									AND   opa.orders_id = opb.orders_id
									AND   opb.products_id !='.(int)$_GET['products_id'].'
									AND   opb.products_id = p.products_id
									AND   opb.orders_id = o.orders_id
									AND   p.products_status =1
									GROUP BY p.products_id
									ORDER BY o.date_purchased DESC
									LIMIT 6 ';
  $also_purchased_products=array();
  
  $also_purchased_products_db=$db->Execute($also_purchased_products_db_sql);
  
  $num_products_ordered = $also_purchased_products_db->RecordCount();

  // show only when 1 or more and equal to or greater than minimum set in admin
  if ($num_products_ordered >= MIN_DISPLAY_ALSO_PURCHASED && $num_products_ordered > 0) {
   
    while (!$also_purchased_products_db->EOF) {
      
	  $tmp_id=$also_purchased_products_db->fields['products_id'];
	  $also_purchased_products[]=array('products_name'=>zen_get_products_name($tmp_id),
									   'products_url_link'=>zen_href_link(zen_get_info_page($tmp_id),'products_id='.$tmp_id),
									   'products_image'=>$also_purchased_products_db->fields['products_image'],
									   'products_price'=>zen_get_products_display_price($tmp_id)
									   );
	  
      $also_purchased_products_db->MoveNext();
    }
	$zc_show_also_purchased = true;
  }
 
}
?>