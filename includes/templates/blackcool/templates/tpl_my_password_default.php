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
<?php echo zen_draw_form('my_password', zen_href_link('my_password', 'ucenter=1', 'SSL'), 'post', 'id="my_password_form" onsubmit="return check_account_pwd_form();"') . zen_draw_hidden_field('action', 'process'); ?>
<input type="hidden" name="update_token" value="<?php echo $_SESSION['update_token'];?>" />
<div class="ucright">
<div class="ucpwd">
        	<h2><?php echo HEADING_TITLE;?></h2>
            <div class="padding10px">
            	<table border="0" width="100%" class="ucaddtable">
                  <tbody><tr>
                    <td align="right" width="20%"><?php echo OLD_PASSWORD;?></td>
                    <td width="40%">
                    <input type="password" name="password_current" id="password_current" class="uc_input"></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right" width="20%"><?php echo NEW_PASSWORD;?></td>
                    <td width="40%"><input type="password" name="password_new" id="password_new" class="uc_input"></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right" width="20%"><?php echo NEW_PASSWORD_CONFIRM;?></td>
                    <td width="40%"><input type="password" name="password_confirmation" id="password_confirmation" class="uc_input"></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right" width="20%"><input type="submit" value="<?php echo BTN_SUBMIT;?>" id="button" name="button"></td>
                    <td width="40%">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </tbody></table>

        </div>
      </div>
    </div>
</form>    

   
<script language="javascript">
function check_account_pwd_form(){
	  var has_error = false;
	  var error_msg = '<?php echo ERROR_MSG_TITLE;?>';
	  var password_current=$.trim($('#password_current').val());
	  var password_new=$.trim($('#password_new').val());
	  var password_confirmation=$.trim($('#password_confirmation').val());
	  if(password_current.length==0){
		  has_error = true;
		  error_msg += "\n*<?php echo CUR_PASSWORD_EMPTY;?>";
	  }
	  
	  if(password_new.length==0){
		  has_error = true;
		  error_msg += "\n*<?php echo NEW_PASSWORD_EMPTY;?>";
	  }
	  if(password_confirmation != password_new){
		  has_error = true;
		  error_msg += "\n*<?php echo PASSWORD_NOT_MATCH;?>";
	  }
	  if(password_current.length<5 || password_current.length>20 || password_new.length<5 || password_new.length>20  ){
		  has_error = true;
		  error_msg += "\n*<?php echo PASSWORD_NOT_MATCH;?>";
	  }
	  
	  if(has_error) {
		alert(error_msg);return false;
	  }
	  return true;
}
<?php if($_REQUEST['action']=='process'){?> 
var update_success='<?php if ($update_success) echo 1; ?>';
jQuery(function(){
	if(update_success=='1'){
		alert('<?php echo UPDATE_SUCCESS;?>');
	}
});
<?php }?>
</script>
