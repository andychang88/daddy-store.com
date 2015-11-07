<?php
/**
 * Contact Us Page
 *
 * @package page
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 6202 2007-04-12 22:56:10Z drbyte $
 */
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

// include template specific file name defines
$define_page = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_ABOUT_US, 'false');

$breadcrumb->add(NAVBAR_TITLE);
?>