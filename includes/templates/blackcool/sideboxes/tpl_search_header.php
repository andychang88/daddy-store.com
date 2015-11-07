<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2010 oasis Team
 * @copyright Portions 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_search_header.php 4142 2010-03-22 17:32:54Z johnzhang $
 */
  
  //modified by john 2010-03-18
  
  $content = "<ul>";
  $s_form = zen_draw_form('quick_find_header', zen_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get');
  $s_main_page = zen_draw_hidden_field('main_page',FILENAME_ADVANCED_SEARCH_RESULT);
  //$s_search_in_description = zen_draw_hidden_field('search_in_description', '1') . zen_hide_session_id();
  $s_categories=zen_draw_pull_down_menu('categories_id', 
										zen_get_top_categories(array (array ('id' => '','text' => TEXT_ALL_CATEGORIES)),0,'',1),
										'',' class="select_2s" id="categories_search_select" ');
  $s_subcat=zen_draw_hidden_field('inc_subcat', '1');
  
  //$s_include_only_title=zen_draw_checkbox_field('only_include_title','',false).TEXT_ONLY_INCLUDE_ITEM_TIELE;
  
  $s_keyword = zen_draw_input_field('keyword',
									'',
									'size="30" maxlength="50" class="input_s"  
									 onfocus="if (this.value == \'' . HEADER_SEARCH_DEFAULT_TEXT . '\') this.value = \'\';" 
									') . '&nbsp;';
  
  //if (strtolower(IMAGE_USE_CSS_BUTTONS) == 'yes') {
    $s_search_button = zen_image_submit (BUTTON_IMAGE_SEARCH,HEADER_SEARCH_BUTTON,'  align="middle" class="input2"  ');
  /*} else {
    $s_search_button = '<input type="submit" value="' . HEADER_SEARCH_BUTTON . '" style="width: 45px" />';
  }*/
  
  /*$s_advanced_search_url='<a href="'.zen_href_link(FILENAME_ADVANCED_SEARCH).'" 
                             title="'.TEXT_ADVACED_SEARCH.'">'.TEXT_ADVACED_SEARCH.'</a>';*/
  
  $content.=$s_form.$s_main_page;
 
  $content.='<li><strong>'.TEXT_HEADING_SEARCH.'</strong></li>';
  $content.='<li>'.$s_categories.'</li><li>'.$s_keyword.'</li>';
  $content.=$s_subcat;
  //$content.=$s_search_in_description;
  //$content.=$s_include_only_title;
  $content.='<li>'.$s_search_button.'</li>';
  //$content.='<li>'.$s_advanced_search_url.'</li>';
  $content.= "</form>";
  $content.= "</ul>";
/**********************end******************************/  
?>