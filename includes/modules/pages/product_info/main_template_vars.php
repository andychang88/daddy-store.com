<?php
/**
 *  product_info main_template_vars.php
 *
 * @package productTypes
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: main_template_vars.php 6275 2007-05-02 11:46:37Z drbyte $
 */
/*
 * Extracts and constructs the data to be used in the product-type template tpl_TYPEHANDLER_info_display.php
 */

  // This should be first line of the script:
  $zco_notifier->notify('NOTIFY_MAIN_TEMPLATE_VARS_START_PRODUCT_INFO');
  // categories_description
$sql = "SELECT categories_name 
        FROM " . TABLE_CATEGORIES_DESCRIPTION . "
        WHERE categories_id= :categoriesID
        AND language_id = :languagesID";

$sql = $db->bindVars($sql, ':categoriesID', $current_category_id, 'integer');
$sql = $db->bindVars($sql, ':languagesID', $_SESSION['languages_id'], 'integer');
$categories_description_lookup = $db->Execute($sql);
if ($categories_description_lookup->RecordCount() > 0) {
  
  $current_categories_name = $categories_description_lookup->fields['categories_name'];
}


  
  $module_show_categories = PRODUCT_INFO_CATEGORIES;

  $sql = "select count(*) as total
          from " . TABLE_PRODUCTS . " p, " .
                   TABLE_PRODUCTS_DESCRIPTION . " pd
          where    p.products_status = '1'
          and      p.products_id = '" . (int)$_GET['products_id'] . "'
          and      pd.products_id = p.products_id
          and      pd.language_id = '" . (int)$_SESSION['languages_id'] . "'";


  $res = $db->Execute($sql);

  if ( $res->fields['total'] < 1 ) {

    $tpl_page_body = '/tpl_product_info_noproduct.php';

  } else {

    $tpl_page_body = '/tpl_product_info_display.php';

    $sql = "update " . TABLE_PRODUCTS_DESCRIPTION . "
            set        products_viewed = products_viewed+1
            where      products_id = '" . (int)$_GET['products_id'] . "'
            and        language_id = '" . (int)$_SESSION['languages_id'] . "'";

    $res = $db->Execute($sql);

    $sql ="select p.products_id, pd.products_name,
                  pd.products_description,pd.products_short_description, p.products_afterbuy_model,pd.products_photo_html,
                  p.products_quantity, p.products_image,
                  pd.products_url, p.products_price,
                  p.products_tax_class_id, p.products_date_added,
                  p.products_date_available, p.manufacturers_id, p.products_quantity,
                  p.products_weight, p.products_priced_by_attribute, p.product_is_free,
                  p.products_qty_box_status,
				  pd.products_viewed,
                  p.products_quantity_order_max,
                  p.products_stock_status,
                  p.products_discount_type, p.products_discount_type_from, p.products_sort_order, p.products_price_sorter,
				  p.master_categories_id
           from   " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
           where  p.products_status = '1'
           and    p.products_id = '" . (int)$_GET['products_id'] . "'
           and    pd.products_id = p.products_id
           and    pd.language_id = '" . (int)$_SESSION['languages_id'] . "'";

    $product_info = $db->Execute($sql);

    $products_price_sorter = $product_info->fields['products_price_sorter'];

    /*$products_price = $currencies->display_price($product_info->fields['products_price'],
												 zen_get_tax_rate($product_info->fields['products_tax_class_id']));*/
	$products_price=zen_get_products_display_price($product_info->fields['products_id']);

    $manufacturers_name= zen_get_products_manufacturers_name((int)$_GET['products_id']);

    /*if ($new_price = zen_get_products_special_price($product_info->fields['products_id'])) {        
        $specials_price = $currencies->display_price($new_price,zen_get_tax_rate($product_info->fields['products_tax_class_id']));

    }*/

// set flag for attributes module usage:
    $flag_show_weight_attrib_for_this_prod_type = SHOW_PRODUCT_INFO_WEIGHT_ATTRIBUTES;
    // get attributes
    require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_ATTRIBUTES));

