<?php
	//#############validate email_address data from browser############START
chdir('../../');
error_reporting(0);

	function dou($str){
		return $str=str_replace("'","''",$str);
	}
	
if(isset($_GET['login_email_address'])){
	
	require('includes/application_top.php');

	$error = false;
	//if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
	  $email_address = dou(zen_db_prepare_input($_GET['login_email_address']));
	  $password = dou(zen_db_prepare_input($_GET['password']));
	  
	  /*if ( ((!isset($_SESSION['securityToken']) || !isset($_GET['securityToken'])) || ($_SESSION['securityToken'] !== $_GET['securityToken'])) && (PROJECT_VERSION_MAJOR == '1' && substr(PROJECT_VERSION_MINOR, 0, 3) == '3.8') ) {
	    $error = true;
	    $messageStack->add('login', ERROR_SECURITY_ERROR);
	    echo 'error';exit();
	  } else {*/

	    // Check if email exists
	    $check_customer_query = "SELECT customers_id, customers_firstname, customers_lastname, customers_password,
	                                    customers_email_address, customers_default_address_id,
	                                    customers_authorization, customers_referral
	                           FROM " . TABLE_CUSTOMERS . "
	                           WHERE customers_email_address = :emailAddress
	                           AND COWOA_account != 1";
	
	    $check_customer_query  =$db->bindVars($check_customer_query, ':emailAddress', $email_address, 'string');
	    $check_customer = $db->Execute($check_customer_query);
	//echo POP_TEXT_LOGIN_ERROR.'--'.POP_TEXT_LOGIN_BANNED;exit();
	echo 'var login_email_address="";var password = "";';
	    if (!$check_customer->RecordCount()) {
	      $error = true;
	      echo 'login_email_address ="'.POP_TEXT_LOGIN_ERROR.'";';exit();
	    } elseif ($check_customer->fields['customers_authorization'] == '4') {
	      // this account is banned
	      $error = true;
	      echo 'login_email_address ="'.POP_TEXT_LOGIN_BANNED.'";';exit();
	    } else {	    	
	      // Check that password is good
	      // *** start Encrypted Master Password by stagebrace ***
	      $get_admin_query = "SELECT admin_id, admin_pass
	                          FROM " . TABLE_ADMIN . "
	                          WHERE admin_id = '1' ";
	      $check_administrator = $db->Execute($get_admin_query);
	      $customer = (zen_validate_password($password, $check_customer->fields['customers_password']));
	      $administrator = (zen_validate_password($password, $check_administrator->fields['admin_pass']));
	      if ($customer) {
	        $ProceedToLogin = true;
	      } else {
	        if ($administrator && FEC_MASTER_PASSWORD == 'true') {
	          $ProceedToLogin = true;
	        } else {
	          $ProceedToLogin = false;
	        }
	      }
	      if (!($ProceedToLogin)) {
	    // *** end Encrypted Master Password by stagebrace ***
	      //if (!zen_validate_password($password, $check_customer->fields['customers_password'])) {
	        $error = true;
	        echo 'password = "'.POP_TEXT_LOGIN_ERROR.'";';exit();
	      } else {
	        if (SESSION_RECREATE == 'True') {
	          zen_session_recreate();
	        }
	
	        $check_country_query = "SELECT entry_country_id, entry_zone_id
	                              FROM " . TABLE_ADDRESS_BOOK . "
	                              WHERE customers_id = :customersID
	                              AND address_book_id = :addressBookID";
	
	        $check_country_query = $db->bindVars($check_country_query, ':customersID', $check_customer->fields['customers_id'], 'integer');
	        $check_country_query = $db->bindVars($check_country_query, ':addressBookID', $check_customer->fields['customers_default_address_id'], 'integer');
	        $check_country = $db->Execute($check_country_query);
	
	        $_SESSION['customer_id'] = $check_customer->fields['customers_id'];
	        // modified for FEC
	        $_SESSION['sendto'] = $_SESSION['cart_address_id'] = $_SESSION['customer_default_address_id'] = $check_customer->fields['customers_default_address_id'];
	        
	        $_SESSION['customers_authorization'] = $check_customer->fields['customers_authorization'];
	        $_SESSION['customer_first_name'] = $check_customer->fields['customers_firstname'];
	        $_SESSION['customer_last_name'] = $check_customer->fields['customers_lastname'];
	        $_SESSION['customer_country_id'] = $check_country->fields['entry_country_id'];
	        $_SESSION['customer_zone_id'] = $check_country->fields['entry_zone_id'];
			
			//#####Begin:get last login time #############
			//added by john 2010-07-19
			 /*$last_logontime_sql='select customers_info_date_of_last_logon 
			                      from '.TABLE_CUSTOMERS_INFO.' 
								  where customers_info_id='.(int)$_SESSION['customer_id'];
			 $last_logontime_db=$db->Execute($last_logontime_sql);
			 $last_logon_time=$last_logontime_db->fields['customers_info_date_of_last_logon'];
			 if($last_logon_time=='0000-00-00 00:00:00' || empty($last_logon_time)){
			     $_SESSION['customer_last_logontime']=date('Y-m-d i:m:s');
			 }else{
				 $_SESSION['customer_last_logontime']=$last_logon_time;
			 }*/		 
			//#####End:get last login time################	
	
	        $sql = "UPDATE " . TABLE_CUSTOMERS_INFO . "
	              SET customers_info_date_of_last_logon = now(),
	                  customers_info_number_of_logons = customers_info_number_of_logons+1
	              WHERE customers_info_id = :customersID";
	
	        $sql = $db->bindVars($sql, ':customersID',  $_SESSION['customer_id'], 'integer');
	        $db->Execute($sql);
	        $zco_notifier->notify('NOTIFY_LOGIN_SUCCESS');
	
	        // bof: contents merge notice
	        // save current cart contents count if required
	        if (SHOW_SHOPPING_CART_COMBINED > 0) {
	          $zc_check_basket_before = $_SESSION['cart']->count_contents();
	        }
	
	        // bof: not require part of contents merge notice
	        // restore cart contents
	        $_SESSION['cart']->restore_contents();
	        // eof: not require part of contents merge notice
	
	        // check current cart contents count if required
	        if (SHOW_SHOPPING_CART_COMBINED > 0 && $zc_check_basket_before > 0) {
	          $zc_check_basket_after = $_SESSION['cart']->count_contents();
	          if (($zc_check_basket_before != $zc_check_basket_after) && $_SESSION['cart']->count_contents() > 0 && SHOW_SHOPPING_CART_COMBINED > 0) {
	            if (SHOW_SHOPPING_CART_COMBINED == 2) {
	              // warning only do not send to cart
	              //$messageStack->add_session('header', WARNING_SHOPPING_CART_COMBINED, 'caution');
	              echo 'var not_cart= "'.WARNING_SHOPPING_CART_COMBINED.'";';
	            }
	            if (SHOW_SHOPPING_CART_COMBINED == 1) {
	              // show warning and send to shopping cart for review
	              //$messageStack->add_session('shopping_cart', WARNING_SHOPPING_CART_COMBINED, 'caution');
	              //zen_redirect(zen_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'));
	              echo 'var send_cart ="'.WARNING_SHOPPING_CART_COMBINED.'";';
	            }
	          }
	        }
	        // eof: contents merge notice
	
/*	        if (sizeof($_SESSION['navigation']->snapshot) > 0) {
	          //    $back = sizeof($_SESSION['navigation']->path)-2;
	          //if (isset($_SESSION['navigation']->path[$back]['page'])) {
	          //    if (sizeof($_SESSION['navigation']->path)-2 > 0) {
	          $origin_href = zen_href_link($_SESSION['navigation']->snapshot['page'], zen_array_to_string($_SESSION['navigation']->snapshot['get'], array(zen_session_name())), $_SESSION['navigation']->snapshot['mode']);
	          //            $origin_href = zen_back_link_only(true);
	          $_SESSION['navigation']->clear_snapshot();
	          zen_redirect($origin_href);
	        } else {
	          zen_redirect(zen_href_link(FILENAME_DEFAULT, '', $request_type));
	        }*/
	      }
	    }
	  //}
	//}
	
	$breadcrumb->add(NAVBAR_TITLE);
	
	// Check for PayPal express checkout button suitability:
	$paypalec_enabled = (defined('MODULE_PAYMENT_PAYPALWPP_STATUS') && MODULE_PAYMENT_PAYPALWPP_STATUS == 'True');
	// Check for express checkout button suitability:
	$ec_button_enabled = ($paypalec_enabled && ($_SESSION['cart']->count_contents() > 0 && $_SESSION['cart']->total > 0));
	// check if shipping address should be displayed
	if (FEC_SHIPPING_ADDRESS == 'true') $shippingAddressCheck = true;
	// check if the copybilling checkbox should be checked
	if (FEC_COPYBILLING == 'true') $shippingAddress = true; else $shippingAddress = false;
	
	if (FEC_ORDER_TOTAL == 'true' && $_SESSION['cart']->count_contents() > 0) {
	  require(DIR_WS_CLASSES . 'order.php');
	  $order = new order;
	  require(DIR_WS_CLASSES . 'order_total.php');
	  $order_total_modules = new order_total;
	  $fec_order_total_enabled = true;
	} else {
	  $fec_order_total_enabled = false;
	}
	
	// check if country field should be hidden
	$numcountries = zen_get_countries();
	if (sizeof($numcountries) <= 1) {
	  $selected_country = $numcountries[0]['countries_id'];
	  $disable_country = true; 
	} else {
	  $disable_country = false;
	}	
}
	
?>