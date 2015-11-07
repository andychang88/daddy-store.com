<?php
/**
 * jscript_main
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: jscript_main.php 106 2010-03-14 20:55:15Z numinix $
 */
?>
<script type="text/javascript"><!--



$(document).ready(function(){
	$('#checkoutPayment input[@name=payment]:first').attr('checked', true);
	//change shipping address
	$('#changeCheckoutShippingAddr').bind('click', function(){
		$('#checkoutShipTo').hide();$('#mainCheckoutPayAddress').hide();$('#checkoutBillTo').show();
		//billing form the same shipping form so we have to fill data on two form
		//when submit, data will get from twice form.
		$('select[@name=address]:first').bind('change', function(){
	 		$('select[@name=address]:last').val($(this).val());
	 		$('div.detailShippingAddr').hide();
	 		$('div#detailShippingAddrBook'+$(this).val()).show();
	 	});
		$('input[@name=firstname]:first').bind('blur', function(){$('input[@name=firstname]:last').val($(this).val());});
		$('input[@name=lastname]:first').bind('blur', function(){$('input[@name=lastname]:last').val($(this).val());});
		$('input[@name=company]:first').bind('blur', function(){$('input[@name=company]:last').val($(this).val());});
		$('input[@name=street_address]:first').bind('blur', function(){$('input[@name=street_address]:last').val($(this).val());});
		$('input[@name=suburb]:first').bind('blur', function(){$('input[@name=suburb]:last').val($(this).val());});
		$('input[@name=city]:first').bind('blur', function(){$('input[@name=city]:last').val($(this).val());});
		$('input[@name=state]:first').bind('blur', function(){$('input[@name=state]:last').val($(this).val());});
		$('input[@name=telephone]:first').bind('blur', function(){$('input[@name=telephone]:last').val($(this).val());});
		$('input[@name=postcode]:first').bind('blur', function(){$('input[@name=postcode]:last').val($(this).val());});
		$('select[@name=zone_country_id]:first').bind('change', function(){$('select[@name=zone_country_id]:last').val($(this).val());});
		$('input[@name=address_new]:first').bind('click', function(){if($(this).is(':checked')) {$('input[@name=address_new]:last').attr('checked', true);} else {$('input[@name=address_new]:last').attr('checked', false);}});
		$('#mainCheckoutShippingAddress').show();
		$('div#checkout form').attr({
			name: 'checkout_address',
			onsubmit: 'return true;',
			action: '<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL');?>'
		});
		
	});
	$('div#mainCheckoutShippingAddress .cancelChangeShippingAddr').bind('click', function(){
		$('#checkoutShipTo').show();
		$('#mainCheckoutShippingAddress').hide();
		$('div#checkout form').attr({
			name: 'checkout_payment',
			onsubmit: 'return true;',
			action: '<?php echo $form_action_url;?>'
		});
	});
	
	//change billing address
	$('#changeCheckoutPayAddr').bind('click', function(){
		$('#checkoutBillTo').hide();$('#mainCheckoutShippingAddress').hide();
		$('#mainCheckoutPayAddress').show();$('#checkoutShipTo').show();
		$('select[@name=address]:last').bind('change', function(){
	 		$('div.detailPaymentAddr').hide();
	 		$('div#detailPaymentAddrBook'+$(this).val()).show();
	 	});
		$('div#checkout form').attr({
			name: 'checkout_address',
			onsubmit: 'return true;',
			action: '<?php echo zen_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL');?>'
		});
		
	});
	$('div#mainCheckoutPayAddress .cancelChangeShippingAddr').bind('click', function(){
		$('#checkoutBillTo').show();
		$('#mainCheckoutPayAddress').hide();
		$('div#checkout form').attr({
			name: 'checkout_payment',
			onsubmit: 'return true;',
			action: '<?php echo $form_action_url;?>'
		});
	});
});
var selected;
var submitter = null;

function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=320,screenX=150,screenY=150,top=150,left=150')
}
function couponpopupWindow(url) {
  window.open(url,'couponpopupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=320,screenX=150,screenY=150,top=150,left=150')
}
function submitFunction($gv,$total) {
  if ($gv >=$total) {
    submitter = 1;	
  }
  $('div#checkout form').attr({
    name: 'checkout_payment',
    onsubmit: 'return true;',
    action: '<?php echo $form_action_url;?>'
  }); 
}

function methodSelect(theMethod) {
  if (document.getElementById(theMethod)) {
    document.getElementById(theMethod).checked = 'checked';
  }
}

function updateForm() {
  if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)){
    var ieversion=new Number(RegExp.$1) // capture x.x portion and store as a number
    if (ieversion <= 7) {
      document.forms['checkout_payment'].action = "index.php?main_page=checkout&fecaction=update";
      document.forms['checkout_payment'].submit();             // Submit the page
    } else {
      nonIEupdateForm();
    }
  } else {
	  nonIEupdateForm();
  }
}

function nonIEupdateForm() {
  /*$('div#checkout form').attr({
    name: 'checkout_payment',
    onsubmit: 'return true;',
    action: 'index.php?main_page=checkout&fecaction=update'
  });
  $('div#checkout form').submit();*/
  document.forms['checkout_payment'].action = "index.php?main_page=checkout&fecaction=update";
  document.forms['checkout_payment'].submit();             // Submit the page
}
//--></script>