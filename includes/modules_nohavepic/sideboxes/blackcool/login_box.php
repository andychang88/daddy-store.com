<?php
   if (!defined('IS_ADMIN_FLAG')) {
       die('Illegal Access');
   }
   
   require($template->get_template_dir('tpl_login_box.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_login_box.php');
   require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
?>