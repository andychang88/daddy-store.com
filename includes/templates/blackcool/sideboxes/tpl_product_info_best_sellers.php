<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_best_sellers.php 2982 2006-02-07 07:56:41Z birdbrain $
 */
  $content = '';//<!--zhanglu 2011-5-16 br /-->
  $content .= '<div  class="bestseller2">' . "\n";
  $content .='<h6>'.BOX_HEADING_BESTSELLERS.'</h6>  ';
  $content .= '<ul>';
  for ($i=1; $i<=sizeof($bestsellers_list); $i++) {
	
    $content .= '<li>
	                <a href="' . zen_href_link(zen_get_info_page($bestsellers_list[$i]['id']), 
					                           'products_id=' . $bestsellers_list[$i]['id']) . '">
					'.zen_image(DIR_WS_IMAGES.$bestsellers_list[$i]['image'],
					            addslashes($bestsellers_list[$i]['name']),50,50,' class="float_left"').'		
					</a>
					<p>
					  <a href="' . zen_href_link(zen_get_info_page($bestsellers_list[$i]['id']), 
					                            'products_id=' . $bestsellers_list[$i]['id']) . '" 
						 title="'.$bestsellers_list[$i]['name'].'">
					    ' . zen_trunc_string($bestsellers_list[$i]['name'], 60, BEST_SELLERS_TRUNCATE_MORE) . '		
					  </a> <br />
					  <span>'.$bestsellers_list[$i]['price'].'</span>
					</p>
				 </li>';
  }//<!--end-->
  $content .= '</ul>' . "\n";
  $content .= '</div>' . "\n";
  $content .= '<div class="clear"></div>'; 
?>