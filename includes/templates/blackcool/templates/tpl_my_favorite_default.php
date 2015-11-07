<?php

?>
<style type="text/css">
.uccoupon,uccoupon td{border:1px solid #CCC;}
</style>
<div class="ucright">
	 
	  <div class="ucpwd">
        <h2><?php echo HEADING_TITLE;?></h2>
          <table id="myFavoriteTable" border="0" width="100%" class="uccoupon margintop10px">
            <tbody><tr class="bgfffafa fontbold lineheight20px">
           	  <td align="center" width="3%" valign="middle"></td>
              <td align="center" valign="middle"><?php echo PRODUCT_IMAGE;?></td>
              <td align="center" valign="middle"><?php echo PRODUCT_NAME;?></td>
              <td align="center" valign="middle"><?php echo PRODUCT_PRICE;?></td>
              <td align="center" valign="middle"><?php echo PRODUCT_STOCK;?></td>
              <td align="center" valign="middle"><?php echo PRODUCT_ACTION;?></td>
            </tr>
 <?php 
 if (count($favoriteArray) > 0) {
	foreach ($favoriteArray as $fav) {
		$price_notice_on = $fav['price_notice_id']==0?'block':'none';
		if($fav['price_notice_id']==0){
			$price_notice_on = 'block';
			$price_notice_off = 'none';
			$price_notice_id = '';
		}else{
			$price_notice_on = 'none';
			$price_notice_off = 'block';
			$price_notice_id = $fav['price_notice_id'];
		}
?>           
            <tr>
              <td align="center" width="3%" valign="middle"><input type="checkbox" class="checkone" price="<?php echo $fav["price_num"];?>" fid="<?php echo $fav["favorite_id"];?>"  name="products_id[]" value="<?php echo $fav["products_id"];?>"></td>
              <td align="center" width="15%" valign="middle">
              <a href="<?php echo zen_href_link('product_info','products_id='.$fav["products_id"]);?>" >
               <img alt="<?php echo $fav["products_name"];?>" title="<?php echo $fav["products_name"];?>" height="80" width="80" src="<?php echo DIR_WS_IMAGES.$fav["products_image"];?>">
              </a>
              </td>
              <td><div class="color666">
              	<h3 class="fontsize11px"><a href="<?php echo zen_href_link('product_info','products_id='.$fav["products_id"]);?>" class="color666"><?php echo $fav["products_name"];?></a></h3>
              </div></td>
              <td align="center" width="10%" valign="middle"><span class="colorCC0406 fontbold"><?php echo $fav["products_price"];?></span></td>
              <td align="center" width="10%" valign="middle"><?php echo $fav["products_stock_status"]==1?PRODUCT_STOCK_ON : PRODUCT_STOCK_OUT;?></td>
              <td width="15%">
              	<div class="alignright"><span onclick="addToCart('<?php echo $fav["products_id"];?>');">
              	<?php echo zen_image(DIR_WS_TEMPLATE_BUTTON.'lib_btn01.gif','','','','style="cursor:pointer;"');?>
              	</span></div>
                <div class="alignright margintop5px"><span>
                <a href="<?php echo zen_href_link('my_favorite','favorite_id='.$fav["favorite_id"].'&act=del&ucenter=1');?>">
                <?php echo zen_image(DIR_WS_TEMPLATE_BUTTON.'lib_btn02.gif','','','','style="cursor:pointer;"');?>
                </a></span>
                </div>
                <div class="alignright margintop5px">
                <a style="display:;"  href="javascript:void(0);" onclick="priceNotice('<?php echo $fav["products_afterbuy_model"];?>');">
                <?php echo zen_image(DIR_WS_TEMPLATE_BUTTON.'price_notice2.gif','','','','style="cursor:pointer;"');?>
                </a>
                <a style="display:none;" href="javascript:void(0);" onclick="priceNotice(this,'off','<?php echo $fav["products_afterbuy_model"];?>','<?php echo $fav["language_id"];?>','<?php echo $fav["price_num"];?>','<?php echo $fav["price_notice_id"];?>','<?php echo $fav["favorite_id"];?>');"><?php echo PRICE_NOTICE;?></a>
                <span style="cursor:pointer;display:none;" onclick="window.open('<?php echo zen_href_link('my_favorite','ucenter=1&action=price_notice&favorite_id='.$fav["favorite_id"]);?>','_self');">(Notices:<?php echo $fav["message_num"];?>)</span>
                </div>
              </td>
            </tr>
 <?php }//end foreach?>           
            
            
            <tr>
            	<td valign="middle"><input type="checkbox"   class="checkall"  name="checkbox3"></td>
                <td valign="middle" colspan="5">
                    <span onclick="addAllToCart();">
                    <?php echo zen_image(DIR_WS_TEMPLATE_BUTTON.'lib_btn01.gif','','','','style="cursor:pointer;"');?>
                    </span>
                    <span class="paddingleft10px" onclick="cancelFavorite();">
                    <?php echo zen_image(DIR_WS_TEMPLATE_BUTTON.'lib_btn02.gif','','','','style="cursor:pointer;"');?>
                    </span>
                    <span class="paddingleft10px" onclick="caculatePrice();">
                    <?php echo zen_image(DIR_WS_TEMPLATE_BUTTON.'lib_btn03.gif','','','','style="cursor:pointer;"');?></span>
                </td>
            </tr>
            
  <?php 

 } else {
   ?>
<tr><td colspan=6 align="center"><?php echo NO_MESSAGE;?></td></tr>
<?php }?>

          </tbody></table>
          
 <?php if( $page_split->number_of_pages>0){?>
<br><div class="navSplitPagesLinks forward"><?php echo $page_split->display_links(10, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?></div>
<?php }?>


      </div>
    </div>
    
    
<?php 
/*
 * <form id="buyer_recommend_form" method="post" action="index.php?main_page=product_info&action=multiple_products_add_product">
 */

 echo zen_draw_form('buyer_form',zen_href_link(zen_get_info_page($products_id), 

																				zen_get_all_get_params(array('action','ucenter')).'products_id='.$products_id.'&action=multiple_products_add_product'),

												  'post', 

												  ' enctype="multipart/form-data" id="buyer_form"');
																				


?>

</form>    
  
  
<?php
	//price notice
		  require($template->get_template_dir('tpl_my_modules_price_notice_default.php',
											   DIR_WS_TEMPLATE, 
											   $current_page_base,
											   'templates'). '/tpl_my_modules_price_notice_default.php');
	 ?>
  
    
<span style="display:none;" id="price_prefix"><?php echo $price_prefix;?></span>    
<script language="javascript">
var please_select_product='<?php echo PLEASE_SELECT_YOUR_PRODUCT;?>';

function caculatePrice(){
	var price_total=0;
	var title="<?php echo TOTAL_PRICE_IS;?>";
	if($('#myFavoriteTable input:checkbox:checked').length==0){
		alert(please_select_product);
		return;
	}
	$('#myFavoriteTable input:checkbox:checked').each(function(){
		if(!$(this).hasClass('checkall')){
			price_total = price_total + parseFloat($(this).attr('price'));
		}
	});
	var price_prefix=$('#price_prefix').html();
	alert(title+price_prefix+price_total);
}
function cancelFavorite(){
	var url = '<?php echo zen_href_link('my_favorite','favorite_id=:fids&act=del&ucenter=1');?>';
	var fid_str='';
	$('#myFavoriteTable input:checkbox:checked').each(function(){
		if(!$(this).hasClass('checkall')){
			fid_str +=$(this).attr('fid')+',';
		}
	});
	
	if(fid_str.length==0){
		alert(please_select_product);
		return;
	}
	if(fid_str.substr(fid_str.length-1,1)==','){
		fid_str = fid_str.substr(0,fid_str.length-1);
	}
	url = url.replace(':fids',fid_str).replace(/&amp;/g,'&');
	window.open(url,'_self');
}
function addAllToCart(){
	var input_str='';
	var pid='';
	$('#myFavoriteTable input:checkbox:checked').each(function(){
		if(!$(this).hasClass('checkall')){
			pid=$(this).val();
			input_str +="<input type='hidden' name='products_id["+pid+"]' value='1' />";
		}
	});
	
	if(input_str.length==0){
		alert(please_select_product);
		return;
	}
	
	$('#buyer_form').html(input_str);
	$('#buyer_form').attr('target','_blank');
	$('#buyer_form').submit();
}
function addToCart(pid){
	var input_str="<input type='hidden' name='products_id["+pid+"]' value='1' />";
	$('#buyer_form').html(input_str);
	$('#buyer_form').attr('target','_blank');
	$('#buyer_form').submit();
}
jQuery(function(){
	$('#myFavoriteTable').find('input.checkall').click(function(){
		var is_checked = $(this).is(':checked')?'checked':false;
		$('#myFavoriteTable').find('input.checkone').each(function(){
			$(this).attr('checked',is_checked);
		});
        
	});
});
var price_notice_products_id='';
function sendPriceNotice(products_id ){
	var has_error=false;
	var errorMsg = '';
	var my_email=$.trim($('#my_email').val());
	
	var products_id = price_notice_products_id;
	if(my_email.length==0){
		has_error = true;
		errorMsg += "* <?php echo PRICE_NOTICE_INPUT_EMAIL;?>\n";
		$('#my_email').focus();
	}
	if(my_email.indexOf('@')==-1 || my_email.indexOf('.')==-1){
		has_error = true;
		errorMsg += "* <?php echo PRICE_NOTICE_EMAIL_ERROR;?>\n";
		$('#my_email').focus();
	}
	
	var my_price=$.trim($('#my_price').val());
	if(my_price.length==0){
		has_error = true;
		errorMsg += "* <?php echo PRICE_NOTICE_MY_PRICE;?>\n";
		$('#my_price').focus();
	}
	if(/[^\d\.]/.test(my_price)){
		has_error = true;
		errorMsg += "* <?php echo PRICE_NOTICE_PRICE_ERROR;?>\n";
		$('#my_price').focus();
	}
	if(has_error){
		alert(errorMsg);
		return;
	}else{
		var url='<?php echo zen_href_link('my_order_status','action=price_notice');?>&action=price_notice&my_price='+my_price+'&my_email='+my_email+'&pid='+products_id;
		url=url.replace(/amp;/g,'');
		addLoading();
		$.get(url,{},function(result){
			removeLoading();
			if(typeof result == 'object' && result.status && result.status=='success'){
				alert("<?php echo PRICE_NOTICE_SUCCESS;?>");
			}else if(typeof result == 'object' && result.status && result.content=='repeat'){
				alert("<?php echo PRICE_NOTICE_REPEAT_ERROR;?>");
			}else{
				alert("<?php echo PRICE_NOTICE_UNKNOWN_ERROR;?>");
			}
		},'json');
		
	}
	
}

function priceNotice(products_id,close){
	   var price_notice_id='price_notice_box';
	   if(close){
		   $('#'+price_notice_id).hide();
		   $('#price_notice_frm').hide();
		   removeLoading();
		   return;
	   }
	   price_notice_products_id = products_id;
	   $('#'+price_notice_id).show();
			if($('#price_notice_frm').length==0){
			  $('body').append('<iframe id="price_notice_frm" style="border:0;display:none;position:absolute;left:0px;top:0px;background:#fff;z-index:999;"></iframe>');
			  var iBodyWidth = jQuery(window).width();
		      var iBodyHeight = jQuery(document).height();
		      $('#price_notice_frm').css({width:iBodyWidth+'px',height:iBodyHeight+'px',opacity:.3});
			}
			$('#price_notice_frm').show();
	   
}

var my_favorite_url = '<?php echo zen_href_link("my_favorite", ""); ?>';

function priceNotice2(obj,turn, pid, languages_id, products_price, price_notice_id,favorite_id){
	if(!pid || !languages_id) return;
	var url = my_favorite_url;


    if(turn == 'on'){
    	var params = {
    			'products_id':pid,
    			'favorite_id':favorite_id,
    			'languages_id':languages_id,
    			'products_price':products_price,
    			'act':'price_notice',
    			'ucenter':'1'
    			};
    	jQuery.post(url,params,function(result){
    		if(typeof result == 'object' && result.status){

               $(obj).hide();
       		   $(obj).next('a').show();
     
    		}
    	},'json');
    	
    	
    }
    
    if(turn == 'off'){
    	var params = {
    			'price_notice_id':price_notice_id,
    			'act':'price_notice_cancel',
    			'ucenter':'1'
    			};
    	jQuery.post(url,params,function(result){
    		if(typeof result == 'object' && result.status){

               $(obj).hide();
       		   $(obj).prev('a').show();
    		}
    	},'json');

    }

	
	
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
</script>