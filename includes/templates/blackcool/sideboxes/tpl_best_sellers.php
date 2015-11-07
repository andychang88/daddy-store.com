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

 $content = '
<div class="topseller_h f13 fb">Top Sellers</div>
<div class="topseller_con">
 <div class="sellers">
     <h4>Accessories</h4>';
 
 
   

  for ($i=1; $i<=sizeof($bestsellers_list); $i++) {
	$img_tmp_url = DIR_WS_IMAGES.$bestsellers_list[$i]['image'];
	if(!is_file($img_tmp_url)){
	  $img_tmp_url = DIR_WS_IMAGES."/default.jpg";
	}
    $content .= '<dl>
		<dt>
	                <a href="' . zen_href_link(zen_get_info_page($bestsellers_list[$i]['id']), 'products_id=' . $bestsellers_list[$i]['id']) . '">'
			.zen_image($img_tmp_url,addslashes($bestsellers_list[$i]['name']),75,75,' ').'		
					</a>
		</dt>
		<dd><p class="modelname"><a href="' . zen_href_link(zen_get_info_page($bestsellers_list[$i]['id']), 
					                            'products_id=' . $bestsellers_list[$i]['id']) . '" 
						 title="'.$bestsellers_list[$i]['name'].'">
					    ' . zen_trunc_string($bestsellers_list[$i]['name'], 60, BEST_SELLERS_TRUNCATE_MORE) . '		
					  </a>
		    </p>
		    <p><span class="sale_price">'.$bestsellers_list[$i]['price'].'</span></p>
					  
		</dd>
				 </dl>';
  } //<!--end -->
  
  
  $content .= '</div>' . "\n";
  $content .= '</div>' . "\n";

  
  
 /**
  $content = '';
  $content .= '<div  class="bestseller">' . "\n";
  $content .='<h6>'.BOX_HEADING_BESTSELLERS.'</h6>  ';
  $content .= '<ul>'; // <!--zhanglu 2011-5-16 br /-->
  for ($i=1; $i<=sizeof($bestsellers_list); $i++) {
	
    $content .= '<li>
	                <a href="' . zen_href_link(zen_get_info_page($bestsellers_list[$i]['id']), 
					                           'products_id=' . $bestsellers_list[$i]['id']) . '">
					'.zen_image(DIR_WS_IMAGES.$bestsellers_list[$i]['image'],
					            addslashes($bestsellers_list[$i]['name']),80,80,' class="float_left"').'		
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
  } //<!--end -->
  $content .= '</ul>' . "\n";
  $content .= '</div>' . "\n";
  $content .= '<div class="clear"></div>';
  
  /**/
?>