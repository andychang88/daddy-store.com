<?php
   if (!defined('IS_ADMIN_FLAG')) {
	     die('Illegal Access');
   }
   $banner_info=array();
   $banner_sql='select banners_id, banners_title, banners_image, 
                       banners_html_text, banners_open_new_windows, banners_url
                from ' . TABLE_BANNERS . '
                where status = 1
                and  banners_group="IndexFlash"  order by banners_sort_order asc,banners_id asc ';
   $banner_db=$db->Execute($banner_sql);
   if($banner_db->RecordCount()>0){
     while(!$banner_db->EOF){
	   $banner_info[]=array('banner_title'=>$banner_db->fields['banners_title'],
	                        'banner_image'=>$banner_db->fields['banners_image'],
							'banner_url'=>$banner_db->fields['banners_url']
							);
	   $banner_db->MoveNext();
	 }
   }   
?>
<?php if(sizeof($banner_info)>0){?>
      <div class="mrwm_slide" id="barScroll">
	     <div class="imgScroll">
	  		<ul class="imgScrollCon" > 
			  <?php foreach($banner_info as $bb){?>
			        <li>
					   <a href="<?php echo $bb['banner_url'];?>" target="_blank" title="<?php echo $bb['banner_title'];?>">
					     <?php echo zen_image(DIR_WS_IMAGES.$bb['banner_image']);?>
					   </a>
					</li>
			  <?php }
			        reset($banner_info);
			  ?>
			</ul>
		 </div>
		 <div class="banner_wenziscroll">
			<ul class="mrwm_slist imgScrollTag">
			   <?php 
			         $bchk=0;
			         foreach($banner_info as $bb){?>
					   <?php if($bchk==0){?>
					         <li class="select">
							 
					   <?php $bchk=1;
					         }else{?>
						     <li>
					   <?php }?>
					   <?php echo $bb['banner_title'];?></li>	
			   <?php }?>							
			</ul>
		 </div>
	  </div>
<?php }?>
<script type="text/javascript">
new UI.tagScrollForTag("barScroll");
</script>