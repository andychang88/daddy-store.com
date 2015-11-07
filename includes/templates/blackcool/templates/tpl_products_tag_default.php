<?php
    $p_ptag_list=array();
    for ($i=65; $i<91; $i++) {
      $p_ptag_list[] =chr($i);
    }
	$curr_tag=trim($_GET['tag']);
?>
<div class="productags_list">
	 <?php foreach($p_ptag_list as $tag){
	          if($curr_tag==$tag){?>
			     <span><?php echo $tag;?></span>&nbsp;|
		<?php }else{?>
                <a href="<?php echo zen_href_link(FILENAME_PRODUCTS_TAG,'tag='.$tag);?>"><?php echo $tag;?></a>&nbsp;|
		<?php }?>
   <?php }?> 
</div>
<?php 
	 if(sizeof($products_tags)>0){
?>
	   <div class="a_z_con">
	      <ul class="a_z_grid_left">
		     <?php foreach($products_tags as $pt){?>
			       <li>
				       <a href="<?php echo $pt['product_link'];?>" title="<?php echo $pt['product_name'];?>">
				       <?php echo zen_trunc_string($pt['product_name'],50);?>
					   </a>
				   </li>
			 <?php }?>
		  </ul>
	   </div>
<?php
 	  }else{
?>
       <div class="a_z_con">No products start from <?php echo $_GET['tag'];?></div>
<?php }?>
<div class="productags_list">
     <?php reset($p_ptag_list);?>
	 <?php foreach($p_ptag_list as $tag){
	          if($curr_tag==$tag){?>
			     <span><?php echo $tag;?></span>&nbsp;|
		<?php }else{?>
                <a href="<?php echo zen_href_link(FILENAME_PRODUCTS_TAG,'tag='.$tag);?>"><?php echo $tag;?></a>&nbsp;|
		<?php }?>
   <?php }?> 
</div>