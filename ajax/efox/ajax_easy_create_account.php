<?php
	//#############validate email_address data from browser############START
	
chdir('../../');
error_reporting(0);

/////////////////////////////////////////
	function dou($str){
		return $str=str_replace("'","''",$str);
	}
	/**
	 * Set some defaults
	 */
	  $process = false;
	
	  $error = false;
	  $email_format = (ACCOUNT_EMAIL_PREFERENCE == '1' ? 'HTML' : 'TEXT');
	 
	
	/**
	 * Process form contents
	 */
	if (isset($_GET['email_address'])) {//var_dump($_REQUEST);exit();
		require('includes/application_top.php');
		
	  $process = true;
	
	  if (isset($_GET['email_format'])) {
	    $email_format = zen_db_prepare_input($_GET['email_format']);
	  }
	
	  $s_nick = zen_db_prepare_input($_GET['nick']);
	 
	  $email_address = dou(zen_db_prepare_input($_GET['email_address']));
	 
	  $password = dou(zen_db_prepare_input($_GET['customers_password']));
	  $confirmation = dou(zen_db_prepare_input($_GET['confirmation']));
	
	
	  /*if (DISPLAY_PRIVACY_CONDITIONS == 'true') {
	    if (!isset($_GET['privacy_conditions']) || ($_GET['privacy_conditions'] != '1')) {
	      $error = true;
	      $messageStack->add_session('login', ERROR_PRIVACY_STATEMENT_NOT_ACCEPTED, 'error');
	    }
	  }  */
	//echo POP_TEXT_JS_TIP_EMAIL_REQUIRED.'--'.POP_TEXT_JS_TIP_EMAIL_FORMAT.'--'.ENTRY_EMAIL_ADDRESS_ERROR_EXISTS.'--'.ENTRY_PASSWORD_ERROR_NOT_MATCHING;exit();
	
	//valid email address
	echo 'var email_address="";';
	if (strlen($email_address) < 1) {
		$error = true;
		echo 'email_address = "'.POP_TEXT_JS_TIP_EMAIL_REQUIRED.'";';exit();
	} elseif (zen_validate_email($email_address) == false) {
		$error = true;
		echo 'email_address = "'.POP_TEXT_JS_TIP_EMAIL_FORMAT.'";';exit();
	} else {
		$check_email_query = "select count(*) as total
							  from " . TABLE_CUSTOMERS . "
							  where customers_email_address = '" . zen_db_input($email_address) . "'
							  and   COWOA_account != 1";
		$check_email = $db->Execute($check_email_query);
		
		if ($check_email->fields['total'] > 0) {
		  $error = true;
		  echo 'email_address = "'.ENTRY_EMAIL_ADDRESS_ERROR_EXISTS.'";';exit();
		}
	}
	
	//valid nick name
	if ($phpBB->phpBB['installed'] == true && isset($_GET['nick'])) {
	echo 'var s_nick="";';
		if (strlen($s_nick) < ENTRY_NICK_MIN_LENGTH)  {
			$error = true;
			echo 's_nick = "'.ENTRY_NICK_LENGTH_ERROR.'";';exit();
		} else {
			// check Zen Cart for duplicate nickname
			$check_nick_query = "select * from " . TABLE_CUSTOMERS  . "  where customers_nick = '" . $s_nick . "'";
			$check_nick = $db->Execute($check_nick_query);
			if ($check_nick->RecordCount() > 0 ) {
				$error = true;
				echo 's_nick = "'.ENTRY_NICK_DUPLICATE_ERROR.'";';exit();
			}
			// check phpBB for duplicate nickname
			if ($phpBB->phpbb_check_for_duplicate_nick($nick) == 'already_exists' ) {
				$error = true;
				echo 's_nick = "'.ENTRY_NICK_DUPLICATE_ERROR . ' (phpBB)'.'";';exit();
			}
		}
	}

	
	//valid password
	echo 'var password="";';
	if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {   
		$error = true;
		echo 'password = "'.ENTRY_PASSWORD_ERROR.'";';exit();
	} elseif ($password != $confirmation) {
		$error = true;
		echo 'password = "'.ENTRY_PASSWORD_ERROR_NOT_MATCHING.'";';exit();
	}
	
	  if ($error == true) {
	    // hook notifier class
	    //$zco_notifier->notify('NOTIFY_FAILURE_DURING_CREATE_ACCOUNT');
	    // redirect back to login page
	    //zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
	  } else {
//echo 'var status=1;';exit();	   
			 $sql_data_array = array('customers_email_address' => $email_address,       
		                             'customers_password' => zen_encrypt_password($password),
									 'customers_nick' => $nick,
		                             'customers_authorization' => (int)CUSTOMERS_APPROVAL_AUTHORIZATION
		                            );
		
		    if ((CUSTOMERS_REFERRAL_STATUS == '2' and $customers_referral != '')) $sql_data_array['customers_referral'] = $customers_referral;
		   /* if (ACCOUNT_GENDER == 'true') $sql_data_array['customers_gender'] = $gender;
		    if (ACCOUNT_DOB == 'true') $sql_data_array['customers_dob'] = (empty($_GET['dob']) || $dob_entered == '0001-01-01 00:00:00' ? zen_db_prepare_input('0001-01-01 00:00:00') : zen_date_raw($_GET['dob']));*/
		
		    zen_db_perform(TABLE_CUSTOMERS, $sql_data_array);
		
		    $_SESSION['customer_id'] = $db->Insert_ID();
		
		    $_SESSION['shipping'] = ''; 
		    $sql = "insert into " . TABLE_CUSTOMERS_INFO . "
					  (customers_info_id, customers_info_number_of_logons,
					   customers_info_date_account_created)
		            values ('" . (int)$_SESSION['customer_id'] . "', '0', now())";
		
		    $db->Execute($sql);
		    
		// BEGIN newsletter_subscribe mod 1/1
		// If a newsletter only account exists we update the info,
		// but keep the subscription active, and give them a message that to
		// change they should do so on their account page (after creation).
		    if(defined('NEWSONLY_SUBSCRIPTION_ENABLED') && (NEWSONLY_SUBSCRIPTION_ENABLED=='true')) {
		      $check_subscribers_query = "select count(*) as total from " . TABLE_SUBSCRIBERS . "
		                                  where email_address = '" . zen_db_input($email_address) . "' ";
		      $check_subscribers = $db->Execute($check_subscribers_query);
		      if ($check_subscribers->fields['total'] > 0) {
		        $sql = "UPDATE " . TABLE_SUBSCRIBERS . " SET
		                customers_id = '" . (int)$_SESSION['customer_id'] . "',
		                email_format = '" . zen_db_input($email_format) . "',
		                confirmed = '1' 
		                WHERE email_address = '" . zen_db_input($email_address) . "' ";
		        $db->Execute($sql);
		        $messageStack->add_session('create_account', SUBSCRIBE_MERGED_NEWSONLY_ACCT);
		      } else {
		        if (!empty($newsletter)) {
		          $sql = "INSERT INTO " . TABLE_SUBSCRIBERS . " 
		                  (customers_id, email_address, email_format, confirmed, subscribed_date)
		                  VALUES ('" . (int)$_SESSION['customer_id'] . "', '" . zen_db_input($email_address) . "', '" . zen_db_input($email_format) . "', '1', now())";
		          $db->Execute($sql);
		        }
		      }
		    }
		// END newsletter_subscribe mod 1/1
		
		    // phpBB create account
		    if ($phpBB->phpBB['installed'] == true) {
		      $phpBB->phpbb_create_account($nick, $password, $email_address);
		    }
		    // End phppBB create account
		
		    if (SESSION_RECREATE == 'True') {
		      zen_session_recreate();
		    }
		
		    /*$_SESSION['customer_first_name'] = $firstname;
		    $_SESSION['customer_default_address_id'] = $address_id;
		    $_SESSION['customer_country_id'] = $country;
		    $_SESSION['customer_zone_id'] = $zone_id;*/
		    $_SESSION['customers_authorization'] = $customers_authorization;
		
		    // restore cart contents
		    $_SESSION['cart']->restore_contents();
		
		    // hook notifier class
		    $zco_notifier->notify('NOTIFY_LOGIN_SUCCESS_VIA_CREATE_ACCOUNT');
		
		    // build the message content
		    /*$name = $firstname . ' ' . $lastname;
		
		    if (ACCOUNT_GENDER == 'true') {
		      if ($gender == 'm') {
		        $email_text = sprintf(EMAIL_GREET_MR, $lastname);
		      } else {
		        $email_text = sprintf(EMAIL_GREET_MS, $lastname);
		      }
		    } else {
		      $email_text = sprintf(EMAIL_GREET_NONE, $firstname);
		    }
		    $html_msg['EMAIL_GREETING'] = str_replace('\n','',$email_text);
		    $html_msg['EMAIL_FIRST_NAME'] = $firstname;
		    $html_msg['EMAIL_LAST_NAME']  = $lastname;*/
//echo 'var status=1;';exit();	   		
		    // initial welcome
			$email_text=POP_EMALL_GREET;
			$html_msg['EMAIL_GREETING']=str_replace('\n','',$email_text);
		    $email_text .=  POP_EMAIL_WELCOME;
		    $html_msg['EMAIL_WELCOME'] = str_replace('\n','',POP_EMAIL_WELCOME.POP_EMAIL_USER_PASSWORD_TEXT.$password);///加上用户的密码;
//echo POP_EMALL_GREET.'--'.POP_EMAIL_WELCOME.'--'.NEW_SIGNUP_DISCOUNT_COUPON;
//echo POP_EMAIL_SUBJECT.'--'.POP_TEXT_EASY_SIGNUP_CUSTOMER_NAME.'--'.POP_EMAIL_TEXT.'--'.POP_EMAIL_CONTACT.'--'.POP_EMAIL_GV_CLOSURE;exit();
		    if (NEW_SIGNUP_DISCOUNT_COUPON != '' and NEW_SIGNUP_DISCOUNT_COUPON != '0') {
		      $coupon_id = NEW_SIGNUP_DISCOUNT_COUPON;
		      $coupon = $db->Execute("select * from " . TABLE_COUPONS . " where coupon_id = '" . $coupon_id . "'");
		      $coupon_desc = $db->Execute("select coupon_description from " . TABLE_COUPONS_DESCRIPTION . " where coupon_id = '" . $coupon_id . "' and language_id = '" . $_SESSION['languages_id'] . "'");
		      $db->Execute("insert into " . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $coupon_id ."', '0', 'Admin', '" . $email_address . "', now() )");
		
		      $text_coupon_help = sprintf(TEXT_COUPON_HELP_DATE, zen_date_short($coupon->fields['coupon_start_date']),zen_date_short($coupon->fields['coupon_expire_date']));
		
		      // if on, add in Discount Coupon explanation
		      //        $email_text .= EMAIL_COUPON_INCENTIVE_HEADER .
		      $email_text .= "\n" . EMAIL_COUPON_INCENTIVE_HEADER .
		      (!empty($coupon_desc->fields['coupon_description']) ? $coupon_desc->fields['coupon_description'] . "\n\n" : '') . $text_coupon_help  . "\n\n" .
		      strip_tags(sprintf(EMAIL_COUPON_REDEEM, ' ' . $coupon->fields['coupon_code'])) . EMAIL_SEPARATOR;
		
		      $html_msg['COUPON_TEXT_VOUCHER_IS'] = EMAIL_COUPON_INCENTIVE_HEADER ;
		      $html_msg['COUPON_DESCRIPTION']     = (!empty($coupon_desc->fields['coupon_description']) ? '<strong>' . $coupon_desc->fields['coupon_description'] . '</strong>' : '');
		      $html_msg['COUPON_TEXT_TO_REDEEM']  = str_replace("\n", '', sprintf(EMAIL_COUPON_REDEEM, ''));
		      $html_msg['COUPON_CODE']  = $coupon->fields['coupon_code'] . $text_coupon_help;
		    } //endif coupon
		
		    if (NEW_SIGNUP_GIFT_VOUCHER_AMOUNT > 0) {
		      $coupon_code = zen_create_coupon_code();
		      $insert_query = $db->Execute("insert into " . TABLE_COUPONS . " (coupon_code, coupon_type, coupon_amount, date_created) values ('" . $coupon_code . "', 'G', '" . NEW_SIGNUP_GIFT_VOUCHER_AMOUNT . "', now())");
		      $insert_id = $db->Insert_ID();
		      $db->Execute("insert into " . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $insert_id ."', '0', 'Admin', '" . $email_address . "', now() )");
		
		      // if on, add in GV explanation
		      $email_text .= "\n\n" . sprintf(EMAIL_GV_INCENTIVE_HEADER, $currencies->format(NEW_SIGNUP_GIFT_VOUCHER_AMOUNT)) .
		      sprintf(EMAIL_GV_REDEEM, $coupon_code) .
		      EMAIL_GV_LINK . zen_href_link(FILENAME_GV_REDEEM, 'gv_no=' . $coupon_code, 'NONSSL', false) . "\n\n" .
		      EMAIL_GV_LINK_OTHER . EMAIL_SEPARATOR;
		      $html_msg['GV_WORTH'] = str_replace('\n','',sprintf(EMAIL_GV_INCENTIVE_HEADER, $currencies->format(NEW_SIGNUP_GIFT_VOUCHER_AMOUNT)) );
		      $html_msg['GV_REDEEM'] = str_replace('\n','',str_replace('\n\n','<br />',sprintf(EMAIL_GV_REDEEM, '<strong>' . $coupon_code . '</strong>')));
		      $html_msg['GV_CODE_NUM'] = $coupon_code;
		      $html_msg['GV_CODE_URL'] = str_replace('\n','',EMAIL_GV_LINK . '<a href="' . zen_href_link(FILENAME_GV_REDEEM, 'gv_no=' . $coupon_code, 'NONSSL', false) . '">' . TEXT_GV_NAME . ': ' . $coupon_code . '</a>');
		      $html_msg['GV_LINK_OTHER'] = EMAIL_GV_LINK_OTHER;
		    } // endif voucher
		
		    // add in regular email welcome text
		    $email_text .= "\n\n" . POP_EMAIL_TEXT . POP_EMAIL_CONTACT . POP_EMAIL_GV_CLOSURE;
		
		    $html_msg['EMAIL_MESSAGE_HTML']  = str_replace('\n','',POP_EMAIL_TEXT);
		    $html_msg['EMAIL_CONTACT_OWNER'] = str_replace('\n','',POP_EMAIL_CONTACT);
		    $html_msg['EMAIL_CLOSURE']       = nl2br(POP_EMAIL_GV_CLOSURE);
		
		    // include create-account-specific disclaimer
		    $email_text .= "\n\n" . sprintf(POP_EMAIL_DISCLAIMER_NEW_CUSTOMER, STORE_OWNER_EMAIL_ADDRESS). "\n\n";
		    $html_msg['EMAIL_DISCLAIMER'] = sprintf(POP_EMAIL_DISCLAIMER_NEW_CUSTOMER, '<a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">'. STORE_OWNER_EMAIL_ADDRESS .' </a>');
		    $name=POP_TEXT_EASY_SIGNUP_CUSTOMER_NAME;
		    //send welcome email
		    zen_mail($name, $email_address, POP_EMAIL_SUBJECT, $email_text, STORE_NAME, EMAIL_FROM, $html_msg, 'welcome');
		
		    // send additional emails
		    if (SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO_STATUS == '1' and SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO !='') {
		      /*if ($_SESSION['customer_id']) {
		        $account_query = "select customers_firstname, customers_lastname, customers_email_address, customers_telephone, customers_fax
		                            from " . TABLE_CUSTOMERS . "
		                            where customers_id = '" . (int)$_SESSION['customer_id'] . "'";
		        $account_query = "select  customers_email_address, customers_telephone, customers_fax
		                          from   " . TABLE_CUSTOMERS . "
		                          where customers_id = '" . (int)$_SESSION['customer_id'] . "'";
		        $account = $db->Execute($account_query);
		      }*/
		
		      /*$extra_info=email_collect_extra_info($name,$email_address, $account->fields['customers_firstname'] . ' ' . $account->fields['customers_lastname'], $account->fields['customers_email_address'], $account->fields['customers_telephone'], $account->fields['customers_fax']);*/
			  $extra_info=email_collect_extra_info($name,$email_address,' ', $email_address,'', '');
		      $html_msg['EXTRA_INFO'] = $extra_info['HTML'];
		      zen_mail('', SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO, SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO_SUBJECT . ' ' . POP_EMAIL_SUBJECT,
		      $email_text . $extra_info['TEXT'], STORE_NAME, EMAIL_FROM, $html_msg, 'welcome_extra');
		    } //endif send extra emails
		
		    //zen_redirect(zen_href_link(FILENAME_CREATE_ACCOUNT_SUCCESS, '', 'SSL'));
	
	  } //endif !error
	  echo 'var status=1;';
	}
	
?>