<?php
    /**
	 * manufacturers_row.php module
	 *
	 * @package modules
	 * @copyright Copyright 2003-2007 Zen Cart Development Team
	 * @copyright Portions Copyright 2003 osCommerce
	 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
	 * @version $Id: manufacturers_row.php 6424 2010-04-09 05:59:21Z john $
	 */
	if (!defined('IS_ADMIN_FLAG')) {
	  die('Illegal Access');
	}
	if(isset($current_category_id) && $current_category_id>0){
		$manufacturers_current_category_query='select distinct 
													  m.manufacturers_name,m.manufacturers_id
											   from   products p,												 
													  manufacturers m,
													  products_to_categories p2c												 
											   where  p.products_status=1 										   
											   and    p.manufacturers_id=m.manufacturers_id 
											   and    p2c.products_id=p.products_id
											   and    p2c.categories_id='.(int)$current_category_id.' 							   
											   order  by m.manufacturers_name desc ';
        $manufacturers_db=$db->Execute($manufacturers_current_category_query);
	    if($manufacturers_db->RecordCount()>0){
		   $manufacturers_current_category=array();
		   while(!$manufacturers_db->EOF){
		      $manufacturers_current_category[]=array('manufacturer_name'=>$manufacturers_db->fields['manufacturers_name'],
													  'url_link'=>zen_href_link(FILENAME_DEFAULT, 
																			    'cPath=' .$current_category_id. 
																			    '&manufacturers_id=' .$manufacturers_db->fields['manufacturers_id'])
													  );
			  $manufacturers_db->MoveNext();
		   }
		}		
	}												  
?>