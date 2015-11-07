<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=create-account_success.<br />
 * Displays confirmation that a new account has been created.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_create_account_success_default.php 4886 2006-11-05 09:01:18Z drbyte $
 */
?>
<div class="suces">
    <h1><?php echo HEADING_TITLE; ?></h1>
    <p><?php echo TEXT_ACCOUNT_CREATED; ?>
    </p>
    <p class="btn">
	   <a href="<?php echo $origin_href;?>"><?php echo zen_image_button(BUTTON_IMAGE_CONTINUE, BUTTON_CONTINUE_ALT);?></a>
	</p>
</div>