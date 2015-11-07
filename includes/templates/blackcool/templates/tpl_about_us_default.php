<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=contact_us.<br />
 * Displays contact us page form.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_contact_us_default.php 4272 2006-08-26 03:10:49Z drbyte $
 */
?>
<?php if (DEFINE_ABOUT_US_STATUS >= '1' && DEFINE_ABOUT_US_STATUS <= '2') { ?>
<div id="contactUsNoticeContent" class="content">
	<?php
    /**
     * require html_define for the about_us page
     */
      require($define_page);
    ?>
</div>
<?php } ?>