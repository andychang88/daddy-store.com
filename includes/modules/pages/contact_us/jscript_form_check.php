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
			
	$('#contact_form').validate({
					  event:'blur',
					  rules:{													 
							 email:{
									required:true,
									email:true
							 },
							 contactname:{
									   required:true,
									   rangelength:[5,20]
							 },
							 enquiry:{
									  required:true												 
							 }
					  },
					  messages:{
								email:{
									   required:"<br/><?php echo TEXT_JS_TIP_CONTACT_EMAIL_REQUIRED;?>",
									   email:"<br/><?php echo TEXT_JS_TIP_EMAIL_FORMAT;?>"
								},		
								contactname:{
											required:"<br/><?php echo TEXT_JS_TIP_CONTACT_NAME_REQUIRED;?>",
											rangelength:"<br/><?php echo TEXT_JS_TIP_PASSWORD_LENGTH;?>"
								},															
								enquiry:{
											required:"<br/><?php echo TEXT_JS_TIP_CONTACT_INQUIRY;?>"												
								}
					  }/*,
					  debug:true*/
	});
});
function check_contact_form(){  
   return $('#contact_form').valid();
}
</script>