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
$review_id = (int)$_REQUEST['review_id'];

//修改评论
if($action == 'edit' && $review_id){
  $query = "select r.reviews_id,rd.reviews_text, r.date_added, r.reviews_read ,pd.products_name,p.products_id,p.products_image  
		  from reviews r, reviews_description rd , products p 
		  where r.reviews_id=:reviews_id
		  and customers_id = :customers_id 
		  and rd.languages_id=:languages_id 
		  and rd.reviews_id=r.reviews_id 
		  and r.products_id = p.products_id 
		  and r.status=1";
  $query = $db->bindVars($query, ':reviews_id', $review_id, 'integer');
  $query = $db->bindVars($query, ':customers_id', $_SESSION['customer_id'], 'integer');
  $query = $db->bindVars($query, ':languages_id', $_SESSION['languages_id'], 'integer');
  
  $result=$db->Execute($delete_query);
  $review_arr=array();
  if(!$result->EOF){
  	$review_arr['products_id']=$result->fields['products_id'];
  	$review_arr['products_name']=$result->fields['products_name'];
  	$review_arr['products_image']=$result->fields['products_image'];
  	$review_arr['reviews_id']=$result->fields['reviews_id'];
  	$review_arr['reviews_description']=$result->fields['reviews_description'];
  }
}
//处理修改评论
if($action == 'process' && $review_id ){
	$token=$_REQUEST['token'];
	if(isset($_SESSION['token']) && $_SESSION['token']==$token){
		$content=$_REQUEST['content'];
		$query="select reviews_id from reviews where 
		reviews_id=:reviews_id 
		and customers_id=:customers_id";
		
		$query = $db->bindVars($query, ':reviews_id', $review_id, 'integer');
		$query = $db->bindVars($query, ':customers_id', $_SESSION['customer_id'], 'integer');
	    $result=$db->Execute($query);
		if(!$result->EOF){ 
			$query = "update reviews_description set reviews_text='".$content."' where 
			rd.languages_id=:languages_id 
			and reviews_id=:reviews_id 
			";
			$query = $db->bindVars($query, ':reviews_id', $review_id, 'integer');
	  		$query = $db->bindVars($query, ':languages_id', $_SESSION['languages_id'], 'integer');
	  		$db->Execute($query);
		}
	}
}
$_SESSION['token']=time();

//删除评论
if($action == 'delete' && $review_id){

	$query = "select reviews_id from reviews 
				where reviews_id=:reviews_id 
				and customers_id = :customers_id ";
	
  $query = $db->bindVars($query, ':customers_id', $_SESSION['customer_id'], 'integer');
  $query = $db->bindVars($query, ':reviews_id', $review_id, 'integer');
  
  $count_result=$db->Execute($query);
  
  if($count_result->RecordCount()>0){
  	//删除评论内容
  	$delete_desp_query = "delete from reviews_description where reviews_id=:reviews_id ";
  	$query = $db->bindVars($query, ':reviews_id', $review_id, 'integer');
  	$db->Execute($query);
  }
  //删除评论主id
  $delete_query = "delete from reviews 
  					where reviews_id=:reviews_id 
  					and customers_id = :customers_id ";
  
  $delete_query = $db->bindVars($delete_query, ':customers_id', $_SESSION['customer_id'], 'integer');
  $delete_query = $db->bindVars($delete_query, ':reviews_id', $review_id, 'integer');
  
  $db->Execute($delete_query);
  
}
///所有评论
$query = "select r.reviews_id,rd.reviews_text, r.date_added, r.reviews_read ,pd.products_name,p.products_id,p.products_image  
		  from reviews r, reviews_description rd , products p, products_description pd 
		  where customers_id = :customers_id 
		  and rd.languages_id=:languages_id 
		  and rd.reviews_id=r.reviews_id 
		  
		  and r.products_id = p.products_id 
		  and p.products_id = pd.products_id 
		  and pd.language_id=rd.languages_id 
		  
		  and r.status=1";
  $query = $db->bindVars($query, ':customers_id', $_SESSION['customer_id'], 'integer');
  $query = $db->bindVars($query, ':languages_id', $_SESSION['languages_id'], 'integer');
  
  $page_split = new splitPageResults($query, 20,'*','page');
 
  $query= $page_split->sql_query;
    
  $result = $db->Execute($query);
  $reviews_arr = array();
  while(!$result->EOF){
  	$reviews_arr[]=array(
  	'reviews_id'=>$result->fields['reviews_id'],
  	'reviews_text'=>$result->fields['reviews_text'],
  	'date_added'=>$result->fields['date_added'],
  	'reviews_read'=>$result->fields['reviews_read'],
  	'products_id'=>$result->fields['products_id'],
  	'products_name'=>$result->fields['products_name'],
  	'products_image'=>$result->fields['products_image']);
  	
  	$result->MoveNext();
  }
 
//echo "<pre>";print_r($accountHistory);
// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_ACCOUNT_HISTORY');
?>