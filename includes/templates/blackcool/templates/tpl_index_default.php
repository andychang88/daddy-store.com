<script type="text/javascript">
$(document).ready(function(){
	$('.categorise').show();	
});
</script>
  <style type="text/css">
	.rowsgods .rows5 .plist{width:20%}
	.rowsgods .rows4 .plist{width:25%}
	.rowsgods .rows3 .plist{width:33.33%}
	
  </style>
  <?php 
  
  ?>
		<div class="rightbody">
							<?php
								require(DIR_WS_MODULES . zen_get_module_directory('column_right.php'));
							?>
		</div>
				
		<div class="centron">
	
				<div class="addmar">
					<div class="center_2">
						<div class="banner">            
						<?php
						/**/
						   require($template->get_template_dir('tpl_modules_banner_switch_show.php',
															    DIR_WS_TEMPLATE,
																$current_page_base,
																'templates').'/tpl_modules_banner_switch_show.php');
						   /**/
						?>
						</div>
						
						<div class="clear"></div>	
						
					</div>
				</div>
				<style type="text/css">
				.centrows{clear:left;overflow:hidden;padding-top:15px;}
				.rowsleft{display:inline;float:left;margin:0 10px 0 0;width:210px;}
			      </style>
				
				<div class="centrows">
					<div class="rowsleft">
						     <div class="newsletter">
						       <p class="rednote">Newsletter</p>
						       <p>
							 <span class="emailinfo"></span>
							</p>
							<p>
							  <input id="email" class="email_input" type="text" name="email">
							 </p>
							 <p>
							     <span class="btn_zurm">
								 <input id="btnnewsletter" class="btn_zurm_in" type="button" value="Subscribe" >
							     </span>
							 </p>
						     </div>
				     
						     <div class="abbrands">
							     <h4>Top Brand</h4>
							     <?php echo zen_display_banner_by_groupd('TopBrand');?>
						     </div>
					</div>      
				      
				
				      
				
					<div class="rowsgods">
					
					<?php 
					
					//首页中间部分展示的产品分类
				
					$item_value = getRecommendConfig('index_cat_list');
					 
					foreach($item_value as $tmp) {
						
						list($tmp_cat_id, $tmp_cat_name) = explode('=', $tmp);
							
						require($template->get_template_dir('tpl_modules_show_category.php', 
																					DIR_WS_TEMPLATE, 
																					$current_page_base, 'templates').'/tpl_modules_show_category.php');
						
						
					}
					?>
					
					
					<?php
					
					//特色产品
					require($template->get_template_dir('tpl_modules_featured_index.php',
															    DIR_WS_TEMPLATE,
																$current_page_base,
																'templates').'/tpl_modules_featured_index.php');
					?>
					
						      
					</div>
				</div>
	
			</div>
			