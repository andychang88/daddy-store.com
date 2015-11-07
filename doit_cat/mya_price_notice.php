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
  if(isset($action) && $action=="delete"){
  	$id=(int)$_REQUEST['id'];
  	$db->Execute("delete from 2011system_message where message_id=".$id." limit 1");
  }
  if(isset($action) && $action=="insert" && $token==$_SESSION['token']){
  	$add_time = date("Y-m-d H:i:s");
  	$subject = $_POST["subject"];
  	$content = $_POST["content"];
  	$price_notice_id = $_POST["price_notice_id"];
 
  	
  	$sql = "insert into 2011price_notice_content(price_notice_id, subject, content,  add_time)
  			values('$price_notice_id','$subject','$content','$add_time')";
  	$db->Execute($sql);
  	$insert_success = true;
  	unset($_SESSION['token']);
  }
  $sql = "select pn.*, count(pnc.price_notice_id) as noticed_num 
  from 2011price_notice pn left join 2011price_notice_content pnc on pn.price_notice_id=pnc.price_notice_id 
 
  group by pnc.price_notice_id 
  order by add_time desc";
  $orders_query_numrows='';
   $orders_split = new splitPageResults($_GET['page'], 15, $sql, $orders_query_numrows);
   //$page_split = new splitPageResults($sql, 10,'*','page');
	//$sql=$page_split->sql_query;

  $message_result = $db->Execute($sql);
  $message_array = array();
  while(!$message_result->EOF){
  	$message_array[] = array(
  	"price_notice_id"=>$message_result->fields['price_notice_id'],
  	"noticed_num"=>$message_result->fields['noticed_num'],
  	"products_price"=>round($message_result->fields['products_price'],2),
  	"products_id"=>$message_result->fields['products_id'],
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
                <td class="pageHeading"><?php echo "System message"; ?></td>
                <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
              </tr>
            </table></td>
        </tr>
       </table>
       <?php if($insert_success) echo "<div>更新成功.</div>"?>
       
       
       
  <?php if($_REQUEST['action']=="add" ){?>     
       <table>
       <?php echo zen_draw_form('form_sysem_message', basename($PHP_SELF), '', 'post');?>
        <tr><td>产品ID：</td><td><input type="input" readony="readOnly" disabled="disabled" name="products_id" value="<?php echo $_REQUEST['pid'];?>"></td></tr>
        <tr><td>标题：</td><td><input type="input" name="subject"></td></tr>
        <tr><td>内容：</td><td><textarea name="content" style="width:376px;height:130px;"></textarea></td></tr>
        <tr><td colspan=2><input type="submit" value="submit">&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="reset" value="reset">
        <input type="hidden" name="action" value="insert" />
        <input type="hidden" name="price_notice_id" value="<?php echo $_REQUEST['id'];?>" />
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        </td></tr>
       </form></table>
  <?php }?>     
       
       
       
       
       <table class="list_tbl" width="100%">
       <tr><th>序号</th><th>产品价格</th><th>已通知记录数</th><th>操作</th></tr>
        <?php if(count($message_array)>0){?>
         <?php foreach($message_array as $message){?>
         <tr>
         <td><?php echo $message["price_notice_id"];?></td>
         <td><?php echo $message["products_price"];?></td>
         
         <td><?php echo $message["noticed_num"];?></td>
         
         <td>
         <a style="display:none;" href="javascript:confirmDelete('<?php echo $message["price_notice_id"];?>');">删除</a>&nbsp;&nbsp;
         <a href="mya_price_notice.php?action=add&id=<?php echo $message["price_notice_id"];?>&pid=<?php echo $message["products_id"];?>">添加通知</a>
         </td>
         </tr>
         <?php }?>
         <?php } else {?>
         <tr><td> not found system message</td></tr>
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

<input type="hidden" id="delete_url" value="<?php echo zen_href_link('mya_system_message','action=delete&id=');?>" />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
