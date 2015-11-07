<?php
/**
 * order_history sidebox - if enabled, shows customers' most recent orders
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: order_history.php 4822 2006-10-23 11:11:36Z drbyte $
 */

  //if (isset($_SESSION['customer_id']) && (int)$_SESSION['customer_id'] != 0) {//regardless of logged in or not
// retreive the last x products purchased
  $orders_delivered_query = "select distinct 
									  op.products_id,
									  op.products_name,
									  o.delivery_city,
									  o.delivery_country
						     from   " . TABLE_ORDERS . " o, 
						            " . TABLE_ORDERS_PRODUCTS . " op, 
								    " . TABLE_PRODUCTS . " p
						     where  o.orders_id = op.orders_id
						     and    op.products_id = p.products_id
						     and    p.products_status = '1'
							 and    o.orders_status=3
						     group  by products_id
						     order  by o.date_purchased desc
						     limit  " . MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX;

    $orders_delivered_db = $db->Execute($orders_delivered_query);

    if ($orders_delivered_db->RecordCount() > 0) {
      $orders_delivered_products=array();
	  
      while (!$orders_delivered_db->EOF) {
        $temp_pid = (int)$orders_delivered_db->fields['products_id'];
		
		$orders_delivered_products[]=array('products_name'=>$orders_delivered_db->fields['products_name'],
										   'products_url_link'=>zen_href_link(zen_get_info_page($temp_pid),'products_id=' . $temp_pid),
										   'delivery_city'=>$orders_delivered_db->fields['delivery_city'],
										   'delivery_country'=>$orders_delivered_db->fields['delivery_country']);
		
        $orders_delivered_db->MoveNext();
      }      
      require($template->get_template_dir('tpl_orders_being_delivered.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_orders_being_delivered.php');
      //$title =  BOX_HEADING_CUSTOMER_ORDERS;
      $title_link = false;
      require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
    }
 // }
?>