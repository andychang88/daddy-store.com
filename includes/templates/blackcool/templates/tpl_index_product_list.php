<?php
/**
 * Page Template
 *
 * Loaded by main_page=index<br />
 * Displays product-listing when a particular category/subcategory is selected for browsing
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_index_product_list.php 6009 2007-03-13 23:56:45Z ajeh $
 */
?>
<?php

// categories_description
	//require_once(DIR_WS_MODULES . zen_get_module_directory(FILENAME_PRICE_FILTER));
	
	if (zen_not_null($current_categories_description) || zen_not_null($current_categories_name)) {

	} 
// categories_description ?>
<?php
/**
 * require the code for listing products
 */

 require($template->get_template_dir('tpl_modules_product_listing.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_product_listing.php');
?>
<?php //=============================New products module==================================
		/*require($template->get_template_dir('tpl_modules_whats_new.php',
											 DIR_WS_TEMPLATE,
											 $current_page_base,
											 'templates').'/tpl_modules_whats_new.php');*/
                /**
	  require($template->get_template_dir('tpl_modules_category_new_products.php',
										  DIR_WS_TEMPLATE, 
										  $current_page_base,
										  'templates'). '/tpl_modules_category_new_products.php');
										  /**/
                                                                                  
 ?>
