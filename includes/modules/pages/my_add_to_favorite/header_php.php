<?php
/**
 * reviews Write
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 4274 2006-08-26 03:16:53Z drbyte $
 */
/**
 * Header code file for product reviews "write" page
 *
 */

// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_PRODUCT_REVIEWS_WRITE');
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

if (!$_SESSION['customer_id']) {
  die(json_encode(array('status'=>'need_login','content'=>NEED_LOGIN)));
}


//added by changanti begin

if(isset($_GET['p'])){
	$_GET['cPath'] = $_GET['p'];
}
$cPath = $_GET["cPath"];

if(isset($_GET['pid'])){
	$_GET['products_id'] = $_GET['pid'];
}
  if(strpos($cPath,"_") !== false){ 
  	$cPath = substr(strrchr($cPath,"_"),1); 
  }

$favorite_good_query = "SELECT count(*) AS total FROM 2011favorite_goods  
						WHERE customers_id = :customers_id 
						AND products_id = :products_id 
						AND language_id = :language_id 
						AND categories_id = :categories_id";

$favorite_good_query = $db->bindVars($favorite_good_query, ':customers_id', $_SESSION['customer_id'], 'integer');
$favorite_good_query = $db->bindVars($favorite_good_query, ':products_id', $_GET['products_id'], 'integer');
$favorite_good_query = $db->bindVars($favorite_good_query, ':categories_id', $cPath, 'integer');
$favorite_good_query = $db->bindVars($favorite_good_query, ':language_id', $_SESSION['languages_id'], 'integer');

$favorite_info = $db->Execute($favorite_good_query);

if ($favorite_info->fields['total'] == 0) {
  $time = date("Y-m-d H:i:s");

  $favorite_good_insert = "insert into 2011favorite_goods 
  							(products_id, customers_id, categories_id,language_id, add_time) 
  							values('" . $_GET['products_id'] . "',
  							'" . $_SESSION['customer_id'] . "',
  							'" . $cPath . "',
  							'" . $_SESSION['languages_id'] . "',
  							'".$time."')";
  $db->Execute($favorite_good_insert);
    die(json_encode(array('status'=>'success','content'=>ADD_TO_SUCCESS)));
} else {
	die(json_encode(array('status'=>'failure','content'=>ADD_TO_REPEATED)));
}
die(json_encode(array('status'=>'failure','content'=>UNKOWN_ERROR)));
//added by changanti end




// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_PRODUCT_REVIEWS_WRITE');
?>