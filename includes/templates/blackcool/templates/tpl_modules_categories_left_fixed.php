<?php
     $show_categories_fixed=false;
	 require(DIR_WS_MODULES.zen_get_module_directory('categories_left_fixed.php'));
	 if($show_categories_fixed){
 ?>
     <div id="menu_btn" style="z-index: 200; float: left; position: relative;">
			<div class="absolute" id="litbCon1">	
			   <ul id="menu_index_top2">
				   <li id="litbBtn">	
				     <a href="<?php echo zen_href_link(FILENAME_SITE_MAP);?>" target="_top">				 
					  <?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.'category_2.gif','',177,31,' class="align_top"');?> 
					 </a> 
				   </li>
			   </ul>
			</div>	
		    <div class="absolute" id="litbCon2" style="display: none">
			     <div id="left_menu2">            
					<ul id="menu_index_top2">
					  <li>
					   <a href="<?php echo zen_href_link(FILENAME_SITE_MAP);?>" target="_top">
					   <?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.'category_2.gif','',177,31,' class="align_top"');?>
					   </a>
					  </li>
					</ul>					  
					<div class="menu" id="light_menu">
					  <ul>
					     <?php foreach($categories as $category){
						        
						 ?>
						         <li>
								    <a title="<?php echo $category['category_name'];?>" href="<?php echo $category['category_url_link'];?>">
									    <?php echo $category['category_name'];?>
									  <!--[if ie 7]><!-->
									</a>
								    <!--<![endif]--><!--[if lte ie 6]><table><tr><td><![endif]--> 
									<?php if($category['has_sub_cate']==true && sizeof($category['sub_categories'])>0 ){
									      $b_top_chk=true;
									 ?>
								     <ul>
									    <?php foreach($category['sub_categories'] as $sub_cate_id=>$sub_category){?>
										       <?php if($b_top_chk){
											        $b_top_chk=false;
												?>
											        <li class="b_top">
											   <?php }else{?>
											        <li>
											   <?php }?>
											    <a title="<?php echo $sub_category['category_name'];?>" 
												   href="<?php echo $sub_category['category_url_link'];?>">
												   <?php echo $sub_category['category_name'];?>
												   <?php /*if($sub_category['has_sub_cate']==true && sizeof($sub_category['sub_categories'])>0){?>
												          <!--[if ie 7]><!--></a><!--<![endif]-->
														  <!--[if lte ie 6]><table><tr><td><![endif]-->
														  <dl>
														  <?php $b2_top_chk=true;
														         foreach($sub_category['sub_categories'] as $t3_sub_category){
														   ?>
																   <?php if($b2_top_chk){
																			$b2_top_chk=false;
																   ?>
																		 <dd class="b_top">
																   <?php }else{?>
																		 <dd>
																   <?php }?>  
																			<a title="<?php echo $t3_sub_category['category_name'];?>" 
																			   href="<?php echo $t3_sub_category['category_url_link'];?>">
																			   <?php echo $t3_sub_category['category_name'];?> 
																			</a> 
															             </dd>													   
														   <?php }?>
														  </dl>
														  <!--[if lte ie 6]></td></tr></table></a><![endif]-->
												   <?php }else{?>
											        	  </a> 
												   <?php }*/?>
												   </a>
											   </li>
										<?php }?>										
                                     </ul> 
									<?php }?>
									<!--[if lte ie 6]></td></tr></table></a><![endif]--> 
								 </li>
						 <?php }?>
					  </ul>
					</div>
				 </div>
			</div>
	 </div>
	 <div class="cate_title">
	 <?php
	    echo $breadcrumb->last();
	 ?> 
	 </div>
<?php 	 
	 }
?>