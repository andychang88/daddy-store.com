<?php
/**
 * column_right module 
 *
 * @package templateStructure
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: column_right.php 4274 2006-08-26 03:16:53Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

// Check if there are boxes for the column
$column_right_display= $db->Execute("select layout_box_name from " . TABLE_LAYOUT_BOXES . " 
									where layout_box_location=1 and layout_box_status=1 and layout_template ='" . $template_dir . "'" . ' 
									order by layout_box_sort_order');

// safety row stop
$box_cnt=0;
while (!$column_right_display->EOF and $box_cnt < 10) {
	
  $box_cnt++;
  
  $template_layout_file = DIR_WS_MODULES . 'sideboxes/' . $template_dir . '/' . $column_right_display->fields['layout_box_name'];
  $layout_file = DIR_WS_MODULES . 'sideboxes/' . $column_right_display->fields['layout_box_name'];
  $require_file = '';
  
  if( file_exists( $template_layout_file ) ) {
  	$box_id = zen_get_box_id($column_right_display->fields['layout_box_name']);
	$require_file = $template_layout_file;
  } elseif( file_exists( $layout_file ) ){
  	$box_id = zen_get_box_id($column_right_display->fields['layout_box_name']);
	$require_file = $layout_file;
  }
  //echo $require_file.'<br>';
  if($require_file){
  	require($require_file);
  }
 
  $column_right_display->MoveNext();
  
} // while column_right

$box_id = '';
