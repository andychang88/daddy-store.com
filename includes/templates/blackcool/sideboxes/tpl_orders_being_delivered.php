<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_order_history.php 4224 2006-08-24 01:41:50Z drbyte $
 */
  $content = "";
  $content .= '<div class="bl">';
  $content .= '<h5>'.BOX_HEADING_DELIVERD_PRODUCTS.'</h5>';
  $content .= '<ul>';

  foreach($orders_delivered_products as $order){

        $content .= '<li><a href="' .$order['products_url_link']. '">
		                 ' . $order['products_name'] . '<br />
						 <span>ship to '.$order['delivery_city'].','.$order['delivery_country'].'</span>
						 </a>
					 </li>';
  }
  $content .= '</ul>';
  $content .= '</div>';
?>