<?php
/**
 * jscript_form_check
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: jscript_form_check.php 96 2009-10-13 02:49:30Z numinix $
 */
?>
<script language="javascript" type="text/javascript">
$(document).ready(function(){    
    $("#email_address").focus();	
			
	$('#register_form').validate({
					  event:'keyup',
					  rules:{													 
							 email_address:{
											required:true,
											email:true
							 },
							 customers_password:{
									   required:true,
									   rangelength:[5,20]
							 },
							 confirmation:{
										  required:true,													 
										  equalTo:"#customers_password"
							 }
					  },
					  messages:{
								email_address:{
											   required:"<br/><?php echo TEXT_JS_TIP_EMAIL_REQUIRED;?>",
											   email:"<br/><?php echo TEXT_JS_TIP_EMAIL_FORMAT;?>"
								},		
								customers_password:{
											required:"<br/><?php echo TEXT_JS_TIP_PASSWORD_REQUIRED;?>",
											rangelength:"<br/><?php echo TEXT_JS_TIP_PASSWORD_LENGTH;?>"
								},															
								confirmation:{
											required:"<br/><?php echo TEXT_JS_TIP_PASSWORD2_REQUIRED;?>",													
											equalTo:"<br/><?php echo TEXT_JS_TIP_PASSWORD_MATCH; ?>"
								}
					  }/*,
					  debug:true*/
	});
	
	$('#login_form').validate({
	                           event:'blur',
							   rules:{
							          email_address:{
											required:true,
											email:true
							          },
									  password:{
									            required:true,
											    rangelength:[3,20]
									  }
							   },
							   messages:{
							             email_address:{
											    required:"<br/><?php echo TEXT_JS_TIP_LOGIN_EMAIL_REQUIRED;?>",
											    email:"<br/><?php echo TEXT_JS_TIP_LOGIN_EMAIL_FORMAT;?>"
								         },
										 password:{
												required:"<br/><?php echo TEXT_JS_TIP_PASSWORD_REQUIRED;?>",
												rangelength:"<br/><?php echo TEXT_JS_TIP_PASSWORD_LENGTH;?>"
										 }
							   }/*,
							   debug:true*/
							   
	});		
});
function check_register_form(){  
   var box=document.create_account.xy.checked;
   var boxvalue="<?PHP ECHO TXXT_BOX;?>"
   if(box!=true)
   {
     alert(boxvalue);
	 return false;
   }
   
   return $('#register_form').valid();
}
function check_login_form(){
   return $('#login_form').valid();
}
</script>