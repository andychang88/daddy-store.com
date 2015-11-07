<?php
  if(isset($_GET['products_id']) && is_numeric($_GET['products_id'])){
	    if (isset($current_category_id) && ($current_category_id > 0)) {
			  $best_sellers_query = "select distinct p.products_id, pd.products_name,
											p.products_ordered,p.products_image 
									 from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, "
											. TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c
									 where p.products_status = '1'
									 and   p.products_ordered > 0
									 and   p.products_id = pd.products_id
									 and   pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
									 and   p.products_id = p2c.products_id
									 and   p2c.categories_id = c.categories_id
									 and   '" . (int)$current_category_id . "' in (c.categories_id, c.parent_id)
									 order by p.products_ordered desc, pd.products_name
									 limit " . MAX_DISPLAY_BESTSELLERS;
		
			  $best_sellers = $db->Execute($best_sellers_query);
	
		} else {
			  $best_sellers_query = "select distinct p.products_id, pd.products_name, 
											p.products_ordered,p.products_image 
									 from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
									 where p.products_status = '1'
									 and   p.products_ordered > 0
									 and   p.products_id = pd.products_id
									 and   pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
									 order by p.products_ordered desc, pd.products_name
									 limit " . MAX_DISPLAY_BESTSELLERS;
		
			  $best_sellers = $db->Execute($best_sellers_query);
		}
        	
		if ($best_sellers->RecordCount() >= MIN_DISPLAY_BESTSELLERS) {
			  $rows = 0;
			  $show_product_info_bestsellers=true;
			  $product_info_bestsellers=array();
			  while (!$best_sellers->EOF) {
					$rows++;
					$product_info_bestsellers[$rows]['id'] = $best_sellers->fields['products_id'];
					$product_info_bestsellers[$rows]['name']  = $best_sellers->fields['products_name'];
					$product_info_bestsellers[$rows]['image']= $best_sellers->fields['products_image'];
					$best_sellers->MoveNext();
			  }
	      
		}
  }
?>