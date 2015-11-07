<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account_password.<br />
 * Allows customer to change their password
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_account_password_default.php 2896 2006-01-26 19:10:56Z birdbrain $
 */
?>
<div class="ucright">
        <!--you hui juan-->
		<div class="ucpwd">
            <h2><?php echo HEADING_TITLE;?></h2>
            <div class="margintop10px">
<div class="lineheight20px margintop10px">
                	<table border="0" width="100%" class="uccoupon">
                      <tbody><tr class="bgfffafa fontbold">
                       
                        <td width="10%" align="center"><?php echo COMPLAINT_TYPE;?></td>
                        <td width="15%"  align="center"><?php echo ORDER_NO;?></td>
                        <td width="15%"  align="center"><?php echo COMPLAINT_TIME;?></td>
                        <td align="center"><?php echo COMPLAINT_REPLY;?></td>
                        <td width="10%"  align="center"><?php echo COMPLAINT_ACTION;?></td>
                      </tr>
                      <?php if(count($complaint_arr)>0){
                         		foreach($complaint_arr as $row){
                      ?>
                      <tr>
                        
                        <td align="center"><?php echo $row["type_name"];?></td>
                        <td align="center"><?php echo $row["orders_id"];?></td>
                        <td align="center"><?php echo $row["add_time"];?></td>
                        <td align="center"><?php echo $row["reply_content"];?></td>
                        <?php if(0){?>
                        <td align="center"><a href="javascript:confirmDelete('<?php echo $row["complaint_id"];?>');" ><?php echo ACTION_DELETE;?></a></td>
                        <?php }?>
                        <td align="center"><?php echo ACTION_NONE;?></td>
                      </tr>
                      <?php }
                      } else {?>
                      <tr><td colspan=5 align="center"><?php echo NO_ANY_INFO;?></td>
                      <?php }?>
                    </tbody></table>
              </div>
            
      <form method="post" onsubmit="return checkForm(this);" name="complaint_form" action="<?php zen_href_link('my_complaint','');?>"> 
		 <input type="hidden" name="token" value="<?php echo $_SESSION['add_token'];?>" />
		 <input type="hidden" name="action" value="process" />         
		 <input type="hidden" name="platname" value="10050" /> 
              <div class="ucpunkte lineheight20px margintop10px">
                    <p class="bgfffafa"><?php echo COMPLAINT;?></p>
                    <div class="padding10px">
                    	<table border="0" width="100%" class="ucsharemail">
                          <tbody><tr>
                            <td width="15%"  align="right"><?php echo COMPLAINT_TYPE;?></td>
                            <td width="12%">
                              <select id="select" name="type">
                              <option value="0"><?php echo PLEASE_SELECT_TYPE;?></option>
                              <?php if(count($type_arr)>0){
                              			foreach($type_arr as $key=>$type){
                              ?>
                                <option value="<?php echo preg_replace("/\d+/","",$key);?>"><?php echo $type;?></option>
                              <?php }
                              }?>
                            </select>
                              </td>
                            <td align="right" width="15%"><?php echo RELATIVE_ORDER;?></td>
                            <td>
                            <select id="select"  id="orders_id" name="order_id" >
                            <option value="0"><?php echo PLEASE_SELECT_TYPE;?></option>
                            <?php if(count($ordersId_arr)>0){
                              			foreach($ordersId_arr as $key=>$orderid){
                              ?>
                                <option value="<?php echo $orderid;?>"><?php echo $orderid;?></option>
                              <?php }
                              }?>
                               </select>
                           </td>
                          </tr>
                         
                          <tr>
                            <td align="right" width="10%" valign="middle"><?php echo COMPLAINT_CONTENT;?></td>
                            <td colspan="3"><textarea id="content" class="ucsharetextarea" name="content"></textarea></td>
                          </tr>
                          <tr>
                            <td width="10%">&nbsp;</td>
                            <td colspan="3"><input type="submit"  value="<?php echo BTN_SUBMIT;?>"></td>
                          </tr>
                        </tbody></table>
                    </div>
                </div>
             </form>   
                
	</div>
  </div>
</div>              
              
 <input type="hidden" id="delete_url" value="<?php echo zen_href_link('my_complaint','action=delete&ucenter=1&complaint_id=');?>" />              
<script language="javascript">
var delete_url = $('#delete_url').val();
function confirmDelete(id){
	if(confirm('<?php echo CONFIRM_DELETE;?>')){
		window.open(delete_url+id,'_self');
	}
}
function checkForm(frm){
	var has_error = false;
	var error_msg = '<?php echo ERROR_MSG_TITLE;?>\n';
	var complaint_type = $.trim(frm.type.value);
	if(complaint_type==0){
		has_error = true;
		error_msg += "	* <?php echo PLEASE_SELECT_COMPLAINT_TYPE;?>\n";
	}
	var orders_id = $.trim(frm.order_id.value);
	if(orders_id==0){
		has_error = true;
		error_msg += "	* <?php echo PLEASE_SELECT_ORDERID;?>\n";
	}
//	var subject = $.trim(frm.subject.value);
//	if(subject=='' || subject.length==0){
//		has_error = true;
//		error_msg += "	* <?php echo PLEASE_INPUT_SUBJECT;?>\n";
//	}
	var content = $.trim(frm.content.value);
	if(content=='' || content.length==0){
		has_error = true;
		error_msg += "	* <?php echo PLEASE_INPUT_CONTENT;?>";
	}
	if(has_error){
		alert(error_msg);
		return false;
	}
	return true;
}

jQuery(function(){
 <?php 
  if(isset($insert_erp_error) && $insert_erp_error){
  ?>
  alert("<?php echo ERP_ERROR?>");
  <?php 
  }
 ?>
 	
 <?php if($order_is_not_valid){?>
   alert("<?php echo ORDER_NO_ERROR?>");
 <?php }?>
})
</script>



