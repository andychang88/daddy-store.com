<?php
/**
 * Page Template
 *
 * @package templateSystem Easy Sign-Up and Login
 * @copyright Copyright 2007-2008 Numinix Technology http://www.numinix.com
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_login_default.php 101 2010-01-28 20:50:41Z numinix $
 */
?>
<div class="txtPageWrapper" id="logoffDefault">


<div class="txtPageCenter">
<?php if (FEC_EASY_SIGNUP_STATUS == 'true') { ?>

          <!-- BOF SHOPPING CART -->
          <?php
            /*if ($fec_order_total_enabled) {
		   ?>
              <?php  if ($flagAnyOutOfStock) { ?>
			  <?php    if (STOCK_ALLOW_CHECKOUT == 'true') {  ?>
                            <div class="messageStackError"><?php echo OUT_OF_STOCK_CAN_CHECKOUT; ?></div>
              <?php    } else { ?>
                            <div class="messageStackError"><?php echo OUT_OF_STOCK_CANT_CHECKOUT; ?></div>
              <?php    } //endif STOCK_ALLOW_CHECKOUT ?>
              <?php  } //endif flagAnyOutOfStock ?>
                <div class="cartlist">
                      <h6><?php echo TEXT_SHOPPING_CART_TITLE;?></h6>
					  <?php include(DIR_WS_TEMPLATE . 'templates/fec/tpl_modules_esl_ordertotal.php');?>
                </div>
		  <?php  
            } */
          ?>
          <!-- EOF SHOPPING CART -->          
          <table width="1002" height="176" border="0" cellpadding="10" cellspacing="0" class="table_t">
            <tr>
				<td width="487" valign="top" class="td_b_left">
				<?php echo zen_draw_form('create_account', 
				                         zen_href_link(FILENAME_LOGIN,'','SSL'),
										 'post',
										 'onsubmit="return check_register_form();" id="register_form"')
						   .zen_draw_hidden_field('action', 'easy_createaccount_process')
						   .zen_draw_hidden_field('email_format', $email_format);
                       ?>
					<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
					  <tr>
						<td width="100%" class="td_b_t"><?php echo TEXT_NEW_ACCOUNT_TITLE;?></td>
					  </tr>
					  <?php if ($messageStack->size('easy_createaccount') > 0){?>
                         <tr><td> <?php echo $messageStack->output('easy_createaccount'); ?></td></tr>
                      <?php }?>
					  <tr>
						<td>&nbsp;</td>
					  </tr>
					  <!--<tr>
						<td><?php //echo TEXT_NEW_ACCOUNT_DESC;?></td>
					  </tr>-->
					  
					  <tr>
						<td>						    
						    <?php 
					        //################BEGIN:for better registry experence####################
					        //modified by john 2010-07-15 1/1
							/*require($template->get_template_dir('tpl_modules_create_account.php',
                                                                 DIR_WS_TEMPLATE, 
                                                                 $current_page_base,
                                                                 'templates'). '/tpl_modules_create_account.php');*/
                             require($template->get_template_dir('tpl_modules_easy_create_account.php',
                                                                 DIR_WS_TEMPLATE, 
                                                                 $current_page_base,
                                                                 'templates'). '/tpl_modules_easy_create_account.php');
                            //#################END:for better registry experence####################
					       ?>							
						</td>
					   </tr>
					   
					        <tr>
					   <td width="20%" align="center">
					   <input type="checkbox" name="xy"><?PHP echo TEXE_ACCORD;?>
					   </td>
					   </tr>
					   <tr>
						 <td>
						    <table width="100%" border="0" cellpadding="5" cellspacing="0">
								<tr>
									<td width="36%" valign="top">&nbsp;</td>
									<td width="63%">
										 <?php echo zen_image_submit(BUTTON_IMAGE_REGISTER, BUTTON_REGISTER_ALT); ?>
									</td>
							    </tr>
							</table>
						 </td>
					   </tr>
					   </form>
				     <tr>
					    <td>&nbsp;</td>
				     </tr>
				  </table>				
				</td>
				<td width="475" valign="top">
				  <?php echo zen_draw_form('login', zen_href_link(FILENAME_LOGIN, 'action=process', 'SSL'),'post','onsubmit="return check_login_form();" id="login_form"');?>
				 <table width="98%" border="0" align="center" cellpadding="5" cellspacing="0">
					  <tr>
						  <td class="td_b_t"><?php echo TEXT_RETURNING_TITLE;?></td>
					  </tr>
					  <?php if ($messageStack->size('login') > 0){?>
                         <tr><td> <?php echo $messageStack->output('login'); ?></td></tr>
                      <?php }?>
					  <tr>
						<td>&nbsp;</td>
					  </tr>
					   
					  <tr>
						<td>
							<table width="100%" border="0" cellpadding="5" cellspacing="0" class="registration">
							  <tr>
								<td width="34%" align="right" valign="top"><?php echo TEXT_EMAIL;?></td>
								<td width="66%">
									<?php echo zen_draw_input_field('email_address',
																	'', 
																	zen_set_field_length(TABLE_CUSTOMERS, 'customers_email_address', '20').
																	' class="r_inpur" id="email_address"'); 
									  ?>
							    </td>
							  </tr>
							  
							  <tr>
								<td align="right" valign="top"><?php echo TEXT_PASSWORD;?></td>
								<td>
									 <?php echo zen_draw_password_field('password','',' size="20" class="r_inpur" id="password" ');?>
									 <?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
									 <p>&nbsp;</p>
								</td>
							  </tr>
							  <tr>
								<td height="28" colspan="2" valign="top">
								   <a href="<?php echo  zen_href_link(FILENAME_PASSWORD_FORGOTTEN,'','SSL');?>" class="xhx error h cd">
									  <?php echo TEXT_PASSWORD_FORGOTTEN;?>
									</a>
								</td>
							  </tr>
							</table>
						</td>
					  </tr>	
					  <tr>
					  <td style="color: rgb(51, 153, 255);">
					  <?php echo TEXT_LOGIN_TS;?>
					  </td>
					  </tr>		  
					  <tr>
						<td>
						   <table width="100%" border="0" cellpadding="5" cellspacing="0" class="registration">
							  <tr>
								<td width="34%">&nbsp;</td>
								<td width="66%">
									   <?php echo zen_image_submit('button_login.gif', TEXT_ALT_IMAGE_BUTTON_LOGIN,' id="bereits_img" ');?>
							    </td>
						      </tr>
						   </table>
						</td>
					  </tr> 
					
				 </table>
				 </form>
				</td>
		    </tr>
		  </table>
		  <?php if ($ec_button_enabled) { ?>
		  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="0"   class="table_t">
			 <tr><td width="100%" class="td_border td_b_t" align="center"><?php echo HEADING_PAYPAL; ?></td></tr>
			 <tr><td><?php echo TEXT_PAYPAL_INTRODUCTION_SPLIT; ?></td></tr>                         
			 <tr>
				<td>&nbsp;</td>
			  </tr>
			 <tr>
			     <td align="center"><?php require(DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/tpl_ec_button.php'); ?></td>
			 </tr>
		  </table>
		  <?php }?>			         
<?php }?>
</div>

</div>

<?php
// ** GOOGLE CHECKOUT **
if (strtolower(MODULE_PAYMENT_GOOGLECHECKOUT_STATUS) == 'true') {
?>
  <div id="googleCheckout">
  <?php
    include(DIR_WS_MODULES . 'show_google_components.php');
  ?>
  </div>
<?php
}
// ** END GOOGLE CHECKOUT **
?>