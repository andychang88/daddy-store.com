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
	if(isset($global_id_excluded) && is_array($global_id_excluded) && sizeof($global_id_excluded)>0){
	   $filter_id_str=implode(',',$global_id_excluded);
	   $filter_id_str =' and  p.products_id not in('.$filter_id_str.') ';
	}else{
	   $filter_id_str='';
	}
	$top_sold_query = "select   distinct 
							     p.products_id, 
							     p.products_image,
							     pd.products_name                                           
						from " . TABLE_PRODUCTS . " p, 
							 " . TABLE_PRODUCTS_DESCRIPTION . " pd,
							 " . TABLE_PRODUCTS_TO_CATEGORIES. " p2c,
							 " . TABLE_CATEGORIES. " c
						where p.products_id = pd.products_id
						and   p.products_id = p2c.products_id 
						and   c.categories_id=p2c.categories_id
						and   p.products_status=1
						and   c.categories_status=1						
						and   pd.language_id = '" . (int)$_SESSION['languages_id'] . "'	
						      ".$filter_id_str." 						    
						order by p.products_ordered desc,p.products_date_added desc limit 0,20";							
	$top_sold_db=$db->Execute($top_sold_query);
	if($top_sold_db->RecordCount()>0){
	   $top_sold_products=array();
	   
	   while(!$top_sold_db->EOF){
		   $tmp_pid=$top_sold_db->fields['products_id'];
		   $products_price = zen_get_products_display_price($tmp_pid);
		   
		   $top_sold_products[]=array('products_name'=>$top_sold_db->fields['products_name'],
									  'products_image'=>$top_sold_db->fields['products_image'],
									  'products_price'=>$products_price,
									  'products_url_link'=>zen_href_link(zen_get_info_page($tmp_pid), 
																	   'cPath=' .(int)$current_category_id . 
																	   '&products_id=' .$tmp_pid
																	   )
								      );									
		   $top_sold_db->MoveNext();					 
	   }
	   $show_top_sold=true;
	}
	
?>