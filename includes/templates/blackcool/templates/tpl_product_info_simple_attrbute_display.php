<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=product_info.<br />
 * Displays details of a typical product
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_product_info_display.php 5369 2006-12-23 10:55:52Z drbyte $
 */
 //require(DIR_WS_MODULES . '/debug_blocks/product_info_prices.php');
?>
<div class="right1_top">
			<h1><?php echo $products_name; ?><br><span>Product Code: <?php echo $products_model; ?></span></h1>
			<!--bof Main Product Image -->
			<?php
			  if (zen_not_null($products_image)) {	  
			 
			   require($template->get_template_dir('/tpl_modules_main_product_image.php',
												   DIR_WS_TEMPLATE, 
												   $current_page_base,
												   'templates'). '/tpl_modules_main_product_image.php');
		   
			  }
			?>
			<!--eof Main Product Image-->		
			<div class="r_text">
				 <p><b>Compatible Part Numbers:</b><br>
				   <?php echo $products_part_no;?>
				 </p>				 
				 <!--bof Form start-->
				 <?php echo zen_draw_form('cart_quantity', zen_href_link(zen_get_info_page($products_id), 
																		zen_get_all_get_params(array('action')) . 'action=add_product'),
										  'post', 
										  'enctype="multipart/form-data"'); 
				 ?>
				 <!--eof Form start-->
				 <?php if(isset($attributes)){?>
					 <ul>
					 <?php foreach($attributes as $attribute_name =>$attribute){?>
						   				   
						   <?php 
						       switch($attribute['option_type']){
							      case 0://input type='select'
										 echo '<li><span>'.$attribute_name.': </span>';
										 echo zen_draw_pull_down_menu($attribute_name,$attribute['option_values']);
								  break;
								  case 1://input type='text'
								     //foreach($attribute['option_values'] as $value){
									      echo '<li><span>'.$attribute_name.': </span>';
										  echo zen_draw_input_field($attribute_name,$attribute['option_values'][0]);
									 //}								     
								  break;
								  case 2://input type='radio'
								     echo '<li><span>'.$attribute_name.': </span>';
									 $radio_cnt=sizeof($attribute['option_values']);
									 if($radio_cnt==1){
									     echo $attribute['option_values'][0];
									 }elseif($radio_cnt>1){
										 foreach($attribute['option_values'] as $value){									      
											  echo zen_draw_radio_field($attribute_name,$value);
											  echo $value.'<br>';
										 }
									 }								     
								  break;
								  case 3://input type='checkbox'
								     echo '<li><span>'.$attribute_name.': </span>';
								     foreach($attribute['option_values'] as $value){									      
										  echo zen_draw_checkbox_field($attribute_name,$value);
										  echo $value.'<br>';
									 }
								    // echo zen_draw_checkbox_field($attribute_name,$attribute['option_values']);
								  break;
								  case 4://input type='file'
								     foreach($attribute['option_values'] as $value){
									      echo '<li><span>'.$attribute_name.': </span>';
										  echo zen_draw_file_field($attribute_name,$attribute['option_values']);
									 }
								     //echo zen_draw_file_field($attribute_name,$attribute['option_values']);
								  break;								  
								  case 5://common text
								     echo '<li><span>'.$attribute_name.': </span>';
								     echo $attribute['option_values'][0];
								  break;
							   }
							?>						   
						   </li>
					 <?php }?>
						   <li><span>Weight: </span><?php echo $products_weight;?>g</li>
						   <li><span>Inventory: </span>
						       <strong><?php echo ($products_quantity>0)? 'In Stock':'Out of Stock';?></strong></li>
					</ul>
				<?php }?>	 
				 <div class="ul2">
					 <ul class="ul2">
						 <li>List Price:<span>US $ 26.51</span></li>
						 <li>Our Price:<b><?php echo $products_price;?></b></li>
						 
						 <li>Quantity:<?php echo $products_add_qty;?></li>
						 <li>
							 <?php echo zen_image_submit('add_06_03.gif','Add to Cart');?>
						 </li>
						 </form>
					 </ul>
				 </div>				 
				 <p class="note"><span>Note:</span> Brand new,100% compatible with original camera battery.30 day money back guarantee,1 Year Warranty.</p>
			</div>         
