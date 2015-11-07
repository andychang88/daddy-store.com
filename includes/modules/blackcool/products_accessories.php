<?php
  if(isset($_GET['products_id']) && is_numeric($_GET['products_id']) && isset($products_acc_model) && zen_not_null($products_acc_model) ){
               $p_acce_models=explode(',',zen_clean_html($products_acc_model));
			   $p_acce_models_str='';
			   foreach($p_acce_models as $model){
			        $p_acce_models_str.='"'.$model.'",';
			   }
			   $p_acce_models_str=substr($p_acce_models_str,0,strlen($p_acce_models_str)-1);
			   $p_accessories_query="select distinct p.products_id, 
													 pd.products_name,
											         p.products_image 
									 from " . TABLE_PRODUCTS . " p, 
									      " . TABLE_PRODUCTS_DESCRIPTION . " pd, 
										  " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, 
										  " . TABLE_CATEGORIES . " c
									 where p.products_status = '1'
									 and   p.products_id = pd.products_id
									 and   pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
									 and   p.products_id = p2c.products_id
									 and   p.products_id!=".(int)$_GET['products_id']." 
									 and   p2c.categories_id = c.categories_id	
									 and   c.categories_status='1'
									 and   p.products_model in(".$p_acce_models_str.")							
									 order by p.products_ordered,pd.products_name";
		
			    $p_accessories = $db->Execute($p_accessories_query);		 
        	
				if ($p_accessories->RecordCount() >= 0) {
				
					  $rows = 0;
					  $show_product_accessories=true;
					  $products_accessories=array();
					  
					  while (!$p_accessories->EOF) {
							$rows++;
							$products_accessories[$rows]['id'] = $p_accessories->fields['products_id'];
							$products_accessories[$rows]['image']= $p_accessories->fields['products_image'];					
							$products_accessories[$rows]['name']= $p_accessories->fields['products_name'];	
							
							$p_accessories->MoveNext();
					  }
				  
				}
		}
?>