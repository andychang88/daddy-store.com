<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_top10_products.php 2982 2010-04-08 00:06:41Z john $
 */
  $content = '';
  $content .= '<div  class="t10">' . "\n";
  $content .='<h6>'.BOX_HEADING_TOP_10_SOLD.'</h6>  ';
  $content .= '<ul>';
  for ($i=1; $i<=sizeof($top10_products); $i++) {
	
    $content .='<li>
	                <a href="' . zen_href_link(zen_get_info_page($top10_products[$i]['id']), 
					                           'products_id=' . $top10_products[$i]['id']) . '">';
	$content .=($i<=3)?'<span>':'';
	$content .=$i.'.'.zen_trunc_string($top10_products[$i]['name'], 30, BEST_SELLERS_TRUNCATE_MORE);
	$content .=($i<=3)?'</span>':'';
	$content .='</a></li>';
  }
  $content .= '</ul>' . "\n";
  $content .= '</div>' . "\n";
  $content .= '<div class="clear"></div>';
 
?>