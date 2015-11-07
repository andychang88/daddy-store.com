<?php
   /**
	 * Header code file for the newsletter subscribe page
	 *
	 * @package page
	 * @copyright Copyright 2003-2006 Zen Cart Development Team
	 * @copyright Portions Copyright 2003 osCommerce
	 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
	 * @version $Id: header_php.php 4824 2010-04-08 21:01:28Z john $
	 */
	// This should be first line of the script:
  $zco_notifier->notify('NOTIFY_HEADER_START_NEWSLETTER');
	
  require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
  $breadcrumb->add(NAVBAR_TITLE);
  
  if (isset ($_GET['action']) && ($_GET['action'] == 'process')) {
	$vlcode = zen_random_charcode(32);
	$link = zen_href_link(FILENAME_NEWSLETTERS, 'action=activate&email='.zen_db_input($_POST['email']).'&key='.$vlcode, 'NONSSL');
    $email=zen_db_input($_POST['email']);

	// assign language to template for caching
	$smarty->assign('language', $_SESSION['language']);
	$smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
	$smarty->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');

	// assign vars
	$smarty->assign('EMAIL', zen_db_input($_POST['email']));
	$smarty->assign('LINK', $link);
	// dont allow cache
	$smarty->caching = false;

	// create mails
	$html_mail = $smarty->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/newsletter_mail.html');
	$txt_mail = $smarty->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/newsletter_mail.txt');

	// Check if email exists 

	if (($_POST['check'] == 'inp') && ($_POST['vvcode'] == $_SESSION['vvcode'])) {
		$check_mail_query = $db->Execute("select customers_email_address, mail_status 
		                                  from ".TABLE_NEWSLETTER_RECIPIENTS." 
										  where customers_email_address = '".zen_db_input($_POST['email'])."'");
		if (!$check_mail_query->RecordCount()) {

			if (isset ($_SESSION['customer_id'])) {
				$customers_id = $_SESSION['customer_id'];
				$customers_status = $_SESSION['customers_status']['customers_status_id'];
				$customers_firstname = $_SESSION['customer_first_name'];
				$customers_lastname = $_SESSION['customer_last_name'];
			} else {

				$check_customer_mail_query = $db->Execute("select customers_id, customers_status, 
				                                                  customers_firstname, customers_lastname,
																  customers_email_address 
														   from ".TABLE_CUSTOMERS." 
														   where customers_email_address = '".zen_db_input($_POST['email'])."'");
				if (!$check_customer_mail_query->RecordCount()) {
					$customers_id = '0';
					$customers_status = '1';
					$customers_firstname = TEXT_CUSTOMER_GUEST;
					$customers_lastname = '';
				} else {
					//$check_customer = xtc_db_fetch_array($check_customer_mail_query);
					$customers_id = $check_customer_mail_query->fields['customers_id'];
					$customers_status = $check_customer_mail_query->fields['customers_status'];
					$customers_firstname = $check_customer_mail_query->fields['customers_firstname'];
					$customers_lastname = $check_customer_mail_query->fields['customers_lastname'];
				}

			}

			$sql_data_array = array ('customers_email_address' => zen_db_input($_POST['email']), 
			                         'customers_id' => zen_db_input($customers_id), 
									 'customers_status' => zen_db_input($customers_status), 
									 'customers_firstname' => zen_db_input($customers_firstname), 
									 'customers_lastname' => zen_db_input($customers_lastname), 
									 'mail_status' => '0',
									 'mail_key' => zen_db_input($vlcode), 
									 'date_added' => 'now()');
			zen_db_perform(TABLE_NEWSLETTER_RECIPIENTS, $sql_data_array);

			$info_message = TEXT_EMAIL_INPUT;

			if (SEND_EMAILS == true) {
				//xtc_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, zen_db_input($_POST['email']), '', '', EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', TEXT_EMAIL_SUBJECT, $html_mail, $txt_mail);
			    zen_mail($customers_firstname,zen_db_input($_POST['email']),TEXT_EMAIL_SUBJECT,$html_mail,STORE_NAME, EMAIL_FROM);
			}

		} else {
			//$check_mail = xtc_db_fetch_array($check_mail_query);

			if ($check_mail_query->fields['mail_status'] == '0') {

				$info_message = TEXT_EMAIL_EXIST_NO_NEWSLETTER;

				if (SEND_EMAILS == true) {
					//xtc_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, zen_db_input($_POST['email']), '', '', EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', TEXT_EMAIL_SUBJECT, $html_mail, $txt_mail);
				}

			} else {
				$info_message = TEXT_EMAIL_EXIST_NEWSLETTER;
			}

		}

	} else {
		$info_message = TEXT_WRONG_CODE;
	}

	if (($_POST['check'] == 'del') && ($_POST['vvcode'] == $_SESSION['vvcode'])) {

		$check_mail_query = $db->Execute("select customers_email_address 
		                                  from ".TABLE_NEWSLETTER_RECIPIENTS." 
										  where customers_email_address = '".zen_db_input($_POST['email'])."'");
		if (!$check_mail_query->RecordCount()) {
			$info_message = TEXT_EMAIL_NOT_EXIST;
		} else {
			$del_query = $db->Execute("delete from ".TABLE_NEWSLETTER_RECIPIENTS." 
			                           where customers_email_address ='".zen_db_input($_POST['email'])."'");
			$info_message = TEXT_EMAIL_DEL;
		}
	}
 }

  // Accountaktivierung per Emaillink
  if (isset ($_GET['action']) && ($_GET['action'] == 'activate')) {
		$check_mail_query = $db->Execute("select mail_key from ".TABLE_NEWSLETTER_RECIPIENTS." 
		                                  where customers_email_address = '".zen_db_input($_GET['email'])."'");
		if (!$check_mail_query->RecordCount()) {
			$info_message = TEXT_EMAIL_NOT_EXIST;
		} else {
			//$check_mail = xtc_db_fetch_array($check_mail_query);
			if ($check_mail_query->fields['mail_key'] != $_GET['key']) {
				$info_message = TEXT_EMAIL_ACTIVE_ERROR;
			} else {
				$db->Execute("update ".TABLE_NEWSLETTER_RECIPIENTS." 
				              set mail_status = '1' 
							  where customers_email_address = '".zen_db_input($_GET['email'])."'");
				$info_message = TEXT_EMAIL_ACTIVE;
			}
		}
   }
	
  // Accountdeaktivierung per Emaillink
  if (isset ($_GET['action']) && ($_GET['action'] == 'remove')) {
		$check_mail_query = $db->Execute("select customers_email_address, mail_key 
		                                  from ".TABLE_NEWSLETTER_RECIPIENTS." 
										  where customers_email_address = '".zen_db_input($_GET['email'])."' 
										  and   mail_key = '".zen_db_input($_GET['key'])."'");
		if (!$check_mail_query->RecordCount()) {
			$info_message = TEXT_EMAIL_NOT_EXIST;
		} else {
			//$check_mail = xtc_db_fetch_array($check_mail_query);
			//if (!xtc_validate_password($check_mail['customers_email_address'], $_GET['key'])) 
			if($check_mail_query->fields['mail_key']!=zen_db_input($_GET['key'])){
				$info_message = TEXT_EMAIL_DEL_ERROR;
			} else {
				$del_query = $db->Execute("delete from ".TABLE_NEWSLETTER_RECIPIENTS." 
				                           where  customers_email_address ='".zen_db_input($_GET['email'])."' 
										   and    mail_key = '".zen_db_input($_GET['key'])."'");
				$info_message = TEXT_EMAIL_DEL;
			}
		}
  }
  
  
  
  
  // This should be last line of the script:
  $zco_notifier->notify('NOTIFY_HEADER_END_NEWSLETTER');
?>