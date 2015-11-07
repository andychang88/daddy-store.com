<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_products_quantity_discounts.php 3291 2006-03-28 04:03:38Z ajeh $
 */
?>
<?php if($products_discount_type!=0){
	   if(file_exists(DIR_WS_INCLUDES.'modules/pages/product_info/price_qty.js.php')){				    
		include(DIR_WS_INCLUDES.'modules/pages/product_info/price_qty.js.php');
	   }
?>
<div id="no_more_quantity"></div>
<p class="total">Total:<strong id="price_calc_panel"><?php echo $currencies->display_price($show_price, zen_get_tax_rate($products_tax_class_id)); ?> x 1=<?php echo $currencies->display_price($show_price, zen_get_tax_rate($products_tax_class_id)); ?>
</strong></p>
<div class="wholsale_d">
	<?php
	     if ($zc_hidden_discounts_on) {
	 ?>
		  <table border="1" cellspacing="2" cellpadding="2">
			<tr>
			  <td colspan="1" align="center">
			  <?php echo TEXT_HEADER_DISCOUNTS_OFF; ?>
			  </td>
			</tr>
			<tr>
			  <td colspan="1" align="center">
			  <?php echo $zc_hidden_discounts_text; ?>
			  </td>
			</tr>
		  </table>
	<?php } else { ?>
	      <?php //echo zen_image(DIR_WS_TEMPLATE_IMAGES.'tu-32.gif','',324,6,' class="align_top float_left"');?>
		  <table border="0" cellspacing="0" cellpadding="0"  id="wholesale">
		    <tr>
                    <td><?php echo TEXT_QTY_RANGE;?></td>
                    <td><?php echo TEXT_QTY_PRICE;?></td>
            </tr>
			<!--<tr>
			  <td colspan="<?php //echo $columnCount+1; ?>" align="center">
					<?php
					  /*switch ($products_discount_type) {
						case '1':
						  echo TEXT_HEADER_DISCOUNT_PRICES_PERCENTAGE;
						  break;
						case '2':
						  echo TEXT_HEADER_DISCOUNT_PRICES_ACTUAL_PRICE;
						  break;
						case '3':
						  echo TEXT_HEADER_DISCOUNT_PRICES_AMOUNT_OFF;
						  break;
					  }*/
					?>
			  </td>
			</tr>-->
	
			<tr>
			  <td><?php echo $show_qty;?></td>
			  <td><?php echo $currencies->display_price($show_price, zen_get_tax_rate($products_tax_class_id)); ?></td>
			</tr>
		<?php
		  foreach($quantityDiscounts as $key=>$quantityDiscount) {
		?>
		    <tr>
			   <td><?php echo $quantityDiscount['show_qty'];?></td>
			   <?php if((!isset($_SESSION['customer_id'])) && ($key+1)>SHOW_PRICE_QTY_MAX_GROUP){?>
			   <td><a rel="nofollow" href="<?php echo zen_href_link(FILENAME_LOGIN,'','SSL');?>">Login</a></td>
			   <?php }else{?>
			   <td><?php echo $currencies->display_price($quantityDiscount['discounted_price'], 
														 zen_get_tax_rate($products_tax_class_id)); 
					?>
			   </td>
			   <?php }?>
		    </tr>
		<?php
					/*$disc_cnt++;
					if ($discount_col_cnt == $disc_cnt && !($key == sizeof($quantityDiscount))) {
					  $disc_cnt=0;
				    }*/
	       }
	   
		  /*if ($disc_cnt < $columnCount) {
		?>
			<td align="center" colspan="<?php echo ($columnCount+1 - $disc_cnt)+1; ?>">&nbsp;  </td>
		<?php } */?>			
		<?php
		 /* if (zen_has_product_attributes($products_id_current)) {
		?>
			<tr>
			  <td colspan="<?php echo $columnCount+1; ?>" align="center">
				<?php echo TEXT_FOOTER_DISCOUNT_QUANTITIES; ?>
			  </td>
			</tr>
		<?php }*/ ?>
	  </table>
      <div class="clear"></div>
	  <!--<p> <?php //echo zen_image(DIR_WS_TEMPLATE_IMAGES.'tu-35.gif','',173,22);?></p>-->	 
	<?php } // hide discounts ?>

</div>
<br />
   <strong> <p style="font-size:16px"  class="note"><?php echo TEXT_PRODUCT_WARRANTY;?></p></strong>
<?php }?>