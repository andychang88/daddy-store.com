<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account_password.<br />
 * Allows customer to change their password
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_account_password_default.php 2896 2006-01-26 19:10:56Z birdbrain $
 */
?>
<div class="ucright">
		<div class="ucpwd">
            <h2><?php echo HEADING_TITLE;?></h2>
       </div>
       <div class="margintop10px">
       <div class="lineheight20px margintop10px">
                	<table border="0" width="100%" class="uccoupon">
                      <tbody><tr class="bgfffafa">
                        <td colspan="6"><span class="fontbold fontsize12px"><?php echo HISTORY;?></span></td>
                      </tr>
                      <tr>

                        <td width="10%" align="center"><?php echo TITLE_RELATIVE_ORDER;?></td>
                        <td align="center"><?php echo RETURN_REASON;?></td>
                        <td align="center"><?php echo RETURN_REPLAY;?></td>
                        <td  width="15%" align="center"><?php echo TITLE_APLLY_TIME;?></td>
                        <td width="9%"  align="center"><?php echo TITLE_PROCESS_STATUS;?></td>
                        <td width="5%"  align="center"><?php echo TITLE_ACTION;?></td>
                      </tr>
                      <?php if(count($refund_arr)>0){
                      			foreach ($refund_arr as $refund) {
                      		?>
                      <tr>
                        <td align="center"><?php echo $refund["orders_id"];?></td>
                         <td align="center"><?php echo $refund["refund_apply_reason"];?></td>
                         <td align="center"><?php echo $refund["refund_apply_reply"];?></td>
                        <td align="center"><?php echo $refund["add_time"];?></td>
                        <td align="center"><?php echo $refund["refund_status"];?></td>
                        <?php if(0){?>
                        <td align="center"><a href="javascript:confirmDelete('<?php echo $refund["refund_apply_id"];?>');"><?php echo ACTION_DELETE;?></a></td>
                        <?php }?>
                        
                        <td align="center"><?php echo ACTION_NONE;?></td>
                        
                        
                      </tr>
                      <?php }
                      	} else {?>
                      <tr><td colspan="6" align="center"><?php echo NO_ANY_INFO;?></td></tr>
                      	<?php }?>
                      	
                      	
                    </tbody></table>
                </div>
 
 <style type="text/css">
 #tbl_repair .refund_title{background:#EAF3FE;}
 #tbl_repair{width:100%;border-collapse:collapse;border:0;}
 #tbl_repair td{border:1px solid #ccc;}
 #tbl_repair td{padding:2px 5px;}
 #tbl_repair .align_right{text-align:right;}
 #tbl_repair .desp{width:440px;height:95px;}
 #tbl_repair .paddingleft10px{display:none;}
 #goods_container div{float:left;margin-left:10px;width:60px;text-align:center;}
 #goods_container div img{margin-bottom:5px;}
 .exchange_return_tip{border:1px solid #FFCE8D;background:#FFFACB;margin:2px 10px;padding:3px 2px;}
 #tbl_repair .uc_input{
 color:#999;
 }
 </style>               
 <form method="post" onsubmit="return checkForm(this);" name="refund_form" action="<?php zen_href_link('my_refund','');?>"> 
 <input type="hidden" name="token" value="<?php echo $_SESSION['add_token'];?>" />
 <?php 
 if($_REQUEST['debug']){
 	echo '<input type="hidden" name="debug" value="debug" />';
 }
 ?>
 <input type="hidden" name="action" value="process" />

                <div class="lineheight20px margintop10px">
                
                <table id="tbl_repair">
                <tr><td colspan="2" class="refund_title"><span class="fontbold fontsize12px"><?php echo REFUND_TITLE;?></span></td></tr>
                <tr><td class="align_right"><?php echo RELAVE_ORDER_NO;?></td>
                <td>
                <select  id="orders_id" name="orders_id" onchange="changeOrder(this);" >
                            <option value="0"><?php echo PLEASE_SELECT_TYPE;?></option>
                            <?php if(count($ordersId_arr)>0){
                              			foreach($ordersId_arr as $key=>$orderid){
                              ?>
                                <option value="<?php echo $orderid;?>"><?php echo $orderid;?></option>
                              <?php }
                              }?>
                               </select>
                </td></tr>
                <tr><td class="align_right"><?php echo ORDER_GOODS;?>:</td>
                <td><div id="goods_container" class="order_products"><?php echo SELECT_ORDERNO_FIRST;?> </div></td></tr>
                
                <?php if(!empty($exchange_return_tip)){?>
                <tr><td colspan="2"><div class="exchange_return_tip"><?php echo $exchange_return_tip;?></div></td></tr>
                <?php }?>
                
                <tr><td class="align_right"><?php echo RETURN_TYPE;?>:</td><td>
                <input type="radio" name="return_type" value="1"  /> <?php echo RETURN_TYPE_REPARE;?>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="return_type" value="2" onclick="isAllowReturn();" /> <?php echo RETURN_TYPE_RETURN;?>
                </td></tr>
                <tr><td class="align_right"><?php echo CONTACT_NAME;?>:</td><td><input class="uc_input" type="text" id="customers_name" name="customers_name" value="" /></td></tr>
                <tr><td class="align_right"><?php echo CONTACT_TELPHONE;?>:</td><td><input class="uc_input" type="text" id="telphone" name="telphone" value="" /></td></tr>
                <tr><td class="align_right"><?php echo CONTACT_EMAIL;?>:</td><td><input class="uc_input" type="text" id="email" name="email" value="" /></td></tr>
                <tr><td class="align_right"><?php echo CONTACT_ADDRESS;?>:</td><td><input class="uc_input" type="text" name="address" id="address" value="" /></td></tr>
                <tr><td class="align_right"><?php echo RETURN_REASON;?>:</td><td><textarea class="ucsharetextarea" class="desp" name="apply_reason" rows=8 cols="1"></textarea></td></tr>
                <tr><td align="center" colspan="2" ><input type="submit" name="submit" value="<?php echo BTN_SUBMIT;?>">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value="<?php echo BTN_RESET;?>"> </td></tr>
                </table>
   
                </div>
