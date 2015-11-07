<div class="rhf">
  <div class="rhf_left">
        <h6><?php echo TEXT_RECENTS_VIEWED;?></h6>
        <?php
		     $show_recent_products=false;
		     require($template->get_template_dir('tpl_modules_products_viewed_recently_bottom.php',
												 DIR_WS_TEMPLATE, 
												 $current_page_base,
												 'templates'). '/tpl_modules_products_viewed_recently_bottom.php');
		 ?>
  </div>
  <div class="rhf_right">
      <div class="infiniteCarousel_bottom infiniteCarousel2">
        <?php
		     if($show_recent_products){
			        require($template->get_template_dir('tpl_modules_products_viewed_recommend.php',
													    DIR_WS_TEMPLATE, 
													    $current_page_base,
													    'templates'). '/tpl_modules_products_viewed_recommend.php');
			 }else{
				    require($template->get_template_dir('tpl_modules_products_bestseller_bottom.php',
													    DIR_WS_TEMPLATE, 
													    $current_page_base,
													    'templates'). '/tpl_modules_products_bestseller_bottom.php');
			 }
		     
		 ?>
	  </div>
  </div>
</div>