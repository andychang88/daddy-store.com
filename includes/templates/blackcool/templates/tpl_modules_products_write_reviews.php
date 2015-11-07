<div class="reviews_prompt">
	<a name="write_reviews"></a>
	<p><?php echo TEXT_REVIEWS_INFO;?></p>
	
</div>
<div style="display:none;">
 <?php echo $rstar_image;?>
 <?php echo $bstar_image;?>
</div>
<div class="bg_f8">
    <form class="p_review_form" id="product_review_form" name="product_review_form" >
	<div class="reviews_write">
	    <p id="reviews_write_title"><strong>Assign stars for this article:</strong></p>	   
		<div class="rating_star">
			<!--xing ji ping fen      star:value = fen shu-->  
			<div class="shop-rating">  
				<span class="title"><?php echo TEXT_PRICE_RATING;?></span>  
				<ul class="rating-level" id="price_rating_ul">  
					<?php for($ri=1;$ri<6;$ri++){?>
						<li id="pr<?php echo $ri;?>" star_value="<?php echo $ri;?>"><?php echo $gstar_image;?></li>  
					<?php }?>
				</ul>  
				<span class="result" id="pr_span"></span>  
				<input type="hidden" id="price_rating" name="price_rating" value="5"/>  
			</div>  
			<!-- END of xing ji ping fen --> 
			
			<!--xing ji ping fen star:value = fen shu -->  
			<div class="shop-rating">  
				<span class="title"><?php echo TEXT_VALUE_RATING;?></span>  
				<ul class="rating-level" id="value_rating_ul">  
				   <?php for($ri=1;$ri<6;$ri++){?>
						<li id="vr<?php echo $ri;?>" star_value="<?php echo $ri;?>"><?php echo $gstar_image;?></li>  
				   <?php }?>
				</ul>  
				<span class="result" id="vr_span"></span>  
				<input type="hidden" id="value_rating" name="value_rating" value="5"/>  
			</div>  
			<!-- END of xing ji ping fen --> 
			
			<!--xing ji ping fen    star:value = fen shu-->  
			<div class="shop-rating">  
				<span class="title"><?php echo TEXT_QUALITY_RATING;?></span>  
				<ul class="rating-level" id="quality_rating_ul">  
					<?php for($ri=1;$ri<6;$ri++){?>
						<li id="qr<?php echo $ri;?>" star_value="<?php echo $ri;?>"><?php echo $gstar_image;?></li>  
					<?php }?>  
				</ul>
				<span class="result" id="qr_span"></span>  
				<input type="hidden" id="quality_rating" name="quality_rating" value="5"/>  
			</div>  
			<!-- END of xing ji ping fen --> 
		</div>			
	   		
	</div>
	<div class="ratingdiv2">
		<p><strong><?php echo TEXT_REIVEWS_CONTENT;?></strong></p>
		<textarea  cols="40" rows="10" name="review_text" id="review_text"></textarea>				
		<div id="reivew_error_tip" style="display:none"></div>
		<div id="reivew_success_tip" style="display:none"></div>
		<div id="div_show_processing">
			<?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.'loading.gif');?>
		</div>		
	</div>
	<div class="clear"></div>
	<div id="div_review_btn">
		<?php echo zen_image(DIR_WS_TEMPLATE_BUTTON.'button_review.gif','',89,20,'id="do_product_review"');?>
	</div>
	</form>
</div>	
<div class="clear"></div>			