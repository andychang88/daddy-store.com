<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account_history.<br />
 * Displays all customers previous orders
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_account_history_default.php 2580 2005-12-16 07:31:21Z birdbrain $
 */

?>
<style type="text/css">
.ordertable td {
border:1px solid #CCCCCC;text-align:center;
}
.uctabimg img{
border:1px solid #CCCCCC;padding:0;
}
.uctabimg img:hover {
padding:0;border:1px solid #CCCCCC;
}
</style>
<div class="ucright">
       <div class="ucpwd">
            <h2><?php echo HEADING_TITLE;?></h2>
       </div>
       <div style="margin-top:15px;">
       <form method="post" onsubmit="return checkForm(this);"  action="<?php echo zen_href_link('my_orders','action=find_order&ucenter=1');?>">
       <?php echo FIND_ORDER;?><input type="text" id="find_orders_id" name="find_orders_id" class="uc_input">
       &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="<?php echo BTN_SUBMIT;?>" />
       <?php if($find_str){?>
       &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="showAllOrders('<?php echo zen_href_link('my_orders','ucenter=1');?>');" name="button" value="<?php echo BTN_SHOW_ALL;?>" />
       <?php }?>
       </form>
       </div>
        <div class="uctab">

            <div class="">
                <div>
					<table border="0" width="100%" class="ordertable">
                      <tbody><tr class="ordertrbg3">
                        <td><?php echo ORDER_NO;?></td>
                        <td><?php echo ORDER_PRODUCT;?></td>
                        <td><?php echo PRODUCT_STATUS;?></td>
                        <td><?php echo TRACK_NUM;?></td>
                        <td><?php echo USER_ACTION;?></td>
                      </tr>
                      <?php
                      $products_id_str='';
                      $my_order_ids = array();
						  if ($accountHasHistory === true && $accountHistory) {
						  	foreach ($accountHistory as $history) {
						  $my_order_ids[] = $history['orders_id'];
						?>
                      <tr >
                        <td><span class="fontbold"><?php echo $history['orders_id']; ?></span></td>
                        <td class="uctabimg">
                        	<?php 
                        	$hidden_input="<span id='span_".$history['orders_id']."'>";
                        	foreach($history['products'] as $row){
                        		$hidden_input.= "<input type='hidden' name='products_id[".$row['products_id']."]' value='".$row['products_quantity']."' />";
                        		$products_id_str='products_id='.$row['products_id'];
                        		echo '<a target="_blank" href="'.zen_href_link('product_info','products_id='.$row['products_id']).'" title="'.$row['products_name'].'">';
                        		echo zen_image(DIR_WS_IMAGES.$row['products_image'],$row['products_name'],50,50);
                        		echo '</a>';
                        	}
                        	$hidden_input.= "<input type='hidden' id='shipping_".$history['orders_id']."' name='shipping' value='".$history['shipping_module_code']."' />";
                        	$hidden_input.= "<input type='hidden' id='payment_".$history['orders_id']."'  name='payment' value='".$history['payment_module_code']."' />";
                        	$hidden_input.= "<input type='hidden' id='coupon_".$history['orders_id']."'  name='coupon' value='".$history['coupon_code']."' />";
                        	
                        	
                        	$hidden_input.='</span>';
                        	echo $hidden_input;
                        	?>
                          
                        </td>
                        <td><span class="fontbold colorCC0406"><?php echo strip_tags($history['orders_status_name']); ?></span></td>
                        <td><span class="fontbold"><?php echo strip_tags($history['track_num']); ?></span></td>
                        <td style="font-weight:bold;">
                        <?php 
                        //付款操作暂时屏蔽掉
                        if( $history['orders_status']=='1'){?>
                        <a href="javascript:void(0);" onclick="handlePayment('<?php echo $history['orders_id'];?>');">
                        <?php 
                        $pay_img = DIR_WS_TEMPLATE_BUTTON . 'mail_checkout.gif';
                        if(is_file($pay_img)){
                        	echo zen_image($pay_img,'','150','30');
                        }else{
                        	echo ORDER_ACTION_PAY;
                        }
                        ?>
                        </a>
                        <?php }else if($history['orders_status']=='4' || $history['orders_status']=='5'){?>
                        <a href='javascript:getDeliveredInfo2("<?php echo $history['track_url'];?>");'><?php echo VIEW_DELIVERED_INFO;?></a>
                           
                        <?php }else if($history['orders_status']=='3'){?>
                         <a href='javascript:void(0);' onclick='getProcessingInfo("<?php echo $history['orders_id'];?>",this)'><?php echo VIEW_PROCESSING_INFO;?></a>
                        	<?php 
                        }else if($history['orders_status']=='2'){?>
                        <a href='javascript:void(0);' onclick='getPayedInfo("<?php echo $history['orders_id'];?>",this);'><?php echo VIEW_PAYED_INFO;?></a>
                        <?php 
                        }else{
                           echo NO_ACTION;
                        }?>
                        
                        </td>
                      </tr>
                     <?php } /*end foreach*/?> 
                      
                      <tr>
                        <td align="center" valign="middle" colspan="6">
                        	<div class="alignright">
                        		
                            	<span class="marginright20px"><?php echo ORDER_PENDING;?>:<font class="colorCC0406 fontbold"><?php echo $status_count['Pending'];?></font></span>
                                <span class="marginright20px"><?php echo ORDER_PAYED;?>:<font class="colorCC0406 fontbold"><?php echo $status_count['Payed'];?></font></span>
                                <span class="marginright20px"><?php echo ORDER_PROCESSING;?>:<font class="colorCC0406 fontbold"><?php echo $status_count['Processing'];?></font></span>
                                <span class="marginright20px"><?php echo ORDER_DELIVERIED;?>:<font class="colorCC0406 fontbold"><?php echo $status_count['Delivered'];?></font></span>
                            </div>
                        </td>
                      </tr>
                      <?php } else {?>
                      <tr><td colspan="6"><?php echo TEXT_NO_PURCHASES;?></td></tr>
                      <?php }/*end if*/?>
                    </tbody></table>
				</div>
				
				
            </div>
        </div>
   
    </div>

    <?php 

 echo zen_draw_form('buyer_form',zen_href_link('product_info',zen_get_all_get_params(array('action')).'action=multiple_products_add_product&'.$products_id_str),

												  'post', 

												  ' enctype="multipart/form-data" id="buyer_form"');
