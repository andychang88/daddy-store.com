<?php
/**
 * Page Template
 *
 * Displays page-not-found message and site-map (if configured)
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_page_not_found_default.php 3230 2006-03-20 23:21:29Z drbyte $
 */
?>
<div class="centerColumn" id="pageNotFound">
<h1 id="pageNotFoundHeading"><?php echo HEADING_TITLE; ?></h1>

<?php //if (DEFINE_PAGE_NOT_FOUND_STATUS == '1') { ?>
<div id="pageNotFoundMainContent" class="content">
<?php
/**
 * require the html_define for the page_not_found page
 */
  require($define_page); ?>
</div>
<?php //} ?>

<div class="erro_tag"><?php //echo $zen_SiteMapTree->buildTree(); ?>	
	  <?php 
		       reset($categories);
			   $chk_s=1;
			   $count_pcates=count($categories);
			   $per_column_show=ceil($count_pcates/4);
			   foreach($categories as $category){
			      if($chk_s==1){?>
				    <ul class="erro_tag_border_r">
	   <?php      }
	   ?>              
				  <h4><?php echo $category['category_name'];?></h4>
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
		 </ul>
  <div class="clear"></div>
</div>
<div class="buttonRow back"><?php echo zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?></div>
</div>