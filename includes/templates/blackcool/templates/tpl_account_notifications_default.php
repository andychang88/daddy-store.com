<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account_notifications.<br />
 * Allows customer to manage product notifications
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_account_notifications_default.php 3206 2006-03-19 04:04:09Z birdbrain $
 */
?>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
 <tbody> 
  <tr>
        <td bgcolor="#E6E6E6"><span class="smallHeading"><strong><?php echo HEADING_TITLE;?></strong></span></td>
  </tr>
 </tbody>
</table>        
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tbody>
    <tr>
      <td style="BORDER-BOTTOM-COLOR: #cccccc; BORDER-RIGHT-COLOR: #cccccc; BORDER-LEFT-COLOR: #cccccc; BORDER-TOP: #cccccc 1px solid" 
          class="main" valign="center">
          <table border="0" cellspacing="0" cellpadding="5" width="100%">
            <tbody>
              <tr>
                <td class="main" valign="top"><?php echo MY_NOTIFICATIONS_DESCRIPTION;?></td>
              </tr>
            </tbody>
          </table>
      </td>
    </tr>
  </tbody>
</table>  
<div class="centerColumn" id="accountNotifications">
<?php echo zen_draw_form('account_notifications', zen_href_link(FILENAME_ACCOUNT_NOTIFICATIONS, '', 'SSL')) . zen_draw_hidden_field('action', 'process'); ?>
<fieldset>
<legend><?php echo GLOBAL_NOTIFICATIONS_TITLE; ?></legend>

<?php echo zen_draw_checkbox_field('product_global', '1', (($global->fields['global_product_notifications'] == '1') ? true : false), 'id="globalnotify"'); ?>
<label class="checkboxLabel" for="globalnotify"><?php echo GLOBAL_NOTIFICATIONS_DESCRIPTION; ?></label>
<br class="clearBoth" />
</fieldset>

<?php
  if ($flag_global_notifications != '1') {
?>
<fieldset>
<legend><?php echo NOTIFICATIONS_TITLE; ?></legend>

<?php
    if ($flag_products_check) {
?>
<div class="notice"><?php echo NOTIFICATIONS_DESCRIPTION; ?></div>
<?php
/**
 * Used to loop thru and display product notifications
 */
  foreach ($notificationsArray as $notifications) { 
?>
<?php echo zen_draw_checkbox_field('notify[]', $notifications['products_id'], true, 'id="notify-' . $notifications['counter'] . '"'); ?>
<label class="checkboxLabel" for="<?php echo 'notify-' . $notifications['counter']; ?>"><?php echo $notifications['products_name']; ?></label>
<br />
<?php
  }
?>
</fieldset>

<div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_UPDATE, BUTTON_UPDATE_ALT); ?></div>
<div class="buttonRow back"><?php echo '<a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?></div>

<?php
    } else {
?>
<div class="notice"><?php echo NOTIFICATIONS_NON_EXISTING; ?></div>
</fieldset>
<div class="buttonRow forward" style="float:left"><?php echo zen_image_submit(BUTTON_IMAGE_UPDATE, BUTTON_UPDATE_ALT); ?></div>
<div class="buttonRow back" align="center"><?php echo '<a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?></div>
<?php
    }
?>

<?php
  }
?>

</form>    
</div>
