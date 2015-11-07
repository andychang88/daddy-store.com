<?php
/**
 * @package shippingMethod
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: zones.php 6347 2007-05-20 19:46:59Z ajeh $
 */


  class gls {
    var $code, $title, $description, $enabled, $num_zones;

// class constructor
    function gls() {
	  global $order;
      $this->code = 'gls';
      $this->title = MODULE_SHIPPING_GLS_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_GLS_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_GLS_SORT_ORDER;
      $this->icon = '';
      $this->tax_class = MODULE_SHIPPING_GLS_TAX_CLASS;
      $this->tax_basis = MODULE_SHIPPING_GLS_TAX_BASIS;

      // disable only when entire cart is free shipping
      if (zen_get_shipping_enabled($this->code)) {
        $this->enabled = ((MODULE_SHIPPING_GLS_STATUS == 'True') ? true : false);
      }

      //##################BOF:limit for delivery to only those countries like DE######
      //added by john 2010-06-21 
      $dest_country = $order->delivery['country']['iso_code_2'];
	  
	  if(!defined('MODULE_SHIPPING_GLS_ENABLED_COUNTRIES'))  $this->enabled = false;
	  if($this->enabled ==true && defined('MODULE_SHIPPING_GLS_ENABLED_COUNTRIES')){
		  $enabled2countries=split("[,]",constant('MODULE_SHIPPING_GLS_ENABLED_COUNTRIES'));
		  if(is_array($enabled2countries) && in_array($dest_country,$enabled2countries)){
			  $this->enabled = true;
		  }else{
			  $this->enabled = false;
		  }
	  }
	  //##################EOF:limit for delivery to only those countries like DE######    

      // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
      $this->num_zones = 1;
    }

// class methods
    function quote($method = '') {
      global $order, $shipping_weight, $shipping_num_boxes, $total_count;
      $dest_country = $order->delivery['country']['iso_code_2'];
      $dest_zone = 0;
      $error = false;

      $order_total_amount = $_SESSION['cart']->show_total() - $_SESSION['cart']->free_shipping_prices() ;

      for ($i=1; $i<=$this->num_zones; $i++) {
        $countries_table = constant('MODULE_SHIPPING_GLS_COUNTRIES_' . $i);
        $countries_table = strtoupper(str_replace(' ', '', $countries_table));
        $country_zones = split("[,]", $countries_table);
        if (in_array($dest_country, $country_zones)) {
          $dest_zone = $i;
          break;
        }
        if (in_array('00', $country_zones)) {
          $dest_zone = $i;
          break;
        }
      }

      if ($dest_zone == 0) {
        $error = true;
      } else {
        $shipping = -1;
        $zones_cost = constant('MODULE_SHIPPING_GLS_COST_' . $dest_zone);

        $zones_table = split("[:,]" , $zones_cost);
        $size = sizeof($zones_table);
        $done = false;
		
        for ($i=0; $i<$size; $i+=2) {
		  if (round($shipping_weight,9) <= $zones_table[$i] || $i==$size-2) {
                $shipping = $zones_table[$i+1];
				break;
		  }
        }

        if ($shipping == -1) {
          $shipping_cost = 0;
          $shipping_method = MODULE_SHIPPING_GLS_UNDEFINED_RATE;
        } else {
		  $shipping_cost = $shipping;
		  $shipping_method = MODULE_SHIPPING_GLS_TEXT_WAY .' '.$dest_country.' ('.number_format($shipping_weight,2).MODULE_SHIPPING_GLS_TEXT_UNITS.')';		
        }
      }
      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_GLS_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => $shipping_method,
                                                     'cost' => $shipping_cost)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = zen_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);

      
      if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_GLS_INVALID_ZONE;
      

      return $this->quotes;
    }

    function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_GLS_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }

    function install() {
      global $db;
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Enable Zones Method', 'MODULE_SHIPPING_GLS_STATUS', 'True', 'Do you want to offer GLS e shipping?', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");      
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Tax Class', 'MODULE_SHIPPING_GLS_TAX_CLASS', '0', 'Use the following tax class on the shipping fee.', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Tax Basis', 'MODULE_SHIPPING_GLS_TAX_BASIS', 'Shipping', 'On what basis is Shipping Tax calculated. Options are<br />Shipping - Based on customers Shipping Address<br />Billing Based on customers Billing address<br />Store - Based on Store address if Billing/Shipping Zone equals Store zone', '6', '0', 'zen_cfg_select_option(array(\'Shipping\', \'Billing\', \'Store\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_SHIPPING_GLS_SORT_ORDER', '0', 'Sort order of display.', '6', '0', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enabled Countries, use a comma separated list of the two character ISO country codes', 'MODULE_SHIPPING_GLS_ENABLED_COUNTRIES', '', 'enable for the following Countries:', '6', '0', 'zen_cfg_textarea(', now())");

      for ($i = 1; $i <= $this->num_zones; $i++) {
        $default_countries = '';
        if ($i == 1) {
          $default_countries = 'US,CA';
        }
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Zone " . $i ." Countries', 'MODULE_SHIPPING_GLS_COUNTRIES_" . $i ."', '" . $default_countries . "', 'Comma separated list of two character ISO country codes that are part of Zone " . $i . ".<br />Set as 00 to indicate all two character ISO country codes that are not specifically defined.', '6', '0', 'zen_cfg_textarea(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Zone " . $i ." Shipping Table', 'MODULE_SHIPPING_GLS_COST_" . $i ."', '3:8.50,7:10.50,99:20.00', 'Shipping rates to Zone " . $i . " destinations based on a group of maximum order weights/prices. Example: 3:8.50,7:10.50,... Weight/Price less than or equal to 3 would cost 8.50 for Zone " . $i . " destinations.<br />You can end the last amount as 10000:7% to charge 7% of the Order Total', '6', '0', 'zen_cfg_textarea(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Zone " . $i ." Handling Fee', 'MODULE_SHIPPING_GLS_HANDLING_" . $i."', '0', 'Handling Fee for this shipping zone', '6', '0', now())");
      }
    }

    function remove() {
      global $db;
      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      $keys = array('MODULE_SHIPPING_GLS_STATUS', 
					'MODULE_SHIPPING_GLS_TAX_CLASS',
					'MODULE_SHIPPING_GLS_TAX_BASIS', 
					'MODULE_SHIPPING_GLS_SORT_ORDER', 
					'MODULE_SHIPPING_GLS_ENABLED_COUNTRIES');

      for ($i=1; $i<=$this->num_zones; $i++) {
        $keys[] = 'MODULE_SHIPPING_GLS_COUNTRIES_' . $i;
        $keys[] = 'MODULE_SHIPPING_GLS_COST_' . $i;
        $keys[] = 'MODULE_SHIPPING_GLS_HANDLING_' . $i;
      }

      return $keys;
    }
  }
?>