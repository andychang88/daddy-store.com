<div class="fixwidth">
	
	
  <?php
  // following used for setting style type of order total and discount modules only
    $selection =  $order_total_modules->credit_selection();
    $numselection = sizeof($selection);
    if (FEC_SPLIT_CHECKOUT == 'true') {
      $selectionStyle = ($numselection%2 == 0 ? 'split' : '');
    }
    G('templage credit_selection');
    
  ?>
  
  <?php  if ($flagAnyOutOfStock) { 
  			if (STOCK_ALLOW_CHECKOUT == 'true') {  ?>
                <div class="messageStackError"><?php echo OUT_OF_STOCK_CAN_CHECKOUT; ?></div>
  <?php     } else { ?>
                <div class="messageStackError"><?php echo OUT_OF_STOCK_CANT_CHECKOUT; ?></div>
  <?php     } //endif STOCK_ALLOW_CHECKOUT ?>
  <?php  } //endif flagAnyOutOfStock ?>
  
  
  
  <?php include(DIR_WS_TEMPLATE . 'templates/fec/tpl_modules_order_content.php');?>
  <?php include(DIR_WS_TEMPLATE . 'templates/fec/tpl_modules_order_coupon.php');?>
  <?php include(DIR_WS_TEMPLATE . 'templates/fec/tpl_modules_order_address.php');//送货地址、账单地址?>
  
  <?php 
  		G(' order address finish ');
    
    
  		//是否支持信用卡
  		if (SHOW_ACCEPTED_CREDIT_CARDS != '0') {
				if (SHOW_ACCEPTED_CREDIT_CARDS == '1') {
				  echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled();
				}
				if (SHOW_ACCEPTED_CREDIT_CARDS == '2') {
				  echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled('IMAGE_');
				}
	    } 
  ?>
    	
  <?php
    // GOOGLE CHECKOUT
    foreach($payment_modules->modules as $pm_code => $pm) {
      if(substr($pm, 0, strrpos($pm, '.')) == 'googlecheckout') {
        unset($payment_modules->modules[$pm_code]);
      }
    }
   ?>
   
   <?php /**************************支付模块列表开始**********************/ ?>
    <dl class="clientinfo">
          <dt>Payment Method</dt>
   
				<?php
				
				$selection = $payment_modules->selection();//echo "<pre>";print_r($selection);
				      
				
				$radio_buttons = 0;
				
				if(empty($_SESSION['payment'])){
					$_SESSION['payment']='paypal';
				}
																	
				for ($i=0, $n=sizeof($selection); $i<$n; $i++) {
				?>
										
										
				<dd>
					  <?php
					  
					  if (sizeof($selection) > 1) {
							if (empty($selection[$i]['noradio'])) {																	
								echo zen_draw_radio_field('payment',$selection[$i]['id'],($selection[$i]['id'] == $_SESSION['payment'] ? true : false), 'id="pmt-'.$selection[$i]['id'].'"');
							}
					  } else {
							echo zen_draw_hidden_field('payment', $selection[$i]['id']);
					  }
					  
					  
					  echo zen_not_null($selection[$i]['icon'])?$selection[$i]['icon']:'&nbsp;';
					  echo $selection[$i]['module'];
					  
					  if(isset($selection[$i]['extra_icon']) && zen_not_null($selection[$i]['extra_icon']) ){
					  		echo $selection[$i]['extra_icon'];
					  }
					  
					  ?>														
                                  
               </dd>
                <?php     
				}     
				?>	        
                                
   </dl>
   <?php G(' payment module finish ');/**************************支付模块列表结束**********************/ ?> 
    
    
    
    <?php /**************************选择物流方式模块列表开始**********************/ ?>
    
    <?php if (zen_count_shipping_modules() > 0) {?>
    
    <dl class="clientinfo">
             <dt>
			   	  <?php  
			   	  if (sizeof($quotes) > 1 && count($quotes[0]) > 1) { 
							 echo TEXT_SELECT_SHIPPING_METHOD; 
				  }elseif ($free_shipping == false){
							 echo "Shipping Method"; 
				  }
			      ?>
			  </dt>
                   <?php 
                   if ($free_shipping == true) { ?>
				<dd>
				  <?php echo FREE_SHIPPING_TITLE; ?><?php echo $quotes[$i]['icon']; ?><br>
				  <?php echo sprintf(FREE_SHIPPING_DESCRIPTION,$currencies->format(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER)).zen_draw_hidden_field('shipping', 'free_free');?>
				</dd>
			    
			   <?php   
                    
                   }else{
			   	
					$radio_buttons = 0;
					for ($i=0, $n=sizeof($quotes); $i<$n; $i++){
			   ?>
					    <?php if (isset($quotes[$i]['error'])) {?>
						  <dd>
						    <?php echo $quotes[$i]['error']; ?>
						  </dd>
					    <?php }else{
					    	
						      for ($j=0, $n2=sizeof($quotes[$i]['methods']); $j<$n2; $j++) {
									$checked =(($quotes[$i]['id'].'_'.$quotes[$i]['methods'][$j]['id']==$_SESSION['shipping']['id'])?true:false);
					    ?>
						   <dd>
						      
						      	<?php echo zen_draw_radio_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'],$checked,'onclick="updateForm();" id="ship-'.$quotes[$i]['id'] . '-' . $quotes[$i]['methods'][$j]['id'].'"');?>
								<strong><?php echo $quotes[$i]['module']; ?></strong> &nbsp; &nbsp;&nbsp;[<?php echo $quotes[$i]['methods'][$j]['title']; ?>]
							
							<?php	 
									if ( ($n > 1) || ($n2 > 1) ) {
										echo $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'],(isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0)));                                        
									}else{
										echo $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'], $quotes[$i]['tax'])).zen_draw_hidden_field('shipping',$quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id']); 
									}
							?>
							
						    </dd>
					    <?php
						      }
					    
					    }
					    ?>
                                
							
							
							
							
							<?php
					}
			     }     ?>	
    
    
    					<dd id="ECS_NEEDINSURE_DD" style="padding-left:30px;display:block">
                                <label for="ECS_NEEDINSURE">
                                	<input type="checkbox" name="insurance" value="<?php if($_SESSION['insurance']==1){echo"0";}else{echo"1";}?>" <?php if($_SESSION['insurance']==1){echo "checked='checked'";}?> onclick="updateForm();"/>
				     Add Customs Insurance(<font color="#FF0000"><strong>Customs Insurance offers premium protection and safety for your valuable items during internationl shipping. We will refund you the tax once package has been caught by the customs or you will undertake all</strong></font>) 
				     			</label>
                        </dd>
    </dl>
    <?php     }     ?>	 
    <?php G(' shipping method selection module finish ');/**************************物流方式模块列表结束**********************/ ?>
    
    
    <?php /**************************订单费用汇总开始**********************/ ?>
    <dl class="clientinfo">
                        <dt>Order Information</dt>
                        <dd>
                            <div class="fl leavemsg">
                                <p class="leave_note">Special requirement or comments about the order:</p>
                                <?php echo zen_draw_textarea_field('comments', '25', '5'); ?>
                            </div>
                                
                            <div id="AECMP_ORDERTOTAL" class="fr calcul_rice">
							      <p>
								  <?php  if (MODULE_ORDER_TOTAL_INSTALLED) {
															$order_total_modules->process();
												 ?>
												  <table width="99%">
													  <?php $order_total_modules->output(); ?>
												  </table>
												  <?php }?>
							      </p>
					        </div>
					   </dd>
     </dl>
    <?php G(' order total  module finish ');/**************************订单费用汇总结束**********************/ ?>
    
    
     <?php  
     		/**************************提交订单按钮**********************/
     
     		if (FEC_ONE_PAGE == 'false') {
     			echo zen_image_submit(BUTTON_IMAGE_CONTINUE_CHECKOUT,BUTTON_CONTINUE_ALT,'onclick="submitFunction('.zen_user_has_gv_account($_SESSION['customer_id']).','.$order->info['total'].')"'); 
     		}else{
     	//echo zen_image_submit(BUTTON_IMAGE_CONFIRM_ORDER,BUTTON_CONFIRM_ORDER_ALT,'onclick="submitFunction('.zen_user_has_gv_account($_SESSION['customer_id']).','.$order->info['total'].')"'); 
			    echo "<p style='text-align:right;padding:15px 0px;'>".zen_image_submit('button_checkout.gif',BUTTON_CONFIRM_ORDER_ALT,'onclick="submitFunction('.zen_user_has_gv_account($_SESSION['customer_id']).','.$order->info['total'].')"')."</p>"; 
            }
     ?>
							 
	 
	<?php /**************************是否显示网站购物协议条款**********************/ ?>
							 
    <?php if (DISPLAY_CONDITIONS_ON_CHECKOUT == 'true') {?>

            <fieldset class="checkout" id="checkoutConditions">
                <legend><?php echo TABLE_HEADING_CONDITIONS; ?></legend>
                <div><?php echo TEXT_CONDITIONS_DESCRIPTION;?></div>
                <?php echo  zen_draw_checkbox_field('conditions', '1', false, 'id="conditions"');?>
                <label class="checkboxLabel" for="conditions"><?php echo TEXT_CONDITIONS_CONFIRM; ?></label>
            </fieldset>        
	<?php }?>

</div>


<!-- include hidden payment attributes -->
<?php 
    if (is_array($payment_modules->modules)) {
      echo $payment_modules->process_button();  
    }
    //echo '<pre>';print_r($_SESSION);
    
    G(' all tempalte finish ');
    
    //echo  "<br>".__FILE__.' line:'.__LINE__.'============'."<pre>";print_r(G());exit;
?> 







       
