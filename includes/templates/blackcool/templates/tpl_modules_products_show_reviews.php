<?php
  if (!defined('IS_ADMIN_FLAG')) {
      die('Illegal Access');
  }
 
  $show_p_reviews=false;
  include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_MODULES_PRODUCTS_REVIEWS));

?>
<a name="view_reviews"></a>
<div class="reviews_title reviews_title_border">
			 <font style=" font-size:18px; text-align:left; "><strong><?php echo TEXT_REVIEWS;?></strong></font >
			<span>
				<a rel="nofollow" href="<?php echo $products_herf_link;?>#write_reviews">
				   <?php echo zen_image(DIR_WS_TEMPLATE_BUTTON.'button_write_reviews.gif');?>
				</a>
			</span>
			<div style="clear:both"></div>
</div>
<div id="previews_container">
<?php if($show_p_reviews){?>
	
	<?php
		foreach($product_reviews as $review){
	  ?>
		 <div class="reviews_msg">
			<p class="reviews_name">
				<strong>By <?php echo $review['author'];?></strong>
				<span class="reviews_right"><font class="gray_date"><?php echo $review['date'];?></font></span>
			</p>
			<table border="0" class="reviews_price">
			  <tbody>
				  <tr>
					<td><strong><?php echo TEXT_PRICE_RATING_RESULT;?></strong></td>
					<td><?php echo $review['price_rating'];?></td>
					<td><strong><?php echo TEXT_VALUE_RATING_RESULT;?></strong></td>
					<td><?php echo $review['value_rating'];?></td>
					<td><strong><?php echo TEXT_QUALITY_RATING_RESULT;?></strong></td>
					<td><?php echo $review['quality_rating'];?></td>
				  </tr>
			  </tbody>
			</table>
			<p class="reviews_content"><?php echo strip_tags($review['text']);?></p>
			<p class="reviews_evaluate">
			  <?php echo TEXT_REVIEW_HELPFUL_OR_NOT;?>
			  <input class="Ja" name="Ja" type="button" value="<?php echo TEXT_REVIEW_HELPFUL.'('.$review['yes_cnt'].')';?>" 
			         yesid="<?php echo $review['reviews_id'];?>" id="yesid<?php echo $review['reviews_id'];?>" />
			  <input class="Nein" name="Nein" type="button" value="<?php echo TEXT_REVIEW_NOT_HELPFUL.'('.$review['no_cnt'].')';?>" 
			         noid="<?php echo $review['reviews_id'];?>" id="noid<?php echo $review['reviews_id'];?>" />
			</p>
			<hr />
		</div>
	<?php
		}
	 ?>	 
	<?php if($product_reviews_splitpage_info['pr_pages']>1){?>     
		<div class="scott2">       
			  <div id="pages_r">
				  <ul id="previews_pages_nav">
				  <?php for($pr_pi=0;$pr_pi<$product_reviews_splitpage_info['pr_pages'];$pr_pi++){?>
						  <?php if($pr_pi==0){?>
								<li class="review_currpage" id="<?php echo ($pr_pi+1);?>"><?php echo ($pr_pi+1);?></li>
						  <?php }else{?>
								<li id="<?php echo ($pr_pi+1);?>"><?php echo ($pr_pi+1);?></li>
						  <?php }?>
						  
				  <?php }?>
				  </ul>
			  </div>
		 </div>
    <?php  
		if(file_exists(DIR_WS_INCLUDES.'modules/pages/product_info/ajax_reviews_page_split.js.php')){				    
			 include(DIR_WS_INCLUDES.'modules/pages/product_info/ajax_reviews_page_split.js.php');
		}
      }
	   
     ?>
<?php }?>
</div>
<?php
   //read those star pic path
   $gstar_image=zen_image(DIR_WS_TEMPLATE_IMAGES.'gray_star.jpg');
   preg_match('#<img.*src="(.*.[gif|jpeg|jpg|png])".*>#U',$gstar_image,$gstar_path);
   $gstar_image_path=$gstar_path[1];
   
   $rstar_image=zen_image(DIR_WS_TEMPLATE_IMAGES.'red_star.jpg');
   preg_match('#<img.*src="(.*.[gif|jpeg|jpg|png])".*>#U',$rstar_image,$rstar_path);
   $rstar_image_path=$rstar_path[1];
   
   $bstar_image=zen_image(DIR_WS_TEMPLATE_IMAGES.'black_star.jpg');
   preg_match('#<img.*src="(.*.[gif|jpeg|jpg|png])".*>#U',$bstar_image,$bstar_path);
   $bstar_image_path=$bstar_path[1];

   if(file_exists(DIR_WS_INCLUDES.'modules/pages/product_info/ajax_products_reviews.js.php')){				    
	  include(DIR_WS_INCLUDES.'modules/pages/product_info/ajax_products_reviews.js.php');
   } 
?>