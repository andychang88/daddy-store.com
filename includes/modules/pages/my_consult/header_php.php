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


if ($action == 'process' && isset($_SESSION['add_token']) && $token == $_SESSION['add_token']) {
	
	$subject = empty($_REQUEST["subject"])?"":zen_db_input($_REQUEST["subject"]);
	$content = empty($_REQUEST["content"])?"":zen_db_input($_REQUEST["content"]);
	
	$customers_id = $_SESSION['customer_id'];

	$addtime = date("Y-m-d H:i:s");
	
	$add_query = "insert into 2011user_consult(subject,content,customers_id,add_time) 
						 values('$subject','$content','$customers_id','$addtime')";
	$db->Execute($add_query);
	$token = "";
}

$_SESSION['add_token'] = time();//不能放在insert操作的上面



//用户所有的咨询
$query = "select consult_id,customers_id, status, subject, add_time, content, reply_content   
				from 2011user_consult   
				where customers_id=:customers_id 
				 ";
$query = $db->bindVars($query, ":customers_id", $_SESSION['customer_id'], "integer");

//$page_split = new splitPageResults($query, 10,'*','page');
//$query=$page_split->sql_query;

$complaint = $db->Execute($query);
$complaint_arr = array();
while(!$complaint->EOF){
	$complaint_arr[] = array("subject"=>$complaint->fields["subject"],
						"consult_id"=>$complaint->fields["consult_id"],
						"add_time"=>$complaint->fields["add_time"],
	"status"=>$complaint->fields["status"],
	"reply_content"=>$complaint->fields["reply_content"],
						"content"=>$complaint->fields["content"]
						 );
	$complaint->MoveNext();
}


$breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2);

// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_ACCOUNT_PASSWORD');
?>