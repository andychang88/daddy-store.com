<?php
/**
 * Page Template
 *
 * Loaded by index.php?main_page=site_map <br />
 * Displays site-map and some hard-coded navigation components
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_site_map_default.php 4340 2006-09-02 04:54:53Z drbyte $
 */
?>
<div class="sitemap">
<div class="sitemap_title"><?php echo HEADING_TITLE; ?></div>
<div class="site_map">
     
	     <?php 
		       reset($categories);
			   $chk_s=1;
			   $count_pcates=count($categories);
			   $per_column_show=ceil($count_pcates/4);
			   foreach($categories as $category){
			      if($chk_s==1){?>
				    <ul class="border_r">
		 <?php    }?>              
				   <h4>
				       <a class="red" href="<?php echo $category['category_url_link'];?>">
				          <?php echo $category['category_name'];?>
					   </a>
				   </h4>
			       <?php if($category['has_sub_cate']==true && sizeof($category['sub_categories'])>0 ){?>
				        
						   <?php foreach($category['sub_categories'] as $sub_cate_id=>$sub_category){?>								   
									<a title="<?php echo $sub_category['category_name'];?>" 
									   href="<?php echo $sub_category['category_url_link'];?>">
									 <?php echo $sub_category['category_name'];?>
									</a> 							
						   <?php }?>										
                   <?php }?>
				   <?php if($chk_s<$per_column_show){
				           $chk_s++;
						 }else if($chk_s==$per_column_show){
				           $chk_s=1;
					?>	   
					       </ul>
				   <?php   
					     }					
					?>				   
		 <?php }?>
     
</div>
</div>