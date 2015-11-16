

<?php 
  $selection =  $order_total_modules->credit_selection();
    $credit_numselection = sizeof($selection);
    if (FEC_SPLIT_CHECKOUT == 'true') {
      $selectionStyle = ($credit_numselection%2 == 0 ? 'split' : '');
    }
?>
	<dl class="clientinfo" id="code">
                        <dt>Coupon Code</dt>
                        <dd>
			  
			  <?php if ($credit_numselection>0) { ?>
			  
			  <?php
				for ($i = 0; $i < $credit_numselection; $i++) {
					if ($selectionStyle == 'split') {
					  // $i starts at 0
					  if ($i%2 == 0) $box = 'odd'; else $box = 'even';
					}
			  ?>
			  
			  <?php if ($_GET['credit_class_error_code'] == $selection[$i]['id']) {	?>
			  			<div class="messageStackError"><?php echo zen_output_string_protected($_GET['credit_class_error']); ?></div>
			  <?php }?>	
			  
						
			 <?php 
			 		$tmp_payment = $selection[$i];
			 		$num_fields = count($tmp_payment['fields']);
			 		
					for ($j = 0; $j < $num_fields; $j++) {
						
					   if ( !($COWOA && $tmp_payment['module']==MODULE_ORDER_TOTAL_GV_TITLE) ) {
					   	
							  $continue_discount = true;
							  
							  if ( $tmp_payment['module'] == MODULE_ORDER_TOTAL_INSURANCE_TITLE && $order->content_type == 'virtual' ) { 
									$continue_discount = false;
									$_SESSION['insurance'] = $_SESSION['opt_insurance'] = '0';
							  }
						  
						  
						    
			  ?>
								<?php 
								if ($continue_discount == true) {
								  		echo $tmp_payment['module'];
								?>
		                            <div class="put_code fl">
		                                <p class="code_note"><?php echo $tmp_payment['redeem_instructions']; ?></p>
		                                <p class="green">
		                                	<?php 
		                                		
		                                		$img_submit_btn = '';
		                                		
												if ( ($tmp_payment['module'] != MODULE_ORDER_TOTAL_INSURANCE_TITLE) && ($tmp_payment['module'] != MODULE_ORDER_TOTAL_SC_TITLE) ) { 
														
															$img_submit_btn = zen_image(zen_output_string($template->get_template_dir(BUTTON_IMAGE_UPDATE,
													                                                                     DIR_WS_TEMPLATE, 
																														 $current_page_base,
																														 'buttons/'.$_SESSION['language'].'/').BUTTON_IMAGE_UPDATE2),
																		   BUTTON_UPDATE_ALT, '', '', 'onclick="updateForm();"'); 
																		   
															
												 }
														   
		                                		 echo $tmp_payment['fields'][$j]['title'] . $tmp_payment['fields'][$j]['field'] . $img_submit_btn; 
		                                		 
		                                		 
											?>
						    
						    
		                                    <span id="aecmp_use_bonus_tip" style="display:none;" class="avile none"><em class="rigt"></em>The coupon has been Applied Successfully!</span>
		                                </p>
		                            </div>
					    	<?php }?>
			    
			    <?php //end $continue_discount
			    
			    	}//end if
			    
			    }//end for
			    ?>
                            <div class="fr"><p id="aecmp_use_bonus_money" class="sale_price"></p></div>
			    
			    <?php }
			  }
			    ?>
                        </dd>
    </dl>
