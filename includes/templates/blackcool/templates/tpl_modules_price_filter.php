<?php
		if($need_price_range){
		   if(file_exists(DIR_WS_INCLUDES.'modules/pages/index/price_filter.js.php')){
		     require_once(DIR_WS_INCLUDES.'modules/pages/index/price_filter.js.php');
		   }
?>
              <?php echo zen_draw_form('price_fitler_form', HTTP_SERVER.$_SERVER['REQUEST_URI'], 'GET',' id="price_fitler_form" ');					
					echo zen_draw_hidden_field('main_page',$_GET['main_page']);
					echo zen_draw_hidden_field('cPath',$_GET['cPath']);
					echo zen_draw_hidden_field('sort',$_GET['sort']);
					echo zen_draw_hidden_field('price_filter_from',$_SESSION['pf_from'],' id="price_filter_from"');
					echo zen_draw_hidden_field('price_filter_to',$_SESSION['pf_to'],' id="price_filter_to"');
				?>
				<p class="sort_price">
				    <span>Wählen Sie nach Preis » </span>
					<?php foreach($price_range_arr as $prange){?>							
						   <?php if($prange['p_from']==$_SESSION['pf_from'] && $prange['p_to']==$_SESSION['pf_to'] ){?>
								<span class="sort_price_current">
									<?php echo $prange['p_from'].'.00'.' ~ '.$prange['p_to'].'.00';?>
								</span>
						   <?php }else{?>
								<span>
									<a href="javascript:doPriceFilter(<?php echo $prange['p_from'];?>,<?php echo $prange['p_to'];?>);">
										<?php echo $prange['p_from'].'.00'.' ~ '.$prange['p_to'].'.00';?>
									</a>
								</span>
						   <?php }?>							
					<?php }?>
					<span>
					     <a href="javascript:doPriceFilter('nofilter','nofilter');">All</a>
					</span>
				</p>
			   <?php echo '</form>';?>
			   <div class="clear"></div>    
<?php	
		}
?>