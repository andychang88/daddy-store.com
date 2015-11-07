<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2005 Joshua Dechant                               |
// |                                                                      |   
// | Portions Copyright (c) 2004 The zen-cart developers                  |
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
// $Id: seo.php
//


  /*
   * added by changanti
   * add reword pointers
   * called /itmyefox/includes/modules/bluemood/easy_create_account.php 
   */
$web_plat=HTTP_SERVER;
$web_platname="10032";
$salt='12312@#$%~~*&^^f';

	function addRewardPointersForRecommender(){
		if(isset($_SESSION['from_recommend'])){
			$sid=(int)$_SESSION['from_recommend'];
			$uid=(int)$_SESSION['customer_id'];
			
			//
			if($uid && $uid==$sid){
				unset($_SESSION['from_recommend']);
				return;
			}
			
			$add_time=date('Y-m-d H:i:s');
			if(defined('REWARD_POINT_FOR_RECOMMENDER') && defined('REWARD_POINT_MODE')){
				$reward_points=(int)REWARD_POINT_FOR_RECOMMENDER;
			}else{
				return;//没有安装积分插件
				//$reward_points=1;
			}
			
			global $db;
			$query = "insert into 2011recommend(user_id,from_user_id,add_time,reward_points)values
			('$uid','$sid','$add_time','$reward_points')";
			$db->Execute($query);
			
			$query = "select * from reward_customer_points where customers_id=$sid limit 1";
			$result = $db->Execute($query);
			$cur_points = $result->fields['reward_points'];
			$new_points = $cur_points + $reward_points;
			$query = "update reward_customer_points set reward_points='".$new_points."' where customers_id=$sid limit 1";
			$db->Execute($query);
			
			unset($_SESSION['from_recommend']);
		}
	}
  /*
   * added by changanti
   * if a user is from recommend,reward pointers
   * called index.php
   */
  function isFromRecommend(){
  		$sid = (int)$_GET['sid'];
	  if(empty($sid)){
	  	return;
	  }
	  
	  global $db;
	  $query = "select count(*) as total from customers where customers_id=:customers_id";
	  $query=$db->bindVars($query, ":customers_id", $sid, "integer");
	  $result = $db->Execute($query);
	  if($result->RecordCount()>0){
	  	$_SESSION['from_recommend']=$sid;
	  }else{
	  	$_SESSION['from_recommend']=0;
	  }
	  
	  
  }
    /*
   * added by changanti
   * called /itmyefox/includes/modules/bluemood/easy_create_account.php 
   */
   function getCustomConfig($item_key,$is_return_arr=false,$return_arr=array()){
   	 global $db;
  	 $query = "select item_value from 2011recommend_config where item_key=:item_key limit 1";
	  $query=$db->bindVars($query, ":item_key", $item_key, "string");
	  $result = $db->Execute($query);
	  if($result->RecordCount()>0){
	  	if($is_return_arr){
	  		
	  		$str=$result->fields['item_value'];
	  		if(!isset($return_arr['sep1'])){
	  			$return_arr['sep1']=',';
	  		}
	  		if( !isset($return_arr['sep2'])){
	  			$return_arr['sep2']='=';
	  		}
	  		


	  		
		  	$tmp_types_arr=explode($return_arr['sep1'], $str);
			$types_arr=array();
			foreach ($tmp_types_arr as $type){
				$tmp=explode($return_arr['sep2'], $type);
				if(count($tmp)==2){
					$types_arr[$tmp[0]]=$tmp[1];
				}
			}
			
			return $types_arr;
	  		
	  	}else{
	  		return $result->fields['item_value'];
	  	}
	  	
	  }else{
	  	return '';
	  }
   }
       /*
   * added by changanti
   */
  function getERPInterface($key,$test_host){
  	global $web_platname;
  	if(empty($web_platname)){
  		$web_platname=":platname";
  	}
  	if(strpos($_SERVER[HTTP_HOST], 'www')!==false){
  		$port='';
  	}else{
  		$port=':8445';
  	}
  	
  	if(!empty($test_host)){
  		$base_name=$test_host.'/crmsfa/control/';
  	}else{
  		$base_name='https://www.aukey888.com'.$port.'/crmsfa/control/';
  	}

  	$arr=array(
  	/*收藏商品*/'favorite_good'=>$base_name.'favouriteReceiver?product_id=:product_id&platname='.$web_platname,
  	/*降价通知*/'price_notice'=>$base_name.'priceCutReceiver?products_id=:products_id&platname='.$web_platname.'&email=:email&my_price=:my_price',
  	/*添加用户投诉*/'complaint'=>$base_name.'complaintReceiver?platname='.$web_platname.'&orderid=:orderid&cid=:cid&type=:type&content=:content',
  	/*退换货*/'refund'=>$base_name.'refundReceiver?orders_id=:orders_id&product=:product&return_type=:return_type&customers_name=:customers_name&telphone=:telphone&email=:email&address=:address&apply_reason=:apply_reason',
  	);
  	if(in_array($key, array_keys($arr))){
  		return $arr[$key];
  	}else{
  		return '';
  	}
  }
?>