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
/**
$(document).ready(function(){
	  $('#my_password_form').validate({
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
												required:'<br/>please type your password ',
												rangelength:'<br/>Char length must be between 3 and 20'
								   },
								   password_new:{
											   required:'<br/>please type your password ',
											   rangelength:'<br/>Char length must be between 3 and 20'
								   },
								   password_confirmation:{
								  			  required:'<br/>please confirm your password',													
											  equalTo:'<br/>Die Passwortbestätigung stimmt nicht mit dem neu eingegebenen Passwort überein.'
								   }
						  }
	  });
	});
	function check_account_pwd_form(){
	  return $('#my_password_form').valid();
	}
/**/
//--></script>
