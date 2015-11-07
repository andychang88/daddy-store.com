<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_main_product_image.php 3208 2010-03-24 11:28:57Z johnzhang $
 */

?>
<?php //require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_MAIN_PRODUCT_IMAGE)); ?>
	<div>
	<div id="add_to_fav" style="display:'';margin:8px 0;"><a rel="nofollow" style="color:red;" onclick="Addtofavorite(this);" href="javascript:void(0);">
	<?php echo zen_image(DIR_WS_TEMPLATE_BUTTON.'fav.gif','add to favorite');?>
	</a></div>
	<div id="add_to_login"  style="display:none;margin:8px 0;"><a  rel="nofollow"  style="color:red;" href="<?php echo zen_href_link('login','');?>">
	<?php echo zen_image(DIR_WS_TEMPLATE_BUTTON.'button_login.gif');?>
	</a></div>
	<?php 
	//erp方面的产品id不能全部是数字。这里的产品id如果全部是数字，将不能使用降价通知
	if(preg_match("/[a-zA-Z]/",$products_afterbuy_model)){
	?>
	<div id="price_notice" style="display:'';margin:8px 0;"><a rel="nofollow" style="color:red;" onclick="priceNotice(this);" href="javascript:void(0);">
	<?php echo zen_image(DIR_WS_TEMPLATE_BUTTON.'price_notice.gif','price notice');?>
	</a></div>
	<?php }?>
	</div>

<?php
	//price notice
		  require($template->get_template_dir('tpl_my_modules_price_notice_default.php',
											   DIR_WS_TEMPLATE, 
											   $current_page_base,
											   'templates'). '/tpl_my_modules_price_notice_default.php');
	 ?>

	<script language="javascript">
	var add_to_favorite_url = '<?php echo zen_href_link('my_add_to_favorite', 'pid='.$products_id.'&p='.$current_category_id);?>';
	add_to_favorite_url = add_to_favorite_url.replace('&amp;','&');
	function Addtofavorite(obj){
		addFavoriteStatics();
		add_to_favorite_url=add_to_favorite_url+'&rnd='+Math.random();
		jQuery.get(add_to_favorite_url,{},function(result){
			result = eval('('+result+')');
		 if(typeof result == 'object' && result.content){
			 if(result.status=='need_login'){
				 $('#add_to_fav').hide();
				 $('#add_to_login').show();
			 }
			 alert(result.content);
 
		 }
		},'html');
	}
	function addFavoriteStatics(){
		var url='<?php echo zen_href_link('my_order_status','pid='.$products_id.'&action=add_favorite');?>';
		url=url.replace(/amp;/g,'');
		if(url.indexOf('products_id')==-1){
			url = url + '&pid=<?php echo $products_id;?>';
		}
		
		$.get(url,{},function(result){
			
		},'json');
	}
	function sendPriceNotice(products_id ){
		var has_error=false;
		var errorMsg = '';
		var my_email=$.trim($('#my_email').val());
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
			addLoading();
		
			var url='<?php echo zen_href_link('my_order_status','');?>&action=price_notice&my_price='+my_price+'&my_email='+my_email+'&pid='+products_id;
			
			url=url.replace(/&amp;/g,'');
			$.get(url,{},function(result){
				removeLoading();
				result = eval('('+result+')');
				if(typeof result == 'object' && result.status && result.status=='success'){
					alert("<?php echo PRICE_NOTICE_SUCCESS;?>");
				}else if(typeof result == 'object' && result.status && result.content=='repeat'){
					alert("<?php echo PRICE_NOTICE_REPEAT_ERROR;?>");
				}else{
					alert("<?php echo PRICE_NOTICE_UNKNOWN_ERROR;?>");
				}
			},'html');
			
		}
		
	}
   function priceNotice(obj,close){
	   var price_notice_id='price_notice_box';
	   if(close){
		   $('#'+price_notice_id).hide();
		   $('#price_notice_frm').hide();
		   removeLoading();
		   return;
	   }
	   $('#'+price_notice_id).show();
			if($('#price_notice_frm').length==0){
			  $('body').append('<iframe id="price_notice_frm" style="border:0;display:none;position:absolute;left:0px;top:0px;background:#fff;z-index:999;"></iframe>');
			  var iBodyWidth = jQuery(window).width();
		      var iBodyHeight = jQuery(document).height();
		      $('#price_notice_frm').css({width:iBodyWidth+'px',height:iBodyHeight+'px',opacity:.3});
			}
			$('#price_notice_frm').show();
	   
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