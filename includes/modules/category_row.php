<?php
/**
 * index category_row.php
 *
 * Prepares the content for displaying a category's sub-category listing in grid format.  
 * Once the data is prepared, it calls the standard tpl_list_box_content template for display.
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: category_row.php 4084 2006-08-06 23:59:36Z drbyte $
 */

if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
$title = '';
$current_sub_categories=array();

if($number_of_categories == 0){
  
unset($sub_categories);								
								
  zen_get_parent_categories($sub_categories,$current_category_id);
  
  //$current_sub_categories = $sub_categories;
  
  //echo '<pre>';print_r($current_sub_categories);exit;
   if(!empty($sub_categories)){
	    $pc_id = $sub_categories[0];
	    $subcategories_array = zen_get_categories('',$pc_id);
	    
	    
	    
	    $arr = array();
	    
	    foreach($subcategories_array as $key=>$val){
	      	$arr[] = $val['id'];
	    }
	    
	    if(count($arr)){
		      $id_str = implode(",",$arr);
		      
		      $categories_query = "select c.categories_id,c.categories_image,cd.categories_name
			    from categories c
			    inner join categories_description cd on c.categories_id=cd.categories_id
			    where c.categories_id in (".$id_str.") and c.categories_status=1";
			    
		      $categories = $db->Execute($categories_query);
		      
		      
		      $number_of_categories = $categories->RecordCount();
	      
	      
	    }
  }else{

	    zen_get_subcategories($subcategories_array,$current_category_id);
	    
	    //echo '<pre>';print_r($subcategories_array);exit;
	    
	    // $pc_id = $sub_categories[0];
	   // $subcategories_array = zen_get_categories('',$pc_id);
	    
	    
	    
	    $arr = array();
	    
	    foreach($subcategories_array as $key=>$val){
	      $arr[] = $val;
	    }
	    //echo '<pre>';print_r($arr);exit;
	    if(count($arr)){
	      $id_str = implode(",",$arr);
	      
	      $categories_query = "select c.categories_id,c.categories_image,cd.categories_name
		    from categories c
		    inner join categories_description cd on c.categories_id=cd.categories_id
		    where c.categories_id in (".$id_str.") and c.categories_status=1";
		    
	      $categories = $db->Execute($categories_query);
	      
	      
	      $number_of_categories = $categories->RecordCount();
	      
	      
	    }
    
  }
  
}


/**/
if ($number_of_categories > 0) {
  
  while (!$categories->EOF) {
    //if (!$categories->fields['categories_image']) !$categories->fields['categories_image'] = 'pixel_trans.gif';
   

    
    $current_sub_categories[]=array('category_id'=>$categories->fields['categories_id'],'category_name'=>$categories->fields['categories_name'],
									'category_image'=>$categories->fields['categories_image'],
									'category_link'=>zen_href_link(FILENAME_DEFAULT,
																   zen_get_all_get_params(array('cPath','products_id')).'
																   &cPath='.$current_category_id.'_'.$categories->fields['categories_id'])
								   );
    
    
    
    
   
   
   
	
	
	
    $categories->MoveNext();
  }
}

/**/


?>
