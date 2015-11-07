<?php
      if (!defined('IS_ADMIN_FLAG')) {
	     die('Illegal Access');
      }
	  $show_viewed_recommend = false;
	  include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_VIEWED_RECOMMEND));
	  if($show_viewed_recommend){
 ?>
      <h6><strong><?php echo TEXT_CONTINUE_SHOPPING;?></strong><?php echo TEXT_RECOMMEND_TITLE;?></h6>
	  <div class="wrapper">
		  <ul>
		      <?php foreach($recommends as $recommend){?>
					<li>
					  <a href="<?php echo $recommend['products_url_link'];?>" title="<?php echo $recommend['products_name'];?>">	   
						<?php echo zen_image(DIR_WS_IMAGES.$recommend['products_image'],
											 addslashes($recommend['products_name']),
											 115,
											 115);
						 ?>  
					  </a>
					  <p class="p_t">
					     <a href="<?php echo $recommend['products_url_link'];?>" title="<?php echo $recommend['products_name'];?>">						 
						   <?php echo zen_trunc_string($recommend['products_name'],100,true);?>
						 </a>
					  </p>
					  <p class="p_r red "><?php echo $recommend['products_price'];?></p>
					  <p>
					     <a rel="nofollow" href="<?php echo $recommend['buy_link'];?>">
					     <?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.'sofort.gif');?>
						 </a>
					  </p>
					  <!--<p class="p_r"><a href="" class="a_color1">Based on 2 reviews</a></p>
					  <p class="a_color2"><?php //echo TEXT_FREE_SHIPPING;?></p>-->
					</li>
			  <?php }?>
		  </ul>
	  </div>
<?php }else{
            require($template->get_template_dir('tpl_modules_products_bestseller_bottom.php',
												DIR_WS_TEMPLATE, 
												$current_page_base,
												'templates'). '/tpl_modules_products_bestseller_bottom.php');
      }
?>