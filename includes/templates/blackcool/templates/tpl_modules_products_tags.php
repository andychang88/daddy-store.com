<?php

    $ptag_list=array();

    for ($i=65; $i<91; $i++) {

      $ptag_list[] =chr($i);

    }

?>

<strong><?php echo TEXT_PRODUCTS_TAGS_TITLE;?></strong>       

<p>

   <?php foreach($ptag_list as $tag){?>

         <a rel="nofollow"  href="<?php echo zen_href_link(FILENAME_PRODUCTS_TAG,'tag='.$tag);?>"><?php echo $tag;?></a>

   <?php }
         for ($i=0; $i<10; $i++) {
   ?>
     		<a rel="nofollow" href="<?php echo zen_href_link(FILENAME_PRODUCTS_TAG,'tag='.$i);?>"><?php echo $i;?></a>
   <?php
   		 }
		if($domain=='www.myefox.com' or $domain=='myefox.com')
		{  
   ?> 
   <strong><a rel="nofollow" href="http://<?php echo HTTP_SERVER;?>/region/">Sort by Region</a></strong>
   <?php }else{ ?>
 <strong><a rel="nofollow" href="http://<?php echo HTTP_SERVER;?>/region/">Sort by Region</a></strong>
   <?php }?>
</p>


<p>

   <?php echo TEXT_BOTTOM_PRODUCT_TAG_DESC;?>

</p>
