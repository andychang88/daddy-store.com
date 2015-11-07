


	<?php if ($order->content_type != 'virtual') {?>
    <dl class="clientinfo">
                        <dt>Shipping Address</dt>
                        <dd>
						      <?php echo zen_address_label($_SESSION['customer_id'], $_SESSION['sendto'], true, ' ', '<br />'); ?>
						      <?php echo TEXT_CHOOSE_SHIPPING_DESTINATION; ?>
                              <a href="/my_address_book_process/edit/<?php echo $_SESSION['sendto'];?>/ucenter/1" class="edite"><span class="redbold">[Modify]</span></a>
                        </dd>
                                                
                                    
                        <dd>
                        	<span class="btn_org" id="addshipbtn">
								      <?php if ($displayAddressEdit) { ?>
					                                    <a href="/my_address_book/ucenter/1">
															  <?php echo zen_image_button('button_change_address.gif',BUTTON_CHANGE_ADDRESS_ALT);?>
													    </a>
								      <?php }?>						 
                            </span>
                        </dd>
    </dl>
    <?php }?>
    
    
    <?php  if (!$payment_modules->in_special_checkout()) {?>
    <dl class="clientinfo">
                        <dt>Billing Address</dt>
                        <dd>
						      <?php echo zen_address_label($_SESSION['customer_id'], $_SESSION['billto'], true, ' ', '<br />'); ?>
						      <?php echo TEXT_SELECTED_BILLING_DESTINATION; ?>
                              <a href="/my_address_book_process/edit/<?php echo $_SESSION['billto'];?>/ucenter/1" class="edite"><span class="redbold">[Modify]</span></a>
                        </dd>
                                                
                                    
                       <dd><span class="btn_org" id="addshipbtn">
			    		<?php if (MAX_ADDRESS_BOOK_ENTRIES >= 2) { ?>
                                    <a href="/my_address_book/ucenter/1">
															  <?php echo zen_image_button('button_change_address.gif',BUTTON_CHANGE_ADDRESS_ALT);?>
									</a>
			      		<?php }?>						 
                                </span>
                       </dd>
    </dl>
    <?php }?>
