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
$debug=false;

$orderId=isset($_REQUEST['orderId'])?$_REQUEST['orderId']:'';
$check=isset($_REQUEST['check'])?$_REQUEST['check']:'';
$statusId=isset($_REQUEST['statusId'])?$_REQUEST['statusId']:'';
$shippingDate=isset($_REQUEST['shippingDate'])?$_REQUEST['shippingDate']:'';
$trackingNumber=isset($_REQUEST['trackingNumber'])?$_REQUEST['trackingNumber']:'';
/**
 * 修改订单状态 index.php?main_page=my_order_status&orderId=:orderId&statusId=:statusId&check=:check
 */

if($debug){
	  echo "<pre>";print_r($_REQUEST);
	  $arr=array(
		 'error0'=>'参数不对，或者没通过校验',
		 'error40'=>'订单号不存在',
		 'error20'=>'发货日期，跟踪单号为空',
		 'error50'=>'订单状态不连续',
		 'error30'=>'未知处理错误',
	  );
	  print_r($arr);
}
if(isset($_REQUEST['action'])){
	$action=trim($_REQUEST['action']);
}else{
	$action="";
}

//包裹查询接口  erp-->here
if($action=="trackno"){
	$orderId=(int)$_REQUEST['orderId'];//投诉订单号
	if(!isValidRequest()){
		die(json_encode(array('status'=>'error','content'=>'error0')));
	}
	$groupId=trim($_REQUEST['groupId']);
	$detail=trim($_REQUEST['detail']);
	$trackingNum=trim($_REQUEST['trackingNum']);

	if(empty($groupId) || empty($detail) || empty($trackingNum)){
		die(json_encode(array('status'=>'error','content'=>'error001')));
	}
	
	$sql="select count(*) as num  from orders  
	where orders_id=:orders_id";
	//$sql=$db->bindVars($sql, ":customers_id", $uid, "integer");
	$sql=$db->bindVars($sql, ":orders_id", $orderId, "integer");
	$select_result=$db->Execute($sql);
	if($select_result->EOF){
		die(json_encode(array('status'=>'error','content'=>'error002')));
	}
	
	$goods_id=$detail;//格式：CEM005,1;MHC519,1 goods_id  数量
	

	$add_time=date("Y-m-d H:i:s");
	$insert_sql="insert into 2011orders_track_num(orders_id,track_num,add_time,group_id,goods_id,goods_num) 
	values('$orderId','$trackingNum','$add_time','$groupId','$goods_id','1')";
	
	$db->Execute($insert_sql);
	die(json_encode(array('status'=>'success','content'=>'')));
	
}


//用户投诉后管理员回复接口 erp-->here
if($action=="complaint_reply"){
	$oid=(int)$_REQUEST['oid'];//投诉订单号
	$orderId=$oid;
	if(!isValidRequest()){
		die(json_encode(array('status'=>'error','content'=>'error0')));
	}
	$oid=trim((int)$_REQUEST['oid']);//投诉订单号
	$reply_content=trim($_REQUEST['reply_content']);
	$uid=trim((int)$_REQUEST['uid']);//用户id  erp不要这个了
	if(empty($oid) || empty($reply_content)){
		die(json_encode(array('status'=>'error','content'=>'error001')));
	}
	
	$sql="select count(*) as num,complaint_id from 2011user_complaint 
	where orders_id=:orders_id";
	//$sql=$db->bindVars($sql, ":customers_id", $uid, "integer");
	$sql=$db->bindVars($sql, ":orders_id", $oid, "integer");
	$select_result=$db->Execute($sql);
	if($select_result->EOF){
		die(json_encode(array('status'=>'error','content'=>'error002')));
	}

	if(empty($reply_content)){
		die(json_encode(array('status'=>'error','content'=>'error003')));
	}
	
	$complaint_id=$select_result->fields['complaint_id'];
	$add_time=date("Y-m-d H:i:s");
	$insert_sql="insert into 2011user_complaint_reply(complaint_id,reply_content,add_time) 
	values('$complaint_id','$reply_content','$add_time')";
	
	$db->Execute($insert_sql);
	die(json_encode(array('status'=>'success','content'=>'')));
	
}

