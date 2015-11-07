<?php
   /**
	 * product_listing module
	 *
	 * @package modules
	 * @copyright Copyright 2003-2007 Zen Cart Development Team
	 * @copyright Portions Copyright 2003 osCommerce
	 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
	 * @version $Id: product_listing.php 6787 2007-08-24 14:06:33Z drbyte $
	 */
	if (!defined('IS_ADMIN_FLAG')) {
	  die('Illegal Access');
	}
	if($result->number_of_rows>MAX_DISPLAY_PRODUCTS_LISTING) $show_split_page=true;
	
	if(isset($result) && $result->number_of_rows>0){
	   $search_products=array();
	   $listing = $db->Execute($result->sql_query);
	   while(!$listing->EOF) {
	        $tmp_pid=$listing->fields['products_id'];
		    $products_price = zen_get_products_display_price($tmp_pid);
		   
		    $search_products[]=array('products_name'=>$listing->fields['products_name'],
									 'products_short_description'=>$listing->fields['products_short_description'],
									 'products_image'=>$listing->fields['products_image'],
									 'products_price'=>$products_price,
									 'products_url_link'=>zen_href_link(zen_get_info_page($tmp_pid), 
																	   'cPath=' .(int)$current_category_id . 
																	   '&products_id=' .$tmp_pid
																	   )
									);									
		    $listing->MoveNext();
	   }
	   $has_search_results=true;
	}
?>