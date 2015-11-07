<script language="javascript" type="text/javascript">
<!--
     var review_pid=<?php echo $products_id;?>;
	 var need_login_tip="<?php echo TEXT_NEED_LOGIN_TIP;?>";
	 var no_more_dig="<?php echo TEXT_NO_MORE_DIG;?>";
	 
	 var helpful="<?php echo TEXT_REVIEW_HELPFUL;?>";
	 var nothelpful="<?php echo TEXT_REVIEW_NOT_HELPFUL;?>";
	 var helpful_or_not="<?php echo TEXT_REVIEW_HELPFUL_OR_NOT;?>";	 
	 
	 var review_succ_tip_text="<?php echo TEXT_SUCC_REVIEW_TIP;?>";
	 
	 var re_customer_id=<?php echo $customer_id;?>; 
	 var re_customer_name="<?php echo $customer_name;?>";
	 var re_language_id="<?php echo $language_id;?>";
	 var re_products_id="<?php echo $products_id;?>";
	 
	 var rstar_image_path="<?php echo $rstar_image_path;?>";
	 var gstar_image_path="<?php echo $gstar_image_path;?>";
	 var bstar_image_path="<?php echo $bstar_image_path;?>";
	 var star_review="<?php echo TEXT_STAR_REVIEW;?>";
	 
	 var star_class=[];
	     star_class[1]="<?php echo TEXT_1_STAR_REVIEW;?>";
		 star_class[2]="<?php echo TEXT_2_STAR_REVIEW;?>";
		 star_class[3]="<?php echo TEXT_3_STAR_REVIEW;?>";
		 star_class[4]="<?php echo TEXT_4_STAR_REVIEW;?>";
		 star_class[5]="<?php echo TEXT_5_STAR_REVIEW;?>";
	 <?php if($customer_id!=0){?>
	 function getCookie(name){
		  var strCookie=document.cookie;
		  var arrCookie=strCookie.split("; ");
		  for(var i=0;i<arrCookie.length;i++){
				var arr=arrCookie[i].split("=");
				if(arr[0]==name)return arr[1];
		  }
		  return "";
     }
	 function addCookie(name,value,expireHours){
		  var cookieString=name+"="+escape(value);
		  //判断是否设置过期时间
		  if(expireHours>0){
				 var date=new Date();
				 date.setTime(date.getTime()+expireHours*3600*1000);
				 //alert(date.toGMTString());
				 cookieString=cookieString+"; expires="+date.toGMTString();
		  }
		  document.cookie=cookieString;
	 }	 
	 <?php }?>
     $(document).ready(function(){	
	        //dig/undig a review   
		    <?php if($customer_id!=0){?>
				//dig a review
				$('.Ja').live('click',function(){			  
				   var ja_review_id=$(this).attr('yesid');
				   var ja_cookie=getCookie('yesid'+ja_review_id);
				   if(ja_cookie!=""){
				       alert(no_more_dig);
				   }else{
					   var ja_queryStr='review_id='+ja_review_id+'&review_pid='+review_pid;					   
					   $.ajax({
							 type:"Get",      //Get method or post method			
							 async: false,     //asynchonic
							 cache: false,     //read data from cache or not
							 url: "ajax_dig_a_review.php",//server script pathurl
							 dataType:"text",      //the data type of return(xml,html or text)
							 data: ja_queryStr, 						
							 success:function(text){
							             $('#yesid'+ja_review_id).val(helpful+'('+text+')');
										 addCookie('yesid'+ja_review_id,ja_review_id,30);												
							 },
							 error:function(){
										 alert('server error');
							 }
					   });
				   }
				  
				});
				//undig a review
				$('.Nein').live('click',function(){
				   var nein_review_id=$(this).attr('noid');
				   var nein_cookie=getCookie('noid'+nein_review_id);
				   if(nein_cookie!=""){
				       alert(no_more_dig);
				   }else{
					   var nein_queryStr='review_id='+nein_review_id+'&review_pid='+review_pid;			   
					   $.ajax({
							 type:"Get",      //Get method or post method			
							 async: false,     //asynchonic
							 cache: false,     //read data from cache or not
							 url: "ajax_undig_a_review.php",//server script pathurl
							 dataType:"text",      //the data type of return(xml,html or text)
							 data: nein_queryStr, 						
							 success:function(text){											 
										 $('#noid'+nein_review_id).val(nothelpful+'('+text+')');	
										 addCookie('noid'+nein_review_id,nein_review_id,30);				  
							 },
							 error:function(){
										 alert('server error');
							 }
					   });
				   }
				   
				});
		    <?php }else{?>
			    $('.Ja').live('click',function(){
				        alert(need_login_tip);
				});
				$('.Nein').live('click',function(){
				        alert(need_login_tip);
				});
			<?php }?>
			
			
			//post review for an item
			
			$('#do_product_review').click(function(){	
				//alert(1);
				 //if($('#product_review_form').valid()){   
					  $('#div_review_btn').css('display','none');
					  $('#div_show_processing').css('display','block');
					  //var queryStr_rating=$('#product_review_form').formSerialize();
					  var queryStr_rating= '&review_text='+$('#review_text').val()+'&price_rating='+$('#price_rating').val()+'&value_rating='+$('#value_rating').val()+'&quality_rating='+$('#quality_rating').val();
					//  alert(queryStr_rating);

					  var queryStr_text_tip='&helpful='+helpful+'&nothelpful='+nothelpful+'&helpful_or_not='+helpful_or_not;
					  var queryStr='re_customer_id='+re_customer_id+'&re_customer_name='+re_customer_name+'&re_language_id='+re_language_id+'&re_products_id='+re_products_id+'&';
					      queryStr+=queryStr_rating;
						  queryStr+=queryStr_text_tip;
					  $.ajax({
						 type:"post",      //Get method or post method			
						 async: false,     //asynchonic
						 cache: false,     //read data from cache or not
						 url: "do_product_review.php",//server script pathurl
						 dataType:"text",      //the data type of return(xml,html or text)
						 data: queryStr, 						
						 success:function(text){
									 $('#div_review_btn').css('display','block');
									 $('#div_show_processing').css('display','none');
									 switch(text){
										case 'NOLOGIN':
											  //$('#reivew_error_tip').attr('innerHTML','<?php //echo TEXT_NEED_LOGIN_TIP;?>');
											  //$('#reivew_error_tip').css('display','block');
											  alert("<?php echo TEXT_NEED_LOGIN_TIP;?>");											  
											  break;
										case 'NOREVIEW':
											  //$('#reivew_error_tip').attr('innerHTML','<br/><?php //echo TEXT_NO_REVIEW_CONTENT;?>');
											  //$('#reivew_error_tip').css('display','block');
											  alert("<?php echo TEXT_NO_REVIEW_CONTENT;?>");
											  break;
										case 'INSERTERROR':
											  //$('#reivew_error_tip').attr('innerHTML','<br/><?php //echo TEXT_INSERT_REVIEW_ERROR;?>');
											  //$('#reivew_error_tip').css('display','block');
											  alert("<?php echo TEXT_INSERT_REVIEW_ERROR;?>");
										default:
											  $('#previews_container').prepend(text);
											  window.location.hash="view_reviews";
											  alert(review_succ_tip_text);
											  break;
									 }
									 //$('#focusPic3').unblock();
						 }, //the server-side runs ok ,then the function that the client  will run
						 error:function(){
									 alert('server error');
						 }///the server-side runs error ,then the function that the client  will run
				    });
				 //}
			});
	
			$('#product_review_form').validate({
						event:'keyup',
						rules:{										       
							   review_text:{
											required:true,
											rangelength:[5,5000]
											}
						},
						messages:{									         
								 review_text:{
											required:'<br/><?php echo TEXT_MUST_TYPE_REVIEW_CONTENT;?>',
											rangelength:'<br/><?php echo TEXT_REVIEW_CONTENT_LENGTH_LIMIT;?>'
								 }
						} 
			});
			
			$('#review_text').focus(function(){
					   $('#reivew_error_tip').hide();
					   $('#reivew_success_tip').css('display','none');
			 });	
			//shining star show
			$('#quality_rating_ul li').each(function(){
				   
				  $(this).mouseover(function(){
				      var star=$(this).attr('star_value');
					  if(star<3){
					      for(var i=1;i<6;i++){
						    if(i<=star){
						     $('#qr'+i+' img').eq(0).attr('src',bstar_image_path);
						    }else{
						     $('#qr'+i+' img').eq(0).attr('src',gstar_image_path);
						    }
							
						  }
					  }else{
						  for(var i=1;i<6;i++){
							if(i<=star){
						     $('#qr'+i+' img').eq(0).attr('src',rstar_image_path);
						    }else{
						     $('#qr'+i+' img').eq(0).attr('src',gstar_image_path);
						    } 
						  }
					  }
					  $('#qr_span').attr('innerHTML',star_class[star]);
				  });
			});
			$('#value_rating_ul li').each(function(){
				   $(this).mouseover(function(){
					  var star=$(this).attr('star_value');
					  $('#value_rating').val(star);
					   if(star<3){
					      for(var i=1;i<6;i++){
						    if(i<=star){
						     $('#vr'+i+' img').eq(0).attr('src',bstar_image_path);
						    }else{
						     $('#vr'+i+' img').eq(0).attr('src',gstar_image_path);
						    }
						  }
					  }else{
						  for(var i=1;i<6;i++){
							if(i<=star){
						     $('#vr'+i+' img').eq(0).attr('src',rstar_image_path);
						    }else{
						     $('#vr'+i+' img').eq(0).attr('src',gstar_image_path);
						    } 
						  }
					  }	
					  $('#vr_span').attr('innerHTML',star_class[star]);  
				   });
			});
			$('#price_rating_ul li').each(function(){
				   $(this).mouseover(function(){					  
					  var star=$(this).attr('star_value');
					  $('#price_rating').val(star);
					   if(star<3){
					      for(var i=1;i<6;i++){
						    if(i<=star){
						     $('#pr'+i+' img').eq(0).attr('src',bstar_image_path);
						    }else{
						     $('#pr'+i+' img').eq(0).attr('src',gstar_image_path);
						    }
						  }
					  }else{
						  for(var i=1;i<6;i++){
							if(i<=star){
						     $('#pr'+i+' img').eq(0).attr('src',rstar_image_path);
						    }else{
						     $('#pr'+i+' img').eq(0).attr('src',gstar_image_path);
						    } 
						  }
					  }
					  $('#pr_span').attr('innerHTML',star_class[star]);
				   });
			});
	  });
  -->
</script>