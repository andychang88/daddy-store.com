<?php
/**
 * @package admin
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: orders.php 2 2008-09-07 09:28:29Z numinix $
 */

  require('includes/application_top.php');

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  include(DIR_WS_CLASSES . 'order.php');

  // prepare order-status pulldown list
  $orders_statuses = array();
  $orders_status_array = array();
  $orders_status = $db->Execute("select orders_status_id, orders_status_name
                                 from " . TABLE_ORDERS_STATUS . "
                                 where language_id = '" . (int)$_SESSION['languages_id'] . "'");
  while (!$orders_status->EOF) {
    $orders_statuses[] = array('id' => $orders_status->fields['orders_status_id'],
                               'text' => $orders_status->fields['orders_status_name'] . ' [' . $orders_status->fields['orders_status_id'] . ']');
    $orders_status_array[$orders_status->fields['orders_status_id']] = $orders_status->fields['orders_status_name'];
    $orders_status->MoveNext();
  }

  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  $order_exists = false;
  if (isset($_GET['oID']) && trim($_GET['oID']) == '') unset($_GET['oID']);
  if ($action == 'edit' && !isset($_GET['oID'])) $action = '';

  if (isset($_GET['oID'])) {
    $oID = zen_db_prepare_input(trim($_GET['oID']));

    $orders = $db->Execute("select orders_id from " . TABLE_ORDERS . "
                            where orders_id = '" . (int)$oID . "'");
    $order_exists = true;
    if ($orders->RecordCount() <= 0) {
      $order_exists = false;
      if ($action != '') $messageStack->add(sprintf(ERROR_ORDER_DOES_NOT_EXIST, $oID), 'error');
    }
  }
  //#####################Begin:send data to our erp ######################
 //----------------------------------------------------
//ajax action send xml file to ERP
function ajax_sendxml($order,$xml_orderid='0')
    {global $db;
    //begin order xml----------
        $xml_product_details = '';
    if (count($order->products) > 0) {
        $xml_product = '';
        foreach ($order->products as $key => $val) {
            $xml_attr = ""; //init xml_attr
            $xml_productId = $val['id'];
            $xml_titlename = base64_encode(strip_tags( $val['name']));
            $xml_quantity = $val['qty'];
            $xml_price = $val['price'];
            $xml_final_price = $val['final_price'];
            $xml_all_final_price = $val['final_price']*$xml_quantity;
            $xml_model = base64_encode($val['model']);
            $xml_product.="<item productId='$xml_productId' description='$xml_titlename' quantity='$xml_quantity' price='$xml_price' final_price='$xml_final_price'  all_final_price='$xml_all_final_price'  model='$xml_model'>";
            if (is_array($val['attributes'])) {
                foreach ($val['attributes'] as $key_arr => $val_arr) {
					//erp_send_products_attribute,,,begin
					$erp_product_attribute=$db->Execute("select * from `erp_send_products_attribute`
														 where upper(`main_products_model`)=upper('$val[model]')
														 and upper(`value`) like upper('$val_arr[value]%')");
					$products_att_main_m='';
					$products_att_model='';
					if($erp_product_attribute->RecordCount()>0)
					{
						$products_att_main_m=$erp_product_attribute->fields['main_products_model'];
						$products_att_model=$erp_product_attribute->fields['products_model'];					
					}		
					//erp_send_products_attribute,,,end						
                    $xml_attr.="<attribute option='$val_arr[option]' value='$val_arr[value]'
								m_p_model='$products_att_main_m'
								model = '$products_att_model'
								prefix='$val_arr[prefix]' price='$val_arr[price]'></attribute>";  
                }
            }
            $xml_product = $xml_product . $xml_attr . '</item>';
        }
    }
    $xml_product_details = $xml_product;

//    $xml_orderid = $oID;//这里是获取的ID
    $xml_url =$_SERVER['HTTP_HOST'];// "http://www.efox-shop.com";
    $xml_time = $order->info['date_purchased'];//wushh 20110329 modify the time now to date_purchased
    $xml_currency_type = base64_encode($order->info['currency']);
    $xml_total = str_replace(',', '', $order->info['total']);//wushh 20110329 modify the large total money
    $xml_shipping_module_code= base64_encode($order->info['shipping_module_code']);
    $xml_payment_module_code= base64_encode($order->info['payment_module_code']);
    $xml_customer_id = $order->customer['id'];
    $xml_customer_name = base64_encode($order->customer['name']);
    $xml_customer_email_address = base64_encode($order->customer['email_address']);
    $xml_bill_name = base64_encode($order->billing['name']);
    $xml_bill_street_address = base64_encode($order->billing['street_address']);
    $xml_bill_suburb = base64_encode($order->billing['suburb']);
    $xml_bill_city = base64_encode($order->billing['city']);
    $xml_bill_postcode = base64_encode($order->billing['postcode']);
    $xml_bill_province = base64_encode($order->billing['province']);
    $xml_bill_country = base64_encode($order->billing['country']);
    $xml_deli_name = base64_encode($order->delivery['name']);
    $xml_deli_street_address = base64_encode($order->delivery['street_address']);
    $xml_deli_suburb = base64_encode($order->delivery['suburb']);
    $xml_deli_city = base64_encode($order->delivery['city']);
    $xml_deli_postcode = base64_encode($order->delivery['postcode']);
    $xml_deli_state = base64_encode($order->delivery['state']);
    $xml_deli_country = base64_encode($order->delivery['country']);
	$xml_coupon= base64_encode($order->info['coupon_code']);
    $xml_discount = "";
    $xml_salesTax = "";
    $xml_info_shippingCost = "";
	$xml_info_insuranceCost = "";
	$xml_info_coupon = "";
	
    $curr_source=array("&euro;","&pound;","$","€","-");
    foreach ($order->totals as $key => $val) {
        if ($val['class'] == "ot_shipping"){
            $xml_info_shippingCost = str_replace($curr_source, "", $val['text']);
            $xml_info_shippingCost_title = urlencode($val['title']);
        }
		/*此处为团购的价格导入，现在网站没有团购，暂时先不要 2011.6.23 du
        if ($val['class'] == "ot_group_pricing") {
            $xml_discount = str_replace($curr_source, "", $val['text']);
            $xml_discount_title = urlencode($val['title']);
        }
		*/
        if ($val['class'] == "ot_tax"){
            $xml_salesTax = str_replace($curr_source, "", $val['text']);
            $xml_salesTax_title = urlencode($val['title']);
        }
		if ($val['class'] == "ot_total"){
			if(strpos($val['text'],":")=="" && strpos($subtext,")")==""){
				$xml_info_insuranceCost = "0";
				$xml_info_insuranceCost_title = "insuranceCost";
			}else{
				$subtext = str_replace($curr_source, "", $val['text']);
				
				$text=substr($subtext,strpos($subtext,":")+1,strpos($subtext,")")-strpos($subtext,":")-1);
				$xml_info_insuranceCost = $text;
				$xml_info_insuranceCost_title = "insuranceCost";
			}
        }
		if ($val['class'] == "ot_coupon"){
            $xml_couponTax = str_replace($curr_source, "", $val['text']);
            $xml_couponTax_title = urlencode($val['title']);
        }
    }
//    $xml_arr_old=array( '$xml_orderid','$xml_url','$xml_orderid','$xml_time','$xml_currency_type','$xml_total',
//                        '$xml_customer_id','$xml_customer_name','$xml_customer_email_address',
//                        '$xml_bill_name','$xml_bill_street_address','$xml_bill_suburb','$xml_bill_city',
//                        '$xml_bill_postcode','$xml_bill_province','$xml_bill_country',
//                        '$xml_deli_name','$xml_deli_street_address','$xml_deli_suburb','$xml_deli_city',
//                        '$xml_deli_postcode','$xml_deli_state','$xml_deli_country',
//                        '$xml_product_details',
//                        '$xml_discount','$xml_salesTax','$xml_info_shippingCost',
//                        );
//    $xml_arr_new=array($xml_orderid,$xml_url,$xml_orderid,$xml_time,$xml_currency_type,$xml_total,
//                        $xml_customer_id,$xml_customer_name,$xml_customer_email_address,
//                        $xml_bill_name,$xml_bill_street_address,$xml_bill_suburb,$xml_bill_city,
//                        $xml_bill_postcode,$xml_bill_province,$xml_bill_country,
//                        $xml_deli_name,$xml_deli_street_address,$xml_deli_suburb,$xml_deli_city,
//                        $xml_deli_postcode,$xml_deli_state,$xml_deli_country,
//                        $xml_product_details,
//                        $xml_discount,$xml_salesTax,$xml_info_shippingCost,);
//添加留言信息  select orders_status_id, date_added, customer_notified, comments from orders_status_history where orders_id = '7129' order by date_added
//  $xml_orderid
    $message_sql="select orders_status_id, date_added, customer_notified, comments from orders_status_history where orders_id = '{$xml_orderid}' order by date_added";
    $message_arr = $db->Execute($message_sql);
    $xml_leave_message = base64_encode($message_arr->fields['comments']);

    $customer_phone_sql = "select customers_telephone from orders where orders_id = '{$xml_orderid}' limit 1";
    $customer_phone_arr=$db->Execute($customer_phone_sql);
    $xml_customer_phone = base64_encode($customer_phone_arr->fields['customers_telephone']);
    
    $xml_body_source = "<?xml version='1.0' encoding='utf-8' ?>
<order id='$xml_orderid' url='$xml_url' siteId='myefoxcom'
signiture='asfdadfadsfadfsaadf' timestamp='$xml_time' currency='$xml_currency_type' total='$xml_total'
    shipping_module='$xml_shipping_module_code' payment_module='$xml_payment_module_code'>
    <customer id='$xml_customer_id' title='empty' firstName='$xml_customer_name' lastName='' mail='$xml_customer_email_address' phone='$xml_customer_phone' message='$xml_leave_message'>
        <billAddress>
            <name>$xml_bill_name</name>
            <addressLine1>$xml_bill_street_address</addressLine1>
            <addressLine2>$xml_bill_suburb</addressLine2>
            <city>$xml_bill_city</city>
            <zipcode>$xml_bill_postcode</zipcode>
            <province>$xml_bill_province</province>
            <country>$xml_bill_country</country>
        </billAddress>
        <shippingAddress>
            <name>$xml_deli_name</name>
            <addressLine1>$xml_deli_street_address</addressLine1>
            <addressLine2>$xml_deli_suburb</addressLine2>
            <city>$xml_deli_city</city>
            <zipcode>$xml_deli_postcode</zipcode>
            <province>$xml_deli_state</province>
            <country>$xml_deli_country</country>
        </shippingAddress>
    </customer>
    <items>
        $xml_product_details
    </items>
    <adjustments>
        <adjustment type='discount' description='zhekou1' title='$xml_couponTax_title' prefix='-' amount='$xml_couponTax'></adjustment>
        <adjustment type='salesTax' description='xiaoshoushui' title='$xml_salesTax_title' prefix='+' amount='$xml_salesTax'></adjustment>
        <adjustment type='shippingCost' description='yunfei' title='$xml_info_shippingCost_title' prefix='+' amount='$xml_info_shippingCost'></adjustment>
		<adjustment type='insuranceCost' description='baoxian' title='$xml_info_insuranceCost_title' prefix='+' amount='$xml_info_insuranceCost'></adjustment>
    </adjustments>
</order>";
    return array($xml_body_source,$xml_url,$xml_orderid);
//end order xml--------
    }

 if ($action == 'unlinklogs') {//delete the log file today
     /* 删除log文件,仅限于当天 
	 * ?action=unlinklogs&logtype=date_purchased(类型)
      */
     $xml_log_type=$_GET['logtype'];
    if ($xml_log_type == 'comm') {
        $log_file_name = "../cache/erp_comm_" . date("y_m_d") . ".log"; //log记录名称
    } elseif ($xml_log_type == 'date_purchased') {
        $log_file_name = "../cache/erp_date_" . date("y_m_d") . ".log"; //log记录名称
    } elseif ($xml_log_type == 'orders_id') {
        $log_file_name = "../cache/erp_order_" . date("y_m_d") . ".log"; //log记录名称
    }
    unlink($log_file_name);
}
    
  if($action == 'ajaxsendxml' ) {//main action
    /* 初始化: order.php?action=initjs&b_init=10000&e_init=20000&b_time=100&e_time=10&b_ods=1000&e_ods=1100
     * 默认检查cache内log文件的查询次数
     *  action=initjs 传输xml数据到erp
     *  @int 循环时间   b_init=5000载入页面5秒后执行数据     e_init=10000循环时间10秒收执行数据
     *  @int 订单号     b_ods=3从第三个开始                 e_ods=10到第十个订单结束
     *  @int 时间       b_time=100从第100小时前执行         e_time=10 到距离现在10小时前结束,应考虑程序执行时间在内
     * 注意：订单号和时间参数互斥，定义请务必定义"开始"和"结束"2个参数，缺一不可
    */
    $sql_add="";
    $xml_log_type='comm';
    if (isset($_GET['b_time']) && isset($_GET['e_time']) && $_GET['b_time']>0 && $_GET['e_time']>0 ) {
        $b_before = $_GET['b_time'] * 60 * 60;
        $e_before = $_GET['e_time'] * 60 * 60;
        $b_time = time() - $b_before;
        $e_time = time() - $e_before;
        $b_time=date("Y-m-d h:i:s", $b_time);
        $e_time=date("Y-m-d h:i:s", $e_time);
        if($b_time>$e_time){
            $change_ods_b=$b_time;
            $change_ods_e=$e_time;
            $b_time=$change_ods_e;
            $e_time=$change_ods_b;
        }
        $sql_add = " and date_purchased>= '".$b_time."' and date_purchased<= '".$e_time."'";
        $xml_log_type='date_purchased';
    } elseif (isset($_GET['b_ods']) && isset($_GET['e_ods']) && $_GET['b_ods']>0 && $_GET['e_ods']>0 ) {
        if($_GET['b_ods']>$_GET['e_ods']){
            $change_ods_b=$_GET['b_ods'];
            $change_ods_e=$_GET['e_ods'];
            $_GET['b_ods']=$change_ods_e;
            $_GET['e_ods']=$change_ods_b;
        }
        $b_ods=$_GET['b_ods'];
        $e_ods=$_GET['e_ods'];
        $sql_add = " and orders_id>=".$b_ods." and orders_id<= ".$e_ods;
        $xml_log_type='orders_id';
    }
    if ($xml_log_type == 'comm') {
        $log_file_name = "../cache/erp_comm_" . date("y_m_d") . ".log"; //log记录名称
    } elseif ($xml_log_type == 'date_purchased') {
        $log_file_name = "../cache/erp_date_" . date("y_m_d") . ".log"; //log记录名称
    } elseif ($xml_log_type == 'orders_id') {
        $log_file_name = "../cache/erp_order_" . date("y_m_d") . ".log"; //log记录名称
    }
    !file_exists($log_file_name)?error_log('0__',3,$log_file_name):'';
    $xml_array_ordersid=explode('__',  file_get_contents($log_file_name));
    //选择今天是数据，默认，-->查看是否在log内，不在内-->发送数据
    $no_set_time=date("Y-m-d h:i:s", date("Y-m-d h:i:s", time()-3600*2));//2小时前 
    $sql_add=trim($sql_add);
    if(empty($sql_add ))$sql_add=" and date_purchased>= '".$no_set_time."' "; //设定默认时间
//    $sql_add=' and orders_id = 12 ';//test
    $xml_get_orders = $db->Execute("select orders_id  from " . TABLE_ORDERS . "
                                      where 1  ".$sql_add." order by orders_id asc ");//and date_purchased>='".date("Y-m-d")."'
    if ($xml_get_orders->RecordCount() > 0) {
        while (!$xml_get_orders->EOF) {
//            echo $xml_get_orders->fields['orders_id'];echo '<hr>';
//			附加绝对传输参数(正对单个失败产品),稍后在添加            
		if (!in_array($xml_get_orders->fields['orders_id'], $xml_array_ordersid)) {
//                echo 'init it ';
                $oID = $xml_get_orders->fields['orders_id'];
                $order = new order($oID);
                $xml_backall = ajax_sendxml($order, $oID);
                $xml_sou=$xml_backall[0];
                $xml_url=$xml_backall[1];
                $xml_orderid=$xml_backall[2];
               
                //                error_log($xml_get_orders->fields['orders_id'] . '__', 3, $log_file_name); //send id history 非正常处理，logo另外生成
                //				转移到下                $xml_sendto = urlencode($xml_sou);
                //                    $url = "http://localhost:8012/?xmlfileinfo=" . $xml_sendto;//输出地址
                echo $url = "https://www.aukey888.com/crmsfa/control/websiteOrderReceiver?siteId=myefoxcom&orderId=".$xml_orderid."&order=" . urlencode($xml_sou);
                // echo $url = "http://flyinglimy.gicp.net/crmsfa/control/websiteOrderReceiver?siteId=".$xml_url."&orderId=".$xml_orderid."&order=" . $xml_sendto;
                //                header("location:{$url}");//www.auke888.com

$opts = array(
   'http'=>array(
     'method'=>"GET",
     'timeout'=>33,
    )
);
$context = stream_context_create($opts); //防止服务器出现程序超时的问题
$c =file_get_contents($url, false, $context);//改用curl
//             $c = cls_curl::get($url);

if($c==true)
                {
                        error_log($xml_get_orders->fields['orders_id'] . '__', 3, $log_file_name); //send id history 非正常处理，logo另外生成
                }

				echo '
					----------result---------';
                var_dump($c);
                echo '--------ok----------';
                exit('send finished');
            } else {
//                echo 'has been send';
            }
            $xml_get_orders->MoveNext();
        }
    }
    die('die to send xml');
}
class cls_curl {
    protected static $timeout = 20;
    protected static $ch = null;
    protected static $proxy = null;
    protected static $useragent = 'Mozilla/5.0';
    protected static $cookie = null;
    protected static $referer = null;
    public static function set_timeout($timeout) {
        self::$timeout = $timeout;
    }
    public static function set_proxy($proxy) {
        self::$proxy = $proxy;
    }
    public static function set_referer($referer) {
        self::$referer = $referer;
    }
    public static function set_useragent($useragent) {
        self::$useragent = $useragent;
    }
    public static function set_cookie($cookie) {
        self::$cookie = $cookie;
    }
    public static function init() {
        if (empty(self::$ch)) {
            self::$ch = curl_init ();
            curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(self::$ch, CURLOPT_CONNECTTIMEOUT, self::$timeout);
            curl_setopt(self::$ch, CURLOPT_HEADER, false);
            curl_setopt(self::$ch, CURLOPT_USERAGENT, self::$useragent);
            curl_setopt(self::$ch, CURLOPT_TIMEOUT, self::$timeout + 5);
        }
        return self::$ch;
    }
    public static function get($url, $proxy = false) {
        self::init ();
        curl_setopt(self::$ch, CURLOPT_URL, $url);
        if (self::$useragent) {
            curl_setopt(self::$ch, CURLOPT_USERAGENT, self::$useragent);
        }
        if (self::$cookie) {
            curl_setopt(self::$ch, CURLOPT_COOKIE, self::$cookie);
        }
        if (self::$referer) {
            curl_setopt(self::$ch, CURLOPT_REFERER, self::$referer);
        }
        if ($proxy) {
            curl_setopt(self::$ch, CURLOPT_PROXY, $url);
            curl_setopt(self::$ch, CURLOPT_USERAGENT, $url);
        }
        $data = curl_exec(self::$ch);
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }
    public static function post($url, $fields, $proxy = false) {
        self::init ();
        curl_setopt(self::$ch, CURLOPT_URL, $url);
        curl_setopt(self::$ch, CURLOPT_POST, true);
        curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $fields);
        if ($proxy) {
            curl_setopt(self::$ch, CURLOPT_PROXY, $url);
            curl_setopt(self::$ch, CURLOPT_USERAGENT, $url);
        }
        if (self::$cookie) {
            curl_setopt(self::$ch, CURLOPT_COOKIE, self::$cookie);
        }
        if (self::$referer) {
            curl_setopt(self::$ch, CURLOPT_REFERER, self::$referer);
        }
        $data = curl_exec(self::$ch);
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

}

//ajax action end  20101012
//----------------------------------------------------
  //#####################End:send data to our erp ######################
  if (zen_not_null($action) && $order_exists == true) {
    switch ($action) {
      case 'edit':
      // reset single download to on
        if ($_GET['download_reset_on'] > 0) {
          // adjust download_maxdays based on current date
          $check_status = $db->Execute("select customers_name, customers_email_address, orders_status,
                                      date_purchased, COWOA_order from " . TABLE_ORDERS . "
                                      where orders_id = '" . $_GET['oID'] . "'");
          $zc_max_days = date_diff($check_status->fields['date_purchased'], date('Y-m-d H:i:s', time())) + DOWNLOAD_MAX_DAYS;

          $update_downloads_query = "update " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " set download_maxdays='" . $zc_max_days . "', download_count='" . DOWNLOAD_MAX_COUNT . "' where orders_id='" . $_GET['oID'] . "' and orders_products_download_id='" . $_GET['download_reset_on'] . "'";
          $db->Execute($update_downloads_query);
          unset($_GET['download_reset_on']);

          $messageStack->add_session(SUCCESS_ORDER_UPDATED_DOWNLOAD_ON, 'success');
          zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        }
      // reset single download to off
        if ($_GET['download_reset_off'] > 0) {
          // adjust download_maxdays based on current date
          // *** fix: adjust count not maxdays to cancel download
//          $update_downloads_query = "update " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " set download_maxdays='0', download_count='0' where orders_id='" . $_GET['oID'] . "' and orders_products_download_id='" . $_GET['download_reset_off'] . "'";
          $update_downloads_query = "update " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " set download_count='0' where orders_id='" . $_GET['oID'] . "' and orders_products_download_id='" . $_GET['download_reset_off'] . "'";
          unset($_GET['download_reset_off']);
          $db->Execute($update_downloads_query);

          $messageStack->add_session(SUCCESS_ORDER_UPDATED_DOWNLOAD_OFF, 'success');
          zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        }
      break;
      case 'update_order':
        // demo active test
        if (zen_admin_demo()) {
          $_GET['action']= '';
          $messageStack->add_session(ERROR_ADMIN_DEMO, 'caution');
          zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        }
        $oID = zen_db_prepare_input($_GET['oID']);
        $status = zen_db_prepare_input($_POST['status']);
        $comments = zen_db_prepare_input($_POST['comments']);

        $order_updated = false;
        $check_status = $db->Execute("select customers_name, customers_email_address, orders_status,
                                      date_purchased, COWOA_order from " . TABLE_ORDERS . "
                                      where orders_id = '" . (int)$oID . "'");

        if ( ($check_status->fields['orders_status'] != $status) || zen_not_null($comments)) {
          $db->Execute("update " . TABLE_ORDERS . "
                        set orders_status = '" . zen_db_input($status) . "', last_modified = now()
                        where orders_id = '" . (int)$oID . "'");

          $notify_comments = '';
          if (isset($_POST['notify_comments']) && ($_POST['notify_comments'] == 'on') && zen_not_null($comments)) {
            $notify_comments = EMAIL_TEXT_COMMENTS_UPDATE . $comments . "\n\n";
          }
//send emails
      $message = STORE_NAME . "\n" . EMAIL_SEPARATOR . "\n" .
      EMAIL_TEXT_ORDER_NUMBER . ' ' . $oID . "\n\n";
      if(!$check_status->fields['COWOA_order']) {
      $message .= EMAIL_TEXT_INVOICE_URL . ' ' . zen_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oID, 'SSL') . "\n\n";
      }
      $message .= EMAIL_TEXT_DATE_ORDERED . ' ' . zen_date_long($check_status->fields['date_purchased']) . "\n\n" .
      strip_tags($notify_comments) .
      EMAIL_TEXT_STATUS_UPDATED . sprintf(EMAIL_TEXT_STATUS_LABEL, $orders_status_array[$status] ) .
      EMAIL_TEXT_STATUS_PLEASE_REPLY;

          $html_msg['EMAIL_CUSTOMERS_NAME']    = $check_status->fields['customers_name'];
          $html_msg['EMAIL_TEXT_ORDER_NUMBER'] = EMAIL_TEXT_ORDER_NUMBER . ' ' . $oID;
          if(!$check_status->fields['COWOA_order']) {
            $html_msg['EMAIL_TEXT_INVOICE_URL']  = '<a href="' . zen_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oID, 'SSL') .'">'.str_replace(':','',EMAIL_TEXT_INVOICE_URL).'</a>';
          }
          $html_msg['EMAIL_TEXT_DATE_ORDERED'] = EMAIL_TEXT_DATE_ORDERED . ' ' . zen_date_long($check_status->fields['date_purchased']);
          $html_msg['EMAIL_TEXT_STATUS_COMMENTS'] = nl2br($notify_comments);
          $html_msg['EMAIL_TEXT_STATUS_UPDATED'] = str_replace('\n','', EMAIL_TEXT_STATUS_UPDATED);
          $html_msg['EMAIL_TEXT_STATUS_LABEL'] = str_replace('\n','', sprintf(EMAIL_TEXT_STATUS_LABEL, $orders_status_array[$status] ));
          $html_msg['EMAIL_TEXT_NEW_STATUS'] = $orders_status_array[$status];
          $html_msg['EMAIL_TEXT_STATUS_PLEASE_REPLY'] = str_replace('\n','', EMAIL_TEXT_STATUS_PLEASE_REPLY);

          $customer_notified = '0';
          if (isset($_POST['notify']) && ($_POST['notify'] == 'on')) {
            zen_mail($check_status->fields['customers_name'], $check_status->fields['customers_email_address'], EMAIL_TEXT_SUBJECT . ' #' . $oID, $message, STORE_NAME, EMAIL_FROM, $html_msg, 'order_status');
            $customer_notified = '1';

            //send extra emails
            if (SEND_EXTRA_ORDERS_STATUS_ADMIN_EMAILS_TO_STATUS == '1' and SEND_EXTRA_ORDERS_STATUS_ADMIN_EMAILS_TO != '') {
              zen_mail('', SEND_EXTRA_ORDERS_STATUS_ADMIN_EMAILS_TO, SEND_EXTRA_ORDERS_STATUS_ADMIN_EMAILS_TO_SUBJECT . ' ' . EMAIL_TEXT_SUBJECT . ' #' . $oID, $message, STORE_NAME, EMAIL_FROM, $html_msg, 'order_status_extra');
            }
          }

          $db->Execute("insert into " . TABLE_ORDERS_STATUS_HISTORY . "
                      (orders_id, orders_status_id, date_added, customer_notified, comments)
                      values ('" . (int)$oID . "',
                      '" . zen_db_input($status) . "',
                      now(),
                      '" . zen_db_input($customer_notified) . "',
                      '" . zen_db_input($comments)  . "')");
          $order_updated = true;
        }

        if ($order_updated == true) {
         if ($status == DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE) {
            // adjust download_maxdays based on current date
            $zc_max_days = date_diff($check_status->fields['date_purchased'], date('Y-m-d H:i:s', time())) + DOWNLOAD_MAX_DAYS;

            $update_downloads_query = "update " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " set download_maxdays='" . $zc_max_days . "', download_count='" . DOWNLOAD_MAX_COUNT . "' where orders_id='" . (int)$oID . "'";
            $db->Execute($update_downloads_query);
          }
          $messageStack->add_session(SUCCESS_ORDER_UPDATED, 'success');
        } else {
          $messageStack->add_session(WARNING_ORDER_NOT_UPDATED, 'warning');
        }

        zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        break;
      case 'deleteconfirm':
        // demo active test
        if (zen_admin_demo()) {
          $_GET['action']= '';
          $messageStack->add_session(ERROR_ADMIN_DEMO, 'caution');
          zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')), 'NONSSL'));
        }
        $oID = zen_db_prepare_input($_GET['oID']);

        zen_remove_order($oID, $_POST['restock']);

        zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')), 'NONSSL'));
        break;
      case 'delete_cvv':
        $delete_cvv = $db->Execute("update " . TABLE_ORDERS . " set cc_cvv = '" . TEXT_DELETE_CVV_REPLACEMENT . "' where orders_id = '" . (int)$_GET['oID'] . "'");
        zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        break;
      case 'mask_cc':
        $result  = $db->Execute("select cc_number from " . TABLE_ORDERS . " where orders_id = '" . (int)$_GET['oID'] . "'");
        $old_num = $result->fields['cc_number'];
        $new_num = substr($old_num, 0, 4) . str_repeat('*', (strlen($old_num) - 8)) . substr($old_num, -4);
        $mask_cc = $db->Execute("update " . TABLE_ORDERS . " set cc_number = '" . $new_num . "' where orders_id = '" . (int)$_GET['oID'] . "'");
        zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        break;

      case 'doRefund':
        $order = new order($oID);
        if ($order->info['payment_module_code']) {
          if (file_exists(DIR_FS_CATALOG_MODULES . 'payment/' . $order->info['payment_module_code'] . '.php')) {
            require_once(DIR_FS_CATALOG_MODULES . 'payment/' . $order->info['payment_module_code'] . '.php');
            require_once(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $order->info['payment_module_code'] . '.php');
            $module = new $order->info['payment_module_code'];
            if (method_exists($module, '_doRefund')) {
              $module->_doRefund($oID);
            }
          }
        }
        zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        break;
      case 'doAuth':
        $order = new order($oID);
        if ($order->info['payment_module_code']) {
          if (file_exists(DIR_FS_CATALOG_MODULES . 'payment/' . $order->info['payment_module_code'] . '.php')) {
            require_once(DIR_FS_CATALOG_MODULES . 'payment/' . $order->info['payment_module_code'] . '.php');
            require_once(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $order->info['payment_module_code'] . '.php');
            $module = new $order->info['payment_module_code'];
            if (method_exists($module, '_doAuth')) {
              $module->_doAuth($oID, $order->info['total'], $order->info['currency']);
            }
          }
        }
        zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        break;
      case 'doCapture':
        $order = new order($oID);
        if ($order->info['payment_module_code']) {
          if (file_exists(DIR_FS_CATALOG_MODULES . 'payment/' . $order->info['payment_module_code'] . '.php')) {
            require_once(DIR_FS_CATALOG_MODULES . 'payment/' . $order->info['payment_module_code'] . '.php');
            require_once(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $order->info['payment_module_code'] . '.php');
            $module = new $order->info['payment_module_code'];
            if (method_exists($module, '_doCapt')) {
              $module->_doCapt($oID, 'Complete', $order->info['total'], $order->info['currency']);
            }
          }
        }
        zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        break;
      case 'doVoid':
        $order = new order($oID);
        if ($order->info['payment_module_code']) {
          if (file_exists(DIR_FS_CATALOG_MODULES . 'payment/' . $order->info['payment_module_code'] . '.php')) {
            require_once(DIR_FS_CATALOG_MODULES . 'payment/' . $order->info['payment_module_code'] . '.php');
            require_once(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $order->info['payment_module_code'] . '.php');
            $module = new $order->info['payment_module_code'];
            if (method_exists($module, '_doVoid')) {
              $module->_doVoid($oID);
            }
          }
        }
        zen_redirect(zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=edit', 'NONSSL'));
        break;
	  /***************afterbuy module handle*******************/
	  case 'afterbuy_send' :
		//$oID = zen_db_prepare_input($_GET['oID']);
		if (AFTERBUY_ACTIVATED=='true'){
			require_once (DIR_FS_CATALOG.'includes/classes/afterbuy.php');
			$aBUY = new zen_afterbuy($oID);
			if ($aBUY->order_send())
				$aBUY->process_order();
		}
		break;
    }
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" media="print" href="includes/stylesheet_print.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/jquery142.js"></script>
<script type="text/javascript">
  <!--
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  }
  <?php
  if ( $action=='initjs')
  {
      ?>

  function  countSecond()
    {
        $.get("orders.php",
          { action: "ajaxsendxml"
          <?php
          if(isset($_GET['b_time']) && $_GET['b_time']>0)echo ", b_time:\"".$_GET['b_time']."\"";
          if(isset($_GET['e_time']) && $_GET['e_time']>0)echo ", e_time:\"".$_GET['e_time']."\"";
          if(isset($_GET['b_ods']) && $_GET['b_ods']>0)echo ", b_ods:\"".$_GET['b_ods']."\"";
          if(isset($_GET['e_ods']) && $_GET['e_ods']>0)echo ", e_ods:\"".$_GET['e_ods']."\"";
          ?>
            },
          function(data){
  
                    //alert("Data Loaded: " + data);
                    //alert('dddddddddddddd');
          }
        );
        setTimeout("countSecond()", <?php if(empty($_GET['e_init']))echo 7000;else echo $_GET['e_init']?>);
    }
    setTimeout("countSecond()",<?php if(empty($_GET['b_init']))echo 5000;else echo $_GET['b_init']?>);
    //  order.php?action=initjs&b_init=10000&e_init=20000&b_time=100&e_time=10&b_ods=1000&e_ods=1100
  <?php
  }
  ?>
  // -->
</script>
<script language="javascript" type="text/javascript"><!--
function couponpopupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=280,screenX=150,screenY=150,top=150,left=150')
}
//--></script>
</head>
<body onLoad="init()">
<!-- header //-->
<div class="header-area">
<?php
  require(DIR_WS_INCLUDES . 'header.php');
?>
</div>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<!-- body_text //-->

<?php if ($action == '') { ?>
<!-- search -->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
         <tr><?php echo zen_draw_form('search', FILENAME_ORDERS, '', 'get', '', true); ?>
            <td width="65%" class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td colspan="2" class="smallText" align="right">
<?php
// show reset search
  if ((isset($_GET['search']) && zen_not_null($_GET['search'])) or $_GET['cID'] !='') {
    echo '<a href="' . zen_href_link(FILENAME_ORDERS, '', 'NONSSL') . '">' . zen_image_button('button_reset.gif', IMAGE_RESET) . '</a><br />';
  }
?>
<?php
  echo HEADING_TITLE_SEARCH_DETAIL . ' ' . zen_draw_input_field('search') . zen_hide_session_id();
  if (isset($_GET['search']) && zen_not_null($_GET['search'])) {
    $keywords = zen_db_input(zen_db_prepare_input($_GET['search']));
    echo '<br/ >' . TEXT_INFO_SEARCH_DETAIL_FILTER . $keywords;
  }
?>
            </td>
          </form>


         <?php echo zen_draw_form('search_orders_products', FILENAME_ORDERS, '', 'get', '', true); ?>
            <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td colspan="2" class="smallText" align="right">
<?php
// show reset search orders_products
  if ((isset($_GET['search_orders_products']) && zen_not_null($_GET['search_orders_products'])) or $_GET['cID'] !='') {
    echo '<a href="' . zen_href_link(FILENAME_ORDERS, '', 'NONSSL') . '">' . zen_image_button('button_reset.gif', IMAGE_RESET) . '</a><br />';
  }
?>
<?php
  echo HEADING_TITLE_SEARCH_DETAIL_ORDERS_PRODUCTS . ' ' . zen_draw_input_field('search_orders_products') . zen_hide_session_id();
  if (isset($_GET['search_orders_products']) && zen_not_null($_GET['search_orders_products'])) {
    $keywords_orders_products = zen_db_input(zen_db_prepare_input($_GET['search_orders_products']));
    echo '<br/ >' . TEXT_INFO_SEARCH_DETAIL_FILTER_ORDERS_PRODUCTS . zen_db_prepare_input($keywords_orders_products);
  }
?>
            </td>
          </form>

        </table></td>
      </tr>
<!-- search -->
<?php } ?>


<?php
  if (($action == 'edit') && ($order_exists == true)) {
    $order = new order($oID);
	if($_GET['wutest']=='1')
    {
        echo '<pre>';
        print_r($order);
        echo '</pre>';
    }
    if ($order->info['payment_module_code']) {
      if (file_exists(DIR_FS_CATALOG_MODULES . 'payment/' . $order->info['payment_module_code'] . '.php')) {
        require(DIR_FS_CATALOG_MODULES . 'payment/' . $order->info['payment_module_code'] . '.php');
        require(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $order->info['payment_module_code'] . '.php');
        $module = new $order->info['payment_module_code'];
//        echo $module->admin_notification($oID);
      }
    }
    // fec dropdown
    if (FEC_DROP_DOWN == 'true') {
      $drop_down = $db->Execute("SELECT dropdown FROM " . TABLE_ORDERS . " WHERE orders_id = " . $oID . " LIMIT 1");
    }
    // fec checkbox
    if (FEC_CHECKBOX == 'true') {
      $checkbox = $db->Execute("SELECT checkbox FROM " . TABLE_ORDERS . " WHERE orders_id = " . $oID . " LIMIT 1");
    }
?>
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td class="pageHeading" align="right"><?php echo '<a href="javascript:history.back()">' . zen_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td colspan="3"><?php echo zen_draw_separator(); ?></td>
          </tr>
          <tr>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" valign="top"><strong><?php echo ENTRY_CUSTOMER; ?></strong></td>
                <td class="main"><?php echo zen_address_format($order->customer['format_id'], $order->customer, 1, '', '<br />'); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
              </tr>
              <tr>
                <td class="main"><strong><?php echo ENTRY_TELEPHONE_NUMBER; ?></strong></td>
                <td class="main"><?php echo $order->customer['telephone']; ?></td>
              </tr>
              <tr>
                <td class="main"><strong><?php echo ENTRY_EMAIL_ADDRESS; ?></strong></td>
                <td class="main"><?php echo '<a href="mailto:' . $order->customer['email_address'] . '">' . $order->customer['email_address'] . '</a>'; ?></td>
              </tr>
              <tr>
                <td class="main"><strong><?php echo TEXT_INFO_IP_ADDRESS; ?></strong></td>
                <td class="main"><?php echo $order->info['ip_address']; ?></td>
              </tr>
            </table></td>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" valign="top"><strong><?php echo ENTRY_SHIPPING_ADDRESS; ?></strong></td>
                <td class="main"><?php echo zen_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br />'); ?></td>
              </tr>
              <!-- bof FEC v1.24 drop down -->
              <?php if (FEC_DROP_DOWN == 'true') { ?>
              <tr>
                <td class="main" valign="top"><strong><?php echo ENTRY_DROP_DOWN; ?></strong></td>
                <td class="main"><?php echo $drop_down->fields['dropdown']; ?></td>
              </tr>
              <?php } ?>
              <!-- eof dropdown -->
            </table></td>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" valign="top"><strong><?php echo ENTRY_BILLING_ADDRESS; ?></strong></td>
                <td class="main"><?php echo zen_address_format($order->billing['format_id'], $order->billing, 1, '', '<br />'); ?></td>
              </tr>
              <!-- bof FEC CHECKBOX -->
              <?php if (FEC_CHECKBOX == 'true') { ?>
              <tr>
                <td class="main" valign="top"><strong><?php echo ENTRY_CHECKBOX; ?></strong></td>
                <td class="main"><?php echo ($checkbox->fields['checkbox'] == 1 ? 'yes' : 'no'); ?></td>
              </tr>
              <?php } ?>
              <!-- eof FEC CHECKBOX -->
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><strong><?php echo ENTRY_ORDER_ID . $oID; ?></strong></td>
      </tr>
      <tr>
     <td><table border="0" cellspacing="0" cellpadding="2">
        <tr>
           <td class="main"><strong><?php echo ENTRY_DATE_PURCHASED; ?></strong></td>
           <td class="main"><?php echo zen_date_long($order->info['date_purchased']); ?></td>
        </tr>
        <tr>
           <td class="main"><strong><?php echo ENTRY_PAYMENT_METHOD; ?></strong></td>
           <td class="main"><?php echo $order->info['payment_method']; ?></td>
        </tr>
<?php
    if (zen_not_null($order->info['cc_type']) || zen_not_null($order->info['cc_owner']) || zen_not_null($order->info['cc_number'])) {
?>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_TYPE; ?></td>
            <td class="main"><?php echo $order->info['cc_type']; ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_OWNER; ?></td>
            <td class="main"><?php echo $order->info['cc_owner']; ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_NUMBER; ?></td>
            <td class="main"><?php echo $order->info['cc_number'] . (zen_not_null($order->info['cc_number']) && !strstr($order->info['cc_number'],'X') && !strstr($order->info['cc_number'],'********') ? '&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_ORDERS, '&action=mask_cc&oID=' . $oID, 'NONSSL') . '" class="noprint">' . TEXT_MASK_CC_NUMBER . '</a>' : ''); ?><td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_CVV; ?></td>
            <td class="main"><?php echo $order->info['cc_cvv'] . (zen_not_null($order->info['cc_cvv']) && !strstr($order->info['cc_cvv'],TEXT_DELETE_CVV_REPLACEMENT) ? '&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_ORDERS, '&action=delete_cvv&oID=' . $oID, 'NONSSL') . '" class="noprint">' . TEXT_DELETE_CVV_FROM_DATABASE . '</a>' : ''); ?><td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_EXPIRES; ?></td>
            <td class="main"><?php echo $order->info['cc_expires']; ?></td>
          </tr>
<?php
    }
?>
        </table></td>
      </tr>
<?php
      if (method_exists($module, 'admin_notification')) {
?>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <?php echo $module->admin_notification($oID); ?>
      </tr>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
}
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr class="dataTableHeadingRow">
            <td class="dataTableHeadingContent" colspan="2"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
            <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS_MODEL; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRICE_EXCLUDING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRICE_INCLUDING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_EXCLUDING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_INCLUDING_TAX; ?></td>
          </tr>
<?php
    for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
      echo '          <tr class="dataTableRow">' . "\n" .
           '            <td class="dataTableContent" valign="top" align="right">' . $order->products[$i]['qty'] . '&nbsp;x</td>' . "\n" .
           '            <td class="dataTableContent" valign="top">' . $order->products[$i]['name'];

      if (isset($order->products[$i]['attributes']) && (sizeof($order->products[$i]['attributes']) > 0)) {
        for ($j = 0, $k = sizeof($order->products[$i]['attributes']); $j < $k; $j++) {
          echo '<br /><nobr><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . nl2br(zen_output_string_protected($order->products[$i]['attributes'][$j]['value']));
          if ($order->products[$i]['attributes'][$j]['price'] != '0') echo ' (' . $order->products[$i]['attributes'][$j]['prefix'] . $currencies->format($order->products[$i]['attributes'][$j]['price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . ')';
          if ($order->products[$i]['attributes'][$j]['product_attribute_is_free'] == '1' and $order->products[$i]['product_is_free'] == '1') echo TEXT_INFO_ATTRIBUTE_FREE;
          echo '</i></small></nobr>';
        }
      }

      echo '            </td>' . "\n" .
           '            <td class="dataTableContent" valign="top">' . $order->products[$i]['model'] . '</td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top">' . zen_display_tax_value($order->products[$i]['tax']) . '%</td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><strong>' .
                          $currencies->format($order->products[$i]['final_price'], true, $order->info['currency'], $order->info['currency_value']) .
                          ($order->products[$i]['onetime_charges'] != 0 ? '<br />' . $currencies->format($order->products[$i]['onetime_charges'], true, $order->info['currency'], $order->info['currency_value']) : '') .
                        '</strong></td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><strong>' .
                          $currencies->format(zen_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) .
                          ($order->products[$i]['onetime_charges'] != 0 ? '<br />' . $currencies->format(zen_add_tax($order->products[$i]['onetime_charges'], $order->products[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) : '') .
                        '</strong></td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><strong>' .
                          $currencies->format($order->products[$i]['final_price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) .
                          ($order->products[$i]['onetime_charges'] != 0 ? '<br />' . $currencies->format($order->products[$i]['onetime_charges'], true, $order->info['currency'], $order->info['currency_value']) : '') .
                        '</strong></td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><strong>' .
                          $currencies->format(zen_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) .
                          ($order->products[$i]['onetime_charges'] != 0 ? '<br />' . $currencies->format(zen_add_tax($order->products[$i]['onetime_charges'], $order->products[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) : '') .
                        '</strong></td>' . "\n";
      echo '          </tr>' . "\n";
    }
?>
          <tr>
            <td align="right" colspan="8"><table border="0" cellspacing="0" cellpadding="2">
<?php
    for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {
      echo '              <tr>' . "\n" .
           '                <td align="right" class="'. str_replace('_', '-', $order->totals[$i]['class']) . '-Text">' . $order->totals[$i]['title'] . '</td>' . "\n" .
           '                <td align="right" class="'. str_replace('_', '-', $order->totals[$i]['class']) . '-Amount">' . $order->totals[$i]['text'] . '</td>' . "\n" .
           '              </tr>' . "\n";
    }
?>
            </table></td>
          </tr>
        </table></td>
      </tr>
<?php
  if (MODULE_ORDER_TOTAL_DOUBLEBOX_STATUS == 'true') {
    $orders_doublebox = $db->Execute("select orders_products_id  
                                    from " . TABLE_ORDERS_DOUBLEBOX . "  
                                    where orders_id = '" . zen_db_input($oID) . "' and wrap = 1");  

  if ($orders_doublebox->RecordCount() > 0) {
?>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><table border="1" cellspacing="0" cellpadding="5">
          <tr>
            <td class="smallText" align="center"><strong><?php echo DOUBLEBOX_SUMMARY_HEADING; ?></strong></td>
          </tr>
<?php
       while (!$orders_doublebox->EOF) {
          $pos = -1;
          for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
              if ($order->products[$i]['orders_products_id'] == 
                  $orders_doublebox->fields['orders_products_id']) {
                  $pos = $i; 
                  break;
              }
          }
          $orders_doublebox->MoveNext();
          if ($pos == -1) {
             continue; // Should never happen
          }
          $i = $pos; 

          echo '<tr>';
          echo '<td class="accountProductDisplay">' . $order->products[$i]['name'];
          if ( (isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0) ) {
               echo '<br><nobr><small>';
               for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
                       echo '&nbsp;&nbsp;- ' . $order->products[$i]['attributes'][$j]['option'] . ": " . nl2br(zen_output_string_protected($order->products[$i]['attributes'][$j]['value'])) . '<br>';
                    }
               echo '</small></nobr>';
          }
          echo '</td>'; 
          echo '</tr>'; 
       }
?>
        </table></td>
      </tr>
<?php
  } else { 
    echo '<tr><td>'. DOUBLEBOX_NO_TEXT . '</td></tr>'; 
  }
} 
?>
<?php
  if (FEC_GIFT_WRAPPING_SWITCH == 'true') {
    $orders_wrapping = $db->Execute("select orders_products_id  
                                    from " . TABLE_ORDERS_GIFTWRAP . "  
                                    where orders_id = '" . zen_db_input($oID) . "' and wrap = 1");  

    if ($orders_wrapping->RecordCount() > 0) {
?>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><table border="1" cellspacing="0" cellpadding="5" width="100%">
          <tr>
            <td class="smallText" align="center"><strong><?php echo GIFT_WRAP_SUMMARY_HEADING; ?></strong></td>
          </tr>
<?php
       while (!$orders_wrapping->EOF) {
          $pos = -1;
          for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
              if ($order->products[$i]['orders_products_id'] == 
                  $orders_wrapping->fields['orders_products_id']) {
                  $pos = $i; 
                  break;
              }
          }
          $orders_wrapping->MoveNext();
          if ($pos == -1) {
             continue; // Should never happen
          }
          $i = $pos; 

          echo '<tr>';
          echo '<td class="accountProductDisplay">' . $order->products[$i]['name'];
          if ( (isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0) ) {
               echo '<br><nobr><small>';
               for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
                       echo '&nbsp;&nbsp;- ' . $order->products[$i]['attributes'][$j]['option'] . ": " . nl2br(zen_output_string_protected($order->products[$i]['attributes'][$j]['value'])) . '<br>';
                    }
               echo '</small></nobr>';
          }
          echo '</td>'; 
          echo '</tr>'; 
       }
?>
        </table></td>
      </tr>
<?php
    } else { 
      echo '<tr><td>'. GIFT_WRAP_NO_TEXT . '</td></tr>'; 
    }
  } 
?>
<?php
  // show downloads
  require(DIR_WS_MODULES . 'orders_download.php');
?>

      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><table border="1" cellspacing="0" cellpadding="5">
          <tr>
            <td class="smallText" align="center"><strong><?php echo TABLE_HEADING_DATE_ADDED; ?></strong></td>
            <td class="smallText" align="center"><strong><?php echo TABLE_HEADING_CUSTOMER_NOTIFIED; ?></strong></td>
            <td class="smallText" align="center"><strong><?php echo TABLE_HEADING_STATUS; ?></strong></td>
            <td class="smallText" align="center"><strong><?php echo TABLE_HEADING_COMMENTS; ?></strong></td>
          </tr>
<?php
    $orders_history = $db->Execute("select orders_status_id, date_added, customer_notified, comments
                                    from " . TABLE_ORDERS_STATUS_HISTORY . "
                                    where orders_id = '" . zen_db_input($oID) . "'
                                    order by date_added");

    if ($orders_history->RecordCount() > 0) {
      while (!$orders_history->EOF) {
        echo '          <tr>' . "\n" .
             '            <td class="smallText" align="center">' . zen_datetime_short($orders_history->fields['date_added']) . '</td>' . "\n" .
             '            <td class="smallText" align="center">';
        if ($orders_history->fields['customer_notified'] == '1') {
          echo zen_image(DIR_WS_ICONS . 'tick.gif', ICON_TICK) . "</td>\n";
        } else {
          echo zen_image(DIR_WS_ICONS . 'cross.gif', ICON_CROSS) . "</td>\n";
        }
        echo '            <td class="smallText">' . $orders_status_array[$orders_history->fields['orders_status_id']] . '</td>' . "\n";
        echo '            <td class="smallText">' . nl2br(zen_db_output($orders_history->fields['comments'])) . '&nbsp;</td>' . "\n" .
             '          </tr>' . "\n";
        $orders_history->MoveNext();
      }
    } else {
        echo '          <tr>' . "\n" .
             '            <td class="smallText" colspan="5">' . TEXT_NO_ORDER_HISTORY . '</td>' . "\n" .
             '          </tr>' . "\n";
    }
?>
        </table></td>
      </tr>
      <tr>
        <td class="main noprint"><br /><strong><?php echo TABLE_HEADING_COMMENTS; ?></strong></td>
      </tr>
      <tr>
        <td class="noprint"><?php echo zen_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
      </tr>
      <tr><?php echo zen_draw_form('status', FILENAME_ORDERS, zen_get_all_get_params(array('action')) . 'action=update_order', 'post', '', true); ?>
        <td class="main noprint"><?php echo zen_draw_textarea_field('comments', 'soft', '60', '5'); ?></td>
      </tr>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="2" class="noprint">
          <tr>
            <td><table border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main"><strong><?php echo ENTRY_STATUS; ?></strong> <?php echo zen_draw_pull_down_menu('status', $orders_statuses, $order->info['orders_status']); ?></td>
              </tr>
              <tr>
                <td class="main"><strong><?php echo ENTRY_NOTIFY_CUSTOMER; ?></strong> <?php echo zen_draw_checkbox_field('notify', '', true); ?></td>
                <td class="main"><strong><?php echo ENTRY_NOTIFY_COMMENTS; ?></strong> <?php echo zen_draw_checkbox_field('notify_comments', '', true); ?></td>
              </tr>
            </table></td>
            <td valign="top"><?php echo zen_image_submit('button_update.gif', IMAGE_UPDATE); ?></td>
          </tr>
        </table></td>
      </form></tr>
      <tr>
        <td colspan="2" align="right" class="noprint"><?php echo '<a href="' . zen_href_link(FILENAME_ORDERS_INVOICE, 'oID=' . $_GET['oID']) . '" TARGET="_blank">' . zen_image_button('button_invoice.gif', IMAGE_ORDERS_INVOICE) . '</a> <a href="' . zen_href_link(FILENAME_ORDERS_PACKINGSLIP, 'oID=' . $_GET['oID']) . '" TARGET="_blank">' . zen_image_button('button_packingslip.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a> <a href="' . zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('action'))) . '">' . zen_image_button('button_orders.gif', IMAGE_ORDERS) . '</a>'; ?></td>
      </tr>
<?php
// check if order has open gv
        $gv_check = $db->Execute("select order_id, unique_id
                                  from " . TABLE_COUPON_GV_QUEUE ."
                                  where order_id = '" . $_GET['oID'] . "' and release_flag='N' limit 1");
        if ($gv_check->RecordCount() > 0) {
          $goto_gv = '<a href="' . zen_href_link(FILENAME_GV_QUEUE, 'order=' . $_GET['oID']) . '">' . zen_image_button('button_gift_queue.gif',IMAGE_GIFT_QUEUE) . '</a>';
          echo '      <tr><td align="right"><table width="225"><tr>';
          echo '        <td align="center">';
          echo $goto_gv . '&nbsp;&nbsp;';
          echo '        </td>';
          echo '      </tr></table></td></tr>';
        }
?>
<?php
  } else {
?>
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td align="right"><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr><?php echo zen_draw_form('orders', FILENAME_ORDERS, '', 'get', '', true); ?>
                <td class="smallText" align="right"><?php echo HEADING_TITLE_SEARCH . ' ' . zen_draw_input_field('oID', '', 'size="12"') . zen_draw_hidden_field('action', 'edit') . zen_hide_session_id(); ?></td>
              </form></tr>
              <tr><?php echo zen_draw_form('status', FILENAME_ORDERS, '', 'get', '', true); ?>
                <td class="smallText" align="right">
                  <?php
                    echo HEADING_TITLE_STATUS . ' ' . zen_draw_pull_down_menu('status', array_merge(array(array('id' => '', 'text' => TEXT_ALL_ORDERS)), $orders_statuses), $_GET['status'], 'onChange="this.form.submit();"');
                    echo zen_hide_session_id();
                  ?>
                </td>
              </form></tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="smallText"><?php echo TEXT_LEGEND . ' ' . zen_image(DIR_WS_IMAGES . 'icon_status_red.gif', TEXT_BILLING_SHIPPING_MISMATCH, 10, 10) . ' ' . TEXT_BILLING_SHIPPING_MISMATCH; ?>
          </td>
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
<?php
// Sort Listing
          switch ($_GET['list_order']) {
              case "id-asc":
              $disp_order = "c.customers_id";
              break;
              case "firstname":
              $disp_order = "c.customers_firstname";
              break;
              case "firstname-desc":
              $disp_order = "c.customers_firstname DESC";
              break;
              case "lastname":
              $disp_order = "c.customers_lastname, c.customers_firstname";
              break;
              case "lastname-desc":
              $disp_order = "c.customers_lastname DESC, c.customers_firstname";
              break;
              case "company":
              $disp_order = "a.entry_company";
              break;
              case "company-desc":
              $disp_order = "a.entry_company DESC";
              break;
              default:
              $disp_order = "c.customers_id DESC";
          }
?>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_ORDERS_ID; ?></td>
                <td class="dataTableHeadingContent" align="left" width="50"><?php echo TABLE_HEADING_PAYMENT_METHOD; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CUSTOMERS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ORDER_TOTAL; ?></td>                                
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_DATE_PURCHASED; ?></td>
				<?php if (AFTERBUY_ACTIVATED=='true') {//add by john 2010-04-30 ?>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_AFTERBUY; ?></td>
                <?php } ?>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_CUSTOMER_COMMENTS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>

<?php
// Only one or the other search
// create search_orders_products filter
  $search = '';
  $new_table = '';
  $new_fields = '';
  if (isset($_GET['search_orders_products']) && zen_not_null($_GET['search_orders_products'])) {
    $new_fields = '';
    $search_distinct = ' distinct ';
    $new_table = " left join " . TABLE_ORDERS_PRODUCTS . " op on (op.orders_id = o.orders_id) ";
    $keywords = zen_db_input(zen_db_prepare_input($_GET['search_orders_products']));
    $search = " and (op.products_model like '%" . $keywords . "%' or op.products_name like '" . $keywords . "%')";
    if (substr(strtoupper($_GET['search_orders_products']), 0, 3) == 'ID:') {
      $keywords = TRIM(substr($_GET['search_orders_products'], 3));
      $search = " and op.products_id ='" . (int)$keywords . "'";
    }
  } else {
?>
<?php
// create search filter
  $search = '';
  if (isset($_GET['search']) && zen_not_null($_GET['search'])) {
    $search_distinct = ' ';
    $keywords = zen_db_input(zen_db_prepare_input($_GET['search']));
    $search = " and (o.customers_city like '%" . $keywords . "%' or o.customers_postcode like '%" . $keywords . "%' or o.date_purchased like '%" . $keywords . "%' or o.billing_name like '%" . $keywords . "%' or o.billing_company like '%" . $keywords . "%' or o.billing_street_address like '%" . $keywords . "%' or o.delivery_city like '%" . $keywords . "%' or o.delivery_postcode like '%" . $keywords . "%' or o.delivery_name like '%" . $keywords . "%' or o.delivery_company like '%" . $keywords . "%' or o.delivery_street_address like '%" . $keywords . "%' or o.billing_city like '%" . $keywords . "%' or o.billing_postcode like '%" . $keywords . "%' or o.customers_email_address like '%" . $keywords . "%' or o.customers_name like '%" . $keywords . "%' or o.customers_company like '%" . $keywords . "%' or o.customers_street_address  like '%" . $keywords . "%' or o.customers_telephone like '%" . $keywords . "%' or o.ip_address  like '%" . $keywords . "%')";
    $new_table = '';
//    $new_fields = ", o.customers_company, o.customers_email_address, o.customers_street_address, o.delivery_company, o.delivery_name, o.delivery_street_address, o.billing_company, o.billing_name, o.billing_street_address, o.payment_module_code, o.shipping_module_code, o.ip_address ";
  }
} // eof: search orders or orders_products
    $new_fields = ", o.customers_company, o.customers_email_address, o.customers_street_address, o.delivery_company, o.delivery_name, o.delivery_street_address, o.billing_company, o.billing_name, o.billing_street_address, o.payment_module_code, o.shipping_module_code, o.ip_address ";
?>
<?php
    if (isset($_GET['cID'])) {
      $cID = zen_db_prepare_input($_GET['cID']);
      $orders_query_raw =   "select o.afterbuy_success,o.afterbuy_id,o.orders_id, o.customers_id, o.customers_name, o.payment_method, o.shipping_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total" .
                            $new_fields . "
                            from (" . TABLE_ORDERS_STATUS . " s, " .
                            TABLE_ORDERS . " o " .
                            $new_table . ")
                            left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id) " . "
                            where o.customers_id = '" . (int)$cID . "' and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$_SESSION['languages_id'] . "' and ot.class = 'ot_total' order by orders_id DESC";

//echo '<BR><BR>I SEE A: ' . $orders_query_raw . '<BR><BR>';

    } elseif ($_GET['status'] != '') {
      $status = zen_db_prepare_input($_GET['status']);
      $orders_query_raw = "select o.afterbuy_success,o.afterbuy_id,o.orders_id, o.customers_id, o.customers_name, o.payment_method, o.shipping_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total" .
                          $new_fields . "
                          from (" . TABLE_ORDERS_STATUS . " s, " .
                            TABLE_ORDERS . " o " .
                          $new_table . ")
                          left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id) " . "
                          where o.orders_status = s.orders_status_id and s.language_id = '" . (int)$_SESSION['languages_id'] . "' and s.orders_status_id = '" . (int)$status . "' and ot.class = 'ot_total'  " .
                          $search . " order by o.orders_id DESC";

//echo '<BR><BR>I SEE B: ' . $orders_query_raw . '<BR><BR>';

    } else {
      $orders_query_raw = "select " . $search_distinct . " o.orders_id,o.afterbuy_success,o.afterbuy_id, o.customers_id, o.customers_name, o.payment_method, o.shipping_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total" .
                          $new_fields . "
                          from (" . TABLE_ORDERS_STATUS . " s, " .
                            TABLE_ORDERS . " o " .
                          $new_table . ")
                          left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id) " . "
                          where (o.orders_status = s.orders_status_id and s.language_id = '" . (int)$_SESSION['languages_id'] . "' and ot.class = 'ot_total')  " .
                          $search . " order by o.orders_id DESC";

//echo '<BR><BR>I SEE C: ' . $orders_query_raw . '<BR><BR>';

    }

// Split Page
// reset page when page is unknown
if (($_GET['page'] == '' or $_GET['page'] <= 1) and $_GET['oID'] != '') {
  $check_page = $db->Execute($orders_query_raw);
  $check_count=1;
  if ($check_page->RecordCount() > MAX_DISPLAY_SEARCH_RESULTS_ORDERS) {
    while (!$check_page->EOF) {
      if ($check_page->fields['orders_id'] == $_GET['oID']) {
        break;
      }
      $check_count++;
      $check_page->MoveNext();
    }
    $_GET['page'] = round((($check_count/MAX_DISPLAY_SEARCH_RESULTS_ORDERS)+(fmod_round($check_count,MAX_DISPLAY_SEARCH_RESULTS_ORDERS) !=0 ? .5 : 0)),0);
  } else {
    $_GET['page'] = 1;
  }
}

//    $orders_query_numrows = '';
    $orders_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_ORDERS, $orders_query_raw, $orders_query_numrows);
    $orders = $db->Execute($orders_query_raw);
    while (!$orders->EOF) {
    if ((!isset($_GET['oID']) || (isset($_GET['oID']) && ($_GET['oID'] == $orders->fields['orders_id']))) && !isset($oInfo)) {
        $oInfo = new objectInfo($orders->fields);
      }

      if (isset($oInfo) && is_object($oInfo) && ($orders->fields['orders_id'] == $oInfo->orders_id)) {
        echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=edit', 'NONSSL') . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID')) . 'oID=' . $orders->fields['orders_id'], 'NONSSL') . '\'">' . "\n";
      }

      $show_difference = '';
      if (($orders->fields['delivery_name'] != $orders->fields['billing_name'] and $orders->fields['delivery_name'] != '')) {
        $show_difference = zen_image(DIR_WS_IMAGES . 'icon_status_red.gif', TEXT_BILLING_SHIPPING_MISMATCH, 10, 10) . '&nbsp;';
      }
      if (($orders->fields['delivery_street_address'] != $orders->fields['billing_street_address'] and $orders->fields['delivery_street_address'] != '')) {
        $show_difference = zen_image(DIR_WS_IMAGES . 'icon_status_red.gif', TEXT_BILLING_SHIPPING_MISMATCH, 10, 10) . '&nbsp;';
      }
      $show_payment_type = $orders->fields['payment_module_code'] . '<br />' . $orders->fields['shipping_module_code'];
?>
                <td class="dataTableContent" align="right"><?php echo $show_difference . $orders->fields['orders_id']; ?></td>
                <td class="dataTableContent" align="left" width="50"><?php echo $show_payment_type; ?></td>
                <td class="dataTableContent"><?php echo '<a href="' . zen_href_link(FILENAME_CUSTOMERS, 'cID=' . $orders->fields['customers_id'], 'NONSSL') . '">' . zen_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW . ' ' . TABLE_HEADING_CUSTOMERS) . '</a>&nbsp;' . $orders->fields['customers_name'] . ($orders->fields['customers_company'] != '' ? '<br />' . $orders->fields['customers_company'] : ''); ?></td>
                <td class="dataTableContent" align="right"><?php echo strip_tags($orders->fields['order_total']); ?></td>                
                <td class="dataTableContent" align="center"><?php echo zen_datetime_short($orders->fields['date_purchased']); ?></td>
				<?php if (AFTERBUY_ACTIVATED=='true') { //added by john 2010-04-30?>
                <td class="dataTableContent" align="right">
				<?php		
					if ($orders->fields['afterbuy_success'] == 1) {
						echo $orders->fields['afterbuy_id'];
					} else {
						echo 'TRANSMISSION_ERROR';
					}
				?>
                </td>
                <?php } ?>
                <td class="dataTableContent" align="right"><?php echo $orders->fields['orders_status_name']; ?></td>
                <td class="dataTableContent" align="center"><?php echo (zen_get_orders_comments($orders->fields['orders_id']) == '' ? '' : zen_image(DIR_WS_IMAGES . 'icon_yellow_on.gif', TEXT_COMMENTS_YES, 16, 16)); ?></td>

                <td class="dataTableContent" align="right"><?php echo '<a href="' . zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')) . 'oID=' . $orders->fields['orders_id'] . '&action=edit', 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT) . '</a>'; ?><?php if (isset($oInfo) && is_object($oInfo) && ($orders->fields['orders_id'] == $oInfo->orders_id)) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID')) . 'oID=' . $orders->fields['orders_id'], 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
      $orders->MoveNext();
    }
?>
              <tr>
                <td colspan="5"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $orders_split->display_count($orders_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_ORDERS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS); ?></td>
                    <td class="smallText" align="right"><?php echo $orders_split->display_links($orders_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_ORDERS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'oID', 'action'))); ?></td>
                  </tr>
<?php
  if (isset($_GET['search']) && zen_not_null($_GET['search'])) {
?>
                  <tr>
                    <td class="smallText" align="right" colspan="2">
                      <?php
                        echo '<a href="' . zen_href_link(FILENAME_ORDERS, '', 'NONSSL') . '">' . zen_image_button('button_reset.gif', IMAGE_RESET) . '</a>';
                        if (isset($_GET['search']) && zen_not_null($_GET['search'])) {
                          $keywords = zen_db_input(zen_db_prepare_input($_GET['search']));
                          echo '<br/ >' . TEXT_INFO_SEARCH_DETAIL_FILTER . $keywords;
                        }
                      ?>
                    </td>
                  </tr>
<?php
  }
?>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'delete':
      $heading[] = array('text' => '<strong>' . TEXT_INFO_HEADING_DELETE_ORDER . '</strong>');

      $contents = array('form' => zen_draw_form('orders', FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=deleteconfirm', 'post', '', true));
//      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO . '<br /><br /><strong>' . $cInfo->customers_firstname . ' ' . $cInfo->customers_lastname . '</strong>');
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO . '<br /><br /><strong>' . ENTRY_ORDER_ID . $oInfo->orders_id . '<br />' . $oInfo->order_total . '<br />' . $oInfo->customers_name . ($oInfo->customers_company != '' ? '<br />' . $oInfo->customers_company : '') . '</strong>');
      $contents[] = array('text' => '<br />' . zen_draw_checkbox_field('restock') . ' ' . TEXT_INFO_RESTOCK_PRODUCT_QUANTITY);
      $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id, 'NONSSL') . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    default:
      if (isset($oInfo) && is_object($oInfo)) {
        $heading[] = array('text' => '<strong>[' . $oInfo->orders_id . ']&nbsp;&nbsp;' . zen_datetime_short($oInfo->date_purchased) . '</strong>');

        $contents[] = array('align' => 'center', 'text' => '<a href="' . zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=edit', 'NONSSL') . '">' . zen_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . zen_href_link(FILENAME_ORDERS, zen_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=delete', 'NONSSL') . '">' . zen_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
        $contents[] = array('align' => 'center', 'text' => '<a href="' . zen_href_link(FILENAME_ORDERS_INVOICE, 'oID=' . $oInfo->orders_id) . '" TARGET="_blank">' . zen_image_button('button_invoice.gif', IMAGE_ORDERS_INVOICE) . '</a> <a href="' . zen_href_link(FILENAME_ORDERS_PACKINGSLIP, 'oID=' . $oInfo->orders_id) . '" TARGET="_blank">' . zen_image_button('button_packingslip.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a>');
        $contents[] = array('text' => '<br />' . TEXT_DATE_ORDER_CREATED . ' ' . zen_date_short($oInfo->date_purchased));
        $contents[] = array('text' => '<br />' . $oInfo->customers_email_address);
        $contents[] = array('text' => TEXT_INFO_IP_ADDRESS . ' ' . $oInfo->ip_address);
        if (zen_not_null($oInfo->last_modified)) $contents[] = array('text' => TEXT_DATE_ORDER_LAST_MODIFIED . ' ' . zen_date_short($oInfo->last_modified));
        $contents[] = array('text' => '<br />' . TEXT_INFO_PAYMENT_METHOD . ' '  . $oInfo->payment_method);
        $contents[] = array('text' => '<br />' . ENTRY_SHIPPING . ' '  . $oInfo->shipping_method);

// check if order has open gv
        $gv_check = $db->Execute("select order_id, unique_id
                                  from " . TABLE_COUPON_GV_QUEUE ."
                                  where order_id = '" . $oInfo->orders_id . "' and release_flag='N' limit 1");
        if ($gv_check->RecordCount() > 0) {
          $goto_gv = '<a href="' . zen_href_link(FILENAME_GV_QUEUE, 'order=' . $oInfo->orders_id) . '">' . zen_image_button('button_gift_queue.gif',IMAGE_GIFT_QUEUE) . '</a>';
          $contents[] = array('text' => '<br />' . zen_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','3'));
          $contents[] = array('align' => 'center', 'text' => $goto_gv);
        }
      }

// indicate if comments exist
      $orders_history_query = $db->Execute("select orders_status_id, date_added, customer_notified, comments from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = '" . $oInfo->orders_id . "' and comments !='" . "'" );
      if ($orders_history_query->RecordCount() > 0) {
        $contents[] = array('align' => 'left', 'text' => '<br />' . TABLE_HEADING_COMMENTS);
      }

      $contents[] = array('text' => '<br />' . zen_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','3'));
      $order = new order($oInfo->orders_id);
      $contents[] = array('text' => 'Products Ordered: ' . sizeof($order->products) );
      for ($i=0; $i<sizeof($order->products); $i++) {
        $contents[] = array('text' => $order->products[$i]['qty'] . '&nbsp;x&nbsp;' . $order->products[$i]['name']);

        if (sizeof($order->products[$i]['attributes']) > 0) {
          for ($j=0; $j<sizeof($order->products[$i]['attributes']); $j++) {
            $contents[] = array('text' => '&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . nl2br(zen_output_string_protected($order->products[$i]['attributes'][$j]['value'])) . '</i></nobr>' );
          }
        }
        if ($i > MAX_DISPLAY_RESULTS_ORDERS_DETAILS_LISTING and MAX_DISPLAY_RESULTS_ORDERS_DETAILS_LISTING != 0) {
          $contents[] = array('align' => 'left', 'text' => TEXT_MORE);
          break;
        }
      }

      /*if (sizeof($order->products) > 0) {
        $contents[] = array('align' => 'center', 
							'text' => '<a href="' . zen_href_link(FILENAME_ORDERS, 
																  zen_get_all_get_params(array('oID', 'action')) 
																  . 'oID=' . $oInfo->orders_id . '&action=edit', 'NONSSL') . '">
							           ' . zen_image_button('button_edit.gif', IMAGE_EDIT) . 
									   '</a>');
      }*/
	  if (AFTERBUY_ACTIVATED == 'true' && $oInfo->afterbuy_success == 0) {
	     $contents[] = array('align' => 'center', 
							 'text' => '<a href="' . zen_href_link(FILENAME_ORDERS, 
																  zen_get_all_get_params(array('oID', 'action')) 
																  . 'oID=' . $oInfo->orders_id . '&action=afterbuy_send', 'NONSSL') . '">
							           ' . zen_image_button('button_afterbuy_send.gif', IMAGE_EDIT) . 
									   '</a>');
	  }
      break;
  }

  if ( (zen_not_null($heading)) && (zen_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<div class="footer-area">
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</div>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>