<?php
/**
 * also_purchased_products.php
 *
 * @package modules
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: also_purchased_products.php 5369 2006-12-23 10:55:52Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

$sql = "select p.products_id,p.products_image,pd.products_name,
p.products_image,p.products_price from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd 
where p.products_status = '1' and   p.products_id < '" . (int)$_GET['products_id'] . "' 
 and p.master_categories_id='".$master_categories_id."' 
 and    pd.products_id = p.products_id 
 and    pd.language_id = '" . (int)$_SESSION['languages_id'] . "' 
 order by p.products_id desc limit 10";
$products_related_result = $db->Execute($sql);

$sql = "select categories_name from categories_description 
where categories_id='".$master_categories_id."' and language_id='".(int)$_SESSION['languages_id']."' ";
$categories_name_result = $db->Execute($sql);
if(!$categories_name_result->EOF){
	$categories_name = $categories_name_result->fields['categories_name'];
}else{
	$categories_name = '';
}
?>