// if review must be approved or disabled do not show review
    /*$review_status = " and r.status = '1'";

    $reviews_query = " select count(*) as count from " . TABLE_REVIEWS . " r, "
                                                       . TABLE_REVIEWS_DESCRIPTION . " rd
                       where r.products_id = '" . (int)$_GET['products_id'] . "'
                       and   r.reviews_id = rd.reviews_id
                       and   rd.languages_id = '" . (int)$_SESSION['languages_id'] . "'" .
                       $review_status;

    $reviews = $db->Execute($reviews_query);*/	
  }

  //require(DIR_WS_MODULES . zen_get_module_directory('product_prev_next.php'));

  $products_name = $product_info->fields['products_name'];
  $products_afterbuy_model = $product_info->fields['products_afterbuy_model'];
  $master_categories_id= $product_info->fields['master_categories_id'];
  //added by john 2010-06-15 11:35 for products accessories model
  $products_photo_html=$product_info->fields['products_photo_html'];
  $products_short_description=$product_info->fields['products_short_description'];
  //end add
  $products_description = $product_info->fields['products_description'];

  if ($product_info->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == '1') {
    $products_image = PRODUCTS_IMAGE_NO_IMAGE;
  } else {
    $products_image = $product_info->fields['products_image'];
  }

  $products_url = $product_info->fields['products_url'];
  $products_date_available = $product_info->fields['products_date_available'];
  $products_date_added = $product_info->fields['products_date_added'];
  $products_manufacturer = $manufacturers_name;
  $products_weight = $product_info->fields['products_weight'];
  $products_quantity = $product_info->fields['products_quantity'];
  
  $products_qty_box_status = $product_info->fields['products_qty_box_status'];
  $products_quantity_order_max = $product_info->fields['products_quantity_order_max'];

  $products_base_price = $currencies->display_price(zen_get_products_base_price((int)$_GET['products_id']),
                      zen_get_tax_rate($product_info->fields['products_tax_class_id']));

  $product_is_free = $product_info->fields['product_is_free'];

  $products_tax_class_id = $product_info->fields['products_tax_class_id'];

  $module_show_categories = PRODUCT_INFO_CATEGORIES;
  $module_next_previous = PRODUCT_INFO_PREVIOUS_NEXT;

  $products_id_current = (int)$_GET['products_id'];
  $products_discount_type = $product_info->fields['products_discount_type'];
  $products_discount_type_from = $product_info->fields['products_discount_type_from'];
  //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&Customed by oasis&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
  //added by john 2010-04-10
  $products_add_qty=zen_draw_input_field('cart_quantity','1',' size="3" maxlength="4" id="input1"').' '.zen_draw_hidden_field('products_id', $product_info->fields['products_id']);
  //Product Review handle
  $products_viewed=$product_info->fields['products_viewed'];
  $products_stock_status=$product_info->fields['products_stock_status'];
  //$products_reviews=zen_get_reviews_of_product($product_info->fields['products_id']); 
  $products_id=$product_info->fields['products_id'];
  $language_id=isset($_SESSION['languages_id'])?$_SESSION['languages_id']:1;
  $customer_id=isset($_SESSION['customer_id'])?$_SESSION['customer_id']:0;
  $customer_name=isset($_SESSION['customer_first_name'])?$_SESSION['customer_first_name']:''; 
  
  $products_herf_link=zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$products_id);
  //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&& END &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
  require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_PRODUCTS_QUANTITY_DISCOUNTS));
  require($template->get_template_dir($tpl_page_body,DIR_WS_TEMPLATE, $current_page_base,'templates'). $tpl_page_body);

  require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_ALSO_PURCHASED_PRODUCTS));

  
  

  //This should be last line of the script:
  $zco_notifier->notify('NOTIFY_MAIN_TEMPLATE_VARS_END_PRODUCT_INFO');
?>