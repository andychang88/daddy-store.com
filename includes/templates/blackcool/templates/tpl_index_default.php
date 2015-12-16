<script type="text/javascript">
$(document).ready(function(){
	$('.categorise').show();	
});
</script>
  <style type="text/css">
	.rowsgods .rows5 .plist{width:20%}
	.rowsgods .rows4 .plist{width:22%}
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
				.centrows{clear:left;overflow:hidden;padding-top:45px;}
				.rowsleft{display:inline;float:left;margin:0 10px 0 0;width:210px;}
			      </style>
				
				<div class="centrows">
			
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
			