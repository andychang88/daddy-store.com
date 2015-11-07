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
$('document').ready(function(){
    $('#account_info_form').validate({
	     event:'blur',
		 rules:{
				 firstname:{
						   required:true,
						   minlength:<?php echo ENTRY_FIRST_NAME_MIN_LENGTH; ?>
				 },
				 lastname:{
						   required:true,
						   minlength:<?php echo ENTRY_LAST_NAME_MIN_LENGTH; ?>
				 },
				 email_address:{
						   required:true,
						   email:true
				 },
				 telephone:{
								required:true,
								number:true
			 }
		  },
		  messages:{
		             firstname:{
							   required:'<br/><?php echo ENTRY_FIRST_NAME_ERROR; ?>',
							   minlength:'<br/><?php echo ENTRY_FIRST_NAME_ERROR; ?>'
					 },
					 lastname:{
							   required:'<br/><?php echo ENTRY_LAST_NAME_ERROR; ?>',
							   minlength:'<br/><?php echo ENTRY_LAST_NAME_ERROR; ?>'
					 },
					 email_address:{
								   required:"<br/><?php echo TEXT_JS_TIP_EMAIL_REQUIRED;?>",
								   email:"<br/><?php echo TEXT_JS_TIP_EMAIL_FORMAT;?>"
					 },
					 telephone:{
											   required:'<br/><?php echo "Phone number is required."; ?>',
											   number:'<br/>here must be number'
					 }
		  }
	});
});
function check_account_info_form(){
   return $('#account_info_form').valid();
}
//--></script>
