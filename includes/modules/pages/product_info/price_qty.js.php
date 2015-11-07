<script language="javascript" type="text/javascript">
<!--
    var price_arr=[];
	var qty_arr=[];
	//var fprice=<?php echo $currencies->value($show_price,true)?>;
	var logged=<?php echo (isset($_SESSION['customer_id'])&& $_SESSION['customer_id']!=0)?1:0;?>;
	var currency='<?php echo $currencies->currencies[$_SESSION['currency']]['symbol_left'];?>';
	var login_link='<?php echo zen_href_link(FILENAME_LOGIN,'','SSL');?>';
	var qty_limit_str1='For pricing above ';
	var qty_limit_str2=' pieces, please <a href="'+login_link+'">log in</a> now.';
	var max_qty_allowed = max_price_allowed = max_total = 400000;
	<?php //$cnt=0;	     
	 
	      if($quantityDiscountsJS[0]>1){
		     array_unshift($quantityDiscountsJS,array('qty'=>1,'price'=>$currencies->value($show_price,true)));
		  }
	?>
	<?php foreach($quantityDiscountsJS as $key=>$qtyDis){?>
	        price_arr[<?php echo $key;?>]=<?php echo $qtyDis['price'];?>;
			qty_arr[<?php echo $key;?>]=<?php echo $qtyDis['qty'];?>;			
	<?php 
	        if( (!isset($_SESSION['customer_id'])) && $key==SHOW_PRICE_QTY_MAX_GROUP){?>
			   //var max_qty_allowed=<?php /*echo ((int)$quantityDiscountsJS[$key+1]['qty'])-1;*/?>;  zhengcongzhen  20110422
			   <?php //echo ($quantityDiscountsJS[count($quantityDiscountsJS)-1]['qty'])-1;?>
			   var max_qty_allowed=400000;
			   var max_price_allowed=<?php echo $qtyDis['price'];?>;
			   var max_total=<?php echo	($qtyDis['price']*($quantityDiscountsJS[$key+1]['qty']-1));?>;		  
	<?php    
	           break;
	        }
	       // $cnt++;
	      }
	 ?>	
	function calc_the_price(){
	     var entered_qty=$('#input1').val();
		 var target_i=0;
		 if(isNaN(entered_qty)|| entered_qty.length==0){
		       $('#input1').val(1);
			   entered_qty=1;			  
		 }else{
		       $('#input1').val(parseInt(entered_qty/1));
			   entered_qty=parseInt(entered_qty/1);
			   if(entered_qty<=0){
			       entered_qty=1;
				   $('#input1').val(1);
			   }			   
		       
		       for(var tmp_i=0;tmp_i<qty_arr.length;tmp_i++){
			   
				   if(qty_arr[tmp_i]>entered_qty){
					  target_i=tmp_i-1;
					  break;
				   }else{
					  target_i=tmp_i;
				   }	
				   		   
		       }			   	   
		 }
		 if(!logged && entered_qty>max_qty_allowed){
		     $('#no_more_quantity').html(qty_limit_str1+ ''+max_qty_allowed+qty_limit_str2);
			 $('#price_calc_panel').html(currency+''+max_price_allowed.toFixed(2)+' x '+max_qty_allowed+'='+currency+max_total);
		     $('#no_more_quantity').css('display','block');
			 //$('#input2').attr('disabled',true);
		     $('#input1').val(max_qty_allowed);
		 }
		 else if(entered_qty>=400000)
		{
           var total_price=price_arr[target_i]*400000;
			 total_price=total_price.toFixed(2);
          $('#no_more_quantity').html('<?php echo TEXT_PRODUCT_NO_MORE; ?>');
          $('#no_more_quantity').css('display','block');
          $('#input1').val(400000);
		//  $('#price_calc_panel').html(currency+''+' x '+20+'='+currency+max_total);
		  $('#price_calc_panel').html(currency+''+price_arr[target_i].toFixed(2)+' x '+40+'='+currency+total_price);
		}
		 else{
		     $('#input2').removeAttr('disabled');
			 var total_price=price_arr[target_i]*entered_qty;
			 total_price=total_price.toFixed(2);
			 $('#price_calc_panel').html(currency+''+price_arr[target_i].toFixed(2)+' x '+entered_qty+'='+currency+total_price);
			 $('#no_more_quantity').css('display','none');
		 }
		
	}
	$(document).ready(function(){
		$('#input1').keyup(function(){
			 setTimeout(calc_the_price,900);
		 });
		$("#btn_qty_plus").click(function(){
			 var entered_qty=$('#input1').val();
					 
			 if(logged){
				  if(entered_qty<9999){
					 $('#input1').val(parseInt(entered_qty)+1);	
					 calc_the_price();			 
				  }
			 }else{
				  if(entered_qty>=max_qty_allowed){
					   $('#no_more_quantity').html(qty_limit_str1+ ''+max_qty_allowed+qty_limit_str2);				   
					   $('#price_calc_panel').html(currency+''+max_price_allowed.toFixed(2)+' x '+max_qty_allowed+'='+currency+max_total);
					   $('#no_more_quantity').css('display','block');
					  
				  }else{
					   $('#no_more_quantity').css('display','none');
					   $('#input1').val(parseInt(entered_qty)+1);
					   calc_the_price();			   
				  }
			 }
			 
		});
		$("#btn_qty_minus").click(function(){
			 var entered_qty=$('#input1').val();
			 if(entered_qty>1){
				$('#input1').val(parseInt(entered_qty)-1);
				calc_the_price();
			 }
		});	
	});
//-->
</script>
