<script type="text/javascript">
	var top_items_count_tip='<?php echo TEXT_SHOPPING_CART_DESCRIPTION;?>';
	var btn_add_cart_processing='<?php echo $btn_add_cart_processing;?>';
	var btn_add_cart='<?php echo $btn_add_cart; ?>';
	$(document).ready(function(){
		$('#addtocart_btn').live('click',function(){
			<?php if(sizeof($check_must_select)>0){?>			
			if(add_to_cart_check()){
			<?php }?>
				$('#add_cart_place').html(btn_add_cart_processing);
				var formData=$('#products_add_form').formSerialize();
				$.ajax({
					 type:"POST",//Get method or post method			
					 async: false,//asynchonic
					 cache: false,//read data from cache or not
					 url: "ajax_add_to_cart.php",//server script pathurl
					 dataType:"text",//the data type of return(xml,html or text)
					 data:formData, 						
					 success:function(text){			
							var dd=eval('['+text+']');							
							$('#add_cart_place').html(btn_add_cart);
													
							if(dd[0].error){
								alert(dd[0].error);
							}else{
								var total_amount=dd[0].total_amount;
								var items_count=dd[0].items_count;
								$('#a_total_amount').html(total_amount);
								$('#a_items_count').html(items_count);
								$('#tci_count').html(items_count+' '+top_items_count_tip);//ding
															
								$('#a_addcart_result').css('display','block');
							}
							
					 },
					 error:function(){
							alert('server error');
							$('#add_cart_place').html(btn_add_cart);
					 }
				
				});
			<?php if(sizeof($check_must_select)>0){?>
			}
			<?php }?>
		});
		$('#go_to_top').click(function(){
			window.location.hash="the_topest_area";
		});
		$('#bottom_buy_now').click(function(){
			<?php if(sizeof($check_must_select)>0){?>			
			if(add_to_cart_check()){
			<?php }?>
				$('#add_cart_place').html(btn_add_cart_processing);
				var formData=$('#products_add_form').formSerialize();
				$.ajax({
					 type:"POST",//Get method or post method			
					 async: false,//asynchonic
					 cache: false,//read data from cache or not
					 url: "ajax_add_to_cart.php",//server script pathurl
					 dataType:"text",//the data type of return(xml,html or text)
					 data:formData, 						
					 success:function(text){			
							var dd=eval('['+text+']');							
							$('#add_cart_place').html(btn_add_cart);
													
							if(dd[0].error){
								alert(dd[0].error);
							}else{
								var total_amount=dd[0].total_amount;
								var items_count=dd[0].items_count;
								$('#a_total_amount').html(total_amount);
								$('#a_items_count').html(items_count);
								$('#tci_count').html(items_count+' '+top_items_count_tip);//ding
															
								$('#a_addcart_result').css('display','block');
								window.location.hash="top_buy_area";
							}
							
					 },
					 error:function(){
							alert('server error');
							$('#add_cart_place').html(btn_add_cart);
					 }
				
				});
			<?php if(sizeof($check_must_select)>0){?>
			}else{
				window.location.hash="top_buy_area";
				$('#msg-submit').css('display','block');
			}
			<?php }?>
		});
		$('#addcart_result_colse').click(function(){
			$('#a_addcart_result').css('display','none');
		});	
		$('#more_shopping').click(function(){
			$('#a_addcart_result').css('display','none');
		});
	});
</script>