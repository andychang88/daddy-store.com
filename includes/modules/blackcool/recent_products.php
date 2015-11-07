<?php
/**
 * recent products sidebox
 * includes/modules/sideboxes/recent_products.php
 */

	// test if box should display	
	if (isset($_SESSION['recent_products1'])) {
		$productid_array = array_unique(array_reverse($_SESSION['recent_products1'])); 
		
		if (!defined('RECENT_VIEWED_PRODUCTS_MAXIMUM')||RECENT_VIEWED_PRODUCTS_MAXIMUM < 1 || RECENT_VIEWED_PRODUCTS_MAXIMUM>6) {
			//set the maximum number of recently viewed products here
			 $maximum_recent = 5;			
		} else {
			 $maximum_recent = RECENT_VIEWED_PRODUCTS_MAXIMUM;			
		}		
		$recent = array_slice($productid_array, 0, $maximum_recent);
		
		if(sizeof($recent)>0){
			$pid_filter = "  and p.products_id  IN (".implode(',',$recent).") ";
			/*foreach($recent as $value){
				$pid_filter .= "'" . $value . "', ";
			}
			$pid_filter = substr($sub_query , 0, (strlen($sub_query)-2));
			$pid_filter .= ")";*/
		  
			$recent_products_query = "select   p.products_id, 
											   p.products_image, 
											   pd.products_name
										from " . TABLE_PRODUCTS . "  p, 
											 " . TABLE_PRODUCTS_DESCRIPTION . "  pd										
										where   p.products_id = pd.products_id "
											   . $pid_filter ."
										and  p.products_status=1 
										and  pd.language_id=".$_SESSION['languages_id'];		  
			  
			$recent_products_db = $db->Execute($recent_products_query);
			if($recent_products_db->RecordCount()>0){
				  $recent_momery_products=array();
				  $recent_products=array();
				  $show_recent_products=true;
				  
				  while(!$recent_products_db->EOF){
					  $rr_tmp_id=$recent_products_db->fields['products_id'];
					  $recent_momery_products[$rr_tmp_id]=array('products_name'=>$recent_products_db->fields['products_name'],
															    'products_image'=>$recent_products_db->fields['products_image'],
															    'products_id'=>$rr_tmp_id,
															    'products_url_link'=>zen_href_link(zen_get_info_page($rr_tmp_id),'products_id='.$rr_tmp_id),
															   );
											   
					  $recent_products_db->MoveNext();
				  }
				  reset($recent);
				  foreach($recent as $rpid){
				      $recent_products[]=$recent_momery_products[$rpid];
				  }
				  unset($recent_momery_products);
			}    
		}     
  } 
?>