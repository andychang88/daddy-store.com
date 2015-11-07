<?php
   function zen_get_products_short_description($product_id, $language_id) {
    global $db;
    $product = $db->Execute("select products_short_description
                             from " . TABLE_PRODUCTS_DESCRIPTION . "
                             where products_id = '" . (int)$product_id . "'
                             and   language_id = '" . (int)$language_id . "'");

    return $product->fields['products_short_description'];
  }
  function zen_get_products_photo_html($product_id, $language_id) {
    global $db;
    $product = $db->Execute("select products_photo_html
                             from " . TABLE_PRODUCTS_DESCRIPTION . "
                             where products_id = '" . (int)$product_id . "'
                             and   language_id = '" . (int)$language_id . "'");

    return $product->fields['products_photo_html'];
  }
?>