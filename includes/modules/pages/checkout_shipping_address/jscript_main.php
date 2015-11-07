<?php
/**
 * jscript_main
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: jscript_main.php 4683 2006-10-07 06:11:53Z drbyte $
 */
?>
<script language="javascript" type="text/javascript"><!--
$(document).ready(function(){	   
     
       $('#gender-male').attr('checked',true);
	   $('#option_detail_info').css('display','none');
	   $('#new_shipping_address_form').validate({
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
function check_new_shipping_address_form(){
      return $('#new_shipping_address_form').valid();
}
function check_choose_shipping_address_form(){
      return $('input[name="address"]').attr('checked');
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
