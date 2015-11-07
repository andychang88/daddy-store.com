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
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$action=empty($_REQUEST["action"])?"":$_REQUEST["action"];

if (!$_SESSION['customer_id'] && (isset($action) && $action!='getCode')) {
  $_SESSION['navigation']->set_snapshot();
  zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}
$db->Execute("set names utf8");
//邮件推荐
if( $action=="process" && $_SESSION['token']==$_REQUEST['token'] ){
	$email=$_REQUEST['email'];
	$subject=$_REQUEST['subject'];
	$content=$_REQUEST['content'];
	$status=0;
	$add_time=date('Y-m-d H:i:s');
	$customers_id=$_SESSION['customer_id'];
	
	$query="insert into 2011recommend_emails(customers_id,subject,add_time,status,recommend_email) 
	values('$customers_id','$subject','$add_time','$status','$email')";
	$db->Execute($query);
	unset($_SESSION['token']);
	//zen_mail($name, $email_address, POP_EMAIL_SUBJECT, $email_text, STORE_NAME, EMAIL_FROM, $html_msg, 'welcome');
	
	//发送邮件
	$block=array('EMAIL_MESSAGE_HTML'=>$content);
	zen_mail($subject,$email,$subject,$content,STORE_NAME,EMAIL_FROM,$block);
	
	$mail_recommend_success=true;
}
$_SESSION['token']=time();
//用户成功推荐的人
$query="select r.user_id,r.from_user_id,r.add_time,r.reward_points,c.customers_email_address   
from 2011recommend r,customers c 
where r.user_id=c.customers_id 
and from_user_id='".$_SESSION['customer_id']."' order by add_time desc";
$result=$db->Execute($query);

$rows=array();
while(!$result->EOF){
	$rows[]=array(
	'user_id'=>$result->fields['user_id'],
	'from_user_id'=>$result->fields['from_user_id'],
	'add_time'=>$result->fields['add_time'],
	'reward_points'=>$result->fields['reward_points'],
	'customers_email_address'=>$result->fields['customers_email_address'],
	);
	$result->MoveNext();
}

//推荐页面的一些配置信息
 $sql = "select id, item_key, item_value        
  from 2011recommend_config ";

  $message_result = $db->Execute($sql);
  $message_array = array();
  while(!$message_result->EOF){
  	
  	$key = $message_result->fields['item_key'];
  	$message_array[$key]=$message_result->fields['item_value'];

  	$message_result->MoveNext();
  }
  
  
if ($action == "getCode") {
  $num = empty($_GET["n"])?"1":(int)$_GET["n"];
  $type = empty($_GET["type"])?"zx":$_GET["type"];
  
  
  $display_limit = " limit $num ";
  $order_by = " order by p.products_date_added DESC, pd.products_name ";
  
  $specials_query_raw = "SELECT p.products_id, p.products_image, pd.products_name,
                          p.master_categories_id
                         FROM (" . TABLE_PRODUCTS . " p
                         LEFT JOIN " . TABLE_SPECIALS . " s on p.products_id = s.products_id
                         LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                         WHERE p.products_id = s.products_id and p.products_id = pd.products_id and p.products_status = '1'
                         AND s.status = 1
                         AND pd.language_id = :languageID " . $order_by . $display_limit;;

  
  
 $products_new_query_raw = "SELECT p.products_id, p.products_type, pd.products_name, p.products_image, p.products_price,
                                    p.products_tax_class_id, p.products_date_added, m.manufacturers_name, p.products_model,
                                    p.products_quantity, p.products_weight, p.product_is_call,
                                    p.product_is_always_free_shipping, p.products_qty_box_status,
                                    p.master_categories_id
                             FROM " . TABLE_PRODUCTS . " p
                             LEFT JOIN " . TABLE_MANUFACTURERS . " m
                             ON (p.manufacturers_id = m.manufacturers_id), " . TABLE_PRODUCTS_DESCRIPTION . " pd
                             WHERE p.products_status = 1
                             AND p.products_id = pd.products_id
                             AND pd.language_id = :languageID " . $order_by . $display_limit;

  if($type == 'zx'){
  	$query_raw = $products_new_query_raw;
  }else{
  	$query_raw = $specials_query_raw;
  }
  $query_raw = $db->bindVars($query_raw, ':languageID', $_SESSION['languages_id'], 'integer');
  $products_new_result = $db->Execute($query_raw);
  
  $products_str = "";
  while(!$products_new_result->EOF){
  	$img_url = $products_new_result->fields["products_image"];
  	$products_str .= "<img src='".HTTP_SERVER.DIR_WS_CATALOG.$img_url."' />";
  	$products_new_result->MoveNext();
  }
  
  if(!empty($products_str)){
  	if(empty($_GET['prev'])){//非预览
  		echo "document.write(\"".$products_str."\");";exit;
  	}else{//预览效果
  		$arr = array('status'=>'success','content'=>$products_str);
	  	echo json_encode($arr);
	  	exit;
  	}

  					
  }
} 
// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_ACCOUNT');
?>