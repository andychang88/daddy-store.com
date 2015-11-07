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
                        <td align="center"><?php echo CONSULT_SUBJECT;?></td>
                        <td align="center"><?php echo CONSULT_CONTENT;?></td>
                        <td align="center"><?php echo CONSULT_ADD_TIME;?></td>
                        <td align="center"><?php echo CONSULT_REPLY;?></td>
                      
                      </tr>
                      <?php if(count($complaint_arr)>0){
                         		foreach($complaint_arr as $row){
                      ?>
                      <tr>
                        <td align="center"><?php echo $row["subject"];?></td>
                        <td align="center"><?php echo $row["content"];?></td>
                        <td align="center"><?php echo $row["add_time"];?></td>
                        <td align="center">
                        
                      <?php 
                      if($row["status"]==1){
                      	echo $row["reply_content"];
                      }else{
                      	echo NO_REPLY;
                      }
                      ?></td>
                       
                      </tr>
                      <?php }
                      } else {?>
                      <tr><td colspan=4 align="center"><?php echo NO_ANY_INFO;?></td>
                      <?php }?>
                    </tbody></table>
              </div>
              
      <form method="post" onsubmit="return checkForm(this);" name="complaint_form" action="<?php zen_href_link('my_consult','');?>"> 
		 <input type="hidden" name="token" value="<?php echo $_SESSION['add_token'];?>" />
		 <input type="hidden" name="action" value="process" />         
              <div class="ucpunkte lineheight20px margintop10px">
                    <p class="bgfffafa"><?php echo ADD_CONSULT;?></p>
                    <div class="padding10px">
                    	<table border="0" width="100%" class="ucsharemail">
                          <tbody><tr>
                            <td align="right" width="25%"   ><?php echo CONSULT_SUBJECT;?></td>
                            <td >
                              <input type="" name="subject" value=""  class="ucrefundinput"/>
                              </td>
                              </tr><tr>
                            <td align="right" ><?php echo CONSULT_CONTENT;?></td>
                            <td>
                            <textarea rows="8" cols="10"  name="content" style="width:365px;height:136px;"  class="ucrefundinput"></textarea>
                            
                            </td>
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
              
              
<script language="javascript">
function checkForm(frm){
	var has_error = false;
	var error_msg = '<?php echo ERROR_MSG_TITLE;?>\n';

	var subject = $.trim(frm.subject.value);
	if(subject=='' || subject.length==0){
		has_error = true;
		error_msg += "	* <?php echo PLEASE_INPUT_SUBJECT;?>\n";
	}
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

})
</script>



