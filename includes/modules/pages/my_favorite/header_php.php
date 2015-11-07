<?php
/**
 * Header code file for the customer's Account page
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 4824 2006-10-23 21:01:28Z drbyte $
 */
// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_ACCOUNT');
$customer_has_gv_balance = false;
$customer_gv_balance = false;

if (!$_SESSION['customer_id']) {
  $_SESSION['navigation']->set_snapshot();
  zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

//bof 删除指定的收藏商品
if (isset($_GET["act"]) && $_GET["act"] == "del") {
	$favorite_id = $_GET["favorite_id"];
	$favorite_query = "delete from 2011favorite_goods where ";
	if(strpos($favorite_id, ',') !== false){//一次删除多个
		$favorite_list = preg_replace("/,+/", ",", $favorite_id);
		$favorite_query .= " favorite_id in (" . $favorite_list . ")";
	} else {//删除指定的一个
		$favorite_query .= " favorite_id=:favorite_id";
		$favorite_query = $db->bindVars($favorite_query, ':favorite_id', $favorite_id, 'integer');
	}
	
	$favorite_delete_result = $db->Execute($favorite_query);
	zen_redirect(zen_href_link('my_favorite', 'ucenter=1', 'SSL'));
	
}
//bof 降价通知的商品
if (isset($_POST["act"]) && $_POST["act"] == "price_notice") {
	$products_id = $_POST["products_id"];
	$customer_id = $_SESSION['customer_id'];
	$products_price = $_POST["products_price"];
	$favorite_id = $_POST["favorite_id"];
	$add_time = date("Y-m-d H:i:s");
	
	$sql = "insert into 2011price_notice(favorite_id,products_id, customers_id, products_price, add_time)
			values('$favorite_id','$products_id','$customer_id','$products_price','$add_time')";
	$db->Execute($sql);
	$message = array('status'=>'success');
	die(json_encode($message));
}
//eof

//bof 取消降价通知
if (isset($_POST["act"]) && $_POST["act"] == "price_notice_cancel") {
	$price_notice_id = $_POST["price_notice_id"];
	$customer_id = $_SESSION['customer_id'];
	
	$sql = "delete from 2011price_notice where price_notice_id='$price_notice_id' and customers_id ='$customer_id'";
	$db->Execute($sql);
	$message = array('status'=>'success');
	die(json_encode($message));
}
//eof

//bof 收藏的商品
$favorite_query = "select fg.favorite_id, IFNULL(price_notice_id, 0) as price_notice_id, fg.language_id, p.products_id, p.products_price,p.products_afterbuy_model, p.products_image,p.products_stock_status, pd.products_name, fg.add_time, cd.categories_name
    
				   from 2011favorite_goods fg  left join 2011price_notice pn on fg.products_id=pn.products_id, 
				   products p, products_description pd, products_to_categories ptc, categories c, categories_description cd
				      
				   where p.products_id=fg.products_id 
				   and p.products_id=pd.products_id 
				   and p.products_id=ptc.products_id  
				   and c.categories_id=ptc.categories_id 
				   
				   and cd.categories_id=c.categories_id  
				   and fg.language_id=pd.language_id  
				   and fg.language_id=cd.language_id  
				   
				   and fg.language_id=:language_id 
				   and fg.customers_id=:customers_id ";
//and fg.categories_id=c.categories_id 
$favorite_query = $db->bindVars($favorite_query, ':language_id', $_SESSION['languages_id'], 'integer');
$favorite_query = $db->bindVars($favorite_query, ':customers_id', $_SESSION['customer_id'], 'integer');

$page_split = new splitPageResults($favorite_query, 10,'*','page');
$favorite_query=$page_split->sql_query;
$favorite_result = $db->Execute($favorite_query);

$favoriteArray = array();
$pids = array();
$price_prefix='';
while (!$favorite_result->EOF) {
  $products_id = $favorite_result->fields['products_id'];
  if(!$products_id || key_exists($products_id, $pids)){
  	$favorite_result->MoveNext();
  	continue;
  }
  $pids[$products_id] = $products_id;
  $favorite_id = $favorite_result->fields['favorite_id'];
  $count_sql = "select count(*) as price_notice_num 
  				from 2011price_notice_content pnc inner join 2011price_notice pn on pnc.price_notice_id=pn.price_notice_id 
  				inner join 2011favorite_goods fg on fg.favorite_id=pn.favorite_id 
  				where fg.favorite_id='".$favorite_id."'";
  $count_result = $db->Execute($count_sql);
  if(!$count_result->EOF){
  	$message_num = $count_result->fields['price_notice_num'];
  }else{
  	$message_num = 0;
  }
  $display_price=zen_get_products_display_price($favorite_result->fields['products_id']);
  if(empty($price_prefix)){
  	preg_match("/Price:(\D+)\d/",$display_price,$t);
  	if($t){
  		$price_prefix = $t[1];
  	}
  	
  }
  $favoriteArray[] = array(
  'favorite_id'=>$favorite_result->fields['favorite_id'],
  'products_id'=>$favorite_result->fields['products_id'],
  'products_afterbuy_model'=>$favorite_result->fields['products_afterbuy_model'],
  'products_price'=>zen_get_products_display_price($favorite_result->fields['products_id']),
  'price_num'=>zen_get_products_actual_price($favorite_result->fields['products_id']),
  'products_image'=>$favorite_result->fields['products_image'],
  'products_name'=>$favorite_result->fields['products_name'],
  'language_id'=>$favorite_result->fields['language_id'],
  'price_notice_id'=>$favorite_result->fields['price_notice_id'],
  'message_num'=>$message_num,
  'add_time'=>$favorite_result->fields['add_time'],
  'products_stock_status'=>$favorite_result->fields['products_stock_status'],
  );
  //$favoriteArray[][] = $favorite_result->fields['add_time'];

  $favorite_result->MoveNext();
}
//echo "<pre>";print_r($favoriteArray);
//eof
 
// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_ACCOUNT');
?>