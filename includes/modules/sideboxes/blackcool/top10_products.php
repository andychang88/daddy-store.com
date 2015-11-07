<?php
/**
 * top 10 sold products sidebox - displays selected number of (usu top ten) best selling products
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: top10_products.php 2718 2010-04-07 23:59:42:39Z john $
 */

// test if box should display
  $show_top10_products= true;

  /*if (isset($_GET['products_id'])) {
    if (isset($_SESSION['customer_id'])) {
      $check_query = "select count(*) as count
                      from " . TABLE_CUSTOMERS_INFO . "
                      where customers_info_id = '" . (int)$_SESSION['customer_id'] . "'
                      and global_product_notifications = '1'";

      $check = $db->Execute($check_query);

      if ($check->fields['count'] > 0) {
        $show_top10_products= true;
      }
    }
  } else {
    $show_top10_products= true;
  }*/

  if ($show_top10_products == true) {
    if (isset($current_category_id) && ($current_category_id > 0)) {
      $top10_products_query = "select distinct p.products_id, pd.products_name
                               from " . TABLE_PRODUCTS . " p, 
							        " . TABLE_PRODUCTS_DESCRIPTION . " pd, 
									" . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, 
									" . TABLE_CATEGORIES . " c
                               where p.products_status = '1'
                               and   p.products_ordered > 0
                               and   p.products_id = pd.products_id
                               and   pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                               and   p.products_id = p2c.products_id
                               and   p2c.categories_id = c.categories_id
                               and   '" . (int)$current_category_id . "' in (c.categories_id, c.parent_id)
                               order by p.products_ordered desc, pd.products_name
                               limit 10";

      $top10_products_db = $db->Execute($top10_products_query);

    } else {
      $top10_products_query = "select distinct p.products_id, pd.products_name 
                               from " . TABLE_PRODUCTS . " p, 
							        " . TABLE_PRODUCTS_DESCRIPTION . " pd
                               where p.products_status = '1'
                               and   p.products_ordered > 0
                               and   p.products_id = pd.products_id
                               and   pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                               order by p.products_ordered desc, pd.products_name
                               limit 10";

      $top10_products_db = $db->Execute($top10_products_query);
    }

    if ($top10_products_db->RecordCount() >= MIN_DISPLAY_BESTSELLERS) {
      $title =  '';
      //$box_id =  'bestsellers';
      $rows = 0;
      while (!$top10_products_db->EOF) {
        $rows++;
        $top10_products[$rows]['id'] = $top10_products_db->fields['products_id'];
        $top10_products[$rows]['name']  = $top10_products_db->fields['products_name'];
        $top10_products_db->MoveNext();
      }
      
      $title_link = false;
      require($template->get_template_dir('tpl_top10_products.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_top10_products.php');
      //$title =  BOX_HEADING_BESTSELLERS;
      require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
    }
  }
?>