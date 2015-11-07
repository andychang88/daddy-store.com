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

  if ($show_best_sellers == true) {
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
	   $best_sellers_query='';
	  //############check filter some categories or not ##################
	  if(defined('TOPSELLER_LISTING_FITLERED_BY_CATEGORIES') && TOPSELLER_LISTING_FITLERED_BY_CATEGORIES && isset($topseller_listing_filtered_categories)){
	       
		   $allowed_cate_sql='select distinct categories_id from '.TABLE_CATEGORIES.'
							  where  categories_status=1 
							  and    parent_id in('.implode(',',$topseller_listing_filtered_categories).')';
		   $allowed_cate_db=$db->Execute($allowed_cate_sql);
		   $allowed_cate_id=array();
		   while(!$allowed_cate_db->EOF){
			    $allowed_cate_id[]=$allowed_cate_db->fields['categories_id'];
			 
			    $allowed_cate_db->MoveNext();
		   }
		   $category_fitler_str=' and p.master_categories_id in('.implode(',',$allowed_cate_id).') ';
			   
		   
		   $best_sellers_query = "select distinct p.products_id, pd.products_name, 
										          p.products_ordered,p.products_image 
								 from " . TABLE_PRODUCTS . " p, 
								      " . TABLE_PRODUCTS_DESCRIPTION . " pd,
									  " . TABLE_PRODUCTS_TO_CATEGORIES." p2c 
								 where p.products_status = '1'
								 and   p.products_ordered > 0
								 and   p.products_id = pd.products_id
								 and   p2c.products_id=p.products_id 
								 and   p2c.categories_id=p.master_categories_id  
								 ".$category_fitler_str."
								 and   pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
								 order by p.he_list_order desc,p.products_ordered desc, pd.products_name
								 limit " . MAX_DISPLAY_BESTSELLERS;
	  }else{
	       $frist_get_pid_query2="select distinct products_id
								  from products  
								  where  products_status = 1
								  and   products_ordered > 0
								  order by he_list_order desc,products_ordered desc 
								  limit " . MAX_DISPLAY_BESTSELLERS;
			$frist_get_pid_db2=$db->Execute($frist_get_pid_query2);
			$frist_get_pid2=array();
			if($frist_get_pid_db2->RecordCount()>0){
		   
			   while(!$frist_get_pid_db2->EOF){
				   $frist_get_pid2[]=$frist_get_pid_db2->fields['products_id'];
				   $frist_get_pid_db2->MoveNext();
			   }
			   $frist_pid_str2=implode(',',$frist_get_pid2);
			   $best_sellers_query= "select distinct p.products_id, pd.products_name, 
											          p.products_ordered,p.products_image 
									 from " . TABLE_PRODUCTS . " p, 
									      " . TABLE_PRODUCTS_DESCRIPTION . " pd
									 where p.products_id = pd.products_id
									 and   pd.language_id = " . (int)$_SESSION['languages_id'] . "
									 and   p.products_id in(".$frist_pid_str2.") 
									 order by p.products_ordered desc";
		    }
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
        $bestsellers_list[$rows]['name']  = $best_sellers->fields['products_name'];
		$bestsellers_list[$rows]['image']= $best_sellers->fields['products_image'];
		$bestsellers_list[$rows]['price']=zen_get_products_display_price($best_sellers->fields['products_id']);
        $best_sellers->MoveNext();
      }

      $title_link = false;
      require($template->get_template_dir('tpl_best_sellers.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_best_sellers.php');
      $title =  BOX_HEADING_BESTSELLERS;
      require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
    }
  }
?>