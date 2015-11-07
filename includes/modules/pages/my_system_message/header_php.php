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


$action = empty($_REQUEST["action"])?"":zen_db_input($_REQUEST["action"]);
$token = empty($_REQUEST["token"])?"":zen_db_input($_REQUEST["token"]);

if($action == 'add_history'){
	$add_time = date("Y-m-d H:i:s");
	$message_id = $_REQUEST["message_id"];
	
	$query = "select count(*) as num from 2011system_message where message_id='".$message_id."'";
	$total_result = $db->Execute($query);
	$total_num = $total_result->fields['num'];
	if($total_result->fields['num']>0){
		$query = "replace into 2011system_message_history(message_id,customers_id,add_time)values('$message_id','".$_SESSION['customer_id']."','$add_time')";
		$db->Execute($query);
		die(json_encode(array('status'=>'success','content'=>'')));
	}
	die(json_encode(array('status'=>'error','content'=>'not found')));
}
//已经阅读的系统消息数目
$query = "select count(*) as num from 2011system_message_history where customers_id = '". $_SESSION['customer_id']."'";
$readed_result = $db->Execute($query);
$readed_num = $readed_result->fields['num'];

//共有的系统消息数目
$query = "select count(*) as num from 2011system_message ";
$total_result = $db->Execute($query);
$total_num = $total_result->fields['num'];

//没有阅读的数目
$unread_message_num=$total_num - $readed_num;


//所有的系统消息
$query = "select * from 2011system_message  
					   order by add_time desc ";

$page_split = new splitPageResults($query, 10,'*','page');
$query=$page_split->sql_query;


$result = $db->Execute($query);
$result_arr = array();
while(!$result->EOF) {
	$is_readed = checkIsReaded($result->fields['message_id']);
	
	$result_arr[] = array('message_id'=>$result->fields['message_id'],
						  'subject'=>$result->fields['subject'],
						  'content'=>$result->fields['content'],
						  'is_readed'=>$is_readed,
						  'add_time'=>$result->fields['add_time']
	
	);
	$result->MoveNext();
}

function checkIsReaded($message_id){
	global $db;
	$query = "select count(*) as num from 2011system_message_history where customers_id = '". $_SESSION['customer_id']."' 
	and message_id='".$message_id."'";
	$readed_result = $db->Execute($query);
	
	if($readed_result->fields['num']==0){
		return false;
	}else{
		return true;
	}
	
}

$breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2);

// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_ACCOUNT_PASSWORD');
?>