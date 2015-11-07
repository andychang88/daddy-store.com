<?php
   if($free_shipping == true){
?>
   <table border="0" width="100%" cellspacing="0" cellpadding="0">  
       <tr>     
          <td class="leftdist">&nbsp;</td>    
          <td width="100%"> 
              <table border="0" width="100%" cellspacing="0" cellpadding="3">        
                 <tr>           
                    <td colspan="2"><b><?php echo FREE_SHIPPING_TITLE;?></b>&nbsp;<?php echo $quotes[$i]['icon']; ?></td>        
                 </tr>        
                 <tr id="defaultSelected" class="moduleRowSelected" o
                     nmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" 
                     onclick="selectRowEffect(this, 0)">           
                     <td class="leftdist">&nbsp;</td>          
                     <td width="100%">
						  <?php echo sprintf(FREE_SHIPPING_DESCRIPTION, 
                                             $currencies->format(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER)) 
                                . zen_draw_hidden_field('shipping', 'free_free');
                           ?>
                     </td>        
                 </tr>      
              </table>
          </td> 
       </tr>
   </table>
<?php
   }else{
?>
   <table>  
<?php 
    $radio_buttons = 0;
	
    for ($i=0, $n=sizeof($quotes); $i<$n; $i++) {

      if(zen_not_null($quotes[$i]['module'])){
?>
        <tr>
            <th><?php 
						if(isset($quotes[$i]['icon']) && zen_not_null($quotes[$i]['icon'])){
							echo $quotes[$i]['icon'];
						}
				?><b>
				<?php echo $quotes[$i]['module'];?></b>
            </th>
        </tr>
	<?php if (isset($quotes[$i]['error'])){?>        
        <tr>    
            <td colspan="2"><?php echo $quotes[$i]['error'];?></td>        
        </tr> 
    <?php }else{
             for($j=0,$n2=sizeof($quotes[$i]['methods']);$j<$n2;$j++){     
                 $checked = (($quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'] == $_SESSION['shipping']['id']) ? true : false);
                 if($checked==true && ($n==1&&$n2==1)){?>
                 <tr id="defaultSelected" class="moduleRowSelected" 
                     onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" 
                     onclick="selectRowEffect(this,<?php echo $radio_buttons;?>)">
        <?php   }else{?>
                  <tr class="moduleRow" onmouseover="rowOverEffect(this)" 
                      onmouseout="rowOutEffect(this)" 
                      onclick="selectRowEffect(this,<?php echo $radio_buttons;?>)">    
        <?php   }?>
                <td width="90%">
                <?php 
                      echo zen_draw_radio_field('shipping', 
                                                $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'], 
                                                $checked, 
                                                'id="ship-'.$quotes[$i]['id'] . '-' . $quotes[$i]['methods'][$j]['id'].'"');
                      echo $quotes[$i]['methods'][$j]['title'];
                  ?>
                </td>
                <td align="right">
                <?php 		 
                      if ($n>1 || $n2 >1 ) {
                         echo $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'], 
                                                             (isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0)
                                                              )
                                                  ); 
                
                      } else {
                         echo  $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'],
                                                               $quotes[$i]['tax'])
                                                   ) . zen_draw_hidden_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id']); 
                      }
                 ?>
                </td>
            </tr>
    <?php }?>
    <?php }?>
<?php }
     //end check 
     $radio_buttons++;
	 }//end loop 
?>
  </table>
<?php	   
   }
?>