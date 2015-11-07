<?php
/**
 * product_info header_php.php 
 *
 * @package page
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 6963 2007-09-08 02:36:34Z drbyte $
 */

  // This should be first line of the script:
  $zco_notifier->notify('NOTIFY_HEADER_START_PRODUCT_INFO');

  require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

  // if specified product_id is disabled or doesn't exist, ensure that metatags and breadcrumbs don't share inappropriate information
   $sql = "select count(*) as total
          from " . TABLE_PRODUCTS . " p, " .
                   TABLE_PRODUCTS_DESCRIPTION . " pd
          where    p.products_status = '1'
          and      p.products_id = '" . (int)$_GET['products_id'] . "'
          and      pd.products_id = p.products_id
          and      pd.language_id = '" . (int)$_SESSION['languages_id'] . "'";
  $res = $db->Execute($sql);
  if ( $res->fields['total'] < 1 ) {
    unset($_GET['products_id']);
    unset($breadcrumb->_trail[sizeof($breadcrumb->_trail)-1]['title']);
    header('HTTP/1.1 404 Not Found');
  }

  // ensure navigation snapshot in case must-be-logged-in-for-price is enabled
  if (!$_SESSION['customer_id']) {
    $_SESSION['navigation']->set_snapshot();
  }
  //&&&&&&&&&&&&&&&&&&&&&BOF:for recent viewed products only&&&&&&&&&&&&&&&&&&&
  if(zen_not_null($_GET['products_id']) && is_numeric($_GET['products_id']) &&!in_array($_GET['products_id'],$_SESSION['recent_products1'])) {
		$product_id1 = $_GET['products_id']; 
		$_SESSION['recent_products1'][] = $product_id1;
		//setcookie('pid_history',serialize($_SESSION['recent_products1']),time()+2592000,'/', (zen_not_null($current_domain) ? $current_domain : ''));
		
		/*foreach($_SESSION['recent_products1'] as $rpc_id){
		  setcookie("pid_history[$rpc_id]",$rpc_id,time()+2592000,'/', (zen_not_null($current_domain) ? $current_domain : ''));
		}*/
		
		$all_pid_history=implode(',',$_SESSION['recent_products1']);
		setcookie("pid_history_str",$all_pid_history,time()+2592000,'/', (zen_not_null($current_domain) ? $current_domain : ''));
		
   }
   //&&&&&&&&&&&&&&&&&&&&&EOF:for recent viewed products only&&&&&&&&&&&&&&&&&&&
  // This should be last line of the script:
  $zco_notifier->notify('NOTIFY_HEADER_END_PRODUCT_INFO');
?>