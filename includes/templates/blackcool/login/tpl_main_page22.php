<body id="<?php echo $body_id . 'Body'; ?>"<?php if($zv_onload !='') echo ' onload="'.$zv_onload.'"'; ?>>
<div class="head">    
    <div class="logo2"><a href="<?php echo HTTP_SERVER.DIR_WS_CATALOG;?>"><?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.'logo.jpg',TOP_LOGO_ALT);?></a></div>
</div>
<div class="clear"></div>
<div class="login">     
	<?php
	
	require($body_code);?>
    <div class="clear"></div>
</div><?php //end center div ?>
<?php
     /*require($template->get_template_dir('tpl_modules_products_recommend.php',
	                                     DIR_WS_TEMPLATE, 
										 $current_page_base,
										 'templates'). '/tpl_modules_products_recommend.php');*/
?>
<?php
     require($template->get_template_dir('tpl_footer.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_footer.php');
?>
</body>