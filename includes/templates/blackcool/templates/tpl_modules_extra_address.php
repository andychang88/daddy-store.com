<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0"> 
	<tr>
	    <td colspan="2">
			<input type="checkbox" onclick="option_choose();">More Details (Click and Write)
		</td>
	</tr>
</table>
<table>		
		<tr>
			<td colspan="2">
			  
			  <table width="90%" border="0" align="center" cellpadding="3" cellspacing="0"  style="padding-left:0px;" id="option_detail_info">
				<?php if(ACCOUNT_STATE == 'true'){
						  if ($flag_show_pulldown_states == true) {?>
							  <tr class="table_t td_b"> 
								<td align="right"><?php echo TEXT_ZONE;?></td>
								<td>
								  <?php echo zen_draw_pull_down_menu('zone_id', 
																	  zen_prepare_country_zones_pull_down($selected_country), 
																	  $zone_id, 
																	  'id="stateZone"');
										if (zen_not_null(ENTRY_STATE_TEXT)) echo '&nbsp;<span class="alert">' . ENTRY_STATE_TEXT . '</span>';
								   ?>
								</td>
							  </tr>
				  <?php }?>
				  <tr class="table_t td_b"> 
					<td align="right"><?php echo TEXT_STATE;?></td>
					<td>
					   <?php
							echo zen_draw_input_field('state','',zen_set_field_length(TABLE_ADDRESS_BOOK,'entry_state','40').' id="state" class="r_inpur2"');
							//if (zen_not_null(ENTRY_STATE_TEXT)) echo '&nbsp;<span class="alert" id="stText">' . ENTRY_STATE_TEXT . '</span>';
							if ($flag_show_pulldown_states == false) {
							  echo zen_draw_hidden_field('zone_id', $zone_name, ' ');
							}
						?>        
					</td>
				  </tr>		  
				<?php }?> 
				
				<?php if (ACCOUNT_SUBURB == 'true') {?>				
				<tr class="table_t td_b"> 
					<td align="right"><?php echo TEXT_SUBURB;?></td>
					<td class="inputRequirement" align="left">
					<?php echo zen_draw_input_field('suburb','',zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_suburb', '40') . ' id="suburb" class="r_inpur2"').(zen_not_null(ENTRY_SUBURB_TEXT) ? ENTRY_SUBURB_TEXT: ''); ?>
					</td>
				</tr>
			   <?php }?>	  
				
			 </table>
		  </td>
	   </tr>
</table>