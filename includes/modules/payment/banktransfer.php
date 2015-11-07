<?php
/**
 * @package bank transfer payment module global 
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: banktransfer.php 4960 2006-11-20 01:46:46Z drbyte $
 */

  class banktransfer {
    var $code, $title, $description, $enabled;

// class constructor
    function banktransfer() {
      global $order;

      $this->code = 'banktransfer';
      $this->title = MODULE_PAYMENT_BANKTRANSFER_TEXT_TITLE;
      if (IS_ADMIN_FLAG === true){
	     if(MODULE_PAYMENT_BANKTRANSFER_DOMESTIC_ACCOUNT == 'xxxx-xxxx-xxxx-xxxxxxx' || MODULE_PAYMENT_BANKTRANSFER_PAYTO == ''
			||MODULE_PAYMENT_BANKTRANSFER_INTERNATIONAL_ACCOUNT == 'xxxx-xxxx-xxxx-xxxxxxx' ){
	        $this->title .= '<span class="alert"> (not configured correctlly yet)</span>';
		 }	 
	  } 
	  
      $this->description = MODULE_PAYMENT_BANKTRANSFER_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_BANKTRANSFER_SORT_ORDER;
      $this->enabled = ((MODULE_PAYMENT_BANKTRANSFER_STATUS == 'True') ? true : false);
      if ((int)MODULE_PAYMENT_BANKTRANSFER_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_BANKTRANSFER_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();
    
      $this->email_footer = MODULE_PAYMENT_BANKTRANSFER_TEXT_EMAIL_FOOTER;
    }

// class methods
    function update_status() {
      global $order, $db;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_BANKTRANSFER_ZONE > 0) ) {
        $check_flag = false;
        $check = $db->Execute("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_BANKTRANSFER_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
        while (!$check->EOF) {
          if ($check->fields['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check->fields['zone_id'] == $order->billing['zone_id']) {
            $check_flag = true;
            break;
          }
          $check->MoveNext();
        }

        if ($check_flag == false) {
          $this->enabled = false;
        }
      }
    }

    function javascript_validation() {
      return false;
    }

    function selection() {
	 return array('id' => $this->code,
                  'module' => MODULE_PAYMENT_BANKTRANSFER_TEXT_TITLE,
			//	  'icon'=>MODULE_PAYMENT_BANKTRANSFER_LOGO_ICON,
	              'extra_icon'=>MODULE_PAYMENT_BANKTRANSFER_EXTRA_TEXT	 
	 );

     /* return array('id' => $this->code,
                   'module' => $this->title,
				   'fields' => array(array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_BANKNAME,
                                           'field' => MODULE_PAYMENT_BANKTRANSFER_BANKNAME
										   ),
									 array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_BANKCODE,
                                           'field' => MODULE_PAYMENT_BANKTRANSFER_CODE
										   ),
									 array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_BRANCHCODE,
                                           'field' => MODULE_PAYMENT_BANKTRANSFER_BRANCHCODE
										   ),
									 array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_ACCOUNT_NAME,
                                           'field' => MODULE_PAYMENT_BANKTRANSFER_PAYTO
										   ),
									 array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_ACCOUNT_NUMBER_DOMESTIC,
                                           'field' => MODULE_PAYMENT_BANKTRANSFER_DOMESTIC_ACCOUNT
										   ),
									 array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_ACCOUNT_NUMBER_INTERNATIONAL,
                                           'field' => MODULE_PAYMENT_BANKTRANSFER_INTERNATIONAL_ACCOUNT
										   )
									 )
		           );*/
    }

    function pre_confirmation_check() {
      return false;
    }

    function confirmation() {
      //return array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_DESCRIPTION);

      $confirmation = array('title' =>'',
                            'fields' => array(array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_BANKNAME,
                                                    'field' => MODULE_PAYMENT_BANKTRANSFER_BANKNAME),
											  array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_BANKCODE,
                                                    'field' => MODULE_PAYMENT_BANKTRANSFER_CODE),
											  array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_BRANCHCODE,
                                                    'field' => MODULE_PAYMENT_BANKTRANSFER_BRANCHCODE),
											  array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_ACCOUNT_NAME,
                                                    'field' => MODULE_PAYMENT_BANKTRANSFER_PAYTO),
											  array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_ACCOUNT_NUMBER_DOMESTIC,
                                                    'field' => MODULE_PAYMENT_BANKTRANSFER_DOMESTIC_ACCOUNT),
											  array('title' => MODULE_PAYMENT_BANKTRANSFER_TEXT_ACCOUNT_NUMBER_INTERNATIONAL,
                                                    'field' => MODULE_PAYMENT_BANKTRANSFER_INTERNATIONAL_ACCOUNT)
											  )
						    );

	  return $confirmation;
    }

    function process_button() {
      return false;
    }

    function before_process() {
      return false;
    }

    function after_process() {
      return false;
    }

    function get_error() {
      return false;
    }

    function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_BANKTRANSFER_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }

    function install() {
      global $db;
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description,
															 configuration_group_id, sort_order, set_function, date_added) 
				    values ('Enable the BankTransfer', 'MODULE_PAYMENT_BANKTRANSFER_STATUS', 'True', 'Do you want to enable the bank transfer?', 
							'6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now());");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description,
															 configuration_group_id, sort_order, date_added) 
				    values ('Beneficiary: ', 'MODULE_PAYMENT_BANKTRANSFER_PAYTO', '" . STORE_NAME . "', 'please type the beneficiary',
							'6', '1', now());");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, 
															 configuration_group_id, sort_order, date_added) 
				    values ('Bank Name: ', 'MODULE_PAYMENT_BANKTRANSFER_BANKNAME', 'Postbank Hannover', 'you can type the bank name here',
							'6', '2', now());");
	  
	  /*&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&customed by john 2010-04-27&&&&&&&&&&&&&&&&&&&&&&&&&&*/
	  $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, 
															 configuration_group_id, sort_order, date_added)
				    values ('Bank BranchCode', 'MODULE_PAYMENT_BANKTRANSFER_BRANCHCODE', 'XXXXXX', 'the subbranch bank code ',
						    '6', '4', now())");
	  $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, 
															 configuration_group_id, sort_order, date_added)
				    values ('Bank Code', 'MODULE_PAYMENT_BANKTRANSFER_CODE', 'xxx xxx xx', 'please type the bank code',
						    '6', '4', now())");	 
	  
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, 
															 configuration_group_id, sort_order, date_added) 
				    values ('Bank Domestic Account Number: ', 'MODULE_PAYMENT_BANKTRANSFER_DOMESTIC_ACCOUNT', 'xxxx-xxxx-xxxx-xxxxxxx', 
							'please type the bank account number used in domestic', '6', '3', now());");
	  $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, 
															 configuration_group_id, sort_order, date_added)
				    values ('Bank International Account Number', 'MODULE_PAYMENT_BANKTRANSFER_INTERNATIONAL_ACCOUNT', 'xxxx-xxxx-xxxx-xxxxxxx', 
							'please type the bank account number used in international',
						    '6', '4', now())");	
	  
	  /*&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&end of customed&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&*/
	  
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, 
															 configuration_group_id, sort_order, date_added)
				   values ('Display order', 'MODULE_PAYMENT_BANKTRANSFER_SORT_ORDER', '0', 'small value will appear upfront.',
						   '6', '4', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, 
															 configuration_group_id, sort_order, use_function, set_function, date_added) 
				   values ('Payment Zone', 'MODULE_PAYMENT_BANKTRANSFER_ZONE', '0', 'If you choose a payment area, only the region can use the payment module.', 
						   '6', '5', 'zen_get_zone_class_title', 'zen_cfg_pull_down_zone_classes(', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description,
															 configuration_group_id, sort_order, set_function, use_function, date_added) 
				    values ('Setup Order status', 'MODULE_PAYMENT_BANKTRANSFER_ORDER_STATUS_ID', '0', 'Set up the order status after checkout via banktransfer ', 
							'6', '6', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");
					
    }

    function remove() {
      global $db;
      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PAYMENT_BANKTRANSFER_STATUS', 
	               'MODULE_PAYMENT_BANKTRANSFER_ZONE', 
				   'MODULE_PAYMENT_BANKTRANSFER_ORDER_STATUS_ID', 
				   'MODULE_PAYMENT_BANKTRANSFER_SORT_ORDER', 
				   'MODULE_PAYMENT_BANKTRANSFER_PAYTO', 
				   'MODULE_PAYMENT_BANKTRANSFER_BANKNAME', 
				   'MODULE_PAYMENT_BANKTRANSFER_DOMESTIC_ACCOUNT',
				   'MODULE_PAYMENT_BANKTRANSFER_CODE',
				   'MODULE_PAYMENT_BANKTRANSFER_INTERNATIONAL_ACCOUNT',
				   'MODULE_PAYMENT_BANKTRANSFER_BRANCHCODE');
    }
  }
?>