//用户退换货管理员回复接口 erp-->here
if($action=="refund_reply"){
	$oid=(int)$_REQUEST['oid'];
	$orderId=$oid;
	if(!isValidRequest()){
		die(json_encode(array('status'=>'error','content'=>'error0')));
	}
	
	$oid=(int)$_REQUEST['oid'];
	$uid=(int)$_REQUEST['uid'];
	$reply_content=trim($_REQUEST['reply_content']);
	$uid=(int)$_REQUEST['uid'];
	if(empty($uid) || empty($reply_content) || empty($uid)){
		die(json_encode(array('status'=>'error','content'=>'error001')));
	}
	
	$sql="select count(*) as num from 2011refund_apply 
	where customers_id=:customers_id and orders_id=:orders_id";
	$sql=$db->bindVars($sql, ":customers_id", $uid, "integer");
	$sql=$db->bindVars($sql, ":orders_id", $oid, "integer");
	$select_result=$db->Execute($sql);
	if($select_result->EOF){
		die(json_encode(array('status'=>'error','content'=>'error002')));
	}

	if(empty($reply_content)){
		die(json_encode(array('status'=>'error','content'=>'error003')));
	}
	$update_sql="update 2011refund_apply set refund_apply_reply='".$reply_content."' where 
	 customers_id=:customers_id and orders_id=:orders_id
	";
	$update_sql=$db->bindVars($update_sql, ":customers_id", $uid, "integer");
	$update_sql=$db->bindVars($update_sql, ":orders_id", $oid, "integer");

	$db->Execute($update_sql);
	die(json_encode(array('status'=>'success','content'=>'')));
	
}

//商品收藏统计
if($action=="add_favorite"){
	$url=getERPInterface('favorite_good');
	if($url){
		
	if(isset($_REQUEST['pid'])){
		$_REQUEST['products_id'] = $_REQUEST['pid'];
	}

		$products_id=trim($_REQUEST['products_id']);

		$url=str_replace(':product_id', $products_id, $url);
		$url=str_replace(':platname', $web_platname, $url);
		//echo $url;
		if(!empty($_REQUEST['test'])){
			echo "url:".$url."<br>";
			echo "product_id:".$products_id."<br>";
		}
		$content=file_get_contents($url);
		if(strpos($content, "200")!==false){
			die(json_encode(array('status'=>'success','content'=>'')));
		}else if(strpos($content, "300")!==false){
			die(json_encode(array('status'=>'error','content'=>'repeat')));
		}else{
			die(json_encode(array('status'=>'error','content'=>'')));
		}
	}
	die(json_encode(array('status'=>'error exit','content'=>'')));
}


//商品详情页面的降价通知
if($action=="price_notice"){
	
	$products_id=trim($_REQUEST['pid']);
	$my_email=trim($_REQUEST['my_email']);
	$my_price=trim($_REQUEST['my_price']);
	$add_time=date("Y-m-d H:i:s");
	
	//send data to db
	
	$sql = "insert into 2011price_notice(products_id,products_price,add_time,email)
			values('$products_id','$my_price','$add_time','$my_email')";	
	$db->Execute($sql);
	//send data to erp
	$url=getERPInterface('price_notice');
	if($url){

		$url=str_replace(':products_id', $products_id, $url);
		$url=str_replace(':email', $my_email, $url);
		$url=str_replace(':my_price', $my_price, $url);
		$url=str_replace(':platname', $web_platname, $url);
		if(isset($_GET['test'])){
			echo $url;
		}
		$content=file_get_contents($url);
		if(strpos($content, "200")!==false){
			die(json_encode(array('status'=>'success','content'=>'')));
		}else if(strpos($content, "300")!==false){
			die(json_encode(array('status'=>'error','content'=>'repeat')));
		}else{
			die(json_encode(array('status'=>'error','content'=>$content)));
		}
	}
	die(json_encode(array('status'=>'error exit','content'=>'')));
}
/**
  $arr=array(
 'error0'=>'参数不对，或者没通过校验',
 'error40'=>'订单号不存在',
 'error20'=>'发货日期，跟踪单号为空',
 'error50'=>'订单状态不连续',
 'error30'=>'未知处理错误',
  );
 /**/
