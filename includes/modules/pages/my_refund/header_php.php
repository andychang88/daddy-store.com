<?php
/**
 * Header code file for the Account Password page
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 4276 2006-08-26 03:18:28Z drbyte $
 */
// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_ACCOUNT_PASSWORD');

if (!$_SESSION['customer_id']) {
  $_SESSION['navigation']->set_snapshot();
  zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

$db->Execute("set names utf8");

$action = empty($_REQUEST["action"])?"":zen_db_input($_REQUEST["action"]);
$token = empty($_REQUEST["token"])?"":zen_db_input($_REQUEST["token"]);

if ($action == 'get_order_products') {
	
	if(empty($_REQUEST["order_id"])){
		echo json_encode(array('status'=>'failure','content'=>'error1'));
		exit;
	}else{
		$orders_id = (int)$_REQUEST["order_id"];
	}
	$addr_query="select orders_date_finished,customers_name,customers_street_address,customers_city,customers_state,customers_postcode,customers_country,customers_telephone,customers_email_address 
				  from orders 
				  where orders_id=:orders_id and customers_id=:customers_id";
	$addr_query = $db->bindVars($addr_query, ":orders_id", $orders_id, "integer");
	$addr_query = $db->bindVars($addr_query, ":customers_id", $_SESSION['customer_id'], "integer");
	$addr_result = $db->Execute($addr_query);
	if(!$addr_result->EOF){
		$addr_arr=$addr_result->fields;
		
		//1各月之后不可以退货
		$max_allow_time = date("Y-m-d H:i:s",strtotime("-30 days"));
		$order_time = $addr_result->fields["orders_date_finished"];
		if($order_time>$max_allow_time){
			$allow_return = 1;
		}else{
			$allow_return = 0;
		}
		$addr_arr['allow_return']=$allow_return;
	
	}else{
		$addr_arr=array();
	}
	
	
    $products_query = "SELECT distinct op.products_id,op.products_name, p.products_image,op.products_quantity  
                       FROM   " . TABLE_ORDERS_PRODUCTS . " op inner join ".TABLE_PRODUCTS." p on op.products_id=p.products_id 
                       WHERE  orders_id = :ordersID";

    $products_query = $db->bindVars($products_query, ':ordersID', $orders_id, 'integer');
    $products = $db->Execute($products_query);
    
    $products_arr = array();
    while(!$products->EOF){
    	
    	$products_arr[] = array('products_name'=>$products->fields['products_name'],
    							 'products_id'=>$products->fields['products_id'],
    							'products_image'=>$products->fields['products_image'],
    							 'products_quantity'=>$products->fields['products_quantity']);
    	$products->MoveNext();
    }
    echo json_encode(array('status'=>'success','content'=>$products_arr,'address'=>$addr_arr));
	exit;
}  
    
    
if ($action == 'valid_orderid') {
	$orderid = zen_db_input(trim($_REQUEST["orderid"]));
	//检验订单号是否存在
	$valid_query = "select count(*) as num from orders where orders_id=:orders_id and customers_id=:customers_id";
	
	$valid_query = $db->bindVars($valid_query, ":orders_id", $orderid, "integer");
	$valid_query = $db->bindVars($valid_query, ":customers_id", $_SESSION['customer_id'], "integer");
	$valid = $db->Execute($valid_query);
	
	if($valid->fields["num"]>0){//存在
		//检验是否已经提交过申请
		$valid_query2 = "select count(*) as num from 2011refund_apply where orders_id=:orders_id and customers_id=:customers_id";
		
		$valid_query2 = $db->bindVars($valid_query2, ":orders_id", $orderid, "integer");
		$valid_query2 = $db->bindVars($valid_query2, ":customers_id", $_SESSION['customer_id'], "integer");
		$valid2 = $db->Execute($valid_query2);
		
		if($valid2->fields["num"] == 0){
			$arr = array("status"=>"success");
			echo json_encode($arr);
			exit;	
		} else {
			echo json_encode(array("status"=>"failure","content"=>HAD_APPLIED));
			exit;
		}
	

	} else {
		echo json_encode(array("status"=>"failure","content"=>NOT_FOUND_ORDER_ID));
		exit;
	}
}
if($action == 'delete' && isset($_REQUEST['apply_id'])){
	$apply_id = (int)$_REQUEST['apply_id'];
	$query = "delete from 2011refund_apply where customers_id=:customers_id and refund_apply_id=:refund_apply_id";
	$query = $db->bindVars($query, ":customers_id", $_SESSION['customer_id'], "integer");
	$query = $db->bindVars($query, ":refund_apply_id", $apply_id, "integer");
	$db->Execute($query);
	zen_redirect(zen_href_link('my_refund', 'ucenter=1', 'SSL'));
}
if ($action == 'process' && isset($_SESSION['add_token']) && $token == $_SESSION['add_token']) {
	$orders_id = empty($_REQUEST["orders_id"])?"":(int)zen_db_input($_REQUEST["orders_id"]);
	
	$product = empty($_REQUEST["product"])?"":(int)zen_db_input($_REQUEST["product"]);
	$product=join(',', $product);
	
	$return_type = empty($_REQUEST["return_type"])?"":zen_db_input($_REQUEST["return_type"]);
	$customers_name = empty($_REQUEST["customers_name"])?"":zen_db_input($_REQUEST["customers_name"]);
	$telphone = empty($_REQUEST["telphone"])?"":zen_db_input($_REQUEST["telphone"]);
	$email = empty($_REQUEST["email"])?"":zen_db_input($_REQUEST["email"]);
	$address = empty($_REQUEST["address"])?"":zen_db_input($_REQUEST["address"]);
	$apply_reason = empty($_REQUEST["apply_reason"])?"":zen_db_input($_REQUEST["apply_reason"]);
	
	
	$customers_id = $_SESSION['customer_id'];
	$refund_status_id = 1;
	$addtime = date("Y-m-d H:i:s");
	
	$refund_add_query = "insert into 2011refund_apply
		(customers_id,apply_person_name,telphone,email,address,refund_type_id,
		refund_status_id,orders_id,refund_goods_id,refund_apply_reason,refund_apply_reply,add_time)
		
		values('$customers_id','$customers_name','$telphone','$email','$address','$return_type','$refund_status_id',
		'$orders_id','$product','$apply_reason','','$addtime')
	";
	
	$db->Execute($refund_add_query);
	$token = "";
	
		//发送数据到erp
		$erp_url=getERPInterface('refund');
		$erp_url=substr($erp_url,0,strpos($erp_url, "?"));
		
		
		/**
		$complaint_erp_url=str_replace(":platname", $platname, $complaint_erp_url);
		$complaint_erp_url=str_replace(":orderid", $orders_id, $complaint_erp_url);
		$complaint_erp_url=str_replace(":type", $complaint_type, $complaint_erp_url);
		$complaint_erp_url=str_replace(":content", $content, $complaint_erp_url);
		/**/
		$erp_context=array(
		'platname'=>$web_platname,
		'orders_id'=>$orders_id,
		'product'=>$product,
		'return_type'=>$return_type,
		'customers_name'=>$customers_name,
		'telphone'=>$telphone,
		'email'=>$email,
		'address'=>$address,
		'apply_reason'=>$apply_reason
		);
		
		if(isset($_REQUEST['debug']) && $_REQUEST['debug']=='debug'){
			echo $erp_url.'?'.http_build_query($erp_context);
		}
		
		$erp_result=PostERP($erp_url,false, stream_context_create($erp_context));
		if(strpos($erp_result, "200")!==false){
			$insert_erp_error=false;
		}else{
			$insert_erp_error=true;
		}
}

$_SESSION['add_token'] = time();//不能放在insert操作的上面
/**
//所有可用的退款类型
$refund_types_query = "select * from 2011refund_types  
					   where refund_type_status=1 ";
$refund_types = $db->Execute($refund_types_query);
$refund_types_arr = array();
while(!$refund_types->EOF) {
	$refund_types_arr[] = array('refund_type_id'=>$refund_types->fields['refund_type_id'],'refund_type'=>$refund_types->fields['refund_type']);
	$refund_types->MoveNext();
}
/**/

//退换货注意提示信息
$exchange_return_tip=trim(getCustomConfig('exchange_return_tip'));
//退换货类型（退货或者返修）
$types_arr=getCustomConfig('refund_types',1);
//退换货状态（退货或者返修）
$refund_staus_arr=getCustomConfig('refund_status',1);

//所有的订单id
$orderid_query="SELECT orders_id from ".TABLE_ORDERS." where orders_status=4 and customers_id = :customersID ORDER BY   orders_id DESC";
$orderid_query = $db->bindVars($orderid_query, ':customersID', $_SESSION['customer_id'], 'integer');
$orderid_result = $db->Execute($orderid_query);
$ordersId_arr=array();
while(!$orderid_result->EOF) {
	$ordersId_arr[]=$orderid_result->fields['orders_id'];
	$orderid_result->MoveNext();
}


//用户所有的退款申请
$refund_query = "select ra.refund_apply_id,ra.orders_id,ra.add_time,ra.refund_apply_reason,ra.refund_status_id,ra.refund_apply_reply   
				from 2011refund_apply ra 
				where  customers_id=:customers_id 
				order by add_time desc";
$refund_query = $db->bindVars($refund_query, ":customers_id", $_SESSION['customer_id'], "integer");
$refund = $db->Execute($refund_query);
$refund_arr = array();

while(!$refund->EOF){
	$status_id=$refund->fields["refund_status_id"];
	if(isset($refund_staus_arr[$status_id])){
		$refund_status=$refund_staus_arr[$status_id];
	}else{
		$refund_status="";
	}
	
	//已经提交过申请的订单不能再次提交
	foreach ($ordersId_arr as $order_id_key=>$tmp_orderid){
		if($tmp_orderid==$refund->fields["orders_id"]){
			unset($ordersId_arr[$order_id_key]);
		}
	}
	
	$refund_arr[] = array(
						"orders_id"=>$refund->fields["orders_id"],
						"refund_apply_id"=>$refund->fields["refund_apply_id"],
						"add_time"=>$refund->fields["add_time"],
						"refund_apply_reason"=>$refund->fields["refund_apply_reason"],
						"refund_status"=>$refund_status,
						"refund_apply_reply"=>$refund->fields["refund_apply_reply"],
						
						 );
	$refund->MoveNext();
}


$breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2);
function PostERP($url, $post = null)
{
	$context = array();
	
	if (is_array($post))
	{
	ksort($post);
	
	$context['http'] = array
		(
		'method' => 'POST',
		'header'=>'Content-type: application/x-www-form-urlencoded',
		'content' => http_build_query($post, '', '&'),
		);
	}
	
	return file_get_contents($url, false, stream_context_create($context));
}
// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_ACCOUNT_PASSWORD');
?>