<?php

/* -----------------------------------------------------------------------------------------
   $Id: afterbuy.php 1287 2005-10-07 10:41:03Z mz $ 

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(Coding Standards); www.oscommerce.com 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class zen_afterbuy{
	var $order_id;

	// constructor
	function zen_afterbuy($order_id) {
		$this->order_id = $order_id;
	}

	function process_order() {
        global $db;
		// ############ SETTINGS ################

		// PartnerID
		$PartnerID = AFTERBUY_PARTNERID;

		// your PASSWORD for your PartnerID
		$PartnerPass = AFTERBUY_PARTNERPASS;

		// Your Afterbuy USERNAME
		$UserID = AFTERBUY_USERID;

		// new Orderstatus ID of processed order
		$order_status = AFTERBUY_ORDERSTATUS;

		// ######################################

		$oID = $this->order_id;
		$customer = array ();
		$afterbuy_URL = 'https://www.afterbuy.de/afterbuy/ShopInterface.asp';

		// connect
		$ch = curl_init();

		// This is the URL that you want PHP to fetch.
		// You can also set this option when initializing a session with the curl_init()  function.
		curl_setopt($ch, CURLOPT_URL, "$afterbuy_URL");

		// curl_setopt($ch, CURLOPT_CAFILE, 'D:/curl-ca.crt');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		// Set this option to a non-zero value if you want PHP to do a regular HTTP POST.
		// This POST is a normal application/x-www-form-urlencoded  kind, most commonly used by HTML forms.
		curl_setopt($ch, CURLOPT_POST, 1);

		// get order data
		$oData = $db->Execute("SELECT * FROM ".TABLE_ORDERS." WHERE orders_id='".$oID."'");
		//$oData = zen_db_fetch_array($o_query);

		// customers Address
		$customer['id'] = $oData->fields['customers_id'];
		$customer['firma'] = $oData->fields['billing_company'];
		
		$billing_name=explode(" ",$oData->fields['billing_name']);
		if(is_array($billing_name) && sizeof($billing_name)==2){
			$billing_firstname=$billing_name[0];
			$billing_lastname=$billing_name[1];
			
			$customer['vorname'] = $billing_firstname;
			$customer['nachname'] = $billing_lastname;
		}elseif(sizeof($billing_name)>2){//modified by john 2010-06-07 fix bug the blankspace between customer name 
		    $customer['vorname'] = $oData->fields['billing_name'];
			$customer['nachname'] =$oData->fields['billing_name'];
		}
		$customer['strasse'] = ereg_replace(" ", "%20", $oData->fields['billing_street_address']);
		$customer['plz'] = $oData->fields['billing_postcode'];
		$customer['ort'] = ereg_replace(" ", "%20", $oData->fields['billing_city']);
		$customer['tel'] = $oData->fields['customers_telephone'];
		$customer['fax'] = "";
		$customer['mail'] = $oData->fields['customers_email_address'];
		
		$billing_cic_2=$db->Execute('select c.countries_iso_code_2 
									 from   '.TABLE_COUNTRIES.' c  
									 where  c.countries_name="'.trim($oData->fields['billing_country']).'"');
		if($billing_cic_2->RecordCount()>0){			
		   $customer['land'] = $billing_cic_2->fields['countries_iso_code_2'];
		}
		// get gender
		$c_data = $db->Execute("SELECT customers_gender FROM ".TABLE_CUSTOMERS." WHERE customers_id='".$customer['id']."'");
		//$c_data = zen_db_fetch_array($c_query);
		switch ($c_data->fields['customers_gender']) {
			case 'm' :
				$customer['gender'] = 'Herr';
				break;
			default :
				$customer['gender'] = 'Frau';
				break;
		}

		// Delivery Address
		$customer['d_firma'] = $oData->fields['delivery_company'];
		
		$delivery_name=explode(" ",$oData->fields['delivery_name']);
		if(is_array($delivery_name) && sizeof($delivery_name)==2){
			$delivery_firstname=$delivery_name[0];
			$delivery_lastname=$delivery_name[1];
			
			$customer['d_vorname'] = $delivery_firstname;
		    $customer['d_nachname'] = $delivery_lastname;
		}elseif(sizeof($delivery_name)>2){//modified by john 2010-06-07 fix bug the blankspace between customer name 
		    $customer['d_vorname'] = $oData->fields['delivery_name'];
			$customer['d_nachname'] = $oData->fields['delivery_name'];
		}		
		
		
		$customer['d_strasse'] = ereg_replace(" ", "%20", $oData->fields['delivery_street_address']);
		$customer['d_plz'] = $oData->fields['delivery_postcode'];
		$customer['d_ort'] = ereg_replace(" ", "%20", $oData->fields['delivery_city']);
		//$customer['d_land'] = $oData->fields['delivery_country_iso_code_2'];

        $delivery_cic_2=$db->Execute('select c.countries_iso_code_2 
									  from   '.TABLE_COUNTRIES.' c  
									  where  c.countries_name="'.trim($oData->fields['delivery_country']).'"');
		if($delivery_cic_2->RecordCount()>0){			
		   $customer['d_land'] = $delivery_cic_2->fields['countries_iso_code_2'];
		}

		
		// init GET string
		$DATAstring = "Action=new&";
		$DATAstring .= "PartnerID=".$PartnerID."&";
		$DATAstring .= "PartnerPass=".$PartnerPass."&";
		$DATAstring .= "UserID=".$UserID."&";
		$DATAstring .= "Kbenutzername=".$customer['id']."_XTC-ORDER_".$oID."&";
		$DATAstring .= "Kanrede=".$customer['gender']."&";
		$DATAstring .= "KFirma=".$customer['firma']."&";
		$DATAstring .= "KVorname=".$customer['vorname']."&";
		$DATAstring .= "KNachname=".$customer['nachname']."&";
		$DATAstring .= "KStrasse=".$customer['strasse']."&";
		$DATAstring .= "KPLZ=".$customer['plz']."&";
		$DATAstring .= "KOrt=".$customer['ort']."&";
		$DATAstring .= "Ktelefon=".$customer['tel']."&";
		$DATAstring .= "Kfax=&";
		$DATAstring .= "Kemail=".$customer['mail']."&";
		$DATAstring .= "KLand=".$customer['land']."&";
		$DATAstring .= "Lieferanschrift=1&";

		// Delivery Address
		$DATAstring .= "KLFirma=".$customer['d_firma']."&";
		$DATAstring .= "KLVorname=".$customer['d_vorname']."&";
		$DATAstring .= "KLNachname=".$customer['d_nachname']."&";
		$DATAstring .= "KLStrasse=".$customer['d_strasse']."&";
		$DATAstring .= "KLPLZ=".$customer['d_plz']."&";
		$DATAstring .= "KLOrt=".$customer['d_ort']."&";
		$DATAstring .= "KLLand=".$customer['d_land']."&";

		
		// get products data related to order
		$pDATA = $db->Execute("SELECT * FROM ".TABLE_ORDERS_PRODUCTS." WHERE orders_id='".$oID."'");

		$p_count = $pDATA->RecordCount();
		
		$nr = 0;
		$anzahl = 0;
		if($pDATA->RecordCount()>0){
		   while (!$pDATA->EOF){
				$nr ++;
				$artnr = $pDATA->fields['products_afterbuy_model'];
				if ($artnr == '')
					$artnr = $pDATA->fields['products_id'];
				$DATAstring .= "Artikelnr_".$nr."=".$artnr."&";
				
				$DATAstring .= "Artikelname_".$nr."=".ereg_replace("&", "%38", ereg_replace("\"", "", ereg_replace(" ", "%20", $pDATA->fields['products_name'])));
				/******BOF:add attribute data for product***/
				//added by john 2010-06-18
				$pAttrDATA=$db->Execute("SELECT opa.products_options,opa.products_options_values
				                         FROM ".TABLE_ORDERS_PRODUCTS_ATTRIBUTES." opa 
										 WHERE opa.orders_id=".(int)$oID." 
										 AND   opa.orders_products_id=".(int)$pDATA->fields['orders_products_id']);
				$pAttrDATAstring='';
				if($pAttrDATA->RecordCount()>0){
				   while(!$pAttrDATA->EOF){
					  $pAttrDATAstring.=' ['.$pAttrDATA->fields['products_options'].' - '.$pAttrDATA->fields['products_options_values'].'] ';
					    
					  $pAttrDATA->MoveNext();
				   }
				}
				$DATAstring.=$pAttrDATAstring."&";						 
				/******EOF:add attribute data for product***/
				
				/*if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0
				 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1){ */
				    $pDATA->fields['products_price']+=$pDATA->fields['products_tax'];
				//}
				/*if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 
			     && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0){
					$pDATA->fields['products_tax']=0; 
				}*/
				$price = ereg_replace("\.", ",", $pDATA->fields['products_price']);
				$tax = ereg_replace("\.", ",", $pDATA->fields['products_tax']);
	
				$DATAstring .= "ArtikelEPreis_".$nr."=".$price."&";
				$DATAstring .= "ArtikelMwst_".$nr."=".$tax."&";
				$DATAstring .= "ArtikelMenge_".$nr."=".$pDATA->fields['products_quantity']."&";
				$url = HTTP_SERVER.DIR_WS_CATALOG.'index.php?main_page=product_info&products_id='.$pDATA->fields['products_id'];
				$DATAstring .= "ArtikelLink_".$nr."=".$url."&";
	
				$aDATA = $db->Execute("SELECT * FROM ".TABLE_ORDERS_PRODUCTS_ATTRIBUTES." 
									   WHERE orders_id='".$oID."' 
									   AND   orders_products_id='".$pDATA->fields['orders_products_id']."'");
				$options = '';
				if($aDATA->RecordCount()>0){
					while (!$aDATA->EOF) {
						if ($options == '') {
							$options = $aDATA->fields['products_options'].":".$aDATA->fields['products_options_values'];
						} else {
							$options .= "|".$aDATA->fields['products_options'].":".$aDATA->fields['products_options_values'];
						}
						$aDATA->MoveNext();
					}
				}
				if ($options != "") {
					$DATAstring .= "Attribute_".$nr."=".$options."&";
				}
				$anzahl += $pDATA->fields['products_quantity'];
				
				$pDATA->MoveNext();
		    }
		}
		
		// get order total data related to order
		$order_total_values = $db->Execute("SELECT
												  class,
												  value,
												  sort_order
										    FROM ".TABLE_ORDERS_TOTAL."
										    WHERE orders_id='".$oID."'
										    ORDER BY sort_order ASC");

		$order_total = array ();
		$zk = '';
		$cod_fee = '';
		$cod_flag = false;
		$discount_flag = false;
		$gv_flag = false;
		$coupon_flag = false;
		$gv = '';
		if($order_total_values->RecordCount()>0){
		   while (!$order_total_values->EOF) {

				$order_total[] = array ('CLASS' => $order_total_values->fields['class'], 
										'VALUE' => $order_total_values->fields['value']);
	
				// shippingcosts
				if ($order_total_values->fields['class'] == 'ot_shipping')
					$shipping = $order_total_values->fields['value'];
				// nachnamegebuer
				if ($order_total_values->fields['class'] == 'ot_cod_fee') {
					$cod_flag = true;
					$cod_fee = $order_total_values->fields['value'];
				}
				// rabatt
				if ($order_total_values->fields['class'] == 'ot_discount') {
					$discount_flag = true;
					$discount = $order_total_values->fields['value'];
				}
				// Gutschein
				if ($order_total_values->fields['class'] == 'ot_gv') {
					$gv_flag = true;
					$gv = $order_total_values->fields['value'];
				}
				
				if ($order_total_values->fields['class'] == 'ot_coupon') {
					$coupon_flag = true;
					$coupon = $order_total_values->fields['value'];
				}
				$order_total_values->MoveNext();

		   }
		}
		// add cod as product
		if ($cod_flag) {
			// cod tax class
			//    MODULE_ORDER_TOTAL_COD_TAX_CLASS
			$nr ++;
			$DATAstring .= "Artikelnr_".$nr."=99999999&";
			$DATAstring .= "Artikelname_".$nr."=Nachname&";
			$cod_fee = ereg_replace("\.", ",", $cod_fee);
			$DATAstring .= "ArtikelEPreis_".$nr."=".$cod_fee."&";
			$DATAstring .= "ArtikelMwst_".$nr."=".$tax."&";
			$DATAstring .= "ArtikelMenge_".$nr."=1&";
			$p_count ++;
		}

		// rabatt
		if ($discount_flag) {
			$nr ++;
			$DATAstring .= "Artikelnr_".$nr."=99999998&";
			$DATAstring .= "Artikelname_".$nr."=Rabatt&";
			$discount = ereg_replace("\.", ",", $discount);
			$DATAstring .= "ArtikelEPreis_".$nr."=".$discount."&";
			$DATAstring .= "ArtikelMwst_".$nr."=".$tax."&";
			$DATAstring .= "ArtikelMenge_".$nr."=1&";
			$p_count ++;
		}
		// Gutschein
		if ($gv_flag) {
			$nr ++;
			$DATAstring .= "Artikelnr_".$nr."=99999997&";
			$DATAstring .= "Artikelname_".$nr."=Gutschein&";
			$gv = ereg_replace("\.", ",", ($gv * (-1)));
			$DATAstring .= "ArtikelEPreis_".$nr."=".$gv."&";
			$DATAstring .= "ArtikelMwst_".$nr."=0&";
			$DATAstring .= "ArtikelMenge_".$nr."=1&";
			$p_count ++;
		}
		// Kupon
		if ($coupon_flag) {
			$nr ++;
			$DATAstring .= "Artikelnr_".$nr."=99999996&";
			$DATAstring .= "Artikelname_".$nr."=Kupon&";
			$coupon = ereg_replace("\.", ",", ($coupon * (-1)));
			$DATAstring .= "ArtikelEPreis_".$nr."=".$coupon."&";
			$DATAstring .= "ArtikelMwst_".$nr."=0&";
			$DATAstring .= "ArtikelMenge_".$nr."=1&";
			$p_count ++;
		}

		$DATAstring .= "PosAnz=".$p_count."&";

		$vK = ereg_replace("\.", ",", $shipping);

		if (trim($oData->fields['payment_module_code'])== 'cod')
			$oData->fields['payment_method'] = 'Nachnahme';

		$s_method = explode('(', $oData->fields['shipping_method']);
		$s_method = str_replace(' ', '%20', $s_method[0]);

		$DATAstring .= "kommentar=".$oData->fields['comments']."&";
		$DATAstring .= "Versandart=".$s_method."&";
		$DATAstring .= "Versandkosten=".$vK."&";
		$DATAstring .= "Zahlart=".$oData->fields['payment_method']."&";

		//banktransfer data
		/*if ($oData->fields['payment_module_code']=='banktransfer') {
		$b_data = $db-Execute("SELECT * FROM ".TABLE_BANKTRANSFER." WHERE orders_id='".$oID."'");

		if ($b_data->RecordCount()>0) {
			//$b_data = zen_db_fetch_array($b_query);
			$DATAstring .= "Bankname=".$b_data->fields['banktransfer_bankname']."&";
			$DATAstring .= "BLZ=".$b_data->fields['banktransfer_blz']."&";
			$DATAstring .= "Kontonummer=".$b_data->fields['banktransfer_number']."&";
			$DATAstring .= "Kontoinhaber=".$b_data->fields['banktransfer_owner']."&";
		}
		}*/
         
		$DATAstring .= "NoVersandCalc=1";
		/*if ($_SERVER["HTTP_X_FORWARDED_FOR"]=="")
		{
			$user_ip=$_SERVER["REMOTE_ADDR"];
		}else{
            $user_ip=$_SERVER["HTTP_X_FORWARDED_FOR"]; 
		}
        if($user_ip==''){
		   file_put_contents('afterbuy_datamodel.txt',$DATAstring);
		   return false;
		}*/

        /*file_put_contents('test_afterbuy_attr.txt',$DATAstring);
		return false;*/
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $DATAstring);
		$result = curl_exec($ch);
        
		if (ereg("<success>1</success>", $result)) {
			// result ok, mark order
			// extract ID from result
			$cdr = explode('<KundenNr>', $result);
			$cdr = explode('</KundenNr>', $cdr[1]);
			$cdr = $cdr[0];
			$db->Execute("update ".TABLE_ORDERS." set afterbuy_success='1',afterbuy_id='".$cdr."' where orders_id='".$oID."'");

			//set new order status
			if ($order_status != '') {
				$db->Execute("update ".TABLE_ORDERS." set orders_status='".$order_status."' where orders_id='".$oID."'");
			}
		} else {

			// mail to shopowner
			$mail_content = 'Fehler bei &uuml;bertragung der Bestellung: '.$oID.chr(13).chr(10).'Folgende Fehlermeldung wurde vom afterbuy.de zur&uuml;ckgegeben:'.chr(13).chr(10).$result;

			mail(SEND_EXTRA_ORDER_EMAILS_TO, "Afterbuy-Fehl&uuml;bertragung", $mail_content);

		}
		// close session
		curl_close($ch);
	}

	// Funktion zum ueberpruefen ob Bestellung bereits an Afterbuy gesendet.
	function order_send() {
        global $db;
		$data = $db->Execute("SELECT afterbuy_success FROM ".TABLE_ORDERS." WHERE orders_id='".$this->order_id."'");
		//$data = zen_db_fetch_array($check_query);

		if ($data->fields['afterbuy_success'] == 1)
			return false;
		return true;

	}

}
?>