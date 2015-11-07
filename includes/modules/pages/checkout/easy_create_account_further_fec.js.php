<br/><?php
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
<script language="javascript" type="text/javascript"><!--
var chk_details=false;
$(document).ready(function(){	   
       $('#gender-male').attr('checked',true);
	   $('#option_detail_info').css('display','none');
	   $('#checkout_address_form').validate({
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
								 street_address:{
								                 required:true,
											     minlength:<?php echo ENTRY_STREET_ADDRESS_MIN_LENGTH; ?>
								 },
								 telephone:{
								           required:true,
										   number:true
								 },
								 city:{
								       required:true,
									   minlength:<?php echo ENTRY_CITY_MIN_LENGTH; ?>
								 },
								 zone_country_id:{
								                  required:true										          
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
									 street_address:{
													 required:'<br/><?php echo ENTRY_STREET_ADDRESS_ERROR; ?>',
													 minlength:'<br/><?php echo ENTRY_STREET_ADDRESS_ERROR; ?>'
									 },
									 telephone:{
											   required:'<br/><?php echo "Phone number is required."; ?>',
											   number:'<br/>here must be number'
									 },
									 
									 city:{
										   required:'<br/><?php echo ENTRY_CITY_ERROR; ?>',
										   minlength:'<br/><?php echo ENTRY_CITY_ERROR; ?>'
									 },
									 zone_country_id:{
													  required:'<br/><?php echo ENTRY_COUNTRY_ERROR; ?>'
									 }
						  }/*,
						  debug:true*/
	       
	   });
});
function check_address_form(){
      return $('#checkout_address_form').valid();
}
function option_choose(){
     /*if(chk_details){
	    $('#option_detail_info').slideUp();
		chk_details=false;
	 }else{
	    $('#option_detail_info').slideDown();
		chk_details=true;
	 }*/ 
	 if($('#option_detail_info').css('display')=='none'){
	      $('#option_detail_info').css('display','block');
	 }else{
	      $('#option_detail_info').css('display','none');
	 }
}
//--></script>
