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
  
  /**
  $arr = getRecommendConfig('index_cat_list');
  echo  "<meta charset='UTF-8' /><br>".__FILE__.' line:'.__LINE__.'============'."<pre>";print_r($arr);exit;
  /**/
  if(isset($action) && $action=="update" && $token==$_SESSION['token']){
  	$add_time = date("Y-m-d H:i:s");

  	foreach ($_POST as $item_key=>$item_value){
  		$sql = "select *  from 2011recommend_config where item_key='".$item_key."'" ;
  		$result = $db->Execute($sql);
  		if(!$result->EOF){
  			
  			if ($_POST['is_delete'] == 1){
  				$update = "is_delete='1'";
  			} else {
  				$update = "item_value='".$item_value."', item_memo='".$_POST['item_memo']."'";
  			}
  			
  			$sql = "update  2011recommend_config set ".$update." where item_key='".$item_key."'";
  			$db->Execute($sql);
  		}
  	}
  	
  	$insert_success = true;
  	unset($_SESSION['token']);
  }
  
  if(isset($action) && $action=="insert" && $token==$_SESSION['token']){
  	
	  	$item_key = trim($_POST['item_key']);
	  	$item_value = trim($_POST['item_value']);
	  	$item_desp = trim($_POST['item_desp']);
	  	$item_memo = trim($_POST['item_memo']);
	  	
	  	if($item_key && $item_value && $item_desp){
	  		$sql = "insert into 2011recommend_config (item_key, item_value, item_desp, item_memo) values('$item_key', '$item_value', '$item_desp', '$item_memo')";
  			$db->Execute($sql);
	  	}
  }
  
  $select_sql = "select *          
  from 2011recommend_config where is_delete=0 order by id desc";
  
  $items_per_page = 10;
  $result_split = new splitPageResults($_GET['page'], $items_per_page, $select_sql, $result_numrows);
  $result = $db->Execute($select_sql);

  $message_array = array();
  
  while(!$result->EOF){
  	$message_array[]=array(
  	'item_key'=>$result->fields['item_key'],
  	'item_value'=>$result->fields['item_value'],
  	'item_desp'=>$result->fields['item_desp'],
  	'item_memo'=>$result->fields['item_memo'],
  	);

  	$result->MoveNext();
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
<script language="javascript" src="/includes/templates/blackcool/jscript/jscript_a_jquery-1.3.2.js?1446336000"></script>
<script type="text/javascript">
  <!--
  function replyComplaint(id){
	  var delete_url = document.getElementById('delete_url').value;
	  reply_url = delete_url.replace('action=delete','action=reply');
	  window.open(reply_url+id,'_self');
  }
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
  function deleteMessage(item_key){
	  
	var frm = $('form[name="form_'+item_key+'"]');
	frm.find('input[name="is_delete"]').attr('value', '1');
	frm.submit();
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
.tip_msg{padding:10px 5px;background:#9ACD32;border:1px solid #A8A8A8;}
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
       <?php if($insert_success) echo "<div class='tip_msg' >update success.</div>"?>
       
       
    
        <p>调用方法实例：<br>
        $arr = getRecommendConfig('index_cat_list');
        </p>
        
     <?php echo zen_draw_form('form', basename($PHP_SELF), '', 'post');?>
		<table>
		<tr><td>描述：</td><td><textarea name="item_desp" style="width:376px;height:50px;"></textarea></td></tr>
		<tr><td>索引Key：</td><td><input type="text" name="item_key" value="" /></td></tr>
        <tr><td>存储值：</td><td><textarea name="item_value" style="width:376px;height:130px;"></textarea></td></tr>
        <tr><td>说明：</td><td><textarea name="item_memo" style="width:376px;height:130px;"></textarea></td></tr>
        <tr><td colspan=2 text-align="center" style="text-align:center;">
        <input type="submit" value="submit">&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="hidden" name="action" value="insert" />
       
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        </td></tr>
        </table>
       </form>
       
            
       
<?php foreach ($message_array as $message) {?>
		<?php echo zen_draw_form('form_'.$message['item_key'], basename($PHP_SELF), '', 'post');?>
		<table>
        <tr><td><?php echo $message['item_desp'];?> (<?php echo $message['item_key'];?>)：</td>
           <td>存储值：<br><textarea name="<?php echo $message['item_key'];?>" style="width:376px;height:130px;"><?php echo $message['item_value'];?></textarea></td>
           <td>说明:<br><textarea name="item_memo" style="width:376px;height:130px;"><?php echo $message['item_memo'];?></textarea></td>
        </tr>
        
        <tr><td colspan=3  style="text-align:center;">
		         <input type="submit" value="submit">&nbsp;&nbsp;&nbsp;&nbsp;
		        <input type="button" onclick="deleteMessage('<?php echo $message['item_key'];?>')" value="删除">
		        
		        <input type="hidden" name="action" value="update" />
		        <input type="hidden" name="is_delete" value="0" />
		        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
		        
        </td></tr>
        </table>
       </form>
<?php }?>    
        
        
       
       
     
     
     
     <table>
     <tr>
     	<td class="smallText" valign="top"><?php echo $result_split->display_count($result_numrows, $items_per_page, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_COUNTRIES); ?></td>
        <td class="smallText" align="right"><?php echo $result_split->display_links($result_numrows, $items_per_page, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
     </tr>
     </table>
     
     
     
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
