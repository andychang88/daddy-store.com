<?php
/**
 * Common Template
 *
 * outputs the html header. i,e, everything that comes before the \</head\> tag <br />
 * 
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: html_header.php 6948 2007-09-02 23:30:49Z drbyte $
 */
/**
 * load the module for generating page meta-tags
 */
require(DIR_WS_MODULES . zen_get_module_directory('meta_tags.php'));
/**
 * output main page HEAD tag and related headers/meta-tags, etc
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo HTML_PARAMS; ?>>
<head>

<title><?php 

$title=META_TAG_TITLE;
 if(stristr($title,'Hiphone')){
				  echo  $title=str_ireplace('HiPhone','TPhone',$title);
				  }elseif(stristr($title,'iPhone')){
				 echo  $title=str_ireplace('iPhone','TPhone',$title);
				  }else{
					  if(stristr($title,'-')){
						echo rtrim($title, '-');
					  }else{
						echo $title;
					  }		  
				  }
?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<meta name="keywords" content="<?php
	      if(stristr(META_TAG_KEYWORDS,'Hiphone')){
				  echo  str_ireplace('HiPhone','TPhone',META_TAG_KEYWORDS);
				  }elseif(stristr($title,'iPhone')){
				 echo  str_ireplace('iPhone','TPhone',META_TAG_KEYWORDS);
				  }else{
				  echo META_TAG_KEYWORDS;
				  }

 ?>" />
<meta name="description" content="<?php 
	    	      if(stristr(META_TAG_DESCRIPTION,'Hiphone')){
				  echo  str_ireplace('HiPhone','TPhone',META_TAG_DESCRIPTION);
				  }elseif(stristr($title,'iPhone')){
				 echo  str_ireplace('iPhone','TPhone',META_TAG_DESCRIPTION);
				  }else{
				  echo META_TAG_DESCRIPTION;
				  }
 
?>" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<?php if (defined('ROBOTS_PAGES_TO_SKIP') && in_array($current_page_base,explode(",",constant('ROBOTS_PAGES_TO_SKIP'))) || $current_page_base=='down_for_maintenance' || $robotsNoIndex === true) { ?>
<meta name="robots" content="noindex, nofollow" />
<?php }else{ ?>
<meta content="index,follow" name="robots"/>
<?php }?>
<?php if($_SERVER['HTTP_HOST'] == 'www.backever.com'){?>
<meta name="google-site-verification" content="vsyxv5QI3V9O4CPTNaz95lXhXBhU11NkZpy9fNA8tHs" />
<meta name="y_key" content="c69abd765a96c59c" />
<?php }else if($_SERVER['HTTP_HOST'] == 'www.usbexporter.com'){?>
<meta name="google-site-verification" content="vJUfjTQ60XnL4aQ4MUDEU270aFTswh6aptBg6O8BbVg" />
<meta name="y_key" content="77378a14b70ec91c" />
<?php }?>
<?php if (defined('FAVICON')) { ?>
<link rel="icon" href="<?php echo FAVICON; ?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo FAVICON; ?>" type="image/x-icon" />
<?php } //endif FAVICON ?>

<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER . DIR_WS_HTTPS_CATALOG : HTTP_SERVER . DIR_WS_CATALOG ); ?>" />

<?php

/**
 * load all template-specific stylesheets, named like "style*.css", alphabetically
 */
  $directory_array = $template->get_template_part($template->get_template_dir('.css',DIR_WS_TEMPLATE, $current_page_base,'css'), '/^style/', '.css');
  while(list ($key, $value) = each($directory_array)) {
    echo '<link rel="stylesheet" type="text/css" href="' . $template->get_template_dir('.css',DIR_WS_TEMPLATE, $current_page_base,'css') . '/' . $value . '?'.strtotime(date('Y-m')).'" />'."\n";//zhengcongzhen 2011-04-26 在css尾部加了月份时间戳
  }
/**
 * load stylesheets on a per-page/per-language/per-product/per-manufacturer/per-category basis. Concept by Juxi Zoza.
 */
  $manufacturers_id = (isset($_GET['manufacturers_id'])) ? $_GET['manufacturers_id'] : '';
  $tmp_products_id = (isset($_GET['products_id'])) ? (int)$_GET['products_id'] : '';
  $tmp_pagename = ($this_is_home_page) ? 'index_home' : $current_page_base;
  $sheets_array = array('/' . $_SESSION['language'] . '_stylesheet', 
                        '/' . $tmp_pagename, 
                        '/' . $_SESSION['language'] . '_' . $tmp_pagename, 
                        '/c_' . $cPath,
                        '/' . $_SESSION['language'] . '_c_' . $cPath,
                        '/m_' . $manufacturers_id,
                        '/' . $_SESSION['language'] . '_m_' . (int)$manufacturers_id, 
                        '/p_' . $tmp_products_id,
                        '/' . $_SESSION['language'] . '_p_' . $tmp_products_id
                        );
  while(list ($key, $value) = each($sheets_array)) {
    //echo "<!--looking for: $value-->\n";
    $perpagefile = $template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css') . $value . '.css';
    if (file_exists($perpagefile)) echo '<link rel="stylesheet" type="text/css" href="' . $perpagefile .'?'.strtotime(date('Y-m')).'" />'."\n";//zhengcongzhen 2011-04-26 在css尾部加了月份时间戳
  }

