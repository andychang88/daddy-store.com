<?php
/**
 * @package shippingMethod
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: zones.php 6347 2007-05-20 19:46:59Z ajeh $
 */
  class chinapoststandard {
    var $code, $title, $description, $enabled;

// class constructor
    function chinapoststandard() {
	  global $order,$total_weight;
      $this->code = 'chinapoststandard';
      $this->title = MODULE_SHIPPING_CHINAPOSTSTANDARD_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_CHINAPOSTSTANDARD_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_CHINAPOSTSTANDARD_SORT_ORDER;
      $this->icon = '';
      $this->tax_class = MODULE_SHIPPING_CHINAPOSTSTANDARD_TAX_CLASS;
      $this->tax_basis = MODULE_SHIPPING_CHINAPOSTSTANDARD_TAX_BASIS;

      // disable only when entire cart is free shipping
      if (zen_get_shipping_enabled($this->code)) {
        $this->enabled = ((MODULE_SHIPPING_CHINAPOSTSTANDARD_STATUS == 'True') ? true : false);
      }
	  if($total_weight>MODULE_SHIPPING_CHINAPOSTSTANDARD_BEYOND_WEIGHTLIMIT){
	    $this->enabled=false;
	  }
	  //##################BOF:limit for delivery to only those countries like DE######
      //added by john 2010-06-21 
      $dest_country = $order->delivery['country']['iso_code_2'];
	  
	  if(!defined('MODULE_SHIPPING_CHINAPOSTSTANDARD_DISABLED_COUNTRIES'))  $this->enabled = false;
	  if($this->enabled ==true && defined('MODULE_SHIPPING_CHINAPOSTSTANDARD_DISABLED_COUNTRIES')){
		  $disabled2countries=split("[,]",constant('MODULE_SHIPPING_CHINAPOSTSTANDARD_DISABLED_COUNTRIES'));
		  if(is_array($disabled2countries) && in_array($dest_country,$disabled2countries)){
			  $this->enabled = false;
		  }else{
			  $this->enabled = true;
		  }
	  }
	  //##################EOF:limit for delivery to only those countries like DE######     
    }

// class methods
    function quote($method = '') {
      global $order, $shipping_weight; 
	  
	  $calc_weight=$shipping_weight;
	  
      $error=false;
      $dest_country = $order->delivery['country']['iso_code_2'];   

      if(defined('MODULE_SHIPPING_CHINAPOSTSTANDARD_BASIS_WEIGHT_FEE') && 
	     defined('MODULE_SHIPPING_CHINAPOSTSTANDARD_BASIS_WEIGHT') &&
	     defined('MODULE_SHIPPING_CHINAPOSTSTANDARD_REST_WEIGHT_UNIT_FEE') && 
		 MODULE_SHIPPING_CHINAPOSTSTANDARD_REST_WEIGHT_UNIT_FEE>0){
		 
          if($calc_weight<=MODULE_SHIPPING_CHINAPOSTSTANDARD_BASIS_WEIGHT){
			 $shipping_cost=MODULE_SHIPPING_CHINAPOSTSTANDARD_BASIS_WEIGHT_FEE;
		  }else{
		     $calc_weight=$calc_weight-MODULE_SHIPPING_CHINAPOSTSTANDARD_BASIS_WEIGHT;
			 $shipping_cost=(ceil($calc_weight/MODULE_SHIPPING_CHINAPOSTSTANDARD_REST_WEIGHT_UNIT))*MODULE_SHIPPING_CHINAPOSTSTANDARD_REST_WEIGHT_UNIT_FEE;
			  
			 $shipping_cost=MODULE_SHIPPING_CHINAPOSTSTANDARD_BASIS_WEIGHT_FEE+$shipping_cost;
		  }
	      $shipping_method = MODULE_SHIPPING_CHINAPOSTSTANDARD_TEXT_WAY . ' ' .
		                     $dest_country . ' ('.number_format($shipping_weight,2).MODULE_SHIPPING_CHINAPOSTSTANDARD_TEXT_UNITS.') ';
		  //############################for better calculate with currency#########################
		  //modified by john 2010-06-30 1/3		  
		  $shipping_cost=$shipping_cost/((defined('MODULE_SHIPPING_CHINAPOSTSTANDARD_EXCHANGE_RATE'))?MODULE_SHIPPING_CHINAPOSTSTANDARD_EXCHANGE_RATE:1);
      }	  
	  
	  if($shipping_weight>MODULE_SHIPPING_CHINAPOSTSTANDARD_BEYOND_WEIGHTLIMIT){
	       $error=true;
	  }
      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_CHINAPOSTSTANDARD_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => $shipping_method,
                                                     'cost' => $shipping_cost)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = zen_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }
	  
	  if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);

      if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_CHINAPOSTSTANDARD_BEYOND_WEIGHTLIMIT_TEXT;
	  
      return $this->quotes;
    }

    function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_CHINAPOSTSTANDARD_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }

    function install() {
      global $db;
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description,
	                                                         configuration_group_id, sort_order, set_function, date_added) 
					VALUES ('Enable china  airmail  post shipping method', 'MODULE_SHIPPING_CHINAPOSTSTANDARD_STATUS', 'True', 
					        'Do you want to offer china  airmail shipping?', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
            
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, 
	                                                         configuration_group_id, sort_order,date_added) 
					values ('Set the Maxweight limit for this module','MODULE_SHIPPING_CHINAPOSTSTANDARD_BEYOND_WEIGHTLIMIT', '2',
					        'If the package overweight this value,this module will be disabled', '6', '0', now())"); 
							
	  $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, 
	                                                         configuration_group_id, sort_order,date_added) 
					values ('Set the Basis-Weight for china  airmail post','MODULE_SHIPPING_CHINAPOSTSTANDARD_BASIS_WEIGHT', '',
					        'you can set the basis weight here and the weigh-unit is gram', '6', '0', now())");  
							
	  $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, 
	                                                         configuration_group_id, sort_order,date_added) 
					values ('Set the Basis-Weight-Fee for china airmail post ','MODULE_SHIPPING_CHINAPOSTSTANDARD_BASIS_WEIGHT_FEE', '',
					        'you can set the basis-weight-fee here', '6', '0', now())");   
							
	  $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, 
	                                                         configuration_group_id, sort_order,date_added) 
					values ('Set the Exclude-Basis-Weight Unit for china airmail post','MODULE_SHIPPING_CHINAPOSTSTANDARD_REST_WEIGHT_UNIT', '',
					        'you can set the exclude basis weight unit here and the weigh-unit is gram ', '6', '0', now())");  
							
	  $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, 
	                                                         configuration_group_id, sort_order,date_added) 
					values ('Set the Exclude-Basis-Weight-Fee for china airmail post','MODULE_SHIPPING_CHINAPOSTSTANDARD_REST_WEIGHT_UNIT_FEE', '',
					        'you can set the exclude basis weight fee here', '6', '0', now())"); 							
	  //############################for better calculate with currency#########################
	  //modified by john 2010-06-30 2/3
	  $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, 
	                                                         configuration_group_id, sort_order,date_added) 
					values ('Set the exchange rate according to CNY for china airmail post','MODULE_SHIPPING_CHINAPOSTSTANDARD_EXCHANGE_RATE', '',
					        'you can set the exchange rate here', '6', '0', now())");
							
	  $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, 
	                                                         configuration_group_id, sort_order, set_function, date_added) 
					values ('disabled countries for this module','MODULE_SHIPPING_CHINAPOSTSTANDARD_DISABLED_COUNTRIES', 'DE',
					        'disable this shipping mothod only for those countries(use a comma separated list of the two character ISO country codes):', 
							'6', '0', 'zen_cfg_textarea(', now())");
	  
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, 
	                                                         configuration_group_id, sort_order, date_added) 
					values ('Sort Order', 'MODULE_SHIPPING_CHINAPOSTSTANDARD_SORT_ORDER', '0', 'Sort order of display.', '6', '0', now())");
    }

    function remove() {
      global $db;
      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      $keys = array('MODULE_SHIPPING_CHINAPOSTSTANDARD_STATUS',	
					'MODULE_SHIPPING_CHINAPOSTSTANDARD_BEYOND_WEIGHTLIMIT',
					'MODULE_SHIPPING_CHINAPOSTSTANDARD_BASIS_WEIGHT',					
					'MODULE_SHIPPING_CHINAPOSTSTANDARD_BASIS_WEIGHT_FEE',
					'MODULE_SHIPPING_CHINAPOSTSTANDARD_REST_WEIGHT_UNIT',
					'MODULE_SHIPPING_CHINAPOSTSTANDARD_REST_WEIGHT_UNIT_FEE',
					//############################for better calculate with currency#########################
	                //modified by john 2010-06-30 3/3
					'MODULE_SHIPPING_CHINAPOSTSTANDARD_EXCHANGE_RATE',
					'MODULE_SHIPPING_CHINAPOSTSTANDARD_DISABLED_COUNTRIES',
					'MODULE_SHIPPING_CHINAPOSTSTANDARD_SORT_ORDER');
      return $keys;
    }
  }
?>