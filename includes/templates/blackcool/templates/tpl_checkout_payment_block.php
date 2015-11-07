<?php
  if (SHOW_ACCEPTED_CREDIT_CARDS != '0') {
		if (SHOW_ACCEPTED_CREDIT_CARDS == '1') {
		  echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled();
		}
		if (SHOW_ACCEPTED_CREDIT_CARDS == '2') {
		  echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled('IMAGE_');
		}
  }   
  
  $selection = $payment_modules->selection();

  if (sizeof($selection) > 1) {
      echo TEXT_SELECT_PAYMENT_METHOD;
  } elseif (sizeof($selection) == 0) {
	  echo TEXT_NO_PAYMENT_OPTIONS_AVAILABLE; 
  }
?>
<table>		
 <?php
	  $radio_buttons = 0;
	  for ($i=0, $n=sizeof($selection); $i<$n; $i++) {
 ?>   		                	
			<?php if ($selection[$i]['checked']==1){?>		
			 <tr id="defaultSelected" class="moduleRowSelected" 
				 onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" 
				 onclick="selectRowEffect(this,<?php echo $radio_buttons;?>)">		
			<?php }else{?>		
			 <tr class="moduleRow" onmouseover="rowOverEffect(this)" 
				 onmouseout="rowOutEffect(this)"
				 onclick="selectRowEffect(this,<?php echo $radio_buttons;?>)">		
			<?php }?>		                   
			   <td>
			<?php   
				   if (sizeof($selection) > 1) {
					  if (empty($selection[$i]['noradio'])) {    
						   echo zen_draw_radio_field('payment', 
													$selection[$i]['id'], 
													($selection[$i]['id'] == $_SESSION['payment'] ? true : false), 
													'id="pmt-'.$selection[$i]['id'].'"'); 							
					  } 
				   }else{			
					 echo zen_draw_hidden_field('payment', $selection[$i]['id']); 						
				   }
			  ?> </td>		                    
			     <td><b><?php echo $selection[$i]['module']; ?></b></td>                
			</tr>		
			<?php if(isset($selection[$i]['error'])){ ?>						  
			<tr>			                    
				<td colspan="2"><?php echo $selection[$i]['error'];?></td>			                    
			</tr>		
			<?php }elseif(isset($selection[$i]['fields']) && is_array($selection[$i]['fields'])){?> 			                  
			<tr>
			    <td>&nbsp;</td>			                   
				<td class="pm_field_table">
					  <table>	
					   <?php  for ($j=0, $n2=sizeof($selection[$i]['fields']); $j<$n2; $j++) {?>
						   <tr>				                       
							   <td>
					   <?php   
								if(isset($selection[$i]['fields'][$j]['title'])){

									echo $selection[$i]['fields'][$j]['title'];
								}
						?>
							   </td>				                        
							   <td>
					   <?php 
									echo $selection[$i]['fields'][$j]['field']; 
						?>
							   </td>				                       
							</tr>							
						<?php }?>			 			                   
					   </table>
				</td>			                    
			</tr>					
		   <?php }?>		 		               
            		
<?php 
	$radio_buttons++;
   }
?>		        
 </table>