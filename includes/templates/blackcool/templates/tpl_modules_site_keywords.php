<strong><?php echo TEXT_PRODUCTS_KEYWORDS;?></strong> 				
<p>
  <?php foreach($text_bottom_category_keywords as $keyword){
   if(strip_tags($keyword['title'])=='Speicals')
   {?>
   <a href="/specials" 
		      title="<?php echo strip_tags($keyword['title']);?>">
			  <?php echo $keyword['title'];?>
		   </a>•		   
   <?php 
   }else{
  
  ?>
           <a href="<?php echo zen_href_link(FILENAME_DEFAULT,'cPath='.$keyword['id']);?>" 
		      title="<?php echo strip_tags($keyword['title']);?>">
			  <?php echo $keyword['title'];?>
		   </a>•		   
  <?php }
  }
  ?> 
 <a href="<?php echo HTTP_SERVER.DIR_WS_CATALOG ?>10-0-inch-android-2-1-tablet-pc-
touchscreen-mid-tablet-pc-apad-notebook-p-81637
" title="Epad"><strong>Epad</strong></a>

 <a href=
"<?php echo HTTP_SERVER.DIR_WS_CATALOG ?>tmd-mid-android-2-2-tablet-pc-8-1-2-ghz-4gb-cem816-mid-s5pv210-samsung-a-816-kls005-arm-cortex-a8-cem816-p-134458" title="7 inch android tablet pc">7 inch android</a>
 <a href=
"<?php echo HTTP_SERVER.DIR_WS_CATALOG ?>zenithink-zt-180-tablet-pc-version-new-updated-model-android-2-2-os-3g-wifi-10-2-inch-1-3-mega-pixel-camera-haipad-1ghz-data-port-hdmi-512mb-memory-4gb-hard-drive-on-sale-cem180-p-134450" title="ZT-180 android 2.2 "><strong>ZT-180 Android 2.2 </strong></a>
 <a href=
"<?php echo HTTP_SERVER.DIR_WS_CATALOG ?>hot-jpad-flytouch2-10-2-inch-tablet-pc-cemx220-infotm-x220-android2-2-gps-and-camera-hdmi-512m-1ghz-4gb-systerm-can-be-upgraded-p-152317" title="ZT-180 android 2.2 "><strong>Flytouch 3 </strong></a>
</p>
