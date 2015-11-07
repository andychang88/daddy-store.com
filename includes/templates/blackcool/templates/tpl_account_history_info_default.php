<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account_edit.<br />
 * Displays information related to a single specific order
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_account_history_info_default.php 6247 2007-04-21 21:34:47Z wilt $
 */
?>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
            <td bgcolor="#E6E6E6"><span class="smallHeading"><strong><?php echo TEXT_ACCOUNT_HISTROY_INFO_TITLE;?></strong></span></td>
        </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="gray_border_table">
  <tr>
    <td width="50%"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
	   <?php echo TEXT_ORDER_ID;?>
       <?php echo ORDER_HEADING_DIVIDER . sprintf(HEADING_ORDER_NUMBER, $_GET['order_id']);?>
      (<?php echo $statusArray[sizeof($statusArray)-1]['orders_status_name'];?>)<br />
      </font></strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
      <font size="1"><?php echo HEADING_ORDER_DATE.' ' . zen_date_long($order->info['date_purchased']);?></font></font></td>
   
  </tr>
</table>
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="gray_border_table">
  <tr>
    <td style="border-top: 1px solid; border-color: #cccccc; padding-left:10px;"width="240" class="main">
      <strong><?php echo TEXT_SHIPPING_ADDRESS;?></strong><br />
       <?php echo zen_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br />');?>  
    </td>
    <td style="border-top: 1px solid; border-color: #cccccc;padding-left:10px;" class="main">      
      <strong><?php echo TEXT_PAYMENT_ADDRESS;?></strong><br />
       <?php echo zen_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br />'); ?>      
    </td>
  </tr>
</table>
<br />
<strong><?php echo TEXT_SHIPPING_METHOD;?></strong>
<strong>
<?php
    if (zen_not_null($order->info['shipping_method'])) {
?>
     <strong>
	 <?php echo TEXT_SHIPPING_METHOD;?></strong>
	 <?php echo $order->info['shipping_method']; ?>
<?php 
     }else{ // temporary just remove these 4 lines 
        echo TEXT_MISSING_SHIPPING_METHOD;
	 }
?>
<br />
<?php echo TEXT_PAYMENT_METHOD;?></strong> 
<?php echo $order->info['payment_method']; ?>
<br />
<br />
<strong><?php echo TEXT_ORDER_HISTROY_TITLE;?></strong>

