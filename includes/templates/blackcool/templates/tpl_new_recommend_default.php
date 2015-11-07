<?php
/**
 * Module Template
 *
 * Loaded automatically by index.php?main_page=products_new.<br />
 * Displays listing of New Products
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_products_new_listing.php 6096 2007-04-01 00:43:21Z ajeh $
 */
?>
<?php
  $group_id = zen_get_configuration_key_value('PRODUCT_NEW_LIST_GROUP_ID');

  if(count($recommend_products_result)>0){
  	foreach($recommend_products_result as $products_new_key=>$products_new){//begin foreach $recommend_products_result
 ?>
 
<div class="grid new_recommends">
<h2><a href="<?php echo $recommend_products_cat_name[$products_new_key]['link'];?>"><?php 
 echo $recommend_products_cat_name[$products_new_key]['cat_name'];
 ?></a></h2>
 
  <ul>
<?php  

    while (!$products_new->EOF) {

      if (PRODUCT_NEW_LIST_IMAGE != '0') {
        if ($products_new->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) {
          $display_products_image = str_repeat('<br clear="all" />', substr(PRODUCT_NEW_LIST_IMAGE, 3, 1));
        } else {
          $display_products_image = '<a href="' . zen_href_link(zen_get_info_page($products_new->fields['products_id']), /*'cPath=' . zen_get_generated_category_path_rev($products_new->fields['master_categories_id']) . */'products_id=' . $products_new->fields['products_id']) . '">' . zen_image(DIR_WS_IMAGES . $products_new->fields['products_image'], $products_new->fields['products_name'], IMAGE_PRODUCT_NEW_LISTING_WIDTH, IMAGE_PRODUCT_NEW_LISTING_HEIGHT) . '</a>';// . str_repeat('<br clear="all" />', substr(PRODUCT_NEW_LIST_IMAGE, 3, 1));
        }
      } else {
        $display_products_image = '';
      }

      if (PRODUCT_NEW_LIST_NAME != '0') {
        $display_products_name = '<a href="' . zen_href_link(zen_get_info_page($products_new->fields['products_id']), /*'cPath=' . zen_get_generated_category_path_rev($products_new->fields['master_categories_id']) . */'products_id=' . $products_new->fields['products_id']) . '">' . $products_new->fields['products_name'] . '</a>';// . str_repeat('<br clear="all" />', substr(PRODUCT_NEW_LIST_NAME, 3, 1));
      } else {
        $display_products_name = '';
      }


      if ((PRODUCT_NEW_LIST_PRICE != '0' and zen_get_products_allow_add_to_cart($products_new->fields['products_id']) == 'Y') and zen_check_show_prices() == true) {
        $products_price = zen_get_products_display_price($products_new->fields['products_id']);
        $display_products_price = /*TEXT_PRICE . ' ' . */$products_price . str_repeat('<br clear="all" />', substr(PRODUCT_NEW_LIST_PRICE, 3, 1)) . (zen_get_show_product_switch($products_new->fields['products_id'], 'ALWAYS_FREE_SHIPPING_IMAGE_SWITCH') ? (zen_get_product_is_always_free_shipping($products_new->fields['products_id']) ? TEXT_PRODUCT_FREE_SHIPPING_ICON . '<br />' : '') : '');
      } else {
        $display_products_price = '';
      }



?>

     <li>
        <?php echo $display_products_image;?>
        <h3><?php echo $display_products_name;?></h3>
        <p class="p_price"><?php echo $display_products_price;?></p> 
	 </li>

<?php      
	$products_new->MoveNext(); 
    }//end while foreach $recommend_products_result
?>
</ul>
	 </div>
	 
<?php 
 }//end  foreach $recommend_products_result
 
 ?>
        
<?php	
  } else {
?>
	 <div class="grid"><?php echo TEXT_NO_NEW_PRODUCTS; ?></div>
<?php
  }
?>
