<div class="footer">	
	<div class="keywords">
		<?php //#####################show website keywords##################################
			 /*require($template->get_template_dir('tpl_modules_populcar_search_keywords.php',
												 DIR_WS_TEMPLATE,
												 $current_page_base,
												 'templates').'/tpl_modules_populcar_search_keywords.php');*/ 
		      //###############################################################################
		  ?>   
	</div>

     <?php //#####################show website keywords##################################
				 require($template->get_template_dir('tpl_HSul.html',
													 DIR_WS_TEMPLATE,
													 $current_page_base,
													 'templates').'/tpl_HSul.html'); 
				  //###############################################################################
			  ?>

	<div class="clear"></div>
	<?php if(zen_page_path_check($current_page_base,$bottom_tags_keyword_chk)){?>
	<div class="bottom_inner">
	   <ul>
	      <li class="p_tags">
		      <?php //#####################show website keywords##################################
				 require($template->get_template_dir('tpl_modules_products_tags.php',
													 DIR_WS_TEMPLATE,
													 $current_page_base,
													 'templates').'/tpl_modules_products_tags.php'); 
				  //###############################################################################
			  ?>
		  </li>
		  <li class="inner_s">
		      <?php //#####################show website keywords##################################
				 require($template->get_template_dir('tpl_modules_site_keywords.php',
													 DIR_WS_TEMPLATE,
													 $current_page_base,
													 'templates').'/tpl_modules_site_keywords.php'); 
				  //###############################################################################
			  ?>
		  </li>
		  <li class="inner_s2">
		      <?php //#####################show website keywords##################################
				 require($template->get_template_dir('tpl_modules_hot_products_keywords.php',
													 DIR_WS_TEMPLATE,
													 $current_page_base,
													 'templates').'/tpl_modules_hot_products_keywords.php'); 
				  //###############################################################################
			  ?>
		  </li>
	   </ul>
	</div>
	<?php }?>
  <div class="<?php echo (zen_page_path_check($current_page_base,$main_page_content_chk))?'copyright2':'copyright';?>">
				<ul><!--zhanglu 2011-5-16 li -->
					<li><a href="<?php echo zen_href_link(FILENAME_DEFAULT);?>"><?php echo HEADER_TITLE_CATALOG;?></a></li><li>|</li>
					<li><a href="<?php echo zen_href_link(FILENAME_SITE_MAP);?>"><?php echo HEADER_TITLE_SITEMAP;?></a></li><li>|</li>
					<li><a href="<?php echo zen_href_link(FILENAME_ACCOUNT);?>"><?php echo HEADER_TITLE_MY_ACCOUNT;?></a></li><li>|</li>
					<li><a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART);?>"><?php echo HEADER_TITLE_CART_CONTENTS;?></a></li><li>|</li>
					<li><a href="<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING);?>"><?php echo HEADER_TITLE_CHECKOUT;?></a></li><li>|</li>
					<li><a href="http://www.myefox.com/about_myefox"><?php echo HEADER_TITLE_ABOUT_US;?></a></li><li>|</li>
					<li><a href="<?php echo zen_href_link(FILENAME_CONTACT_US);?>"><?php echo HEADER_TITLE_CONTACT_US;?></a></li><!--end-->
					<li><a href="<?php echo zen_href_link(FILENAME_RSS_FEED);?>">
						<?php 
							  echo zen_image(DIR_WS_TEMPLATE_IMAGES.'rss.gif');
						 ?>
					   </a>
					</li>
				</ul>				
				<p>
					<?php
					//change the partner by wushh 20101115,10:26
					  echo zen_image(DIR_WS_TEMPLATE_IMAGES.'partner_images_01.gif');
					  echo zen_image(DIR_WS_TEMPLATE_IMAGES.'partner_images_02.gif').' ';
					  echo zen_image(DIR_WS_TEMPLATE_IMAGES.'partner_images_03.gif').' ';
					  echo zen_image(DIR_WS_TEMPLATE_IMAGES.'partner_images_04.gif').' ';
					  echo zen_image(DIR_WS_TEMPLATE_IMAGES.'moneyback.gif','',70,70).' ';
					 // echo zen_image(DIR_WS_TEMPLATE_IMAGES.'partner_images_05.jpg').' ';
					  echo zen_image(DIR_WS_TEMPLATE_IMAGES.'partner_images_06.jpg').' ';
					  echo zen_image(DIR_WS_TEMPLATE_IMAGES.'partner_images_07.jpg').' ';
					  echo zen_image(DIR_WS_TEMPLATE_IMAGES.'partner_images_08.jpg').' ';
					   echo zen_image(DIR_WS_TEMPLATE_IMAGES.'freeshipping.gif','',70,70);
					  ?> 
				</p> 
				<p style="text-align:center ">Copyright Notice © 2008-2011 Myefox.com All rights reserved.</p>
	</div>

<script type="text/javascript">

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-22262011-1']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

</script>




          
   <?php if($current_page_base==FILENAME_CHECKOUT_SUCCESS){?>
		 <!-- Google Code for Purchase/Sale Conversion Page -->
		<script type="text/javascript">
		/* <![CDATA[ */
		var google_conversion_id = 1048214433;
		var google_conversion_language = "en";
		var google_conversion_format = "1";
		var google_conversion_color = "666666";
		var google_conversion_label = "purchase";
		var google_conversion_value = 0;
		/* ]]> */
		</script>
		<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
		</script>
		<noscript>
		<div style="display:inline;">
		<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1048214433/?label=purchase&amp;guid=ON&amp;script=0"/>
		</div>
		</noscript>
 <?php }?>

</div>
<link href="OKQQ/images/qq.css" rel="stylesheet" type="text/css" />
<script language='javascript' src='OKQQ/ServiceQQ.js' type='text/javascript' charset='utf-8'></script>