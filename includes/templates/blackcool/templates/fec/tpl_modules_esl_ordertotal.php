
<div class="clientinfo">
    	<div class="outline_note">Checkout Information</div>
        <table class="paypag_table" width="100%" cellspacing="0" cellpadding="0" border="0">
        	<tbody>
            	<tr>
                    <th>Item</th>
                    <th>Description </th>
                    <th width="140">Item Price</th>
                    <th width="60">Quantity</th>
                    <th width="140">Total Price</th>
                </tr>
		
		
		
		
		<?php for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
		  
		  $thumbnail = zen_get_products_image($order->products[$i]['id'],40,42);
		  
		  ?>
		
                <tr id="tr_goods_374846">
                	<td class="pay_gods_img">
			   <?php echo $thumbnail;?>
                        
                    </td>
                    <td>
                        <div class="sopcarinfo">
			   <a href="<?php echo zen_href_link(zen_get_info_page($order->products[$i]['id']),
													'products_id=' . $order->products[$i]['id']); 
						  ?>" target="_blank" style="color:#000000">
				 
					 <?php echo zen_trunc_string($order->products[$i]['name'],110,true); ?>
					 <?php  echo $stock_check[$i]; ?>
				    </a>
				    
				    
				    <?php // if there are attributes, loop thru them and display one per line
					if (isset($order->products[$i]['attributes']) && sizeof($order->products[$i]['attributes']) > 0 ) {
						echo '<div class="cartAttribsList">';
					  for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
				  ?>
					  <div class="cart_attr">
						  <b>&middot;</b>
						  <?php echo $order->products[$i]['attributes'][$j]['option'] 
						             .' - '. nl2br(zen_output_string_protected($order->products[$i]['attributes'][$j]['value'])); 
						   ?>
					   </div> 
				 <?php
					  } // end loop
					    echo '</div>';
					} // endif attribute-info
				  ?>
				
                    </td>
                    <td class="text-center">
                        <p>
                        Now: 
                        <span class=" sale_price">
			   <?php echo $currencies->display_price($order->products[$i]['final_price'],zen_get_tax_rate($order->products[$i]['tax_class_id']),1). ($order->products[$i]['onetime_charges'] != 0 ? '<br /> '. $currencies->display_price($order->products[$i]['onetime_charges'],zen_get_tax_rate($order->products[$i]['tax_class_id']),1) : '');
				 ?>
			   
			</span>
                        </p>
                    </td>
                    <td class="text-center">
                        <p><?php echo $order->products[$i]['qty']; ?></p>
                    </td>
                    <td class="text-center">
                        <p id="goods_subtotal_374846" class="sale_price">
				 <?php echo $currencies->display_price($order->products[$i]['final_price'], 
													   $order->products[$i]['tax'],
													   $order->products[$i]['qty']);
					  if ($order->products[$i]['onetime_charges'] != 0 ) echo '<br /> 
						 ' . $currencies->display_price($order->products[$i]['onetime_charges'],
														$order->products[$i]['tax'],
														1);
				 ?></p>
                    </td>
                </tr>
		
		
		<?php }?>  
		
		
		
		
            </tbody>
        </table>
    </div>