/**
 * load printer-friendly stylesheets -- named like "print*.css", alphabetically
 */
  $directory_array = $template->get_template_part($template->get_template_dir('.css',DIR_WS_TEMPLATE, $current_page_base,'css'), '/^print/', '.css');
  sort($directory_array);
  while(list ($key, $value) = each($directory_array)) {
    echo '<link rel="stylesheet" type="text/css" media="print" href="' . $template->get_template_dir('.css',DIR_WS_TEMPLATE, $current_page_base,'css') . '/' . $value . '?'.strtotime(date('Y-m')).'" />'."\n";//zhengcongzhen 2011-04-26 在css尾部加了月份时间戳
  }

/*****************start 2011-05-12 ************************/
if(!file_exists(DIR_WS_TEMPLATES.'blackcool/jscript/jscript_e_register_login_form_define.js')){
	require(DIR_WS_TEMPLATES.'blackcool/login/register_login_js_define.php');
	file_put_contents(DIR_WS_TEMPLATES.'blackcool/jscript/jscript_e_register_login_form_define.js', $js_define);
}


/**
 * load all site-wide jscript_*.js files from includes/templates/YOURTEMPLATE/jscript, alphabetically
 */
  //modified by john 2010-03-22
  //$directory_array = $template->get_template_part($template->get_template_dir('.js',DIR_WS_TEMPLATE, $current_page_base,'jscript'), '/^jscript_/', '.js');
  $directory_array = $template->get_template_part($template->get_template_dir('.js',DIR_WS_TEMPLATE, $current_page_base,'jscript'), '/\.js$/', '.js');

  while(list ($key, $value) = each($directory_array)) {
    echo '<script type="text/javascript" src="' .  $template->get_template_dir('.js',DIR_WS_TEMPLATE, $current_page_base,'jscript') . '/' . $value . '?'.strtotime(date('Y-m')).'"></script>'."\n";//zhengcongzhen 2011-04-26 在js尾部加了月份时间戳
  }

/**
 * load all page-specific jscript_*.js files from includes/modules/pages/PAGENAME, alphabetically
 */
  $directory_array = $template->get_template_part($page_directory, '/^jscript_/', '.js');
  while(list ($key, $value) = each($directory_array)) {
    echo '<script type="text/javascript" src="' . $page_directory . '/' . $value . '?'.strtotime(date('Y-m')).'"></script>' . "\n";//zhengcongzhen 2011-04-26 在js尾部加了月份时间戳
  }

/**
 * load all site-wide jscript_*.php files from includes/templates/YOURTEMPLATE/jscript, alphabetically
 */
  $directory_array = $template->get_template_part($template->get_template_dir('.php',DIR_WS_TEMPLATE, $current_page_base,'jscript'), '/^jscript_/', '.php');
  while(list ($key, $value) = each($directory_array)) {
/**
 * include content from all site-wide jscript_*.php files from includes/templates/YOURTEMPLATE/jscript, alphabetically.
 * These .PHP files can be manipulated by PHP when they're called, and are copied in-full to the browser page
 */
    require($template->get_template_dir('.php',DIR_WS_TEMPLATE, $current_page_base,'jscript') . '/' . $value); echo "\n";
  }
/**
 * include content from all page-specific jscript_*.php files from includes/modules/pages/PAGENAME, alphabetically.
 */
  $directory_array = $template->get_template_part($page_directory, '/^jscript_/');
  while(list ($key, $value) = each($directory_array)) {
/**
 * include content from all page-specific jscript_*.php files from includes/modules/pages/PAGENAME, alphabetically.
 * These .PHP files can be manipulated by PHP when they're called, and are copied in-full to the browser page
 */
    require($page_directory . '/' . $value); echo "\n";
  }

//DEBUG: echo '<!-- I SEE cat: ' . $current_category_id . ' || vs cpath: ' . $cPath . ' || page: ' . $current_page . ' || template: ' . $current_template . ' || main = ' . ($this_is_home_page ? 'YES' : 'NO') . ' -->';
?>





</head>
<?php // NOTE: Blank line following is intended: ?>