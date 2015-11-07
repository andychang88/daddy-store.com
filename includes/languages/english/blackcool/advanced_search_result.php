<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |   
// | http://www.zen-cart.com/index.php                                    |   
// |                                                                      |   
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: advanced_search_result.php 293 2008-05-28 21:10:40Z maleborg $
//

define('NAVBAR_TITLE_1', 'Advanced Search');
define('NAVBAR_TITLE_2','Search results');

//define('HEADING_TITLE_1', 'Advanced Search');
define('HEADING_TITLE', 'Advanced Search');

define('HEADING_SEARCH_CRITERIA','Search criteria:');

define('TEXT_SEARCH_IN_DESCRIPTION','Search In Product Descriptions');
define('ENTRY_CATEGORIES', 'Categories:');
define('ENTRY_INCLUDE_SUBCATEGORIES', 'Include Subcategories');
define('ENTRY_MANUFACTURERS', 'Manufacturer:');
define('ENTRY_PRICE_FROM', 'Price from:');
define('ENTRY_PRICE_TO', 'Price To:');
define('ENTRY_DATE_FROM', 'From Date:');
define('ENTRY_DATE_TO', 'Date To:');

define('TEXT_SEARCH_HELP_LINK', 'Help [?]');

define('TEXT_ALL_CATEGORIES', 'All Categories');
define('TEXT_ALL_MANUFACTURERS', 'All Manufacturers');

define('HEADING_SEARCH_HELP', 'Help with search');
define('TEXT_SEARCH_HELP', 'Searches can use the AND or OR are used.<br /><br />For example, Microsoft AND mouse tag found with two words. Whereas with Microsoft mouse OR terms are found to contain either Microsoft or mouse.');
define('TEXT_CLOSE_WINDOW', 'Close window [x]');

define('TABLE_HEADING_IMAGE', 'Product Image');
define('TABLE_HEADING_MODEL', 'Article ID');
define('TABLE_HEADING_PRODUCTS', 'Product Name');
define('TABLE_HEADING_MANUFACTURER', 'Manufacturer');
define('TABLE_HEADING_QUANTITY', 'Number');
define('TABLE_HEADING_PRICE', 'Price');
define('TABLE_HEADING_WEIGHT', 'Weight');
define('TABLE_HEADING_BUY_NOW', 'Buy Now');

define('TEXT_NO_PRODUCTS', 'There were no products that match your search criteria.');

define('ERROR_AT_LEAST_ONE_INPUT', 'At least one selection must be made.');
define('ERROR_INVALID_FROM_DATE', 'Illegal entry "From the date"');
define('ERROR_INVALID_TO_DATE', 'Illegal entry "to Date"');
define('ERROR_TO_DATE_LESS_THAN_FROM_DATE', '"to date must be later than entry "From Date" to be.');
define('ERROR_PRICE_FROM_MUST_BE_NUM', '"Price of "must be a number.');
define('ERROR_PRICE_TO_MUST_BE_NUM', '"Price up "must be a number.');
define('ERROR_PRICE_TO_LESS_THAN_PRICE_FROM', '"Price up to "must exceed" price of".');
define('ERROR_INVALID_KEYWORDS', 'Illegal search words');
define('HEADING_SEARCH_RESULT','Search results for ');
?>