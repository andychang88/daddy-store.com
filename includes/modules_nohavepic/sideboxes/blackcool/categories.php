<?php
/**
 * categories sidebox - prepares content for the main categories sidebox
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: categories.php 2718 2005-12-28 06:42:39Z drbyte $
 */
 //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^modified by john 2010-03-19^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

	$categories_query = "select  c.categories_id,
								 cd.categories_name,
								 c.categories_image  
						  from  ".TABLE_CATEGORIES." c, 
								".TABLE_CATEGORIES_DESCRIPTION." cd
						  where c.categories_status = 1
						  and   c.parent_id = 0						
						  and   c.categories_id = cd.categories_id
						  and   cd.language_id='".(int) $_SESSION['languages_id']."'
						  order by sort_order, cd.categories_name";
	$categories_db = $db->Execute($categories_query);
	
	$categories=array();				
	while (!$categories_db->EOF) {
			
			$cPath_new='';
			$cPath_new=zen_href_link(FILENAME_DEFAULT,'&cPath='.$categories_db->fields['categories_id']);			
			$cPath_p=$categories_db->fields['categories_id'];
			$sub_categories_query=" select   c.categories_id,
											 cd.categories_name,
											 c.categories_image 
									from  ".TABLE_CATEGORIES." c, 
										  ".TABLE_CATEGORIES_DESCRIPTION." cd
									where c.categories_status = 1
									and   c.parent_id = '".(int)$categories_db->fields['categories_id']."'						
									and   c.categories_id = cd.categories_id
									and   cd.language_id='".(int) $_SESSION['languages_id']."'
									order by sort_order, cd.categories_name";
			
			$sub_categories_db=$db->Execute($sub_categories_query);
			$sub_categories=array();
			
			$has_sub_cate=false;
			
			if($sub_categories_db->RecordCount()>0){
			   while(!$sub_categories_db->EOF){
			         $sub_cpath='';
					 $s2_cate_id=$sub_categories_db->fields['categories_id'];	
					 				 
					 $cPath_2p=$cPath_p.'_'.$s2_cate_id;
					 $sub_cpath=zen_href_link(FILENAME_DEFAULT,'&cPath='.$cPath_2p);	
					 
					 
					 //############Begin:add the 3rd categories##########################
					 //added by john 2010-08-21
					  /*$t3_sub_categories_query="select   c.categories_id,
														 cd.categories_name 
												from  ".TABLE_CATEGORIES." c, 
													  ".TABLE_CATEGORIES_DESCRIPTION." cd
												where c.categories_status = 1
												and   c.parent_id = '".(int)$s2_cate_id."'						
												and   c.categories_id = cd.categories_id
												and   cd.language_id='".(int) $_SESSION['languages_id']."'
												order by sort_order, cd.categories_name";		
					   $t3_sub_categories_db=$db->Execute($t3_sub_categories_query);
					   $t3_sub_categories=array();
					   $has_t3_sub_cate=false;
					   if($t3_sub_categories_db->RecordCount()>0){
					      while(!$t3_sub_categories_db->EOF){
						       $t3_sub_path='';
							   $t3_cate_id=$t3_sub_categories_db->fields['categories_id'];
							   $t3_sub_path=zen_href_link(FILENAME_DEFAULT,'&cPath='.$cPath_2p.'_'.$t3_cate_id);
							   
							   $t3_sub_categories[$t3_cate_id]=array('category_name'=>$t3_sub_categories_db->fields['categories_name'],
																	 'category_url_link'=>$t3_sub_path);
						       
							   $t3_sub_categories_db->MoveNext();
						  }
						  $has_t3_sub_cate=true;
					   }		
					   
					 $sub_categories[$s2_cate_id]=array('category_name'=>$sub_categories_db->fields['categories_name'],
					                                    'category_image'=>$sub_categories_db->fields['categories_image'],
														'category_url_link'=>$sub_cpath,
														'has_sub_cate'=>$has_t3_sub_cate,
														'sub_categories'=>$t3_sub_categories
														);	*/	
					 $sub_categories[$s2_cate_id]=array('category_name'=>$sub_categories_db->fields['categories_name'],
					                                    'category_image'=>$sub_categories_db->fields['categories_image'],
														'category_url_link'=>$sub_cpath
														);													
					 //############End:add the 3rd categories############################
					 $sub_categories_db->MoveNext();
			   }	
			   $has_sub_cate=true;
			}			
			
			$categories[$categories_db->fields['categories_id']]=array('category_name'=>$categories_db->fields['categories_name'],
			                                                           'category_image'=>$categories_db->fields['categories_image'],
																	   'category_url_link'=>$cPath_new,
																	   'has_sub_cate'=>$has_sub_cate,
																	   'sub_categories'=>$sub_categories);	
			$categories_db->MoveNext();
		                                                                                   
	}	
   
	require($template->get_template_dir('tpl_categories.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_categories.php');

	$title = '';
	//$title_link = false;

	require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
?>