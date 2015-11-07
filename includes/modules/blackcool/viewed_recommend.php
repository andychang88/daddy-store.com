<?php


    if (isset($_SESSION['recent_products1']) && is_array($_SESSION['recent_products1']) ) {
	    $products_r_ids=array_flip(array_flip($_SESSION['recent_products1']));
		
		//get related bought product id
		$related_id_sql='select distinct op2.products_id 
		                 from '.TABLE_ORDERS_PRODUCTS.' op1,
						      '.TABLE_ORDERS_PRODUCTS.' op2
						 where op1.orders_id=op2.orders_id
						 and   op1.products_id !=op2.products_id
						 and   op1.products_id in('.implode(',',$products_r_ids).')';
		$related_id_db=$db->Execute($related_id_sql);
		if($related_id_db->RecordCount()>0){
		   $related_ids=array();
		   while(!$related_id_db->EOF){
		        $related_ids[]=$related_id_db->fields['products_id'];
				$related_id_db->MoveNext();
		   }
		   
		  $recommend_sql='select p.products_id,pd.products_name,p.products_image
						   from '.TABLE_PRODUCTS.' p,
								'.TABLE_PRODUCTS_DESCRIPTION.' pd
						   where p.products_status=1
						   and   p.products_id=pd.products_id 
						   and   p.products_id in('.implode(',',$related_ids).') 
						   and   pd.language_id='.(int)$_SESSION['languages_id'].'
						   order by p.products_ordered desc limit 0,14';
		   $recommend_db=$db->Execute($recommend_sql);
		   if($recommend_db->RecordCount()>0){
		      $recommends=array();
			  $show_viewed_recommend=true;
			  while(!$recommend_db->EOF){
			      $r_tmp_id=$recommend_db->fields['products_id'];
				  $r_price=zen_get_products_display_price($r_tmp_id);
			      $recommends[]=array('products_name'=>$recommend_db->fields['products_name'],
				                      'products_url_link'=>zen_href_link(zen_get_info_page($r_tmp_id),'products_id='.$r_tmp_id),
									  'products_image'=>$recommend_db->fields['products_image'],
									  'products_price'=>$r_price,
									  'buy_link'=>zen_href_link(FILENAME_DEFAULT,
									                            zen_get_all_get_params(array('action','products_id')).
															    'action=buy_now&products_id='.$r_tmp_id),
									  );
									 
				  $recommend_db->MoveNext();
			  }
		   }
		}
		
		
	}
	
?>