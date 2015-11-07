<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=advanced_search.<br />
 * Displays options fields upon which a product search will be run
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_advanced_search_default.php 4673 2006-10-03 01:37:07Z drbyte $
 */
?>
<div class="allborder margin_t">
	 <div class="pad_10px g_t_c">
		<ul><?php echo TEXT_YOUR_SEARCH;?><span class="red"><?php echo trim($_GET['keyword']);?></span></ul>
		<h3 class="red"><?php echo TEXT_SEARCH_NO_RESULT;?></h3>
		<ul>
		    <a href="javascript: history.go(-1);">
			  <?php echo zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT); ?>
			</a>
	    </ul>
		
		<ul class="red_arrow_list g_t_l pad_10px"><h4 class="red"><?php echo TEXT_SEARCH_TIP_TITLE;?></h4>
			<li><?php echo TEXT_SEARCH_TIP_SPELLING;?></li>
			<li><?php echo TEXT_SEARCH_TIP_SHORT;?></li>		
		</ul>
	</div>
</div>
<?php  //=============================New products module==================================
		require($template->get_template_dir('tpl_modules_whats_new.php',
											 DIR_WS_TEMPLATE,
											 $current_page_base,
											 'templates').'/tpl_modules_whats_new.php');
 ?>