?>

</form>  

<input type="hidden" id="set_pay_url" value="<?php echo zen_href_link('my_orders','ucenter=1&action=reset_pay_argument');?>" name="set_pay_url" />
 <div id="tip" style="display:none;border:1px solid #C9E1F4;padding:5px 10px;width:200px;height:50px;position:absolute;background:#FCF6E0;">
    <?php echo ORDER_IS_PROCESSING_PLEASSE_WAITING;?>
 </div>   
<script language="javascript">
function getDeliveredInfo2(track_url){
	window.open(track_url,'_blank');
}
function getDeliveredInfo(orders_id){
	clearTimeout(hanle_timeout);
	$('#tip').hide();
	alert('NO INFOMATION');
}
var hanle_timeout;
function getProcessingInfo(orders_id,obj){
	clearTimeout(hanle_timeout);
	
	var pos=$(obj).offset();
	$('#tip').css({left:(pos.left-68)+'px',top:(pos.top+15)+'px'});

	$('#tip').show();
	hanle_timeout=setTimeout(function(){
		$('#tip').hide();
	},2000);
}
function getPayedInfo(orders_id,obj){
	clearTimeout(hanle_timeout);
	
	var pos=$(obj).offset();
	$('#tip').css({left:(pos.left-68)+'px',top:(pos.top+15)+'px'});

	$('#tip').show();
	hanle_timeout=setTimeout(function(){
		$('#tip').hide();
	},2000);
}
function handlePayment(orders_id){
	var set_pay_url=$('#set_pay_url').val();
	var payment=$('#payment_'+orders_id).val();
	var shipping=$('#shipping_'+orders_id).val();
	var coupon=$('#coupon_'+orders_id).val();

	var reset_pay_error=false;
	var data={orders_id:orders_id,coupon:coupon,payment:payment,shipping:shipping};
	$.ajax({
		type:"POST",
		async:false,
		url:set_pay_url,
		data:data,
		dataType:'json',
		success:function(result){
			if(typeof result != 'object' || result.status != 'success'){
	        	alert('Error');
	        	reset_pay_error=true;
	        }
		}

	});


    if(reset_pay_error) return;
	
	var input_html = $('#span_'+orders_id).html();
	//setTimeout(function(){
		
	$('#buyer_form').html(input_html);
	
	var url_action = $('#buyer_form').attr('action');
	url_action=url_action+'&redirect_to_shipping=1&old_orders_id='+orders_id;
	$('#buyer_form').attr('action',url_action);
	if(set_blank_win){
	  $('#buyer_form').attr('target','_blank');
	}
	$('#buyer_form').submit();
	
	//},0);

//	
//	$.post(set_pay_url,{orders_id:orders_id,coupon:coupon,payment:payment,shipping:shipping},function(result){
//        if(typeof result != 'object' || result.status != 'success'){
//        	alert('Error');
//        	reset_pay_error=true;
//        }
//
//        
//    	
//		},'json');
//	
	
}
function showAllOrders(url){
	window.open(url,'_self');
}
function checkForm(frm){
	var orders_id = $.trim(frm.find_orders_id.value);
	if(orders_id.length==0 || /\D/.test(orders_id)){
		alert("<?php echo ORDER_NO_ERROR;?>");
		frm.find_orders_id.focus();
		return false;
	}
	
	return true;
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

var set_blank_win = true;
$(function(){
	
	<?php if(isset($_REQUEST['order_id']) && in_array($_REQUEST['order_id'], $my_order_ids)){ ?>
	addLoading();
	set_blank_win = false;
	handlePayment('<?php echo $_REQUEST['order_id'];?>');

	<?php }?>
	
});
</script>    
    
    
    
    
    