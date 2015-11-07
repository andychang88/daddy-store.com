<?php
/**
 * unsubscribe header_php.php 
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 3000 2006-02-09 21:11:37Z wilt $
 */

// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_GROSSHANDEL');

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$breadcrumb->add(NAVBAR_TITLE, zen_href_link(FILENAME_WHOLESALE, '', 'NONSSL'));

$products_wholesale=array();
$all_wholesale_sql='';

$all_wholesale_sql ='SELECT p.products_id,pd.products_name, p.products_image,
							p.products_tax_class_id,p.products_model,
							p.products_quantity_order_min, p.products_weight,
							p.products_discount_type,p.products_discount_type_from
					 FROM ' . TABLE_PRODUCTS_DISCOUNT_QUANTITY . ' pdq
					 LEFT JOIN ' . TABLE_PRODUCTS . ' p
					 ON (pdq.products_id = p.products_id),
					      ' . TABLE_PRODUCTS_DESCRIPTION . ' pd
					 WHERE p.products_status = 1
					 AND   p.products_id = pd.products_id
					 AND   pd.language_id ='.(int)$_SESSION['languages_id'];

$all_wholesale_split = new splitPageResults($all_wholesale_sql, MAX_DISPLAY_PRODUCTS_LISTING);
if($all_wholesale_split->number_of_rows > 0){

	$all_wholesale_db = $db->Execute($all_wholesale_split->sql_query);
	
	while(!$all_wholesale_db->EOF){
	   $tmp_w_pid=$all_wholesale_db->fields['products_id'];
	   $tmp_qty_order_min=$all_wholesale_db->fields['products_quantity_order_min'];
	   $tmp_dis_type=$all_wholesale_db->fields['products_discount_type'];
	   $tmp_dis_type_from=$all_wholesale_db->fields['products_discount_type_from'];
	   
	   
	   
	   $price_data=array();
	   $dis_qty_sql='select discount_qty,discount_price 
					 from '.TABLE_PRODUCTS_DISCOUNT_QUANTITY.'
					 where products_id='.$tmp_w_pid.' 
					 and   discount_qty!=0 
					 order by discount_qty';
						
	   $dis_qty_db=$db->Execute($dis_qty_sql);
	   if($dis_qty_db->RecordCount()>0){
	        $dis_cnt=0;
	   
	        $display_price = zen_get_products_base_price($tmp_w_pid);
			$display_specials_price = zen_get_products_special_price($tmp_w_pid, true);			
			//################Begin:set first price value##################
			if ($display_specials_price == false) {
			  $show_price = $display_price;
			} else {
			  $show_price = $display_specials_price;
			}
			switch (true) {
			  case ($dis_qty_db->fields['discount_qty'] <= 2):
				  $show_qty = '1';
				  break;
			  case ($tmp_qty_order_min == ($dis_qty_db->fields['discount_qty']-1) || $tmp_qty_order_min == ($dis_qty_db->fields['discount_qty'])):
				  $show_qty = $tmp_qty_order_min;
				  break;
			  default:
				  $show_qty = $tmp_qty_order_min . '-' . number_format($dis_qty_db->fields['discount_qty']-1);
				  break;
			}   			
			$price_data[$dis_cnt]['discount_qty']=$show_qty;			
			$price_data[$dis_cnt]['discount_price']=$show_price;
			//################End:set first price value##################			
			while(!$dis_qty_db->EOF){	
				   $dis_cnt++;
				   //price handle
				   switch($tmp_dis_type){
					   // none
					   case '0':
							   $price_data[$dis_cnt]['discount_price']=0;
							   break;
					   //discount base on percent
					   case '1':
							   if($tmp_dis_type_from=='0'){
								  $price_data[$dis_cnt]['discount_price']=$display_price*(1-$dis_qty_db->fields['discount_price']/100);
							   }else{
								  if(!display_specials_price){
									 $price_data[$dis_cnt]['discount_price']=$display_price*(1-$dis_qty_db->fields['discount_price']/100);
								  }else{
									 $price_data[$dis_cnt]['discount_price']=$display_specials_price*(1-$dis_qty_db->fields['discount_price']/100);
								  }
							   }
							   break;
					   //actual price
					   case '2':
							   $price_data[$dis_cnt]['discount_price'] = $dis_qty_db->fields['discount_price'];
							   break;
					   //minus specific price
					   case '3':
							   if($tmp_dis_type_from=='0'){
								  $price_data[$dis_cnt]['discount_price']=$display_price-$dis_qty_db->fields['discount_price'];
							   }else{
								  if(!display_specials_price){
									 $price_data[$dis_cnt]['discount_price']=$display_price-$dis_qty_db->fields['discount_price'];
								  }else{
									 $price_data[$dis_cnt]['discount_price']=$display_specials_price-$dis_qty_db->fields['discount_price'];
								  }
							   }
							   break;
				   }
				   //quantity show handle
				   $price_data[$dis_cnt]['discount_qty']=number_format($dis_qty_db->fields['discount_qty']);
				   
				   $dis_qty_db->MoveNext(); 
				   
				   if($dis_qty_db->EOF){
					  $price_data[$dis_cnt]['discount_qty'].='+';
				   }else{
				      if (($dis_qty_db->fields['discount_qty']-1) != $show_qty) {
						  if($price_data[$dis_cnt]['discount_qty']<$dis_qty_db->fields['discount_qty']-1){
							 $price_data[$dis_cnt]['discount_qty'].='-'.number_format($dis_qty_db->fields['discount_qty']-1);
						  }
					  }
				   }    
			   
			   
			 }
			 $products_wholesale[$tmp_w_pid]=array('product_name'=>$all_wholesale_db->fields['products_name'],
			                                       'product_image'=>$all_wholesale_db->fields['products_image'],
												   'product_tax_class_id'=>$all_wholesale_db->fields['products_tax_class_id'],
												   'product_url_link'=>zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$tmp_w_pid),
												   'price_data'=>$price_data
												   );
	   }
	   
	   $all_wholesale_db->MoveNext();
	}

}
// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_GROSSHANDEL');
?>