<?php if(sizeof($statusArray)){?>

<table border="0" width="100%" cellspacing="0" cellpadding="4"   class="gray_border_table"
       id="myAccountOrdersStatus" summary="Table contains the date, order status and any comments regarding the order">

    <tr>
        <td scope="col" id="myAccountStatusDate" style="align:left"><?php echo TABLE_HEADING_STATUS_DATE; ?></th>
        <td scope="col" id="myAccountStatus" style="align:left"><?php echo TABLE_HEADING_STATUS_ORDER_STATUS; ?></th>
        <td scope="col" id="myAccountStatusComments" style="align:left"><?php echo TABLE_HEADING_STATUS_COMMENTS; ?></th>
    </tr>
	<?php
      foreach ($statusArray as $statuses) {
    ?>
    <tr>
        <td><?php echo zen_date_short($statuses['date_added']); ?></td>
        <td><?php echo $statuses['orders_status_name']; ?></td>
        <td><?php echo (empty($statuses['comments']) ? '&nbsp;' : nl2br(zen_output_string_protected($statuses['comments']))); ?></td> 
   </tr>
	<?php
      }
    ?>
</table>
<?php } ?>
<strong><?php echo TEXT_ORDER_PRODUCTS;?></strong> <br />
<table width="100%" border="0" cellspacing="0" cellpadding="4">
<tr>
<td style="border: 1px solid; border-color: #cccccc;" class="main">
  <table style="border-bottom:1px solid;" width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
        <td>
            <table width="100%" border="0" cellpadding="3" cellspacing="0" >
                <tr>
                    <td colspan="2" class="main">
                        <div align="center">
                            <strong>
                            <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_HEAD_UNITS;?></font>
                            </strong>
                        </div>
                    </td>
                    <td class="main"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_HEAD_PRODUCTS;?></font></strong></td>
                    <td class="main"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_HEAD_ATRNR;?></font></strong></td>
                    <td class="main"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_HEAD_UNIT_PRICE;?></font></strong></td>
                    <td class="main" width="150">
                        <div align="right">
                            <strong>
                                <font size="1" face="Verdana, Arial, Helvetica, sans-serif">
                                <?php echo TEXT_HEAD_TOTAL_PRICE;?>
                                </font>
                            </strong>
                        </div>
                    </td>
                </tr>
            <?php
              for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
              ?>
                <tr>
                    <td width="20" style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;"  class="gray_border_table">
                        <div align="center">
                           <font size="1"face="Verdana,Arial,Helvetica,sans-serif"><?php echo $order->products[$i]['qty'];?></font>
                        </div>    
                    </td>
                    <td width="20" style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;">
                        <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">x</font></div>
                    </td>
                    <td style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;">
                        <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo  $order->products[$i]['name'];?></strong>
                            <em>
                                <?php
                                  if ( (isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0) ) {
                                      echo '<ul id="orderAttribsList">';
                                      for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
                                            echo '<li>' . $order->products[$i]['attributes'][$j]['option'] 
                                                        . TEXT_OPTION_DIVIDER 
                                                        . nl2br(zen_output_string_protected($order->products[$i]['attributes'][$j]['value'])). 
                                                 '</li>';
                                      }
                                        echo '</ul>';
                                    }
                                ?>
                            </em>                
                        </font>
                    </td>
                    <td style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;">
                        <font size="1" face="Verdana, Arial, Helvetica, sans-serif">
                            <?php echo $order->products[$i]['model'];?>               
                        </font>
                    </td>
                    <td style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;">
                        <font size="1" face="Verdana, Arial, Helvetica, sans-serif">         
                         <?php echo $currencies->format(zen_add_tax($order->products[$i]['final_price'],$order->products[$i]['tax']));?>           
                        </font>
                    </td>
                    <td style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;" width="150">
                        <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">       
                         <?php echo $currencies->format(zen_add_tax($order->products[$i]['final_price'],
                                                                    $order->products[$i]['tax']) *$order->products[$i]['qty'],
                                                       true, 
                                                       $order->info['currency'], 
                                                       $order->info['currency_value']) .
                                    ($order->products[$i]['onetime_charges'] != 0 ? '<br />' 
                                                                                    .$currencies->format(zen_add_tax($order->products[$i]['onetime_charges'],
                                                                                                                     $order->products[$i]['tax']), 
                                                                                                         true, 
                                                                                                         $order->info['currency'],
                                                                                                         $order->info['currency_value']) : '');?>
                        </font></div>
                    </td>
                </tr>
            <?php
              }
            ?>
            </table>
        </td>
    </tr>
    </table>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td>
    <table width="100%" border="0" cellpadding="3" cellspacing="0">
    <?php
      for ($i=0, $n=sizeof($order->totals); $i<$n; $i++) {
    ?>
        <tr>
            <td nowrap="nowrap" width="100%" style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;">
               <div align="right"><font size="1" face="Arial, Helvetica, sans-serif">
               <?php echo $order->totals[$i]['title'] ?>
               <?php echo $order->totals[$i]['text'] ?></font>
               </div>
            </td>
        </tr>
    <?php
      }
    ?>
    </table>
</td>
</tr>
</table>


</td>
</tr>
</table>
<?php
/**
 * Used to display any downloads associated with the cutomers account
 */
  if (DOWNLOAD_ENABLED == 'true') require($template->get_template_dir('tpl_modules_downloads.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_downloads.php');
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="0" style="margin-top:7px;margin-right:7px;">
    <tr>
      <td >    
      <a style="cursor:pointer" 
         onclick="javascript:print()">         
         <?php echo zen_image_button(BUTTON_IMAGE_PRINT,BUTTON_PRINT_ALT);?>         
         </a>
     </td>
      <td align="right" >
       <?php
	      $from_history = eregi("page=", zen_get_all_get_params());
		  $back_to = $from_history ? FILENAME_ACCOUNT_HISTORY : FILENAME_ACCOUNT;
	   ?>      
       <a href="<?php echo zen_href_link($back_to,zen_get_all_get_params(array ('order_id')), 'SSL');?>">
          <?php echo  zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT);?>
       </a>
      </td>
    </tr>
</table>