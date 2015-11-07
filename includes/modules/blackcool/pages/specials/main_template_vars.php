<?php
/**
 * Specials
 *
 * @package page
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: main_template_vars.php 6912 2007-09-02 02:23:45Z drbyte $
 */
$show_split_page=false;
if (MAX_DISPLAY_SPECIAL_PRODUCTS > 0 ) {
  $specials_query_raw = "SELECT p.products_id, p.products_image, pd.products_name,p.master_categories_id
                         FROM (" . TABLE_PRODUCTS . " p
                         LEFT JOIN " . TABLE_SPECIALS . " s on p.products_id = s.products_id
                         LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                         WHERE p.products_id = s.products_id 
						 and   p.products_id = pd.products_id 
						 and   p.products_status = '1'
                         AND   s.status = 1
                         AND   pd.language_id = :languagesID
                         ORDER BY s.specials_date_added DESC";

  $specials_query_raw = $db->bindVars($specials_query_raw, ':languagesID', $_SESSION['languages_id'], 'integer');
  $specials_split = new splitPageResults($specials_query_raw, MAX_DISPLAY_SPECIAL_PRODUCTS);
  $specials = $db->Execute($specials_split->sql_query);
  /*$row = 0;
  $col = 0;
  $list_box_contents = array();
  $title = '';*/
  
  if($specials_split->number_of_rows > MAX_DISPLAY_SPECIAL_PRODUCTS) $show_split_page=true;
  $num_products_count = $specials->RecordCount();
  if ($num_products_count) {
    /*if ($num_products_count < SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS || SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS==0 ) {
      $col_width = floor(100/$num_products_count);
    } else {
      $col_width = floor(100/SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS);
    }*/

    //$list_box_contents = array();
	$specials_products=array();
    while (!$specials->EOF) {

      $product_price = zen_get_products_display_price($specials->fields['products_id']);
	  $ss_tmp_id=$specials->fields['products_id'];
	  /*$product_url_link=zen_href_link(zen_get_info_page($specials->fields['products_id']), 
	                                  'cPath=' . zen_get_generated_category_path_rev($specials->fields['master_categories_id']) . '&products_id=' . $ss_tmp_id);*/
	  $product_url_link=zen_href_link(zen_get_info_page($specials->fields['products_id']), 
	                                  'products_id=' . $ss_tmp_id);
	  //$product_name=zen_get_products_name($ss_tmp_id);
	  //$specials->fields['products_name'] = zen_get_products_name($specials->fields['products_id']);
	  
	  
	  $specials_products[]=array('product_name'=>$specials->fields['products_name'],
	                             'product_price'=>$product_price,
								 'product_url_link'=>$product_url_link,
								 'product_image'=>$specials->fields['products_image']
								 );	  
      
      /*$list_box_contents[$row][$col] = array('params' => 'class="specialsListBoxContents"' . ' ' . 'style="width:' . $col_width . '%;"',
                                             'text' => '<a href="' . zen_href_link(zen_get_info_page($specials->fields['products_id']), 'cPath=' . zen_get_generated_category_path_rev($specials->fields['master_categories_id']) . '&products_id=' . $specials->fields['products_id']) . '">' . (($specials->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : zen_image(DIR_WS_IMAGES . $specials->fields['products_image'], $specials->fields['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>') . '<br /><a href="' . zen_href_link(zen_get_info_page($specials->fields['products_id']), 'cPath=' . zen_get_generated_category_path_rev($specials->fields['master_categories_id']) . '&products_id=' . $specials->fields['products_id']) . '">' . $specials->fields['products_name'] . '</a><br />' . $products_price);
      $col ++;
      if ($col > (SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS - 1)) {
        $col = 0;
        $row ++;
      }*/
      $specials->MoveNext();
    }
    require($template->get_template_dir('tpl_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_specials_default.php');
  }
}
?>