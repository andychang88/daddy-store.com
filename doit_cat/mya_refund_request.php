<?php
/**
 * @package admin
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: template_select.php 6131 2007-04-08 06:56:51Z drbyte $
 */

  require('includes/application_top.php');
  $action = $_REQUEST["action"];
  $token=$_REQUEST['token'];
  $db->Execute("set names utf8");
  
  if(isset($action) && $action=="delete"){
  	$id=(int)$_REQUEST['id'];
  	$query = "delete from 2011refund_apply 
  	where refund_apply_id=".$id." 
  	limit 1";
  	
  	$db->Execute($query);
  }
  if(isset($action) && $action=="insert" && $token==$_SESSION['token']){
  	$add_time = date("Y-m-d H:i:s");
  	$subject = $_POST["subject"];
  	$content = $_POST["content"];
  	$range = $_POST["range"];
  	
  	$sql = "insert into 2011system_message(subject, content, message_range, add_time)
  			values('$subject','$content','$range','$add_time')";
  	$db->Execute($sql);
  	$insert_success = true;
  	unset($_SESSION['token']);
  }
  $sql = "select ra.*, c.customers_email_address, rs.refund_status   
  from 2011refund_apply ra, customers c, 2011refund_status rs   
  where ra.customers_id=c.customers_id 
  and  ra.refund_status_id=rs.refund_status_id 
  order by add_time desc";
  $orders_query_numrows='';
   $orders_split = new splitPageResults($_GET['page'], 15, $sql, $orders_query_numrows);
   //$page_split = new splitPageResults($sql, 10,'*','page');
	//$sql=$page_split->sql_query;

  $message_result = $db->Execute($sql);
  $message_array = array();
  while(!$message_result->EOF){
  	$message_array[] = array(
  	"refund_apply_id"=>$message_result->fields['refund_apply_id'],
  	"customers_email_address"=>$message_result->fields['customers_email_address'],
  	"refund_status"=>$message_result->fields['refund_status'],
  	"orders_id"=>$message_result->fields['orders_id '],
  	"refund_apply_reason"=>$message_result->fields['refund_apply_reason'],
  	"add_time"=>$message_result->fields['add_time']
  	)
  	;
  	
  	$message_result->MoveNext();
  }
  $_SESSION['token']=time();

 // echo zen_draw_form('zones', FILENAME_TEMPLATE_SELECT, 'page=' . $_GET['page'] . '&action=insert');exit;
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script type="text/javascript">
  <!--

  function confirmDelete(id){
	  var delete_url = document.getElementById('delete_url').value;
          if(confirm('确定要删除吗?')){
                  window.open(delete_url+id,'_self');
          }
  }

  
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  }
  // -->
</script>
<style type="text/css">
table.list_tbl{
width:60%;border-collapse:collapse;
}
table.list_tbl th,table.list_tbl td{
text-align:left;border:1px solid #ccc;padding:3px 2px;
}
</style>
</head>
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->
<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
        <tr>
          <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td class="pageHeading"><?php $page=basename($PHP_SELF,'.php');
                $page=str_replace("mya_", "", $page);
                $page=str_replace("_", " ", $page);
                //$page=ucwords($page);
                echo $page; ?></td>
                <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
              </tr>
            </table></td>
        </tr>
       </table>
       <?php if($insert_success) echo "<div>update success.</div>"?>
      
       <table class="list_tbl">
       <tr><th>序号</th><th>客户</th><th>订单ID</th><th>退款原因</th><th>处理状态</th><th>添加时间</th><th>操作</th></tr>
        <?php if(count($message_array)>0){?>
         <?php foreach($message_array as $message){?>
         <tr>
         <td><?php echo $message["refund_apply_id"];?></td>
         <td><?php echo $message["customers_email_address"];?></td>
         <td><?php echo $message["orders_id"];?></td>
         <td><?php echo $message["refund_apply_reason"];?></td>
         <td><?php echo $message["refund_status"];?></td>
         <td><?php echo $message["add_time"];?></td>
         <td>
         <a href="javascript:confirmDelete('<?php echo $message["refund_apply_id"];?>');">删除</a>
         </td>
         </tr>
         <?php }?>
         <?php } else {?>
         <tr><td colspan=7 style="text-align:center;"> 没找到相关信息</td></tr>
         <?php }?>
       </table>
       <div><?php //echo $orders_query_numrows."<br>"; echo $orders_split->display_count($orders_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_ORDERS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS); ?></div>
       <div><?php echo $orders_split->display_links($orders_query_numrows, 15, 5, $_GET['page'], zen_get_all_get_params(array('page',  'action'))); ?></div>
       </td>
  </tr>
</table>
<!-- body_eof //-->
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>

<input type="hidden" id="delete_url" value="<?php echo zen_href_link(basename($_SERVER[PHP_SELF]),'action=delete&id=');?>" />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
