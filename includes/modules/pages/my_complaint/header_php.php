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

if ($action == 'valid_orderid') {
	$orderid = zen_db_input(trim($_REQUEST["orderid"]));
	//检验订单号是否存在
	
	if(orderIsValid($orderid)){//存在
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
			echo json_encode(array("status"=>"failure","content"=>"you had submitted the applay."));
			exit;
		}
	

	} else {
		echo json_encode(array("status"=>"failure","content"=>"not found order id"));
		exit;
	}
}
if ($action == 'delete'&& isset($_REQUEST['complaint_id'])){
	$complaint_id = (int)$_REQUEST['complaint_id'];
	$query = "delete from 2011user_complaint where customers_id=:customers_id and complaint_id=:complaint_id limit 1";
	$query = $db->bindVars($query, ":customers_id", $_SESSION['customer_id'], "integer");
	$query = $db->bindVars($query, ":complaint_id", $complaint_id, "integer");
	$db->Execute($query);
	zen_redirect(zen_href_link('my_complaint', 'ucenter=1', 'SSL'));
	
}

	
if ($action == 'process' && isset($_SESSION['add_token']) && $token == $_SESSION['add_token']) {
	$orders_id = empty($_REQUEST["order_id"])?"":(int)zen_db_input($_REQUEST["order_id"]);
	
	if(orderIsValid($orders_id)){//存在
		$subject = empty($_REQUEST["subject"])?"":zen_db_input($_REQUEST["subject"]);
		$content = empty($_REQUEST["content"])?"":zen_db_input($_REQUEST["content"]);
		$complaint_type = empty($_REQUEST["type"])?"":zen_db_input($_REQUEST["type"]);
		$customers_id = $_SESSION['customer_id'];
	
		$addtime = date("Y-m-d H:i:s");
		
		$add_query = "insert into 2011user_complaint(orders_id,subject,content,complaint_type,customers_id,add_time) 
							 values('$orders_id','$subject','$content','$complaint_type','$customers_id','$addtime')";
		$db->Execute($add_query);
		$token = "";
		
		$cid = $db->insert_ID();
		
		//发送数据到erp
		$complaint_erp_url=getERPInterface('complaint');
		$complaint_erp_url_test=$complaint_erp_url;
		$complaint_erp_url=substr($complaint_erp_url,0,strpos($complaint_erp_url, "?"));
		
		
		/**
		$complaint_erp_url=str_replace(":platname", $platname, $complaint_erp_url);
		$complaint_erp_url=str_replace(":orderid", $orders_id, $complaint_erp_url);
		$complaint_erp_url=str_replace(":type", $complaint_type, $complaint_erp_url);
		$complaint_erp_url=str_replace(":content", $content, $complaint_erp_url);
		/**/
		$erp_context=array(
		'platname'=>$web_platname,
		'orderid'=>$orders_id,
		'type'=>$complaint_type,
		'content'=>$content,
		'cid'=>$cid,
		);
		if(!empty($_REQUEST['test'])){
			echo 'complaint_erp_url:'.$complaint_erp_url;print_r($erp_context);
			echo '<br>erp_result:'.$erp_result;
			echo $complaint_erp_url.'?'.http_build_query($erp_context);
		}
		
		$erp_result=PostERP($complaint_erp_url,$erp_context);
		if(strpos($erp_result, "200")!==false){
			$insert_erp_error=false;
		}else{
			$insert_erp_error=true;
		}
		
		//echo $complaint_erp_url;print_r($erp_context);echo '$erp_result:'.$erp_result;
		
	}else{
		$order_is_not_valid=true;
	}
	
}

$_SESSION['add_token'] = time();//不能放在insert操作的上面
//所有的订单id
$orderid_query="SELECT orders_id from ".TABLE_ORDERS." where customers_id = :customersID ORDER BY   orders_id DESC";
$orderid_query = $db->bindVars($orderid_query, ':customersID', $_SESSION['customer_id'], 'integer');
$orderid_result = $db->Execute($orderid_query);
$ordersId_arr=array();
while(!$orderid_result->EOF) {
	$ordersId_arr[]=$orderid_result->fields['orders_id'];
	$orderid_result->MoveNext();
}

//所有可用的投诉类型
/**
$type_query = "select * from 2011user_complaint_type  
					   where type_status=1 ";
$db->Execute('set names utf8');
$type = $db->Execute($type_query);
$type_arr = array();
while(!$type->EOF) {
	$type_arr[] = array('type_id'=>$type->fields['type_id'],'type_name'=>$type->fields['type_name']);
	$type->MoveNext();
}
/**/
$complaint_type_str=getCustomConfig('complaint_type');
$complaint_type_arr=explode(",", $complaint_type_str);
$type_arr=array();
foreach ($complaint_type_arr as $complaint_row){
	if(strpos($complaint_row, "|")!==false){
		$tmp = explode("|", $complaint_row);
		$type_arr[$tmp[0]]=$tmp[1];
	}
}
/**
$type_arr=array(
'ORD_CPT_QUAL_FLAW'=>'质量问题',
'ORD_CPT_PRICE'=>'销售价格',
'ORD_CPT_DAMAGE'=>'物流服务',
'ORD_CPT_OTHER'=>'客服质量',
'ORD_CPT_OTHER1'=>'售后',
);
/**/

//用户所有的投诉
$complaint_query = "select c.complaint_id,c.subject, c.add_time, c.orders_id ,c.complaint_type,reply_content   
				from 2011user_complaint c left join 2011user_complaint_reply r  on   r.complaint_id=c.complaint_id
				where  customers_id=:customers_id 
				
				order by c.add_time desc";
$complaint_query = $db->bindVars($complaint_query, ":customers_id", $_SESSION['customer_id'], "integer");
$complaint = $db->Execute($complaint_query);
$complaint_arr = array();
while(!$complaint->EOF){
	if(isset($type_arr[$complaint->fields["complaint_type"]])){
		$type_name=$type_arr[$complaint->fields["complaint_type"]];
	}else{
		$type_name="unknown";
	}
	$complaint_arr[] = array("subject"=>$complaint->fields["subject"],
						"orders_id"=>$complaint->fields["orders_id"],
						"add_time"=>$complaint->fields["add_time"],
						"type_name"=>$type_name,
						"reply_content"=>$complaint->fields["reply_content"],
						"complaint_id"=>$complaint->fields["complaint_id"],
						 );
	$complaint->MoveNext();
}


$breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2);

// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_ACCOUNT_PASSWORD');



function orderIsValid($orderid){
	global $db;
	
	if(!$orderid) return true;
	
	$valid_query = "select count(*) as num from orders where orders_id=:orders_id and customers_id=:customers_id";
	
	$valid_query = $db->bindVars($valid_query, ":orders_id", $orderid, "integer");
	$valid_query = $db->bindVars($valid_query, ":customers_id", $_SESSION['customer_id'], "integer");
	$valid = $db->Execute($valid_query);
	if($valid->fields["num"]>0){
		return true;
	}else{
		return false;
	}

}
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
?>