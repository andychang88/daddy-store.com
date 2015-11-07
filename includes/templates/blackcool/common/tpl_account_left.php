<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account.<br />
 * Displays previous orders and options to change various Customer Account settings
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_account_default.php 4086 2006-08-07 02:06:18Z ajeh $
 */
//已经阅读的系统消息数目
$query = "select message_id from 2011system_message_history where customers_id = '". $_SESSION['customer_id']."' group by message_id";
$readed_result = $db->Execute($query);
$readed_arr = array();
while(!$readed_result->EOF){
	$readed_arr[] = $readed_result->fields['message_id'];
	$readed_result->MoveNext();
}

if(count($readed_arr) > 0){
	$readed_str = '('.implode(',', $readed_arr).')';
}else{
	$readed_str = '';
}


//共有的系统消息数目
$query = "select count(*) as num from 2011system_message ";

if(!empty($readed_str)){
	$query .= " where message_id NOT IN " . $readed_str;
}
$total_result = $db->Execute($query);
//没有阅读的数目
$unread_message_num = $total_result->fields['num'];

 $menus=array();
 $menus[]=array(
 'title'=>NAV_TRADING_CENTER,
 'class'=>'ucicon_01',
 'submenus'=>array(
 					array('title'=>NAV_ORDER_CENTER,'page'=>'my_orders'),
 			)
 );
 if(isset($unread_message_num) && $unread_message_num>0){
 	$system_message_title = ' <span class="unread_num" >('.$unread_message_num.')</span>';
 }else{
 	$system_message_title = '';
 }
 $menus[]=array(
 'title'=>NAV_SERVICE_CENTER,
 'class'=>'ucicon_02',
 'submenus'=>array(
 					//array('title'=>NAV_MY_CONSULT,'page'=>'my_consult'),
 					array('title'=>NAV_COMPLAINT,'page'=>'my_complaint'),
 					array('title'=>NAV_REFUND_REQUEST,'page'=>'my_refund'),
 					array('title'=>NAV_SYSTEM_MESSAGE.$system_message_title,'page'=>'my_system_message'),
 			)
 );
 
 
 $menus[]=array(
 'title'=>NAV_ACCOUNT_CENTER,
 'class'=>'ucicon_04',
 'submenus'=>array(
 					//array('title'=>NAV_PERSONAL_INFO,'page'=>'my_account'),
 					array('title'=>NAV_CHANGE_PASSWORD,'page'=>'my_password'),
 					array('title'=>NAV_MY_ADDRESS_BOOK,'page'=>'my_address_book'),
 					//array('title'=>NAV_COUPON,'page'=>'my_coupon'),
 			)
 );
 
 
  $menus[]=array(
 'title'=>NAV_APPLICATION,
 'class'=>'ucicon_03',
 'submenus'=>array(
 					array('title'=>NAV_MY_FAVORITE,'page'=>'my_favorite'),
 					//array('title'=>NAV_REVIEWS,'page'=>'my_reviews'),
 					array('title'=>NAV_MY_RECOMMEND,'page'=>'my_recommend'),
 					
 			)
 );
 
?>
<style type="text/css">
.ucleft ul{clear:both;}
.ucleft h2{padding-left:40px;}
</style>
<div class="ucleft">
      <h2>User Center</h2>
      
  <?php foreach($menus as $menu){?>    
      <h3><span><?php echo $menu['title'];?></span><span class="<?php echo $menu['class'];?>"></span></h3>
      <ul>
      <?php foreach($menu['submenus'] as $sub){?>
        <li><a href="<?php echo zen_href_link($sub['page'], "ucenter=1"); ?>"><?php echo $sub['title'];?></a></li>
      <?php }?>
       
      </ul>
   <?php }?>   
      
    </div>
     