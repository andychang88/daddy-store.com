<?php
/**
 * Module Template
 *
 * Allows entry of new addresses during checkout stages
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_checkout_new_address.php 4683 2006-10-07 06:11:53Z drbyte $
 */
?>			
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0">
		<tr>
		  <td align="right"><span class="b"><font color="#900">*</font> Required information</span></td>
          <td> </td>
		</tr>
		<tr>
		  <td width="30%" align="right"></td>
		  <td width="70%"></td>
		</tr>
		<?php if (ACCOUNT_GENDER == 'true') {?>  
		<tr class="table_t td_b"> 
			<td align="right"><?php echo TEXT_GENDER;?></td>
			<td>
				<?php echo zen_draw_radio_field('gender', 'm', '', 'id="gender-male"');?>
				<?php echo  MALE;?>
				<?php echo zen_draw_radio_field('gender', 'f', '', 'id="gender-female"');?>
				<?php echo  FEMALE;?>
				<?php (zen_not_null(ENTRY_GENDER_TEXT) ? ENTRY_GENDER_TEXT: '');?>
			</td>
		</tr>
		<?php }?>		
		<tr class="table_t td_b">
			  <td align="right"><?php echo TEXT_FIRTNAME;?></td>
			  <td>
				  <?php echo zen_draw_input_field('firstname','',zen_set_field_length(TABLE_CUSTOMERS,'customers_firstname','40').' id="firstname" class="r_inpur2"').(zen_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="red2">' .ENTRY_FIRST_NAME_TEXT.'</span>': ''); 
				   ?>
			  </td>
		</tr>
		<tr class="table_t td_b">
			  <td align="right"><?php echo TEXT_LASTNAME;?></td>
			  <td>
				  <?php echo zen_draw_input_field('lastname','',zen_set_field_length(TABLE_CUSTOMERS,'customers_lastname','40').' id="lastname" class="r_inpur2"').(zen_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="red2">' .ENTRY_LAST_NAME_TEXT.'</span>': ''); 
				   ?>
			  </td>
		</tr>
		<?php if (ACCOUNT_COMPANY == 'true') {?> 
		 <tr class="table_t td_b"> 
			<td align="right"><?php echo TEXT_COMPANY;?></td>
			<td>
				<?php echo zen_draw_input_field('company','',zen_set_field_length(TABLE_ADDRESS_BOOK,'entry_company','40') . ' id="company" class="r_inpur2"').(zen_not_null(ENTRY_COMPANY_TEXT) ? ENTRY_COMPANY_TEXT: ''); 
				 ?>       
			</td>
		 </tr>
		<?php }?>	
		<tr class="table_t td_b">
		  <td align="right"><?php echo TEXT_STREET;?></td>
		  <td>
			  <?php echo zen_draw_input_field('street_address','',zen_set_field_length(TABLE_ADDRESS_BOOK,'entry_street_address','40') . ' id="street_address" class="r_inpur2"').(zen_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="red2">' .ENTRY_STREET_ADDRESS_TEXT.'</span>': ''); ?></td>
		</tr>
		<tr class="table_t td_b">
		  <td align="right"><?php echo TEXT_POSTCODE;?></td>
		  <td>
			  <?php echo zen_draw_input_field('postcode','',zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_postcode', '40') . ' id="postcode" class="r_inpur2"').(zen_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="red2"></span>': ''); ?>
		  </td>
		</tr>
		
		<?php if (ACCOUNT_TELEPHONE == 'true') { ?> 
			  <tr class="table_t td_b">
				<td width="30%" align="right"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
				<td width="70%">
					<?php echo zen_draw_input_field('telephone', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_telephone', '40') . ' class="r_inpur2" id="telephone"'). (zen_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="red2">' . ENTRY_TELEPHONE_NUMBER_TEXT.'</span>': ''); ?>
				</td>
			  </tr>
			<?php }?>
			
		<tr class="table_t td_b">
		  <td align="right"><?php echo TEXT_CITY;?></td>
		  <td>
			  <?php echo zen_draw_input_field('city','',zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_city', '40') . ' id="city" class="r_inpur2"').(zen_not_null(ENTRY_CITY_TEXT) ? '<span class="red2">' .ENTRY_CITY_TEXT.'</span>': ''); ?>
		  </td>
		</tr>
		<tr class="table_t td_b">
		  <td align="right"><?php echo TEXT_COUNTRY;?></td>
		  <td><?php echo zen_get_country_list('zone_country_id', $selected_country,' class="r_inpur3" id="zone_country_id" '.($flag_show_pulldown_states == true? 'onchange="update_zone(this.form);"' : '')).(zen_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="red2">' .ENTRY_COUNTRY_TEXT.'</span>': ''); ?>			      
		  </td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		</tr>
</table>