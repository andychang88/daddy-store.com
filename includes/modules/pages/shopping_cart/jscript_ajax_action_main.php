<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: jscript_main.php 5444 2006-12-29 06:45:56Z drbyte $
//
?>
<script language="javascript" type="text/javascript">
var empty_cart_html='<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td class="main">&nbsp;</td></tr><tr><td class="main" align="center"><?php echo addslashes(TEXT_EMPTY_CART);?></td></tr><tr><td class="main" align="right"><a href="<?php echo zen_href_link(FILENAME_DEFAULT);?>"><?php echo zen_image(DIR_WS_TEMPLATE_BUTTON.'button_continue_shopping.gif');?></a></td></tr></table>';
var top_items_count_tip='<?php echo TEXT_SHOPPING_CART_DESCRIPTION;?>';
var pre_item_qty=[];
<?php foreach($products as $p){
		//$rll_pid=split(':',$p['id']);
		$_pid=str_replace(':','_',$p['id']);
?>
		pre_item_qty['<?php echo $_pid;?>']=<?php echo $p['quantity'];?>;
<?php }?>
$(document).ready(function(){
	$('#cart_things .cart_minus').click(function(){
		var pid=$(this).attr('attrid');
			//_pid=pid.replace(':','_');
		var _pid=pid;
		
		var tf_cart_qty=document.getElementById('cart_quantity'+_pid);
		if(tf_cart_qty){
			var curr_qty=parseInt(tf_cart_qty.value);
			if(curr_qty==1){//if 1 means delete
					window.alert('<?php echo TEXT_ITEM_MINUS_TIP;?>');
			}else if(curr_qty>=2){				
					tf_cart_qty.value=curr_qty-1;	
									
					var theform=$('#cart_'+_pid);
					if(theform){
						var formData=theform.formSerialize();							
							update_cart_form(formData,_pid);
					}	
				
			}		
		}			
	});
	
	$('#cart_things .cart_add').click(function(){
		var pid=$(this).attr('attrid');
		//var _pid=pid.replace(':','_');
		var _pid=pid;
		var tf_cart_qty=document.getElementById('cart_quantity'+_pid);
		
		if(tf_cart_qty){
			var curr_qty=parseInt(tf_cart_qty.value);
				tf_cart_qty.value=curr_qty+1;
							
			var theform=$('#cart_'+_pid);
			if(theform){
				var formData=theform.formSerialize();
					update_cart_form(formData,_pid);
			}
		}
	});
	
	$('#cart_things .cart_delete').click(function(){
		var del_confirm=window.confirm('<?php echo TEXT_ITEM_REMOVE_TIP;?>');
		if(del_confirm){
			var pid=$(this).attr('attrid');
			//var _pid=pid.replace(':','_');
			var _pid=pid;
			
			var theform=$('#cart_'+_pid);
			if(theform){
				var formData=theform.formSerialize();
					formData+='&cart_delete=1';
				update_cart_form(formData,_pid);
			}
		}
	});	
	
	$('#cart_things .cart_qty').keyup(function(){
		var input_v=$(this).val();
		var rpid=$(this).attr('rpid');
		var _rpid=rpid.replace(':','_');
		if(isNaN(input_v)||input_v<0){
			$(this).val(pre_item_qty[_rpid]);
		}
		
		var formData='products_id='+rpid;
	});
});
function update_cart_form(formData,_pid){
	
	$.ajax({
			 type:"POST",//Get method or post method			
			 async: false,//asynchonic
			 cache: false,//read data from cache or not
			 url: "ajax_cart_action.php",//server script pathurl
			 dataType:"text",//the data type of return(xml,html or text)
			 data:formData, 						
			 success:function(text){			
					//alert(text);
					var dd=eval('['+text+']');	
																					
					if(dd[0].error){
						alert(dd[0].error);
					}else{
						var total_amount=dd[0].total_amount;
						var items_count=dd[0].items_count;
						var item_qty=dd[0].item_qty;
						var item_unit_price=dd[0].item_unit_price;
						var item_total_price=dd[0].item_total_price;
						
						if( (dd[0].delete_action && dd[0].delete_action==1) || item_qty==0){
							var del_row=document.getElementById('trpid_'+_pid);
							if(del_row){
								del_row.remove();
							}
						}	

						if(items_count==0){//shopping cart is empty
							var sc_div=document.getElementById('shopping_cart_div');
							if(sc_div){
								sc_div.innerHTML=empty_cart_html;
							}
						}
						
						pre_item_qty[_pid]=item_qty;
						$('#tci_count').html(items_count+' '+top_items_count_tip);//ding
						$('#it_price_'+_pid).html(item_total_price);
						$('#iu_price_'+_pid).html(item_unit_price);
						$('#cart_total_amount').html(total_amount);
					}				
			 },
			 error:function(){
					alert('server error');
					$('#add_cart_place').html(btn_add_cart);
			 }
		
	});
}	
</script>