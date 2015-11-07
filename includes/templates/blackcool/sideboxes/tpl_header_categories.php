<?php
   $content = "";
   
   $header_categories_query= "select  c.categories_id,
								      cd.categories_name  
							  from  ".TABLE_CATEGORIES." c, 
									".TABLE_CATEGORIES_DESCRIPTION." cd
							  where c.categories_status = 1
							  and   c.parent_id = 0						
							  and   c.categories_id = cd.categories_id
							  and   cd.language_id='".(int) $_SESSION['languages_id']."'
							  order by sort_order, cd.categories_name limit 6";
   $header_categories_db=$db->Execute($header_categories_query);
   
   $header_categories=array();
   
   if($header_categories_db->RecordCount()>0){
      while(!$header_categories_db->EOF){
	     $cPath_hc='';
		 $cPath_hc=zen_href_link(FILENAME_DEFAULT,'&cPath='.$header_categories_db->fields['categories_id']);
		 
		 /*$header_categories[]=array('category_name'=>$header_categories_db->fields['categories_name'],
									'category_url_link'=>$cPath_hc);	*/
		 $content.='<li><a href="'.$cPath_hc.'" 
						  title="'.$header_categories_db->fields['categories_name'].'">
						   '.$header_categories_db->fields['categories_name'].'
						</a>
					</li> ';
		 
		 $header_categories_db->MoveNext();
	  }
	  //echo '<pre>';print_r($header_categories);
   }
?>