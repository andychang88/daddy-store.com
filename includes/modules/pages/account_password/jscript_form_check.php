<?php
/**
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: jscript_form_check.php 4238 2006-08-24 10:01:04Z drbyte $
 */
?>
<script language="javascript" type="text/javascript"><!--
$(document).ready(function(){
  $('#account_password_form').validate({
					  event:'blur',
					  rules:{													 
							 password_current:{
											required:true,
											rangelength:[5,20]
							 },
							 password_new:{
										   required:true,
										   rangelength:[5,20]
							 },
							 password_confirmation:{
										  required:true,													 
										  equalTo:"#password_new"
							 }
					  },
					  message:{
					           password_current:{
											required:'<br/><?php echo TEXT_JS_TIP_PASSWORD_REQUIRED;?>',
											rangelength:'<br/><?php echo TEXT_JS_TIP_PASSWORD_LENGTH;?>'
							   },
							   password_new:{
										   required:'<br/><?php echo TEXT_JS_TIP_PASSWORD_REQUIRED;?>',
										   rangelength:'<br/><?php echo TEXT_JS_TIP_PASSWORD_LENGTH;?>'
							   },
							   password_confirmation:{
							  			  required:'<br/><?php echo TEXT_JS_TIP_PASSWORD2_REQUIRED;?>',													
										  equalTo:'<br/><?php echo TEXT_JS_TIP_PASSWORD_MATCH; ?>'
							   }
					  }
  });
});
function check_account_pwd_form(){
  return $('#account_password_form').valid();
}
//--></script>