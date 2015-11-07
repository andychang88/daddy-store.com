<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr class="cartTableHeading">
      <th scope="col" width="5%" align="left"><?php echo TABLE_HEADING_QUANTITY; ?></th>
      <th scope="col" width="40%" align="left"><?php echo TABLE_HEADING_PRODUCTS; ?></th>
<?php
	  // If there are tax groups, display the tax columns for price breakdown
	  if (sizeof($order->info['tax_groups']) > 1) {
?>
      <th scope="col" id="ccTaxHeading"><?php echo HEADING_TAX; ?></th>
      
<?php
      }
?>
     <th scope="col" width="10%" align="left"><?php echo TABLE_HEADING_TOTAL; ?></th>
 </tr>
<?php   
    $row_chk=1;
	for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
		if($row_chk==1){
			$td_bgpatar='';
			$row_chk=2;
		}else{
			$td_bgpatar=' bgcolor="#EFEFEF" ';
			$row_chk=1;
		}
?>

	<tr>
        <td class="main" align="left" width="5%" valign="top"  <?php echo $td_bgpatar;?> >
            <?php echo $order->products[$i]['qty'] . ' x ';?>
        </td>
        <td class="main" align="left" width="40%" valign="top"  <?php echo $td_bgpatar;?> >
            <?php echo $order->products[$i]['name'];?>
        </td>
        <?php 
		       if (sizeof($order->info['tax_groups']) > 1){				   
		 ?>
                 <td class="main" valign="top" align="left" <?php echo $td_bgpatar;?> >
        <?php
		         echo zen_display_tax_value($order->products[$i]['tax']);			    
		 ?>
		         </td>	
        <?php
				}
		 ?>       
        <td class="main" width="10%" align="left" valign="top" <?php echo $td_bgpatar;?> >
            <?php 
			       //$xtPrice->xtcFormat($order->products[$i]['final_price'], true);
			  echo $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']);	
			  if ($order->products[$i]['onetime_charges'] != 0 ){			  
			      echo '<br /> ' . $currencies->display_price($order->products[$i]['onetime_charges'], $order->products[$i]['tax'], 1);
			  }
		     ?>
        </td>
    </tr>
 
<?php	/*if (ACTIVATE_SHIPPING_STATUS == 'true') {

		<tr>
            <td class="main" align="left" valign="top" '.$td_bgpatar.'>
            <nobr><small>' . SHIPPING_TIME . $order->products[$i]['shipping_time'] . '
            </small><nobr></td>
            <td class="main" align="right" valign="top" '.$td_bgpatar.'>&nbsp;</td>
         </tr>';

	}*/
?>
<?php if ((isset ($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0)) {
			for ($j = 0, $n2 = sizeof($order->products[$i]['attributes']); $j < $n2; $j++) {
?>
                <tr>
                    <td class="main" align="left" valign="top" <?php echo $td_bgpatar;?> >
                        <nobr>
                             <small>&nbsp;
                                 <i> - 
                                  <?php echo  $order->products[$i]['attributes'][$j]['option'] . ':' . 
                                              nl2br(zen_output_string_protected($order->products[$i]['attributes'][$j]['value']));?>                          
                                 </i>
                             </small>
                        <nobr>
                     </td>
                     <td class="main" align="right" valign="top" <?php echo $td_bgpatar;?> >&nbsp;</td>
                </tr>
<?php
		    }
	  }
}
?>
</table>