<script language="javascript">
$(document).ready(function(){
	$('#new_customer').click(function (){
		if($(this).is(':checked')) {
			$('#qc_create_account').fadeIn();
			$('#qc_login').hide();
		}
	});
	
	$('#back_login').click(function() {
		$('#qc_create_account').fadeOut();
		$('#qc_login').fadeIn();
		$('#new_customer').removeAttr('checked');
	});
	
	$('#shippingAddress-checkbox').click(function (){
		if($(this).is(':checked')) {
			$('#shippingField').fadeOut();
		} else {
			$('#shippingField').fadeIn();
		}
	});
<?php if ($shippingAddress == true) { ?>
  $('#shippingField').fadeOut();
<?php } ?>
});
</script>