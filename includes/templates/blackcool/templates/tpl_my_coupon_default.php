<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account_password.<br />
 * Allows customer to change their password
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_account_password_default.php 2896 2006-01-26 19:10:56Z birdbrain $
 */

?>

<div class="ucright">

		<div class="ucpwd">
            <h2><?php echo HEADING_TITLE;?></h2>
            <div class="margintop10px">
            	<table width="100%" class="uccoupon">
                  <tbody><tr class="bgfffafa">
                    <td colspan="6">
                    <span class="fontbold fontsize12px"><?php echo NOT_USED_COUPON;?></span>
                    </td>
                  </tr>
                  <tr>
                    <td align="center"><?php echo COUPON_NO;?></td>
                    <td align="center"><?php echo COUPON_AMOUNT;?></td>
                    <td align="center"><?php echo EXPIRED_TIME;?></td>
                    <td align="center"><?php echo MIN_ORDER;?></td>
                    <td align="center"><?php echo CAN_USE_TIMES;?></td>
                  </tr>
                  <?php if (count($coupons['not_used'])>0) {?>
                  <?php foreach($coupons['not_used'] as $coupon){
                    	if($coupon['expired']==1){
                    		$expire_info = $coupon["coupon_expire_date"].' <span style="color:red;">('.EXPIRED.')</span>';
                    	}else{
                    		$expire_info = $coupon["coupon_expire_date"];
                    	}
                  	?>
                  <tr>
                    <td align="center"><?php echo $coupon["coupon_code"];?></td>
                    <td align="center"><?php echo $coupon["coupon_amount"];?></td>
                    <td align="center"><?php echo $expire_info;?></td>
                    <td align="center"><?php echo $coupon["coupon_minimum_order"];?></td>
                    <td align="center"><?php echo $coupon["uses_per_user"];?></td>
                  </tr>
                  <?php }?>
                  <?php }else{?>
                  <tr><td align="center" colspan=6><?php echo NOT_FOUND;?></td></tr>
				<?php }?>
                </tbody></table>
<?php if( $split_arr['not_used']->number_of_pages>0){?>
<br><div class="navSplitPagesLinks forward"><?php echo $split_arr['not_used']->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page_not_used', 'info', 'x', 'y', 'main_page'))); ?></div>
<?php }?>
                
                <table width="100%" class="uccoupon margintop10px">
                  <tbody><tr class="bgfffafa">
                    <td colspan="5">
                    <span class="fontbold fontsize12px"><?php echo USED_COUPON;?></span>
                    </td>
                  </tr>
                  <tr>
                    <td align="center"><?php echo COUPON_NO;?></td>
                    <td align="center"><?php echo COUPON_AMOUNT;?></td>
                    <td align="center"><?php echo ORDER_NO;?></td>
                    <td align="center"><?php echo USED_TIME;?></td>
                    <td align="center"><?php echo CAN_USE_TIMES;?></td>
                  </tr>
                  <?php if (count($coupons['used_query'])>0) {?>
                  <?php foreach($coupons['used_query'] as $coupon){
                    		
                  	?>
                  <tr>
                    <td align="center"><?php echo $coupon["coupon_code"];?></td>
                    <td align="center"><?php echo $coupon["coupon_amount"];?></td>
                    <td align="center"><?php echo $coupon["orders_id"];?></td>
                    <td align="center"><?php echo $coupon["date_purchased"];?></td>
                    <td align="center"><?php echo $coupon["uses_per_user"];?></td>
                  </tr>
                  <?php }?>
                  <?php }else{?>
                  <tr><td align="center"  colspan=5><?php echo NOT_FOUND;?></td></tr>
				<?php }?>
                </tbody></table>
<?php if( $split_arr['used_query']->number_of_pages>0){?>
<br><div class="navSplitPagesLinks forward"><?php echo ' ' . $split_arr['used_query']->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page_used_query', 'info', 'x', 'y', 'main_page'))); ?></div>
<?php }?>
            </div>
      </div>
    </div>
    
    
    
    





