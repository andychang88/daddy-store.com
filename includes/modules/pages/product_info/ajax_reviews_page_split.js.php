<script language="javascript" type="text/javascript">
 <!--
     var data_reviews=new Array();
     var pre_pageno=1;
	 var review_pid=<?php echo $products_id;?>;
	 var review_lng_id=<?php echo (isset($_SESSION['languages_id'])?$_SESSION['languages_id']:1);?>;
	
	 
	 var helpful="<?php echo TEXT_REVIEW_HELPFUL;?>";
	 var nothelpful="<?php echo TEXT_REVIEW_NOT_HELPFUL;?>";
	 var helpful_or_not="<?php echo TEXT_REVIEW_HELPFUL_OR_NOT;?>";
	 
	 var text_price_vr="<?php echo TEXT_PRICE_RATING_RESULT;?>";
	 var text_value_vr="<?php echo TEXT_VALUE_RATING_RESULT;?>";
	 var text_quality_vr="<?php echo TEXT_QUALITY_RATING_RESULT;?>";
	 
     $(document).ready(function(){
	        $('#previews_pages_nav li').live('click',function(){
			       var pageno=$(this).attr('id');
				   var queryStr='pageno='+pageno+'&review_pid='+review_pid+'&lng_id='+review_lng_id+'&helpful='+helpful+'&nothelpful='+nothelpful+'&helpful_or_not='+helpful_or_not+'&text_price_vr='+text_price_vr+'&text_value_vr='+text_value_vr+'&text_quality_vr='+text_quality_vr;
				   if(pageno!=pre_pageno){
				      if((data_reviews[pageno]==null ||data_reviews[pageno]==undefined )|| pageno<5){
						  $.ajax({
								 type:"Get",      //Get method or post method			
								 async: false,     //asynchonic
								 cache: false,     //read data from cache or not
								 url: "ajax_get_product_reviews.php",//server script pathurl
								 dataType:"text",      //the data type of return(xml,html or text)
								 data: queryStr, 						
								 success:function(text){											 
											data_reviews[pageno]=text;			  
								 },
								 error:function(){
											 alert('server error');
								 }
						 });
					  }
					  pre_pageno=pageno;
					  $('#previews_container').attr('innerHTML',data_reviews[pageno]);
					  window.location.hash="view_reviews";
				   }		    
			});
			$('#previews_pages_nav li').live('mouseover',function(){			   
			   $(this).addClass('page_hover');
			});	
			$('#previews_pages_nav li').live('mouseout',function(){
			   $(this).removeClass('page_hover');
			});		  
	 });
  -->
</script>