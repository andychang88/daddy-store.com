<?php
/**
 * Header code file for the Address Book page
 *
 * @package page
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 2944 2006-02-02 17:13:18Z wilt $
 */
// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_ADDRESS_BOOK');

if (!$_SESSION['customer_id']) {
  $_SESSION['navigation']->set_snapshot();
  zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2);


$action = $_REQUEST['action'];
if(isset($action) && $action=='changePrimary' && isset($_REQUEST['edit'])){
	$edit_id = (int)$_REQUEST['edit'];
	$sql = "select * from ".TABLE_ADDRESS_BOOK." where address_book_id = :edit and customers_id = :customersID";
	$sql = $db->bindVars($sql, ':customersID', $_SESSION['customer_id'], 'integer');
    $sql = $db->bindVars($sql, ':edit', $edit_id, 'integer');
    $result = $db->Execute($sql);
    
    if($result->RecordCount()>0){
    	$entry_firstname=$result->fields['entry_firstname'];
    	$entry_lastname=$result->fields['entry_lastname'];
    	$entry_gender=$result->fields['entry_gender'];
    	$entry_country_id=$result->fields['entry_country_id'];
    	$entry_zone_id=$result->fields['entry_zone_id'];
    	
    	$_SESSION['customer_first_name'] = $entry_firstname;
        $_SESSION['customer_country_id'] = $entry_country_id;
        $_SESSION['customer_zone_id'] = (($entry_zone_id > 0) ? (int)$entry_zone_id : '0');
        //if (isset($_POST['primary']) && ($_POST['primary'] == 'on')) 
        $_SESSION['customer_default_address_id'] = $edit_id;

        $sql_data_array = array(array('fieldName'=>'customers_firstname', 'value'=>$entry_firstname, 'type'=>'string'),
                                array('fieldName'=>'customers_lastname', 'value'=>$entry_lastname, 'type'=>'string'),
                                array('fieldName'=>'customers_gender', 'value'=>$entry_gender, 'type'=>'string'),
                                array('fieldName'=>'customers_default_address_id', 'value'=>$edit_id, 'type'=>'integer'));

        //if (ACCOUNT_GENDER == 'true') $sql_data_array[] = array('fieldName'=>'customers_gender', 'value'=>$gender, 'type'=>'string');
        //if (isset($_POST['primary']) && ($_POST['primary'] == 'on')) 
        //$sql_data_array[] = array('fieldName'=>'customers_default_address_id', 'value'=>$new_address_book_id, 'type'=>'integer');

        $where_clause = "customers_id = :customersID";
        $where_clause = $db->bindVars($where_clause, ':customersID', $_SESSION['customer_id'], 'integer');
        $db->perform(TABLE_CUSTOMERS, $sql_data_array, 'update', $where_clause);
    }
    
}
//个人信息

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
 
  	
  	
//地址薄列表
$addresses_query = "SELECT address_book_id, entry_firstname as firstname, entry_lastname as lastname,
                           entry_company as company, entry_street_address as street_address,
                           entry_suburb as suburb, entry_city as city, entry_postcode as postcode,
                           entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id, 
                           telphone, email 
                    FROM   " . TABLE_ADDRESS_BOOK . "
                    WHERE  customers_id = :customersID
                    ORDER BY firstname, lastname";

$addresses_query = $db->bindVars($addresses_query, ':customersID', $_SESSION['customer_id'], 'integer');
$addresses = $db->Execute($addresses_query);

while (!$addresses->EOF) {
  $format_id = zen_get_address_format_id($addresses->fields['country_id']);
  
  if($_SESSION['customer_default_address_id'] == $addresses->fields['address_book_id']){
  	$is_customer_default_address_id = 1;
  }else{
  	$is_customer_default_address_id = 0;
  }
  
  $addressArray[] = array('firstname'=>$addresses->fields['firstname'],
  'lastname'=>$addresses->fields['lastname'],
  'address_book_id'=>$addresses->fields['address_book_id'],
  'format_id'=>$format_id,
  'is_customer_default_address_id'=>$is_customer_default_address_id,
  'address'=>$addresses->fields);



  $addresses->MoveNext();
}
//echo "<pre>";print_r($addressArray);
// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_ADDRESS_BOOK');
?>