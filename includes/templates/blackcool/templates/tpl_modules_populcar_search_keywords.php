<?php
   if (!defined('IS_ADMIN_FLAG')) {
	  die('Illegal Access');
   }
   $show_hot_keywords=false;
   include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_SHOW_HOT_KEYWORDS));
?>
<?php 
    if($show_hot_keywords==true){
?>	    <div class="keyword">  
			<h6><?php echo TEXT_SITE_KEYWORDS_TITLE;?></h6>	
			<ul>
				 <?php foreach($hot_keywords as $keyword) {?>
						<li><a href="<?php echo $keyword['keyword_link'];?>"><?php echo $keyword['keyword_name'];?></a></li>
				 <?php }?>
			</ul> 
		</div>   
<?php	
	}
 ?>