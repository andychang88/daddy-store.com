<?php
/**
 * index category_row.php
 *
 * Prepares the content for displaying a category's sub-category listing in grid format.  
 * Once the data is prepared, it calls the standard tpl_list_box_content template for display.
 *
 * @package page
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_category_row.php 2986 2006-02-07 22:27:29Z drbyte $
 */

require(DIR_WS_MODULES . zen_get_module_directory('category_row.php'));
?>
<?php
   if(sizeof($current_sub_categories)>0){ 
?>
<dl>
 
<?php
           foreach($current_sub_categories as $category){  
?>
			   <dt>

               
			      <a href="<?php echo $category['category_link'];?>" title="<?php echo $category['category_name'];?>">
				 <?php echo $category['category_name'];?>
			      </a>  
			             
			   </dt>
<?php
           }
?>
        
   </dl>
<?php
   }  
?>