<div class="tags">
          <!-- dchange <h6><?php echo TEXT_POPULAR_PRODUCTS_SEARCH;?></h6> -->
          <p> 
		    <?php 
			      $tag_i=1;
			      foreach($popular_search_data as $b_keyword){
				     /*if(isset($b_keyword['id'])){
					     if($b_keyword['link_to']==FILENAME_PRODUCT_INFO){
						    $link=zen_href_link($b_keyword['link_to'],'products_id='.$b_keyword['id']);
						 }else{
						    $link=zen_href_link($b_keyword['link_to'],'cPath='.$b_keyword['id']);
						 }
					 }else{
					     $link=zen_href_link($b_keyword['link_to']);					 
					 }*/
					 if($tag_i==11) $tag_i=1;
			  ?>
					  <a rel="nofollow" href="<?php echo $b_keyword['search_link'];?>" class="tags_<?php echo $tag_i++;?>">
						 <?php echo trim($b_keyword['keyword']);?>,
					  </a>
			<?php }?>
		  </p>
</div>