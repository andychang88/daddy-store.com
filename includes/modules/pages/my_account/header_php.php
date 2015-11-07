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

$curdate = date("Y-m-d H:i:s");

$select=" select a.customers_id,c.customers_email_address, c.customers_firstname, c.customers_lastname, c.customers_telephone, a.entry_street_address, a.telphone, a.entry_postcode ";
$from=" from customers c ";
if(defined('REWARD_POINT_MODE')){
	$select.=" , IFNULL(r.reward_points,0) AS reward_points ";
	$from.=" left join reward_customer_points r on c.customers_id=r.customers_id  ";
}else{
	$select.=" , 0 AS reward_points ";
}
$from.=" left join  address_book a on a.customers_id=c.customers_id  ";
$where=" where   c.customers_id=:customers_id ";

$query = $select.$from.$where;
/**
$query = "select IFNULL(r.reward_points,0) AS reward_points , a.customers_id,c.customers_email_address, c.customers_firstname, c.customers_lastname, c.customers_telephone, a.entry_street_address, a.telphone, a.entry_postcode  
			from customers c left join reward_customer_points r on c.customers_id=r.customers_id 
			left join  address_book a on a.customers_id=c.customers_id 
			where   c.customers_id=:customers_id 
			";
			/**/
  $query = $db->bindVars($query, ':customers_id',$_SESSION['customer_id'], 'integer');
  $result= $db->Execute($query);

  
  if(empty($result->fields['reward_points'])){
  	$reward_points=0;
  }else{
  	$reward_points=round($result->fields['reward_points'],2);
  }
  
  	$customers_arr = array(
  	'customers_email_address'=>$result->fields['customers_email_address'],
  	'customers_telephone'=>$result->fields['customers_telephone'],
  	'entry_street_address'=>$result->fields['entry_street_address'],
  	'telphone'=>$result->fields['telphone'],
  	'entry_postcode'=>$result->fields['entry_postcode'],
  	'reward_points'=>$reward_points,
  	);
  
  
$breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2);

// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_ACCOUNT_PASSWORD');


?>