</form>
                </div>
                
                
       </div>
 </div>
 <input type="hidden" id="delete_url" value="<?php echo zen_href_link('my_refund','action=delete&ucenter=1&apply_id=');?>" />      
 <input type="hidden" id="product_info_url" value="<?php echo zen_href_link('product_info','products_id=');?>" />
<script language="javascript">
var url = '<?php echo zen_href_link('my_refund');?>';
var delete_url = $('#delete_url').val();
var root_img = '<?php echo DIR_WS_IMAGES;?>';
var order_products={};
function isAllowReturn(){
	
}
function changeOrder(obj){
	var orderid=obj.value;
	if(orderid==0){
	  $('#goods_container').html('');
	  return;
	}
	addLoading();
	if(!order_products[orderid]){
		jQuery.post(url,{action:'get_order_products',order_id:orderid},function(result){
			removeLoading();
		  if(result.status=='success'){
			  
			  order_products[orderid]=result;
			  
			  resetProducts(result.content);
			  resetAddress(result.address);
		  }else{
			  alert('Error');
		  }
		  
		},'json');
	}else{
		removeLoading();
		resetProducts(order_products[orderid].content);
		resetAddress(order_products[orderid].address);
	}
}
function resetAddress(obj_address){
	var addr='';
	if(obj_address.customers_street_address){
		addr +=obj_address.customers_street_address+',';
	}
	if(obj_address.customers_city){
		addr +=obj_address.customers_city+' ';
	}
	if(obj_address.customers_state){
		addr +=obj_address.customers_state+' ';
	}
	if(obj_address.customers_country){
		addr +=obj_address.customers_country+' ';
	}
	if(addr.length>0){
		$('#address').val(addr);
	}
	
	if(obj_address.customers_email_address){
		$('#email').val(obj_address.customers_email_address);
	}
	if(obj_address.customers_telephone){
		$('#telphone').val(obj_address.customers_telephone);
	}
	if(obj_address.customers_name){
		$('#customers_name').val(obj_address.customers_name);
	}
	
}
function resetProducts(obj_products){
	if(obj_products.length && obj_products.length>0){
		var html_arr=[];
		var url = $('#product_info_url').val();
		for(var i=0,len=obj_products.length;i<len;i++){
			var product = obj_products[i];
			html_arr.push('<div><a href="'+url+product.products_id+'" target="_blank">');
			html_arr.push('<img width="50" height="50" title="'+product.products_name+'" alt="'+product.products_name+'" src="'+root_img+product.products_image+'" >');
			html_arr.push('</a>');
			html_arr.push('<input type="checkbox" name="product[]" value="'+product.products_id+'" />');
		
			if(product.products_quantity && product.products_quantity>1){
				html_arr.push('(<b>'+product.products_quantity+'</b>)');
			}
			html_arr.push('</div>');
		}
		if(html_arr.length>0){
			$('#goods_container').html(html_arr.join(''));
		}
	}
}
function confirmDelete(id){
	if(confirm("<?php echo REALLY_DELETE;?>")){
		window.open(delete_url+id,'_self');
	}
}
function checkForm(frm){
	
	var hasError=false;
	var errorMsg='';

	var orderid = $.trim(frm.orders_id.value);
	if(orderid.length == 0){
	   hasError=true;
	   errorMsg += "* <?php echo NEED_ORDER_NO;?>\n";
       frm.orders_id.focus();
	}

	if($('#tbl_repair input[name="product[]"]').length>0){
		var num=0;
		order_products['product_ids']=[];
		
		$('#tbl_repair input[name="product[]"]').each(function(){
			if($(this).is(':checked')){
				num++;
				order_products['product_ids'].push($(this).val());
			}
		});
		
		 if(num==0){
			 hasError=true;
			 errorMsg += "* <?php echo PLEASE_SELECT_GOODS;?>\n";
		 }
	}
	
	for(var i=0,len=frm.return_type.length; i<len;  i++){
		if(frm.return_type[i].checked && frm.return_type[i].value=='2'){
			var allow_return=order_products[orderid].address.allow_return;
			if(allow_return!=1){
				hasError=true;
				errorMsg += "* <?php echo CAN_NOT_RETURN;?>\n";
			}
		}
	}

	var customers_name=$.trim(frm.customers_name.value);
	if(customers_name.length==0){
		hasError=true;
		errorMsg += "* <?php echo PLEASE_INPUT_NAME;?>\n";
	}

	var telphone=$.trim(frm.telphone.value);
	if(telphone.length==0){
		hasError=true;
		errorMsg += "* <?php echo PLEASE_INPUT_TELPHONE;?>\n";
	}

	var email=$.trim(frm.email.value);
	if(email.length==0){
		hasError=true;
		errorMsg += "* <?php echo PLEASE_INPUT_EMAIL;?>\n";
	}
	if(email.indexOf('@')==-1){
		hasError=true;
		errorMsg += "* <?php echo EMAIL_STYLE_ERROR;?>\n";
	}

	var address=$.trim(frm.address.value);
	if(address.length==0){
		hasError=true;
		errorMsg += "* <?php echo PLEASE_INPUT_ADDRESS;?>\n";
	}
	
	var apply_reason=$.trim(frm.apply_reason.value);
	if(apply_reason.length==0){
		hasError=true;
		errorMsg += "* <?php echo PLEASE_INPUT_REASON;?>\n";
	}

	if(hasError){
		alert(errorMsg);
		return false;
	}
	return true;
	
	
}
function valideOrderId(){
	var frm = document.forms['refund_form'];
	var orderid = $.trim(frm.orders_id.value);
	if(orderid.length == 0){
       alert("<?php echo NEED_ORDER_NO;?>");
       frm.orders_id.focus();
       return;
	}
	
	jQuery.post(url,{action:'valid_orderid',orderid:orderid},function(result){
		if(typeof result == 'object' && result.status){
			if(result.status == 'success'){
				document.forms['refund_form'].submit();
			} else if(result.content) {
				alert(result.content);
			} else {
				alert("<?php echo UNKNOWN_ERROR;?>");
			}
			
		}
		
	},'json');
	
}
function addLoading(){
	if($('#loading_img').length>0){
		$('#loading_img').show();
	}else{
		var srolltop=0;
		if(parseInt($('html')[0].scrollTop)>0){
			srolltop=parseInt($('html')[0].scrollTop);
		}else if(parseInt($('body')[0].scrollTop)>0){
			srolltop=parseInt($('body')[0].scrollTop);
		}
		var margin_top=(srolltop-100)+'px';
		var style="position:absolute;left:50%;top:50%;margin-left:-16px;margin-top:"+margin_top+";z-index:10001;";
		$('body').append('<img id="loading_img" src="<?php echo DIR_WS_IMAGES?>loading.gif" style="'+style+'" />');
	}
}
function removeLoading(){
	if($('#loading_img').length>0){
		$('#loading_img').hide();
	}
}
jQuery(function(){
	 		<?php 
			  if(isset($insert_erp_error) && $insert_erp_error){
			  ?>
			  alert("<?php echo ERP_ERROR?>");
			  <?php 
			  }
			 ?>
	$('#tbl_repair .uc_input').each(function(){
	  $(this).click(function(){
		$(this).css({color:'#000'});
	  });
	});
})
</script>



