<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_same_price_products.php 2982 2010-04-08 00:06:41Z john $
 */
  $content = '';
  $content .= '<div  class="gleichem">' . "\n";
  $content .='<h6>'.BOX_HEADING_SAME_PRICE.'</h6>  ';
  $content .= '<ul>';
  foreach($sp_products as $product) {
	
    $content .='<li>
	                <a href="'.$product['product_url_link'].'">'.
					zen_image(DIR_WS_IMAGES.$product['product_image'],$product['product_name'],50,50,' class="float_left"').'
					</a>   							   
				';
	
	$content .='<p><a href="'.$product['product_url_link'].'">
	              '.zen_trunc_string($product['product_name'], 40, BEST_SELLERS_TRUNCATE_MORE).'
				   </a>
				   <br/>';
	$content .='<span>'.$currencies->display_price($product['product_price']).'</span>';
	$content .='</p></li>';
  }
  $content .= '</ul>' . "\n";
  $content .= '</div>' . "\n";
  $content .= '<div class="clear"></div>'; 
?>