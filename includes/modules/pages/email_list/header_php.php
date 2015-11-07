<?php
/**
 * index header_php.php
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 4371 2006-09-03 19:36:11Z ajeh $
 */

// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_INDEX');


        
function getIP()
{
	$ip='';
	
	if (getenv("HTTP_CLIENT_IP"))
		$ip = getenv("HTTP_CLIENT_IP");
	else if(getenv("HTTP_X_FORWARDED_FOR"))
		$ip = getenv("HTTP_X_FORWARDED_FOR");
	else if(getenv("REMOTE_ADDR"))
		$ip = getenv("REMOTE_ADDR");
	else 
		$ip = "Unknow";
		
	return $ip;
}





$act = $_GET['act'];
$products_id = (int)$_GET['id'];

$email = base64_decode($_REQUEST['email']);
$email_list_tag = (int)$_REQUEST['email_list_tag'];


$add_time = date("Y-m-d H:i:s");
        $remote_ip = getIP();
        
        


if(empty($act)){
  zen_redirect(HTTP_SERVER);

        exit;
}

//检查邮件地址是否可发邮件
if($act == 'check_is_accept_email'){
	
	//检查用户是否取消了订阅邮件
	$where = " email='".$email."'  and remote_ip='400' ";       
	$sql_query = "select id from `products_viewed_stat` where ".$where;
		
	$result_viewed_num = $db->Execute($sql_query);
	if($result_viewed->RecordCount()>0){
		echo '0';exit;
	}
	
	//检查该轮是否已经发送过，如果已经发送过，不再发送
	$where = " email='".$email."'  and viewed_num='$email_list_tag' ";
        
	$sql_query = "select id from `products_viewed_stat` where ".$where;
		
	$result_viewed_num = $db->Execute($sql_query);
	if($result_viewed->RecordCount()>0){
		echo '0';exit;
	}
	
	echo '1';exit;
  
  
  
}

if($act == 'email_init'){
  
       

        $sql_update = "insert into  `products_viewed_stat` (products_id,email,remote_ip,viewed_num,add_time)
          values('0','$email','0','$email_list_tag','$add_time')";
        
        $db->Execute($sql_update);
        
        echo 'success';
        exit;
}

//统计用户点击了邮件链接，进入到了网站
if($act == 'email_count'){
  
        if(empty($products_id)){
          die("error:empty products_id");
        }

        $where = " email='".$email."' and products_id=0 and remote_ip=0 and viewed_num=0";
        
        $sql_query = "select id from `products_viewed_stat` where ".$where;
        
        $result_viewed_num = $db->Execute($sql_query);
        
	//首次点击，更新初始化的记录
        if($result_viewed_num->RecordCount()>0){
		
		$tmp_id= $result_viewed_num->fields['id'];
		
		$sql_update = "update  `products_viewed_stat`  set products_id='$products_id', email='$email',
		remote_ip='$remote_ip', viewed_num='$email_list_tag', opened_time='$add_time' where id=".$tmp_id;

	}else{
		
		 $where = " email='".$email."' and products_id='$products_id' and remote_ip='$remote_ip' ";
        
		$sql_query = "select id,viewed_num from `products_viewed_stat` where ".$where;
		
		$result_viewed_num = $db->Execute($sql_query);
		
		//多次点击，累计次数
		if($result_viewed_num->RecordCount()>0){
			
			$tmp_id= $result_viewed_num->fields['id'];
			$tmp_viewed_num= $result_viewed_num->fields['viewed_num'] +1;
			
			$sql_update = "update  `products_viewed_stat`  set viewed_num='$tmp_viewed_num',opened_time='$add_time' where id=".$tmp_id;
			
		}else{
			//首次点击，插入一个新记录
			$sql_update = "insert into  `products_viewed_stat` (products_id,email,remote_ip,viewed_num,opened_time)
		  values('$products_id','$email','$remote_ip','$email_list_tag','$add_time')";
		  
		}
		
	}
        
        
        $db->Execute($sql_update);
        
        
        zen_redirect(zen_href_link(zen_get_info_page($products_id), ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id='.$products_id ));
        
        
        exit;
}



if($act == 'del_unsubscriber'){
  
  $sql_query = "delete from `products_viewed_stat`  where email='".$email."' and remote_ip='400'";

  $db->Execute($sql_query);

}

if($act == 'unsubscribe'){
  $sql_query = "select email from `products_viewed_stat`  where email='".$email."' and remote_ip='400'";

  $result_viewed = $db->Execute($sql_query);
  
  $email_viewed = array();
  
  if($result_viewed->RecordCount()==0){
    
    $sql_update = "insert into  `products_viewed_stat` (products_id,email,remote_ip,viewed_num,add_time)
          values('0','$email','400','0','$add_time')";
        
        $db->Execute($sql_update);
  }
  
  
}


if($act == 'email_list'){
  $sql_query = "select * from `products_viewed_stat`  ";

  $result_viewed = $db->Execute($sql_query);
  
  $email_viewed = array();
  $email_viewed_unsubscribe = array();
  
  
  if($result_viewed->RecordCount()>0){
    while (!$result_viewed->EOF) {
      
      if($result_viewed->fields['remote_ip'] == '400'){
        
        $email_viewed_unsubscribe[] = $result_viewed->fields;
        
      }else{
        
        $email_viewed[] = $result_viewed->fields;
        
      }
      
  
      
      $result_viewed->MoveNext();
    }
  }
  
  
}

//echo '<pre>';print_r($email_viewed);exit;
	
	


// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_INDEX');
?>