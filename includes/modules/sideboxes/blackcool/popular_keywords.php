<?php
    if (!defined('IS_ADMIN_FLAG')) {
       die('Illegal Access');
    }	
	//if(isset($text_left_popular_searches) && $_GET['main_page']=='index' && !$this_is_home_page ){
	if($_GET['main_page']=='index'){	 
	   $popular_search='select keyword,categories_id 
					    from '.TABLE_CUSTOMERS_SEARCHES.' 
					    where language_id ='.(int)$_SESSION['languages_id'].' 
					    order by search_cnt desc limit 15';
	   if(!$this_is_home_page && isset($current_category_id)&& isset($category_depth)){
	       
		    if($category_depth=='nested'){
			   $sub_categories_sql='select distinct categories_id
			                        from  categories 
									where parent_id='.(int)$current_category_id .'
									and   categories_status=1';
			   $sub_categories_db=$db->Execute($sub_categories_sql);
			   while(!$sub_categories_db->EOF){
			      $sub_categories_id[]=$sub_categories_db->fields['categories_id'];
				  $sub_categories_db->MoveNext();
			   }
			   $sub_categories_id[]=$current_category_id;//include parent category id
			   $popular_search='select keyword,categories_id
								from '.TABLE_CUSTOMERS_SEARCHES.' 
								where language_id ='.(int)$_SESSION['languages_id'].' 
								and   categories_id in ('.implode(',',$sub_categories_id).')
								order by search_cnt desc limit 15';
			}else if($category_depth=='products'){
			   $popular_search='select keyword,categories_id
								from '.TABLE_CUSTOMERS_SEARCHES.' 
								where language_id ='.(int)$_SESSION['languages_id'].' 
								and   categories_id ='.$current_category_id.'
								order by search_cnt desc limit 15';
			}				
	   }
	
	   $popular_search_db=$db->Execute($popular_search);	
		 
	   if($popular_search_db->RecordCount()>0){
			 $popular_search_data=array();
			 
			 while(!$popular_search_db->EOF){
			    $tmp_s_cate_id=($popular_search_db->fields['categories_id']==0)?'':$popular_search_db->fields['categories_id'];
				$popular_search_data[]=array('keyword'=>$popular_search_db->fields['keyword'],
											 'search_link'=>zen_href_link(FILENAME_ADVANCED_SEARCH_RESULT,
																		  'keyword='.trim($popular_search_db->fields['keyword']).'&categories_id='.$tmp_s_cate_id.'&inc_subcat=1&search_in_description=0')
											 );
				 $popular_search_db->MoveNext();						 
			 }			     
			 require($template->get_template_dir('tpl_box_popular_keywords.php',
												   DIR_WS_TEMPLATE, 
												   $current_page_base,
												   'sideboxes'). '/tpl_box_popular_keywords.php');
	   }		  
	   
	}
?>