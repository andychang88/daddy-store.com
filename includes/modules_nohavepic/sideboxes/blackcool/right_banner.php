<?php
   if (!defined('IS_ADMIN_FLAG')) {
       die('Illegal Access');
   }
   
   require($template->get_template_dir('tpl_right_banner.php',
                                       DIR_WS_TEMPLATE, 
									   $current_page_base,
									   'sideboxes'). '/tpl_right_banner.php');
?>