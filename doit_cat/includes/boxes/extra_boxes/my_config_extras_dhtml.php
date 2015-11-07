<?php
/**
 * Sitemap XML Feed
 *
 * @package Sitemap XML Feed
 * @copyright Copyright 2005-2009, Andrew Berezin eCommerce-Service.com
 * @copyright Portions Copyright 2003-2009 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @link http://www.sitemaps.org/
 * @version $Id: sitemapxml.php, v 2.1.0 30.04.2009 10:35 AndrewBerezin $
 */

$za_contents[] = array('text' => "---System Message", 'link' => zen_href_link('mya_system_message', '', 'NONSSL'));
$za_contents[] = array('text' => "---Refund Request", 'link' => zen_href_link('mya_refund_request', '', 'NONSSL'));
$za_contents[] = array('text' => "---Price Notice", 'link' => zen_href_link('mya_price_notice', '', 'NONSSL'));
$za_contents[] = array('text' => "---Recommend Setting", 'link' => zen_href_link('mya_recommend_setting', '', 'NONSSL'));
