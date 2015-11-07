<?php
   /**
	 * category_of_new_products.php module
	 *
	 * @package modules
	 * @copyright Copyright 2003-2007 Zen Cart Development Team
	 * @copyright Portions Copyright 2003 osCommerce
	 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
	 * @version $Id: category_of_new_products.php 6424 2010-04-09 05:59:21Z john $
	 */
	if (!defined('IS_ADMIN_FLAG')) {
	  die('Illegal Access');
	}
	
	if(isset($new_products_db)) unset($new_products_db);
	if(isset($new_products)) unset($new_products);
	if(isset($tmp_pid)) unset($tmp_pid);
	
	if( isset($current_category_id) && $current_category_id>0 ){

		$new_products_query = " select distinct 
									   p.products_id, 
									   p.products_image,
									   pd.products_name,
									   pd.products_short_description                                          
							    from " . TABLE_PRODUCTS . " p, 
									 " . TABLE_PRODUCTS_DESCRIPTION . " pd,
									 " . TABLE_PRODUCTS_TO_CATEGORIES. " p2c,
									 " . TABLE_CATEGORIES. " c
							    where p.products_id = pd.products_id
								and   p.products_id = p2c.products_id 
								and   p.products_status=1 
								and   c.categories_id=p2c.categories_id
								and   ".(int)$current_category_id."  in (c.categories_id,c.parent_id) 
							    and   pd.language_id = '" . (int)$_SESSION['languages_id'] . "'					    
							    order by p.products_date_added desc limit 0,".(MAX_DISPLAY_NEW_PRODUCTS+4);							
		$new_products_db=$db->Execute($new_products_query);
		if($new_products_db->RecordCount()>0){
		   $new_products=array();
		   
		   while(!$new_products_db->EOF){
		       $tmp_pid=$new_products_db->fields['products_id'];
			   $products_price = zen_get_products_display_price($tmp_pid);
			   
		       $new_products[]=array('products_name'=>$new_products_db->fields['products_name'],
			                         'products_image'=>$new_products_db->fields['products_image'],
									 //'products_short_description'=>$new_products_db->fields['products_short_description'],
									 'products_price'=>$products_price,
									 'products_url_link'=>zen_href_link(zen_get_info_page($tmp_pid), 
																	   /*'cPath=' .(int)$current_category_id . */
																	   'products_id=' .$tmp_pid
																	   )
									);									
			   $new_products_db->MoveNext();					 
		   }
		   $zc_show_categories_new=true;
		}
	}
?>