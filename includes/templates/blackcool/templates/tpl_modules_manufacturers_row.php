<?php
    /**
	 * index manufacturer_row.php
	 *
	 * Prepares the content for displaying a category's sub-category listing in grid format.  
	 * Once the data is prepared, it calls the standard tpl_list_box_content template for display.
	 *
	 * @package page
	 * @copyright Copyright 2003-2005 Zen Cart Development Team
	 * @copyright Portions Copyright 2003 osCommerce
	 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
	 * @version $Id: tpl_modules_manufacturers_row.php 2986 2010-04-09 16:33:29Z john $
	 */
	require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_MANUFACTURERS_ROW));
	
	if( isset($manufacturers_current_category) && sizeof($manufacturers_current_category)>0){
?>
    <div class="show2">
        <ul>
           <?php foreach($manufacturers_current_category as $manufacturer){?>
           
                    <li><a href="<?php echo $manufacturer['url_link'];?>"><b><?php echo $manufacturer['manufacturer_name'];?></b></a></li>
                    
           <?php }?>
        </ul>	
    </div>
<?php
	}
?>