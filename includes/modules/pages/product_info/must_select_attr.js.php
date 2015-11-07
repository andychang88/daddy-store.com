<script language="javascript" type="text/javascript">
var cms=[];
<?php foreach($check_must_select as $opt_id=>$val_id){?>
		   cms[<?php echo $opt_id;?>]=<?php echo $val_id;?>;
<?php }?> 
<!--
$(document).ready(function(){   
   $('#products_add_form').attr('onsubmit','return add_to_cart_check();');   
   $('#productAttributes select').each(function(){
      $(this).change(function(){
	         var cchk=$(this).val();
			 for(var cv in cms){
			   if(cms[cv]!=cchk){
				 $(this).removeClass('attr_must_sel');				
			   }
			 }
	  });
   });   
}); 

function add_to_cart_check(){
      var atcc_check=true;
      $('#productAttributes select').each(function(){
	     var chk=$(this).val();
		 for(var v in cms){
		   if(cms[v]==chk){
		     $(this).addClass('attr_must_sel');
		     //$(this).css({ color: "#ff0011", background: "blue" }); 
			 atcc_check=false;
		   }
		 }
	  });
	  return atcc_check;
   }
-->
</script>