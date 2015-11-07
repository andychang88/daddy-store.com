<?php
/**
 * best_sellers sidebox - displays selected number of (usu top ten) best selling products
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: best_sellers.php 2718 2005-12-28 06:42:39Z drbyte $
 */

// test if box should display
  $show_best_sellers= true;
  
  if(isset($global_id_excluded)) unset($global_id_excluded);
  $global_id_excluded=array();
  

  /*if (isset($_GET['products_id'])) {
    if (isset($_SESSION['customer_id'])) {
      $check_query = "select count(*) as count
                      from " . TABLE_CUSTOMERS_INFO . "
                      where customers_info_id = '" . (int)$_SESSION['customer_id'] . "'
                      and global_product_notifications = '1'";

      $check = $db->Execute($check_query);

      if ($check->fields['count'] > 0) {
        $show_best_sellers= true;
      }
    }
  } else {
    $show_best_sellers= true;
  }*/

  if ($show_best_sellers == true && ($current_page_base=='product_info'|| (!$this_is_home_page && $current_page_base=='index'))) {
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
	  $frist_get_pid_query4=" select distinct products_id
		                      from products  
							  order by products_ordered desc
							  limit 0,".MAX_DISPLAY_BESTSELLERS;
      $frist_get_pid_db4=$db->Execute($frist_get_pid_query4);
	  $frist_get_pid4=array();
	  $best_sellers_query='';
	  if($frist_get_pid_db4->RecordCount()>0){
		   
		  while(!$frist_get_pid_db4->EOF){
		       $frist_get_pid4[]=$frist_get_pid_db4->fields['products_id'];
			   $frist_get_pid_db4->MoveNext();
		  }
		  $frist_pid_str4=implode(',',$frist_get_pid4);
	
		  $best_sellers_query = "select distinct p.products_id, pd.products_name, 
										p.products_ordered,p.products_image 
								 from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
								 where p.products_status = '1'
								 and   p.products_ordered > 0
								 and   p.products_id = pd.products_id
								 and   pd.language_id = '" . (int)$_SESSION['languages_id'] . "' 
								 and   p.products_id in(".$frist_pid_str4.")";
	  }		 
                             
	  if(!empty($best_sellers_query)){
		  $best_sellers = $db->Execute($best_sellers_query);
	  }
    }

    if ($best_sellers->RecordCount() >= MIN_DISPLAY_BESTSELLERS) {
      $title =  '';
      $box_id =  'bestsellers';
      $rows = 0;
      while (!$best_sellers->EOF) {
	    
		$global_id_excluded[]= $best_sellers->fields['products_id'];
		
        $rows++;
        $bestsellers_list[$rows]['id'] = $best_sellers->fields['products_id'];
        $bestsellers_list[$rows]['name']  = zen_trunc_string($best_sellers->fields['products_name'],30,true);
		$bestsellers_list[$rows]['image']= $best_sellers->fields['products_image'];
		$bestsellers_list[$rows]['price']=zen_get_products_display_price($best_sellers->fields['products_id']);
        $best_sellers->MoveNext();
      }

      $title_link = false;
      require($template->get_template_dir('tpl_product_info_best_sellers.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_product_info_best_sellers.php');
      $title =  BOX_HEADING_BESTSELLERS;
      require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
    }
  }
?>