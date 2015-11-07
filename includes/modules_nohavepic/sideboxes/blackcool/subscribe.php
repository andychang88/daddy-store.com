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
// $Id: subscribe.php,v 1.1 2005/06/28, dmcl1
//  


// test if box should display
   $show_subscribe = false;
   if(defined('NEWSONLY_SUBSCRIPTION_ENABLED') &&(NEWSONLY_SUBSCRIPTION_ENABLED=='true')) {
      $show_subscribe = true;
   }
   //if ($show_subscribe == true && $current_page_base!='product_info') {    
   if ($show_subscribe == true && $this_is_home_page) {    
      require($template->get_template_dir('tpl_subscribe.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_subscribe.php');
   }
?>