</div>
<div class="clear"></div>	 
<div id="focusPic1" style="display: block"  class="num_1">
	<div class="bt">
	  <ul>
		<li class="d"><a><span><?php echo TEXT_PARAMETERS;?></span></a></li>
		<li><a href="javascript:setFocus1(2);" title="Artikel Bild" target="_self"><span>Artikel Bild</span></a></li>
		<li><a href="javascript:setFocus1(3);" title="Artikel Bild" target="_self"><span><?php echo TEXT_REVIEWS;?></span></a></li>
		<li><a href="javascript:setFocus1(4);" title="Artikel Bild" target="_self"><span>OverView</span></a></li>
	  </ul>
	</div>
	
	<div class="num_2">              
	   <?php echo stripslashes($products_description);?> 
	</div>
</div>
<div id="focusPic2" style="display: none"  class="num_1">
	 <div class="bt">
		  <ul>
			<li><a href="javascript:setFocus1(1);" title="Artikel Bild" target="_self"><span>Parameter</span></a></li>
			<li class="d"><a><span>Artikel Bild</span></a></li>
			<li><a href="javascript:setFocus1(3);" title="Artikel Bild" target="_self"><span>Artikel Reviews</span></a></li>
			<li><a href="javascript:setFocus1(4);" title="Artikel Bild" target="_self"><span>OverView</span></a></li>
		  </ul>
	 </div>
	 <div class="num_2"> 
	    <?php echo stripslashes($products_short_description);?>                 
		 <div class="other_pic"> 
		 <ul>
			 <li>
			 <img src="images/TOPAVO4.jpg" width="720" height="423" alt="Das Handy mit 8GB" /> <br />
			 <p>Das Handy mit 8GB TF Karte ist auch der MP3-und Videoplayer und sorgt für beste Multi-Unterhaltung</p> </li>
			 <li>
			 <img src="images/M208V4.jpg" width="600" height="451" alt="Das Handy mit 8GB" /> <br />
			 <p>Das Handy mit 8GB TF Karte ist auch der MP3-und Videoplayer und sorgt für beste Multi-Unterhaltung</p>
			 </li>
			 <li>
			 <img src="images/TVOUT.jpg" width="600" height="361" alt="Das Handy mit 8GB" /> <br />
			 <p>Das Handy mit 8GB TF Karte ist auch der MP3-und Videoplayer und sorgt für beste Multi-Unterhaltung</p>
			 </li>
			 <li>
			 <img src="images/efox_top.jpg" width="720" height="288" alt="Das Handy mit 8GB" /> <br />
			 <p>Das Handy mit 8GB TF Karte ist auch der MP3-und Videoplayer und sorgt für beste Multi-Unterhaltung</p>
			 </li>
			 <li>
			 <img src="images/M208V4.jpg" width="600" height="451" alt="Das Handy mit 8GB" /> <br />
			 <p>Das Handy mit 8GB TF Karte ist auch der MP3-und Videoplayer und sorgt für beste Multi-Unterhaltung</p>
			 </li>
			 <li>
			 <img src="images/TVOUT.jpg" width="600" height="361" alt="Das Handy mit 8GB" /> <br />
			 <p>Das Handy mit 8GB TF Karte ist auch der MP3-und Videoplayer und sorgt für beste Multi-Unterhaltung</p>
			 </li>
		 </ul> 
		 </div> 
	 </div>
