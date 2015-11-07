<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account_newsletters.<br />
 * Subscribe/Unsubscribe from General Newsletter
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_account_newsletters_default.php 2896 2006-01-26 19:10:56Z birdbrain $
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
                <td class="main" valign="top"><?php echo MY_NEWSLETTERS_GENERAL_NEWSLETTER;?></td>
              </tr>
            </tbody>
          </table>
      </td>
    </tr>
  </tbody>
</table>  
<div class="centerColumn" id="acctNewslettersDefault">
<?php echo zen_draw_form('account_newsletter', zen_href_link(FILENAME_ACCOUNT_NEWSLETTERS, '', 'SSL')) . zen_draw_hidden_field('action', 'process'); ?>
<fieldset>
<?php echo zen_draw_checkbox_field('newsletter_general', '1', (($newsletter->fields['customers_newsletter'] == '1') ? true : false), 'id="newsletter"'); ?>
<label class="checkboxLabel" for="newsletter"><?php echo MY_NEWSLETTERS_GENERAL_NEWSLETTER_DESCRIPTION; ?></label>
<br class="clearBoth" /></fieldset>


<div class="buttonRow forward" style="float:left">
  <?php echo zen_image_submit(BUTTON_IMAGE_UPDATE, BUTTON_UPDATE_ALT); ?>
</div> 
<div class="buttonRow back" align="center"><?php echo '<a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?></div>

</form>
</div>