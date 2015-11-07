<?php if(isset($categories) && is_array($categories) && sizeof($categories)>0){
      $cnt_limit_1=1;
?>
<div id="categories_2">
   <h6><?php echo TEXT_RECOMMEND_CATEGORIES;?></h6>
   <ul>
      <?php 
	    foreach($categories as $category){
		   $cnt_limit_2=1;
		   if(!$category['has_sub_cate']) continue;
		   if($cnt_limit_1>6) break;
	  ?>
	  <li>
	    <a href="<?php echo $category['category_url_link'];?>" class="ih">
		  <?php if(zen_not_null($category['category_image'])) echo zen_image(DIR_WS_IMAGES.$category['category_image'],$category['category_name'],170);?>
		</a>
		<h2><a href="<?php echo $category['category_url_link'];?>" title=""><?php echo $category['category_name'];?></a></h2>
		<p>
		  <?php foreach($category['sub_categories'] as $sub_category){
		        if($cnt_limit_2>4) break;
		   ?>
				   <a href="<?php echo $sub_category['category_url_link'];?>" title="">
					  <?php echo zen_trunc_string($sub_category['category_name'],50,true);?>
				   </a> 
				   <br />
		  <?php 
		        $cnt_limit_2++;
		        }
		   ?>
		  <a rel="nofollow"  href="<?php echo $category['category_url_link'];?>" class="f_mover"><?php echo TEXT_MORE_WHOLESALE_PRODUCTS;?></a>
		</p>
	  </li>
	  <?php 
	       $cnt_limit_1++;
	       }
	   ?>
    </ul>
</div>
<?php }?>