<div class="tabs" >
          <ul>
            <li><a rel="nofollow"  href="<?php echo zen_href_link(FILENAME_DEFAULT);?>"><span>Home</span></a></li>
            <li><a href="<?php echo zen_href_link(FILENAME_PRODUCTS_NEW);?>"><span><?php echo HEADER_TITLE_PRODUCTS_NEW;?></span></a></li>
            <li><a href="<?php echo zen_href_link('new_recommend');?>"><span><b>Recommended</b></span></a></li>
            <li><a href="<?php echo zen_href_link(FILENAME_SPECIALS);?>"><span><?php echo HEADER_TITLE_PRODUCTS_SPECIAL;?></span></a></li>          
            <li><a href="<?php echo zen_href_link(FILENAME_WHOLESALE);?>"><span><?php echo HEADER_TITLE_PRODUCTS_WHOLESALE;?></span></a></li>
<!--            <li><a href="<?php echo HTTP_SERVER.'/region';?>" target="_blank"><span><?php echo HEADER_TITLE_REGION;?></span></a></li>-->
          </ul>
          <p>
		     <a rel="nofollow" href="<?php echo zen_href_link(FILENAME_SHOPPING_CART,'','SSL');?> " id="tci_count">
				<?php
					 echo $_SESSION['cart']->count_contents() . ' ' . TEXT_SHOPPING_CART_DESCRIPTION;
				  ?>           
		     </a>
		 </p>
</div>
<div class="clear"></div>
<div class="suche">              
	<?php require(DIR_WS_MODULES . 'sideboxes/search_header.php'); ?>             
</div>
<div class="clear"></div>