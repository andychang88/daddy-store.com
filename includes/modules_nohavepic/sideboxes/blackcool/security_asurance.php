<?php
   if (!defined('IS_ADMIN_FLAG')) {
       die('Illegal Access');
   }
   if($current_page_base!='product_info'){
	   require($template->get_template_dir('tpl_security_asurance.php',
										   DIR_WS_TEMPLATE, 
										   $current_page_base,
										   'sideboxes'). '/tpl_security_asurance.php');
   }
?>