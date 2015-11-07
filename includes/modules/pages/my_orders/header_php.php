<?php
/**
 * Header code file for the Account History page
 *
 * @package page
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 3160 2006-03-11 01:37:18Z drbyte $
 */
// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_ACCOUNT_HISTORY');


if (!$_SESSION['customer_id']) {
  $_SESSION['navigation']->set_snapshot();
  zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

$breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2);
$action = $_REQUEST['action'];

if($action=="reset_pay_argument"){
	if(isset($_POST['coupon'])) $_SESSION['old_coupon']=$_POST['coupon'];
	if(isset($_POST['payment'])) $_SESSION['old_payment']=$_POST['payment'];
	if(isset($_POST['shipping'])) $_SESSION['old_shipping']=$_POST['shipping'];
	if(isset($_POST['orders_id'])) $_SESSION['old_orders_id']=$_POST['orders_id'];
	
	//移除购物车中现有的商品
	$_SESSION['cart']->remove_all();

	die(json_encode(array('status'=>'success','content'=>'')));
}

if($action=="cancel"){
	$orders_id=(int)$_REQUEST['orders_id'];
	$query="select orders_status_id from ".TABLE_ORDERS_STATUS." where orders_status_name='Canceled'";
	$result=$db->Execute($query);
	if($result->RecordCount()==0){
		echo CANNT_CANCELED_NOW;
	}else{
		$status_id=(int)$result->fields['orders_status_id'];
		$query="update ".TABLE_ORDERS." set orders_status=".$status_id." where orders_id=:orders_id and customers_id =:customers_id ";
		
		$query = $db->bindVars($query, ':customers_id', $_SESSION['customer_id'], 'integer');
  		$query = $db->bindVars($query, ':orders_id', $orders_id, 'integer');
  		$db->Execute($query);
  		zen_redirect(zen_href_link('my_orders', 'ucenter=1', 'SSL'));
	}
	
}

$orders_total = zen_count_customer_orders();

//所有的订单状态
$my_order_status=getCustomConfig('order_status');
$my_order_status_arr=explode(",", $my_order_status);
$order_status_arr=array();
foreach ($my_order_status_arr as $status_str){
	$tmp_arr=explode("=", $status_str);
	if(count($tmp_arr)==2){
		$order_status_arr[$tmp_arr[0]]=$tmp_arr[1];
	}
}

if ($orders_total > 0) {
	if($action=="find_order"){
		$find_orders_id=(int)$_REQUEST['find_orders_id'];
		$find_str=" and o.orders_id=".$find_orders_id." ";
	}else{
		$find_str="";
	}
  $history_query_raw = "SELECT o.orders_id, o.date_purchased,o.orders_status, o.delivery_name,payment_module_code,payment_method,shipping_module_code,shipping_method,coupon_code,  
                               o.billing_name, ot.text as order_total 
                        FROM   " . TABLE_ORDERS . " o , " . TABLE_ORDERS_TOTAL . " ot 
                        WHERE      o.customers_id = :customersID
                        AND        o.orders_id = ot.orders_id
                        AND        ot.class = 'ot_total'
                
               
                        $find_str 
                        ORDER BY   orders_id DESC";

  $history_query_raw = $db->bindVars($history_query_raw, ':customersID', $_SESSION['customer_id'], 'integer');

  $history_split = new splitPageResults($history_query_raw, MAX_DISPLAY_ORDER_HISTORY);
  $history = $db->Execute($history_split->sql_query);

  $accountHistory = array();
  $accountHasHistory = true;
  
  $status_count=array('Pending'=>0,'Processing'=>0,'Delivered'=>'0','Update'=>0,'Canceled'=>0,'Payed'=>0);
  
  while (!$history->EOF) {
    $products_query = "SELECT distinct op.products_id,op.products_name, p.products_image,op.products_quantity  
                       FROM   " . TABLE_ORDERS_PRODUCTS . " op inner join ".TABLE_PRODUCTS." p on op.products_id=p.products_id 
                       WHERE  orders_id = :ordersID";

    $products_query = $db->bindVars($products_query, ':ordersID', $history->fields['orders_id'], 'integer');
    $products = $db->Execute($products_query);

    $product_count = 0;
    $products_arr = array();
    while(!$products->EOF){
    	$product_count++;
    	$products_arr[] = array('products_name'=>$products->fields['products_name'],
    							 'products_id'=>$products->fields['products_id'],
    							'products_image'=>$products->fields['products_image'],
    	
    							 'products_quantity'=>$products->fields['products_quantity']);
    	$products->MoveNext();
    }
    
    //can not pay a order if the order expired 30 days.
    $min_pay_time = date("Y-m-d H:i:s",strtotime("-30 days"));
    if($history->fields['orders_status'] == 1 && $history->fields['date_purchased'] < $min_pay_time){
    	$history->fields['orders_status'] = -1;
    }
 
    
    if($history->fields['orders_status'] == '1'){
    	$status_count['Pending']++;
    }else if($history->fields['orders_status'] == '3'){
    	$status_count['Processing']++;
    }else if($history->fields['orders_status'] == '4'){
    	$status_count['Delivered']++;
    }else if($history->fields['orders_status'] == '2'){
    	$status_count['Payed']++;
    }
    $orders_status=$history->fields['orders_status'];
    if(in_array($orders_status, array_keys($order_status_arr))){
    	$history->fields['orders_status_name']=$order_status_arr[$orders_status];
    }else{
    	if(defined('UNKNOW_STATUS')){
    		$history->fields['orders_status_name']=UNKNOW_STATUS;
    	}else{
    		$history->fields['orders_status_name']='unknown';
    	}
    	
    }

    if (zen_not_null($history->fields['delivery_name'])) {
      $order_type = TEXT_ORDER_SHIPPED_TO;
      $order_name = $history->fields['delivery_name'];
    } else {
      $order_type = TEXT_ORDER_BILLED_TO;
      $order_name = $history->fields['billing_name'];
    }
    
    //跟踪单号
    $track_nums=getTrackNums($history->fields['orders_id']);
    $track_nums=join(',', $track_nums);
    
    $shipping_module_code=$history->fields['shipping_module_code'];
    if(strpos($shipping_module_code, "detschepost")!==false){//德国小包
    	$track_url="https://www.deutschepost.de/sendungsstatus/bzl/sendung/simpleQuery.html?locale=en&init=true";
    }else if(strpos($shipping_module_code, "dhl")!==false){
    	$track_url="http://www.dhl.com";
    }else{
    	$track_url="http://www.17track.net/IndexEn.html";
    }
    
    $extras = array('order_type'=>$order_type,
    'order_name'=>$order_name,
    'products'=>$products_arr,
    'product_count'=>$product_count,
    'track_url'=>$track_url,
    'track_num'=>$track_nums);
    
    $accountHistory[] = array_merge($history->fields, $extras);
   // echo "<pre>";print_r($history->fields);exit;
    $history->moveNext();
  }
  

} else {
  $accountHasHistory = false;
}
if($_REQUEST['test']){
  echo "<pre>";print_r($accountHistory);
}

function getTrackNums($orders_id){
	global $db;
	$sql = "select track_num from 2011orders_track_num where orders_id='".$orders_id."'";
	$result = $db->Execute($sql);
	
	$track_num_arr=array();
	while(!$result->EOF){
		$track_num_arr[]=$result->fields['track_num'];
		$result->moveNext();
	}
	return $track_num_arr;
}
// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_ACCOUNT_HISTORY');
?>