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

$template_query = "select c.coupon_id, c.coupon_code, c.coupon_amount, c.coupon_minimum_order, c.coupon_start_date, c.coupon_expire_date, c.coupon_active 
						  from coupons c 
						  inner join orders o  
						  where  c.coupon_start_date <='".$curdate."' 
						  and c.coupon_expire_date > '".$curdate."' 
						  and c.coupon_active='Y' ";



$not_used_query = "select c.uses_per_user,c.uses_per_coupon,IFNULL(o.orders_id,0) AS orders_id,o.date_purchased,c.coupon_id, c.coupon_code, c.coupon_amount, c.coupon_minimum_order, c.coupon_start_date, c.coupon_expire_date, c.coupon_active 
						  from coupons c 
						  left join orders o on  c.coupon_code != o.coupon_code
						  where  c.coupon_start_date <='".$curdate."' 
						  and o.customers_id=:customers_id 
						  and c.coupon_expire_date > '".$curdate."' 
						  and c.coupon_active='Y' ";


$used_query = "select c.uses_per_user,c.uses_per_coupon,IFNULL(o.orders_id,0) AS orders_id,o.date_purchased,c.coupon_id, c.coupon_code, c.coupon_amount, c.coupon_minimum_order, c.coupon_start_date, c.coupon_expire_date, c.coupon_active 
						  from coupons c 
						  inner join orders o on  c.coupon_code = o.coupon_code
						  where  c.coupon_start_date <='".$curdate."' 
						  and o.customers_id=:customers_id 
						  and c.coupon_expire_date > '".$curdate."' 
						  and c.coupon_active='Y' ";

$coupon_query = array('not_used'=>$not_used_query,'used_query'=>$used_query);//sql

$coupons = array();//包括使用的和未使用的
$split_arr=array();

foreach($coupon_query as $key=>$query){
    $query = $db->bindVars($query, ':customers_id',$_SESSION['customer_id'], 'integer');
    
    $page_split = new splitPageResults($query, 10,'*','page_'.$key);
	$split_arr[$key]=$page_split;
	
    $coupon_result = $db->Execute($page_split->sql_query);
    $coupon_arr = array();
    while(!$coupon_result->EOF){
    	if($curdate > $coupon_result->fields['coupon_expire_date']){
    		$expired=1;
    	}else{
    		$expired=0;
    	}
    	$coupon_code= $coupon_result->fields['coupon_code'];
    	$uses_per_user = $coupon_result->fields['uses_per_user'];
    	$uses_per_coupon = $coupon_result->fields['uses_per_coupon'];
    	if($uses_per_user==0){
    		$uses_per_user = NO_LIMIT_USE;
    	}
   		if($uses_per_coupon==0){
    		$uses_per_coupon=NO_LIMIT_USE;
    	}
    	
    	$used_times_by_me = getUsedTimesByme($coupon_code);
    	$used_times_total = getUsedTimesTotal($coupon_code);
    	
    	$coupon_arr[]=array(
    								'coupon_id'=>$coupon_result->fields['coupon_id'],
    								'coupon_code'=>$coupon_result->fields['coupon_code'],
    								'coupon_amount'=>$coupon_result->fields['coupon_amount'],
    								'coupon_minimum_order'=>$coupon_result->fields['coupon_minimum_order'],
    								'coupon_start_date'=>$coupon_result->fields['coupon_start_date'],
    								'coupon_expire_date'=>$coupon_result->fields['coupon_expire_date'],
    								'expired'=>$expired,
    								'orders_id'=>$coupon_result->fields['orders_id'],
    								'date_purchased'=>$coupon_result->fields['date_purchased'],
    								'uses_per_user'=>$uses_per_user,
    								'uses_per_coupon'=>$uses_per_coupon,
    								'used_times_by_me'=>$used_times_by_me,
    								'used_times_total'=>$used_times_total
    								
    							);
    							
    	$coupon_result->MoveNext();
    }
    
    $coupons[$key] = $coupon_arr;

}

$breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2);

// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_ACCOUNT_PASSWORD');

function getUsedTimesByme($coupon_code){
	global $db;
	$query = "select count(*) as total from orders where coupon_code=:coupon_code and customers_id=:customers_id";
	$query = $db->bindVars($query, ':customers_id',$_SESSION['customer_id'], 'integer');
	$query = $db->bindVars($query, ':coupon_code',$coupon_code, 'integer');
	$result = $db->Execute($query);
	return $result->fields['total'];
	
}
function getUsedTimesTotal($coupon_code){
	global $db;
	$query = "select count(*) as total from orders where coupon_code=:coupon_code ";
	$query = $db->bindVars($query, ':coupon_code',$coupon_code, 'integer');
	$result = $db->Execute($query);
	return $result->fields['total'];
	
}
?>