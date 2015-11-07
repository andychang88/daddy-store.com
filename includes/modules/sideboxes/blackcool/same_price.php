<?php
/**
 * top 10 sold products sidebox - displays selected number of (usu top ten) best selling products
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: sp_products.php 2718 2010-04-07 23:59:42:39Z john $
 */

// test if box should display
  if (!defined('IS_ADMIN_FLAG')) {
       die('Illegal Access');
  }
  $show_same_price= true;
  //same price  sp
  if (zen_not_null($_GET['products_id']) && $show_same_price == true && $current_page_base=='product_info') {
      $sp_products=array();
	  $sp_pid=explode(":",$_GET['products_id']);
	  $real_pid=$sp_pid[0];
	  
      $m_cate_db=$db->Execute("select p2.master_categories_id from products p2 where p2.products_id=".$real_pid);
      $m_cate_id=$m_cate_db->fields['master_categories_id'];
	  
      $sp_price=zen_get_products_base_price($real_pid);
      $sp_products_query = "select distinct p.products_id, pd.products_name,p.products_image,p.products_price 
							from " . TABLE_PRODUCTS . " p, 
								 " . TABLE_PRODUCTS_DESCRIPTION . " pd, 
								 " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c,
								 " . TABLE_SPECIALS . " s
							where p.products_status = '1'
							and   p.products_id = pd.products_id
							and   pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
							and   p.products_id = p2c.products_id
							and   p2c.categories_id =".$m_cate_id." 
							and   p.products_id !=s.products_id 
							and   p.products_id !=".$real_pid." 
							and   p.products_price=".$sp_price." 
							order by p.products_ordered desc, pd.products_name
							limit 5";
      $sp_products_db = $db->Execute($sp_products_query);
      $rec_cnt=$sp_products_db->RecordCount();
	
	  if($rec_cnt<=0){
	     $sp_products_query2 ="select distinct p.products_id, pd.products_name,p.products_image,p.products_price 
							from " . TABLE_PRODUCTS . " p, 
								 " . TABLE_PRODUCTS_DESCRIPTION . " pd, 
								 " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c,
								 " . TABLE_SPECIALS . " s
							where p.products_status = '1'
							and   p.products_id = pd.products_id
							and   pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
							and   p.products_id = p2c.products_id
							and   p2c.categories_id in 
							     (select distinct categories_id from categories 
	                              where parent_id=(select parent_id from categories where categories_id=".$m_cate_id.")
								  and   categories_id!=".$m_cate_id.") 
							and   p.products_id !=s.products_id 
							and   p.products_id !=".$real_pid." 
							and   p.products_price=".$sp_price." 
							order by p.products_ordered desc, pd.products_name
							limit 5";
	     $sp_products_db2 = $db->Execute($sp_products_query2);
	     if($sp_products_db2->RecordCount()>0){
	      while($sp_products_db2->EOF){
		  
		        $sp_products[]=array('product_name'=>$sp_products_db2->fields['products_name'],
				                     'product_image'=>$sp_products_db2->fields['products_image'],
									 'product_price'=>$sp_products_db2->fields['products_price'],
									 'product_url_link'=>zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$sp_products_db2->fields['products_id'])
									 );
				$sp_products_db2->MoveNext();
		  }
	   }
	  }elseif($rec_cnt<5){	  
	  
	    while (!$sp_products_db->EOF) {
			    $sp_products[]=array('product_name'=>$sp_products_db->fields['products_name'],
				                     'product_image'=>$sp_products_db->fields['products_image'],
									 'product_price'=>$sp_products_db->fields['products_price'],
									 'product_url_link'=>zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$sp_products_db->fields['products_id'])
									 );
				
				$sp_products_db->MoveNext();
	    }
		$rest_cnt=5-$rec_cnt;
		$sp_products_query3 ="select distinct p.products_id, pd.products_name,p.products_image,p.products_price 
							from " . TABLE_PRODUCTS . " p, 
								 " . TABLE_PRODUCTS_DESCRIPTION . " pd, 
								 " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c,
								 " . TABLE_SPECIALS . " s
							where p.products_status = '1'
							and   p.products_id = pd.products_id
							and   pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
							and   p.products_id = p2c.products_id
							and   p2c.categories_id in 
							     (select distinct categories_id from categories 
	                              where parent_id=(select parent_id from categories where categories_id=".$m_cate_id.")
								  and   categories_id!=".$m_cate_id.") 
							and   p.products_id !=s.products_id 
							and   p.products_id !=".$real_pid."  
							and   p.products_price=".$sp_price." 
							order by p.products_ordered desc, pd.products_name
							limit 0,".$rest_cnt;
	   $sp_products_db3 = $db->Execute($sp_products_query3);
	   if($sp_products_db3->RecordCount()>0){
	      while($sp_products_db3->EOF){
		       $sp_products[]=array('product_name'=>$sp_products_db3->fields['products_name'],
				                    'product_image'=>$sp_products_db3->fields['products_image'],
									'product_price'=>$sp_products_db3->fields['products_price'],
									'product_url_link'=>zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$sp_products_db3->fields['products_id'])
									);
				
				$sp_products_db3->MoveNext();
		  }
	   }
	}
	
    if (sizeof($sp_products)>0) {
      $title =  '';
      //$box_id =  'bestsellers';
      $rows = 0;      
      
      $title_link = false;
      require($template->get_template_dir('tpl_same_price_products.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_same_price_products.php');
      //$title =  BOX_HEADING_BESTSELLERS;
      require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
    }
  }
?>