</div>    
<div id="focusPic3" style="display: none"  class="num_1">
	 <div class="bt">
		  <ul>
			<li><a href="javascript:setFocus1(1);" title="Artikel Bild" target="_self"><span>Parameter</span></a></li>
			<li><a href="javascript:setFocus1(2);" title="Artikel Bild" target="_self"><span>Artikel Bild</span></a></li>
			<li class="d"><a><span>Artikel Reviews</span></a></li>
			<li><a href="javascript:setFocus1(4);" title="Artikel Bild" target="_self"><span>OverView</span></a></li>
		  </ul>
	 </div>
	 <div class="num_2">                  
		  <div id="reviews_2">        
				<div id="reviews_inner">
					<ul>
					<?php
						foreach($products_reviews as $review){
					?>	
						<li> 
							<b><?php echo $review['rating'];?>&nbsp;</b><?php echo $review['date'];?><br /> 
							<strong>By <?php echo $review['author'];?></strong><br />
							<p><?php echo $review['text'];?></p></li>
						<li> 
				   <?php	
						}
					?>				
					</ul>
				</div>				
				<h6><?php echo TEXT_REVIEW_HEADER;?></h6>
				<p class="reviews_2_p"><?php echo TEXT_REVIEWS_INFO;?></p>
				<dl>	
				  <form class="p_review_form" id="product_review_form" name="product_review_form" >
				    <fieldset>
					<dt id="reviews_li2"><strong><?php echo TEXT_REIVEWS_RATE;?>&nbsp;&nbsp;</strong>						   
						<input type="hidden"  value="<?php echo $customer_id; ?>" name="re_customer_id" />
						<input type="hidden"  value="<?php echo $customer_name; ?>" name="re_customer_name" />
						<input type="hidden"  value="<?php echo $language_id; ?>" name="re_language_id" />
						<input type="hidden"  value="<?php echo $products_id; ?>" name="re_products_id"/>
						<?php for($star=1;$star<=5;$star++){?>	
                            <input name="review_rate" type="radio" 
							       value="<?php echo $star;?>"<?php if($star==5){ echo ' checked="checked"';}?>/>    
						<?php	
							echo zen_image($template->get_template_dir('stars_'.$star.'.gif',
																	   DIR_WS_TEMPLATE,
																	   $current_page_base,
																	   'images').'/stars_'.$star.'.gif',
										   constant('TEXT_STAR_ALT'.$star),64,12);
                              }
                         ?>
						<div id="reivew_error_tip" style="display:none"></div>
				    </dt>
					<dt><b><?php echo TEXT_REIVEWS_CONTENT;?></b><br />
						  <textarea  cols="40" rows="10" name="review_text" id="review_text"></textarea>
					</dt>
					<dt><input id="do_product_review" type="button" value="Review" /></dt>
				 </fieldset>
                 </form>
				</dl>
		  </div>                  
	 </div>
</div> 
<div id="focusPic4" style="display: none"  class="num_1">
	 <div class="bt">
		  <ul>
			<li><a href="javascript:setFocus1(1);" title="Artikel Bild" target="_self"><span>Parameter</span></a></li>
			<li><a href="javascript:setFocus1(2);" title="Artikel Bild" target="_self"><span>Artikel Bild</span></a></li>
			<li ><a href="javascript:setFocus1(3);" title="Artikel Bild" target="_self"><span>Artikel Reviews</span></a></li>
			<li class="d"><a><span>OverView</span></a></li>
		  </ul>
	 </div>                
	 <div id="ocfb_text">
		  <h6>Cheap Dell Replacement Bettery For Dell Insriron 6400</h6>
		  <p>Here you will find some of the lowest USA prices on Sony NP-FC11 Digital Camera 
	Batteries & NP-FC11 digital camera battery charger,reviews, features, specifications
	and related accessories. We provide Sony NP-FC11 digital <a href="#">camera battery</a> for popular 
	digital camera model,such as sony DSC-P10, DSC-P8, DSC-P7,DSC-P12,DSC-P9,DSC-V1</p>
	 <p>Here you will find some of the lowest USA prices on Sony NP-FC11 Digital Camera 
	Batteries & NP-FC11 digital camera battery charger,reviews, features, specifications
	and related accessories. We provide <a href="#">Sony NP-FC11 digital camera battery</a> for popular 
	digital camera model,such as sony DSC-P10, DSC-P8, DSC-P7,DSC-P12,DSC-P9,DSC-V1</p>
	 <p>Here you will find some of the lowest USA prices on Sony NP-FC11 Digital Camera 
	Batteries & NP-FC11 digital camera battery charger,reviews, features, specifications
	and related accessories. We provide Sony NP-FC11 digital camera battery for popular 
	digital camera model,such as sony DSC-P10, DSC-P8, DSC-P7,DSC-P12,DSC-P9,DSC-V1</p>
	 </div>
</div>
<!--bof also purchased products module-->
 <?php require($template->get_template_dir('tpl_modules_also_purchased_products.php', 
										   DIR_WS_TEMPLATE, 
										   $current_page_base,
										   'templates'). '/' . 'tpl_modules_also_purchased_products.php');?>
 <!--eof also purchased products module-->