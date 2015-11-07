<?php
/**
 * Module Template:
 * Loaded by product-type template to display additional product images.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_additional_images.php 3215 2006-03-20 06:05:55Z birdbrain $
 */

  require(DIR_WS_MODULES . zen_get_module_directory('additional_images.php'));
 ?>
 <?php
 //modified by john 2010-05-28 no flag limit
 //if ($flag_show_product_info_additional_images != 0 && $num_images > 0) 
 if ($num_images > 0) {
  ?>
     <?php
	   /*echo zen_image($template->get_template_dir('tu_03.gif',
												  DIR_WS_TEMPLATE,
												  $current_page_base,
												  'images').'/tu_03.gif','','','',' class="pd_img2"');*/
	 ?> 
	 <div id="spec-n5"> 
	 
	   <div class="control" id="spec-left">
            <!--move left-->
       </div>         
	   <div class="control" id="spec-right">
		<!--move right-->
	   </div>
	   <div id="spec-list">
	      <ul class="list-h">	   
			<?php $ext_cnt=0;?>
			<?php foreach($images_array as $img){
					   $large_image='';
					   //if($ext_cnt<5){
						   $large_image=zen_image($img,'',350,350);			   
						   preg_match('/<img.*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.JPG|\.GIF]))[\'|\"].*?[\/]?>/',$large_image,$large_image_path);
						   $large_image2=zen_image($img,'',800,800);
						   preg_match('/<img.*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.JPG|\.GIF]))[\'||"].*?[\/]?>/',$large_image2,$large_image_path2);
			 ?> 
						   <li chuimg="<?php echo $large_image_path[1];?>" popimg="<?php echo $large_image_path2[1];?>">      
								<?php echo zen_image($img,addslashes($products_name),45);?>
						   </li>			   
			<?php 
					  //}else{
						//break;
					  //}
					  //$ext_cnt++;
				  }
			 ?>
			 <li chuimg="<?php echo $main_large_image_path[1];?>" popimg="<?php echo $main_large_image_path2[1];?>">
				<?php echo zen_image(DIR_WS_IMAGES.$products_image,addslashes($products_name),45);?>
			 </li>
		 </ul>	
	   </div>
    </div>
<?php 
  }
?>