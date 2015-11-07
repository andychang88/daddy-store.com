// JavaScript Document
$(document).ready(function(){
   $('.rstatus').click(function(){
	   var selected_review_id=$(this).attr('spanid');
	   var status_value=$(this).attr('status_value');
	   var verify_query='review_id='+selected_review_id+'&status_value='+status_value;
	   $.ajax({
				 type:"GET",      //Get method or post method			
				 async: false,     //asynchonic
				 cache: false,     //read data from cache or not
				 url: "review_quick_verify.php",//server script pathurl
				 dataType:"text",      //the data type of return(xml,html or text)
				 data:verify_query, 						
				 success:function(text){
				   if(text=='1'){					
						$('#span'+selected_review_id).find('img').eq(0).attr('src','images/icon_green_on.gif');
						$('#span'+selected_review_id).attr('status_value',1);
				   }else if(text=='0'){
				        $('#span'+selected_review_id).find('img').eq(0).attr('src','images/icon_red_on.gif');	
					    $('#span'+selected_review_id).attr('status_value',0);
				   }else{
				     alert(text);
				   }
				 },
				 error:function(){
					alert('server error');
				 }
		});
   });
});