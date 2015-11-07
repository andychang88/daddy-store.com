<?php
   if (!defined('IS_ADMIN_FLAG')) {
	     die('Illegal Access');
   }
   $bottombest_sellers_query='';
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
			   
		   
		   $bottombest_sellers_query = "select distinct p.products_id, pd.products_name, 
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
										 order by p.products_ordered desc, pd.products_name
										 limit " . MAX_DISPLAY_BESTSELLERS.",".MAX_DISPLAY_BESTSELLERS;
   }else{   
        $frist_get_pid_query="select distinct products_id
		                      from products  
							  where products_status = 1  
							  and   products_ordered > 0
							  order by products_ordered desc 
							  limit " . MAX_DISPLAY_BESTSELLERS.",".MAX_DISPLAY_BESTSELLERS;
        $frist_get_pid_db=$db->Execute($frist_get_pid_query);
		$frist_get_pid=array();
		if($frist_get_pid_db->RecordCount()>0){
		   
		   while(!$frist_get_pid_db->EOF){
		       $frist_get_pid[]=$frist_get_pid_db->fields['products_id'];
			   $frist_get_pid_db->MoveNext();
		   }
		   $frist_pid_str=implode(',',$frist_get_pid);
		   $bottombest_sellers_query = "select distinct p.products_id, pd.products_name, 
													 p.products_ordered,p.products_image 
										 from " . TABLE_PRODUCTS . " p, 
										      " . TABLE_PRODUCTS_DESCRIPTION . " pd
										 where p.products_id = pd.products_id
										 and   pd.language_id = " . (int)$_SESSION['languages_id'] . "
										 and   p.products_id in(".$frist_pid_str.")";
		}
		
		
	}
   if(!empty($bottombest_sellers_query)){
		$bottom_best_sellers = $db->Execute($bottombest_sellers_query);
	
	
		if ($bottom_best_sellers->RecordCount() >= MIN_DISPLAY_BESTSELLERS) {
		  $bottom_bestsellers_list=array();
		  $rows = 0;
		  while (!$bottom_best_sellers->EOF) {	    
			//$global_id_excluded[]= $best_sellers->fields['products_id'];		
			$rows++;
			$b_tmp_id=$bottom_best_sellers->fields['products_id'];
	
			$bottom_bestsellers_list[$rows]['name']  = $bottom_best_sellers->fields['products_name'];
			$bottom_bestsellers_list[$rows]['image']= $bottom_best_sellers->fields['products_image'];
			$bottom_bestsellers_list[$rows]['price']=zen_get_products_display_price($b_tmp_id);
			$bottom_bestsellers_list[$rows]['buy_link']=zen_href_link(FILENAME_DEFAULT,zen_get_all_get_params(array('action','products_id')).'action=buy_now&products_id='.$b_tmp_id);
			$bottom_bestsellers_list[$rows]['products_url_link']=zen_href_link(zen_get_info_page($b_tmp_id),'cPath=' . $productsInCategory[$b_tmp_id].'&products_id='.$b_tmp_id);
			
			$bottom_best_sellers->MoveNext();
		  }
		  $show_bottom_bestseller=true;
		}
	}
 ?>