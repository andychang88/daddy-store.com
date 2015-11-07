<?php

//

// +----------------------------------------------------------------------+

// |zen-cart Open Source E-commerce                                       |

// +----------------------------------------------------------------------+

// | Copyright (c) 2003 The zen-cart developers                           |

// |                                                                      |   

// | http://www.zen-cart.com/index.php                                    |   

// |                                                                      |   

// | Portions Copyright (c) 2003 osCommerce                               |

// +----------------------------------------------------------------------+

// | This source file is subject to version 2.0 of the GPL license,       |

// | that is bundled with this package in the file LICENSE, and is        |

// | available through the world-wide-web at the following url:           |

// | http://www.zen-cart.com/license/2_0.txt.                             |

// | If you did not receive a copy of the zen-cart license and are unable |

// | to obtain it through the world-wide-web, please send a note to       |

// | license@zen-cart.com so we can mail you a copy immediately.          |

// +----------------------------------------------------------------------+

// $Id: moneybookers.php,v 1.3 2004/02/25 10:13:58 wilt Exp $

//

	define('CASHRUN_MERCHANT', 'enomen');//english
	define('CASHRUN_MERCHANT_ID', 'hore9y34thf783g9tfjh4e3nf9y8w397g43i3jt4');
	define('MB_STATUS_URL','https://www.cashrun.com/'.CASHRUN_MERCHANT.'/moneybookers_return.php');

  class moneybookers {

    var $code, $title, $description, $enabled;



// class constructor

    function moneybookers() {

      global $order;



      $this->code = 'moneybookers';

      $this->title = MODULE_PAYMENT_MONEYBOOKERS_TEXT_TITLE;

      $this->description = MODULE_PAYMENT_MONEYBOOKERS_TEXT_DESCRIPTION;

      $this->sort_order = MODULE_PAYMENT_MONEYBOOKERS_SORT_ORDER;

      $this->enabled = ((MODULE_PAYMENT_MONEYBOOKERS_STATUS == 'True') ? true : false);



      if ((int)MODULE_PAYMENT_MONEYBOOKERS_ORDER_STATUS_ID > 0) {

        $this->order_status = MODULE_PAYMENT_MONEYBOOKERS_ORDER_STATUS_ID;

      }



      if (is_object($order)) $this->update_status();



      $this->form_action_url = 'https://www.moneybookers.com/app/payment.pl';

    }



// class methods

    function update_status() {

      global $order, $db;



      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_MONEYBOOKERS_ZONE > 0) ) {

        $check_flag = false;

        $check = $db->Execute("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_MONEYBOOKERS_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");

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

                   'module' =>$this->title,

				   'icon'=>MODULE_PAYMENT_MONEYBOOKERS_LOGO_ICON,

				   'extra_icon'=>MODULE_PAYMENT_MONEYBOOKERS_EXTRA_ICON);

    }



    function pre_confirmation_check() {

      return false;

    }



    function confirmation() {

      return false;

    }



    function process_button() {

      global $order, $currencies;

      

	  if( isset($_SESSION['mb_cs_order_id'])|| isset($_SESSION['products_details_for_email']) ){

	  		unset($_SESSION['products_details_for_email']);

			unset($_SESSION['mb_cs_order_id']);

	  }

	  

      if(!isset($_SESSION['mb_cs_order_id'])){

	  		include('includes/modules/place_moneybooker_order.php');

	  		$_SESSION['mb_cs_order_id']=place_moneybooker_order();

	  }

	  

	  

      if (MODULE_PAYMENT_MONEYBOOKERS_CURRENCY == 'Selected Currency') {

        $my_currency = $_SESSION['currency'];

      } else {

        $my_currency = substr(MODULE_PAYMENT_MONEYBOOKERS_CURRENCY, 5);

      }

      if (!in_array($my_currency, array('CAD', 'EUR', 'GBP', 'CZK', 'USD'))) {

        $my_currency = 'CZK';

      }

     

      $process_button_string = zen_draw_hidden_field('language', 'CS') .

                               zen_draw_hidden_field('pay_to_email', MODULE_PAYMENT_MONEYBOOKERS_ID) .

                               zen_draw_hidden_field('detail1_description', 'Payment on') .

                               zen_draw_hidden_field('firstname', $order->customer[firstname]) .

                               zen_draw_hidden_field('lastname', $order->customer[lastname]) .

                               zen_draw_hidden_field('pay_from_email', $order->customer[email_address]) .

                               zen_draw_hidden_field('postal_code', $order->customer[postcode]) .

                               zen_draw_hidden_field('city', $order->customer[city]) .

                               zen_draw_hidden_field('country', $order->customer[country][iso_code_3]) .

                               zen_draw_hidden_field('state', $order->customer[state]) .

                               zen_draw_hidden_field('address', $order->customer[email_address]) .

                               zen_draw_hidden_field('detail1_text', STORE_NAME) .

                               zen_draw_hidden_field('amount', number_format(($order->info['total']) * $currencies->get_value($my_currency), $currencies->get_decimal_places($my_currency))) .

                               zen_draw_hidden_field('amount_description', 'Ordered Products + Shipping') .

                               zen_draw_hidden_field('currency', $my_currency) .

                               zen_draw_hidden_field('return_url', zen_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL')) .

                               zen_draw_hidden_field('status_url',MB_STATUS_URL) . // added by CashRun

                               zen_draw_hidden_field('transaction_id',CASHRUN_MERCHANT_ID.';'.$_SESSION['mb_cs_order_id']). // format = site_id;cart_id, added by CashRun

                               zen_draw_hidden_field('status_url2', 'mailto:'.MODULE_PAYMENT_MONEYBOOKERS_ID) .

                               zen_draw_hidden_field('cancel_url', zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));



      return $process_button_string;

    }



    function before_process() {

      $script_path = $_SERVER['HTTP_REFERER'];

      $me = explode('main_page=', $script_path);

      $result = explode('&', $me[0]);

      if ($result[0] == 'checkout_confirmation') zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));

	  

	  if(isset($_SESSION['mb_cs_order_id'])){

	  	global $order;

		

		//Afterbuy handle

		if (AFTERBUY_ACTIVATED == 'true') {

				require_once (DIR_WS_CLASSES.'afterbuy.php');

				$aBUY = new zen_afterbuy($_SESSION['mb_cs_order_id']);

				if ($aBUY->order_send())

					$aBUY->process_order();

		}

		//end afterbuy handle

		

		//assign the products details of the order

		$order->products_ordered_html=$_SESSION['products_details_for_email'];

		$order->send_order_email($_SESSION['mb_cs_order_id'],2);

		

	  	unset($_SESSION['products_details_for_email']);

		unset($_SESSION['mb_cs_order_id']);    

	  }

	  $_SESSION['cart']->reset(true);

		unset($_SESSION['sendto']);

		unset($_SESSION['billto']);

		unset($_SESSION['shipping']);

		unset($_SESSION['payment']);

		unset($_SESSION['comments']);

		unset($_SESSION['cot_gv']);

	  zen_redirect(zen_href_link(FILENAME_CHECKOUT_SUCCESS, '', 'SSL'));

      return false;

    }



    function after_process() {    	

    	

    	/*global $insert_id,$order;

		//file_put_contents('ap_cs_mb_cartID.txt',$_SESSION['cs_mb_cartID']);

    	// start of CashRun Code

		

		$pay_from_email = $order->customer['email_address'];

		$amount = $order->info['total'];		

		

		if(isset($_SESSION['cs_mb_cartID'])){

    		$ident = $_SESSION['cs_mb_cartID'];

		}else{

			$ident ='ERROR000000';

		}

		//$var = "cart_id=$ident&order_id=$insert_id";

		$var = "cart_id=$ident&order_id=$insert_id&payer_email=$pay_from_email&amount=$amount";

		// post data to mb_update.php, for updating the order id in CashRun's database

		$header .= "POST /deomen/mb_update.php HTTP/1.0\r\n";

		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";

		$header .= "Content-Length: " . strlen($var) . "\r\n\r\n";

		$fp = fsockopen('ssl://www.cashrun.com', 443, $errno, $errstr, 30);

				

		if (!$fp) {

			// http error

			echo "There is an error processing your request. Please try again! $errno, $errstr";

		} 

		else {			

			$i = 0;

			fputs ($fp, $header . $var);

			

			while (!feof($fp)) {

				$res = fgets ($fp, 1024);

				$result = trim($res);				

			}

		}			

		fclose ($fp);  

		unset($_SESSION['cs_mb_cartID']); 	

		// end of CashRun Code*/

      	

      return false;

    }



    function output_error() {

      return false;

    }



    function check() {

      global $db;

      if (!isset($this->_check)) {

        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_MONEYBOOKERS_STATUS'");

        $this->_check = $check_query->RecordCount();

      }

      return $this->_check;

    }



    function install() {

      global $db;

      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable MoneyBookers Module', 'MODULE_PAYMENT_MONEYBOOKERS_STATUS', 'True', 'Do you want to accept MoneyBookers payments?', '6', '3', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");

      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('E-Mail Address', 'MODULE_PAYMENT_MONEYBOOKERS_ID', 'you@yourbusiness.com', 'The e-mail address to use for the MoneyBookers service', '6', '4', now())");

      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Transaction Currency', 'MODULE_PAYMENT_MONEYBOOKERS_CURRENCY', 'Selected Currency', 'The currency to use for credit card transactions', '6', '6', 'zen_cfg_select_option(array(\'Selected Currency\',\'Only USD\',\'Only CAD\',\'Only EUR\',\'Only GBP\',\'Only CZK\'), ', now())");

      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort order of display.', 'MODULE_PAYMENT_MONEYBOOKERS_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");

      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Payment Zone', 'MODULE_PAYMENT_MONEYBOOKERS_ZONE', '0', 'If a zone is selected, only enable this payment method for that zone.', '6', '2', 'zen_get_zone_class_title', 'zen_cfg_pull_down_zone_classes(', now())");

      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Set Order Status', 'MODULE_PAYMENT_MONEYBOOKERS_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '0', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");

    }



    function remove() {

      global $db;

      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");

    }



    function keys() {

      return array('MODULE_PAYMENT_MONEYBOOKERS_STATUS', 'MODULE_PAYMENT_MONEYBOOKERS_ID', 'MODULE_PAYMENT_MONEYBOOKERS_CURRENCY', 'MODULE_PAYMENT_MONEYBOOKERS_ZONE', 'MODULE_PAYMENT_MONEYBOOKERS_ORDER_STATUS_ID', 'MODULE_PAYMENT_MONEYBOOKERS_SORT_ORDER');

    }

  }