if(!isValidRequest()){
	die(json_encode(array('status'=>'failure','content'=>'error0')));
}
//!empty($orderId) && !empty($check) &&!empty($statusId)
if(!empty($orderId) && !empty($check) &&!empty($statusId)) {
	
	if(!orderExists($orderId)){//检查订单号是否存在
		die(json_encode(json_encode(array('status'=>'failure','content'=>'error40'))));
	}
	
	if($statusId==4 ||$statusId==5 ){//已经发货或者部分发货
		if(allowUpdateCheck(3,$orderId)){
			/**  单独设置
			if(empty($shippingDate) || empty($trackingNumber)){//发货日期，跟踪单号是必须的
				die(json_encode(array('status'=>'failure','content'=>'error20')));
			}
			/**/
			updateOrderStatus($orderId,$statusId);
			//addTrackNum($orderId,$shippingDate,$trackingNumber);  //单独设置
			die(json_encode(array('status'=>'success','content'=>'')));
		}else{
			die(json_encode(array('status'=>'failure','content'=>'error50')));
		}
		
		
	}
	
	if($statusId==2 ){//已经付款
		if(allowUpdateCheck(array(1,2),$orderId)){
			updateOrderStatus($orderId,$statusId);
			die(json_encode(array('status'=>'success','content'=>'')));
		}else{
			die(json_encode(array('status'=>'failure','content'=>'error50')));
		}
	}
	if($statusId==3 ){//处理中
		if(allowUpdateCheck(2,$orderId)){
			updateOrderStatus($orderId,$statusId);
			die(json_encode(array('status'=>'success','content'=>'')));
		}else{
			die(json_encode(array('status'=>'failure','content'=>'error50')));
		}
	}
	
	die(json_encode(array('status'=>'failure','content'=>'error30')));
}


die(json_encode(array('status'=>'failure','content'=>'0')));





function allowUpdateCheck($checkStatus,$orderId){
	global $db;
	
	$sql = 'select  orders_status from  orders  where orders_id='.(int)$orderId;
	$result = $db->Execute($sql);
	if($result->RecordCount()>0){
		$now_status=$result->fields['orders_status'];
		if(is_array($checkStatus)){
			if(in_array($now_status, $checkStatus)){
				return true;
			}else{
				return false;
			}
		}
		
		if($now_status==$checkStatus){
			return true;
		}else{
			return false;
		}
	}
	return false;
}
function orderExists($orderId){
	global $db;
	
	$sql = 'select  orders_id from  orders  where orders_id='.(int)$orderId;
	$result = $db->Execute($sql);
	if($result->RecordCount()>0){
		return true;
	}else{
		return false;
	}
}
function isValidRequest(){
	global $orderId,$salt,$check;
	
	if(empty($check)||empty($salt)||empty($orderId)){
		return false;
	}
	
	$check_result = md5($salt.$orderId);
	if($_REQUEST['test']){
		echo 'my check :'.$check_result;
		echo '<br>other check :'.$check;
		echo '<br>orderId:'.$orderId;
		//echo '<br>k:'.$salt;
		
	}

	if($check ==$check_result){
		return true;
	}else{
		return false;
	}
}

function updateOrderStatus($orderId,$orderStaus){
	global $db;
	
	$sql = 'update orders set orders_status="'.$orderStaus.'" where orders_id='.(int)$orderId;
	$db->Execute($sql);
	
}
function addTrackNum($orderId,$shippingDate,$trackingNumber){
	global $db;
	$date=date("Y-m-d H:i:s");
	$sql = 'insert into 2011orders_track_num (orders_id,shipping_date,track_num,add_time)
			values("'.$orderId.'","'.$shippingDate.'","'.$trackingNumber.'","'.$date.'")';
	$db->Execute($sql);
	
}
// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_ACCOUNT');
?>