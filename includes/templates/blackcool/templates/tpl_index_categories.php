<?php
/**
 * Page Template
 *
 * Loaded by main_page=index<br />
 * Displays category/sub-category listing<br />
 * Uses tpl_index_category_row.php to render individual items
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_index_categories.php 4678 2006-10-05 21:02:50Z ajeh $
 */
?>

<script type="text/javascript">
$(document).ready(function(){
   $(".categorise").hide();

   $('.view_listp').click(function(){
   		 $('#godlistbox').removeClass();
		 $('#godlistbox').addClass('w_pro_liste');
		 // $('#godlistbox').attr('class','w_pro_liste');
	});
	$('.view_gitp').click(function(){
	      $('#godlistbox').removeClass();
		 $('#godlistbox').addClass('w_pro_gitte');
		 //$('#godlistbox').attr('class','w_pro_gitte');
	});

	 $('.view_galp').click(function(){
	     $('#godlistbox').removeClass();
		 $('#godlistbox').addClass('w_pro_gallery');
		 //$('#godlistbox').attr('class','w_pro_gallery');
	});

});
</script>
<style type="text/css">

</style>
<div class="mainauto">
  <div class="subfield_lf">
     <div class="banr">
        <a target="_blank" href="http://www.coolicool.com/ZOPO-C2-MTK6589T-16G-15GHz-Quad-core-Android-42-50-Inch-Capacitive-FHD-1920*1080-Smartphone-Dual-g-26026 ">
        <img border="0" src="http://en.data.coolicool.com/afficheimg/vdmhzpc2t.jpg">
        </a>
    </div>
    <div class="subfield_list">
       <h2><?php echo $current_categories_name;?></h2>
       
       <?php
       
       require($template->get_template_dir('tpl_modules_category_row.php',
											   DIR_WS_TEMPLATE, 
											   $current_page_base,
											   'templates'). '/tpl_modules_category_row.php');
		?>									   
       
    </div>  
    
    <div class="vedidos">
         <?php
       
       require($template->get_template_dir('tpl_modules_category_best_seller.php',
											   DIR_WS_TEMPLATE, 
											   $current_page_base,
											   'templates'). '/tpl_modules_category_best_seller.php');
		?>
    </div> 
    
    
 </div>
 <div class="subfield_lr">
 	<div class="subfield_note">
    	<a href="http://www.coolicool.com">Home</a>
			> 
            <span class="h1_title">
            <a href="http://www.coolicool.com/local-sale-c674.html"><?php echo $current_categories_name;?></a>
            </span>
            > 
    </div>
    <div class="subvield_tite">
    	<h1><?php echo $current_categories_name;?></h1>
    </div>
    
    
    <?php
    $is_showed_cat_img = false;
if (PRODUCT_LIST_CATEGORIES_IMAGE_STATUS_TOP == 'true') {
// categories_image
  if ($categories_image = zen_get_categories_image($current_category_id)) {
    $is_showed_cat_img = true;
?>
<div class="cent_banr">
  <?php echo zen_image(DIR_WS_IMAGES . $categories_image, '', SUBCATEGORY_IMAGE_TOP_WIDTH, SUBCATEGORY_IMAGE_TOP_HEIGHT); ?>
</div>
<?php
  }
} // categories_image
?>


<?php if(!$is_showed_cat_img){?>


    <div class="cent_banr">
    	<a href="" target="_blank">
            <img src="http://en.data.coolicool.com/afficheimg/15.jpg">
         </a>
    </div>
<?php }?>    
    
    <?php if (zen_not_null($current_categories_description) ) {?>
	    <p><?php echo $current_categories_description;?></p>
    
    <?php }?>
    
    
    <div class="showstylebox">
       <div class="common_shownum">
       		<div class="review_blocks" itemscope="" itemtype="http://data-vocabulary.org/Review-aggregate">
            	<p style="float:left">
               		 <span itemprop="itemreviewed"><?php echo $current_categories_name;?></span>
                </p>
                <div class="rating_num_reviews" itemprop="rating" itemscope="" itemtype="http://data-vocabulary.org/Rating">
                	<span itemprop="rating" content="4.4">
                    	
                        <span class="comment_start">
                            <span style="width:92%"></span>
                         </span>
                         <span class="right_header_num_reviews HelveticaCond" itemprop="count">(208 Customer Reviews)</span>
                    </span>
                </div>
            </div>
       </div>
       <div class="shwo_sty">
         	<div class="fl">
              <strong>View:</strong>
             	 <span class="view_listp">
                    <span></span>
                    List
                  </span>
                  <span class="view_gitp">
                    <span></span>
                    Gitte
                    </span>
                    
                    <span class="view_galp">
                    <span></span>
                    Gallery
                    </span>
            </div>
         <div class="fr">
            <strong>Sort by:</strong>
            <select id="view_type_select">
            <option value="http://www.coolicool.com/local-sale-c674.html?disp_order=0" selected="true">Best Match</option>
            <option value="http://www.coolicool.com/local-sale-c674.html?disp_order=5">Topseller</option>
            <option value="http://www.coolicool.com/local-sale-c674.html?disp_order=3">New Arrivals</option>
            <option value="http://www.coolicool.com/local-sale-c674.html?disp_order=1">Price from the lowest</option>
            <option value="http://www.coolicool.com/local-sale-c674.html?disp_order=2">Price from the highest</option>
            </select>
          </div>
       </div>
    </div>
    
    <div id="gods">
    	<input id="current_view_type_hidden" type="hidden" value="w_pro_gitte">
        <div id="godlistbox" class="w_pro_gitte">
        	<div class="flist_box rows4">
				<div class="plist">
                	<dl>
                        <dt>
                        <a title="CUBOT ONE MTK6589 1.2GHz Quad-core Android 4.2 4.7 Inch HD Capacitive IPS Smartphone Dual SIM UMTS/3G" href="http://www.coolicool.com/cubot-one-mtk6589-12ghz-quad-core-android-42-47-inch-hd-capacitive-ips-smartphone-dual-sim-umts3-g-28221">
                        <img width="320" height="320" src="includes/templates/blackcool/images/phonelist.jpg" alt="CUBOT ONE MTK6589 1.2GHz Quad-core Android 4.2 4.7 Inch HD Capacitive IPS Smartphone Dual SIM UMTS/3G" title="CUBOT ONE MTK6589 1.2GHz Quad-core Android 4.2 4.7 Inch HD Capacitive IPS Smartphone Dual SIM UMTS/3G">
                        </a>
                        </dt>
                        <dd>
                       		 <p class="gods_totl">
                            <a title="CUBOT ONE MTK6589 1.2GHz Quad-core Android 4.2 4.7 Inch HD Capacitive IPS Smartphone Dual SIM UMTS/3G" href="http://www.coolicool.com/cubot-one-mtk6589-12ghz-quad-core-android-42-47-inch-hd-capacitive-ips-smartphone-dual-sim-umts3-g-28221">CUBOT ONE MTK6589 1.2GHz Quad-core Android 4.2 4.7 Inch HD Capacitive IPS Smartphone Dual SIM UMTS/3G</a>
                            </p>
                                <p>
                                <span class="sale_price">$236.99</span>
                                </p>
                        </dd>
                     </dl>                   
                </div>
                
                <div class="plist">
                <dl>
                    <dt>
                        <div class="tag">
                        <b>13%</b>
                        <span>OFF</span>
                        </div>
                        <a title="Stock in Europe I9500 MTK6589 Quad-Core 1.2GHz 5.0 Inch HD IPS Screen Android 4.2 Smartphone with Dual SIM UMTS/3G" href="http://www.coolicool.com/i9500-mtk6589-5-0-inch-capacitive-android-4-2-smartphone-with-dual-sim-p24682.html">
                        <img width="320" height="320" src="includes/templates/blackcool/images/phonesamsung.jpg" alt="Stock in Europe I9500 MTK6589 Quad-Core 1.2GHz 5.0 Inch HD IPS Screen Android 4.2 Smartphone with Dual SIM UMTS/3G" title="Stock in Europe I9500 MTK6589 Quad-Core 1.2GHz 5.0 Inch HD IPS Screen Android 4.2 Smartphone with Dual SIM UMTS/3G">
                        </a>
                    </dt>
                    <dd>
                        <p class="gods_totl">
                        <a title="Stock in Europe I9500 MTK6589 Quad-Core 1.2GHz 5.0 Inch HD IPS Screen Android 4.2 Smartphone with Dual SIM UMTS/3G" href="http://www.coolicool.com/i9500-mtk6589-5-0-inch-capacitive-android-4-2-smartphone-with-dual-sim-p24682.html">Stock in Europe I9500 MTK6589 Quad-Core 1.2GHz 5.0 Inch HD IPS Screen Android 4.2 Smartphone with Dual SIM UMTS/3G</a>
                        </p>
                        <p>
                        <span class="old_price">$273.28</span>
                        <span class="sale_price">$237.99</span>
                        </p>
                       <span class="comment_start">
                            <span style="width:96%"></span>
                            </span>
                            <a href="http://www.coolicool.com/i9500-mtk6589-5-0-inch-capacitive-android-4-2-smartphone-with-dual-sim-p24682.html#Reviews">(18)</a>
                        </p>
                    </dd>
                </dl>
             </div>
             
             <div class="plist">
                <dl>
                    <dt>
                    <div class="tag">
                    <b>21%</b>
                    <span>OFF</span>
                    </div>
                    <a title="Stock in Europe CUBOT GT72 MTK6572 1.2GHz dual core 4.0 Inch HD Smartphone with Dual SIM Dual Standby, Dual Camera" href="http://www.coolicool.com/eu-warehouse-stocking-cubot-gt72-mtk6572-12ghz-dual-core-40-inch-hd-smartphone-with-dual-sim-dual-g-29380">
                    <img width="320" height="320" src="includes/templates/blackcool/images/phonelist.jpg" alt="Stock in Europe CUBOT GT72 MTK6572 1.2GHz dual core 4.0 Inch HD Smartphone with Dual SIM Dual Standby, Dual Camera" title="Stock in Europe CUBOT GT72 MTK6572 1.2GHz dual core 4.0 Inch HD Smartphone with Dual SIM Dual Standby, Dual Camera">
                    </a>
                    </dt>
                    <dd>
                        <p class="gods_totl">
                        <a title="Stock in Europe CUBOT GT72 MTK6572 1.2GHz dual core 4.0 Inch HD Smartphone with Dual SIM Dual Standby, Dual Camera" href="http://www.coolicool.com/eu-warehouse-stocking-cubot-gt72-mtk6572-12ghz-dual-core-40-inch-hd-smartphone-with-dual-sim-dual-g-29380">Stock in Europe CUBOT GT72 MTK6572 1.2GHz dual core 4.0 Inch HD Smartphone with Dual SIM Dual Standby, Dual Camera</a>
                        </p>
                        <p>
                        <span class="old_price">$139.99</span>
                        <span class="sale_price">$109.99</span>
                        </p>
                    </dd>
                </dl>
            </div>
            
             <div class="plist">
                <dl>
                    <dt>
                    <div class="tag">
                    <b>21%</b>
                    <span>OFF</span>
                    </div>
                    <a title="Stock in Europe CUBOT GT72 MTK6572 1.2GHz dual core 4.0 Inch HD Smartphone with Dual SIM Dual Standby, Dual Camera" href="http://www.coolicool.com/eu-warehouse-stocking-cubot-gt72-mtk6572-12ghz-dual-core-40-inch-hd-smartphone-with-dual-sim-dual-g-29380">
                    <img width="320" height="320" src="includes/templates/blackcool/images/phonegitter.jpg" alt="Stock in Europe CUBOT GT72 MTK6572 1.2GHz dual core 4.0 Inch HD Smartphone with Dual SIM Dual Standby, Dual Camera" title="Stock in Europe CUBOT GT72 MTK6572 1.2GHz dual core 4.0 Inch HD Smartphone with Dual SIM Dual Standby, Dual Camera">
                    </a>
                    </dt>
                    <dd>
                        <p class="gods_totl">
                        <a title="Stock in Europe CUBOT GT72 MTK6572 1.2GHz dual core 4.0 Inch HD Smartphone with Dual SIM Dual Standby, Dual Camera" href="http://www.coolicool.com/eu-warehouse-stocking-cubot-gt72-mtk6572-12ghz-dual-core-40-inch-hd-smartphone-with-dual-sim-dual-g-29380">Stock in Europe CUBOT GT72 MTK6572 1.2GHz dual core 4.0 Inch HD Smartphone with Dual SIM Dual Standby, Dual Camera</a>
                        </p>
                        <p>
                        <span class="old_price">$139.99</span>
                        <span class="sale_price">$109.99</span>
                        </p>
                    </dd>
                </dl>
            </div>
             
              <div class="plist">
                <dl>
                    <dt>
                        <div class="tag">
                        <b>13%</b>
                        <span>OFF</span>
                        </div>
                        <a title="Stock in Europe I9500 MTK6589 Quad-Core 1.2GHz 5.0 Inch HD IPS Screen Android 4.2 Smartphone with Dual SIM UMTS/3G" href="http://www.coolicool.com/i9500-mtk6589-5-0-inch-capacitive-android-4-2-smartphone-with-dual-sim-p24682.html">
                        <img width="320" height="320" src="includes/templates/blackcool/images/phonesamsung.jpg" alt="Stock in Europe I9500 MTK6589 Quad-Core 1.2GHz 5.0 Inch HD IPS Screen Android 4.2 Smartphone with Dual SIM UMTS/3G" title="Stock in Europe I9500 MTK6589 Quad-Core 1.2GHz 5.0 Inch HD IPS Screen Android 4.2 Smartphone with Dual SIM UMTS/3G">
                        </a>
                    </dt>
                    <dd>
                        <p class="gods_totl">
                        <a title="Stock in Europe I9500 MTK6589 Quad-Core 1.2GHz 5.0 Inch HD IPS Screen Android 4.2 Smartphone with Dual SIM UMTS/3G" href="http://www.coolicool.com/i9500-mtk6589-5-0-inch-capacitive-android-4-2-smartphone-with-dual-sim-p24682.html">Stock in Europe I9500 MTK6589 Quad-Core 1.2GHz 5.0 Inch HD IPS Screen Android 4.2 Smartphone with Dual SIM UMTS/3G</a>
                        </p>
                        <p>
                        <span class="old_price">$273.28</span>
                        <span class="sale_price">$237.99</span>
                        </p>
                       <span class="comment_start">
                            <span style="width:96%"></span>
                            </span>
                            <a href="http://www.coolicool.com/i9500-mtk6589-5-0-inch-capacitive-android-4-2-smartphone-with-dual-sim-p24682.html#Reviews">(18)</a>
                        </p>
                    </dd>
                </dl>
             </div>
             
              <div class="plist">
                <dl>
                    <dt>
                        <div class="tag">
                        <b>13%</b>
                        <span>OFF</span>
                        </div>
                        <a title="Stock in Europe I9500 MTK6589 Quad-Core 1.2GHz 5.0 Inch HD IPS Screen Android 4.2 Smartphone with Dual SIM UMTS/3G" href="http://www.coolicool.com/i9500-mtk6589-5-0-inch-capacitive-android-4-2-smartphone-with-dual-sim-p24682.html">
                        <img width="320" height="320" src="includes/templates/blackcool/images/phonegitter.jpg" alt="Stock in Europe I9500 MTK6589 Quad-Core 1.2GHz 5.0 Inch HD IPS Screen Android 4.2 Smartphone with Dual SIM UMTS/3G" title="Stock in Europe I9500 MTK6589 Quad-Core 1.2GHz 5.0 Inch HD IPS Screen Android 4.2 Smartphone with Dual SIM UMTS/3G">
                        </a>
                    </dt>
                    <dd>
                        <p class="gods_totl">
                        <a title="Stock in Europe I9500 MTK6589 Quad-Core 1.2GHz 5.0 Inch HD IPS Screen Android 4.2 Smartphone with Dual SIM UMTS/3G" href="http://www.coolicool.com/i9500-mtk6589-5-0-inch-capacitive-android-4-2-smartphone-with-dual-sim-p24682.html">Stock in Europe I9500 MTK6589 Quad-Core 1.2GHz 5.0 Inch HD IPS Screen Android 4.2 Smartphone with Dual SIM UMTS/3G</a>
                        </p>
                        <p>
                        <span class="old_price">$273.28</span>
                        <span class="sale_price">$237.99</span>
                        </p>
                       <span class="comment_start">
                            <span style="width:96%"></span>
                            </span>
                            <a href="http://www.coolicool.com/i9500-mtk6589-5-0-inch-capacitive-android-4-2-smartphone-with-dual-sim-p24682.html#Reviews">(18)</a>
                        </p>
                    </dd>
                </dl>
             </div>
             
              <div class="plist">
                <dl>
                    <dt>
                        <div class="tag">
                        <b>13%</b>
                        <span>OFF</span>
                        </div>
                        <a title="Stock in Europe I9500 MTK6589 Quad-Core 1.2GHz 5.0 Inch HD IPS Screen Android 4.2 Smartphone with Dual SIM UMTS/3G" href="http://www.coolicool.com/i9500-mtk6589-5-0-inch-capacitive-android-4-2-smartphone-with-dual-sim-p24682.html">
                        <img width="320" height="320" src="includes/templates/blackcool/images/phonesamsung.jpg" alt="Stock in Europe I9500 MTK6589 Quad-Core 1.2GHz 5.0 Inch HD IPS Screen Android 4.2 Smartphone with Dual SIM UMTS/3G" title="Stock in Europe I9500 MTK6589 Quad-Core 1.2GHz 5.0 Inch HD IPS Screen Android 4.2 Smartphone with Dual SIM UMTS/3G">
                        </a>
                    </dt>
                    <dd>
                        <p class="gods_totl">
                        <a title="Stock in Europe I9500 MTK6589 Quad-Core 1.2GHz 5.0 Inch HD IPS Screen Android 4.2 Smartphone with Dual SIM UMTS/3G" href="http://www.coolicool.com/i9500-mtk6589-5-0-inch-capacitive-android-4-2-smartphone-with-dual-sim-p24682.html">Stock in Europe I9500 MTK6589 Quad-Core 1.2GHz 5.0 Inch HD IPS Screen Android 4.2 Smartphone with Dual SIM UMTS/3G</a>
                        </p>
                        <p>
                        <span class="old_price">$273.28</span>
                        <span class="sale_price">$237.99</span>
                        </p>
                       <span class="comment_start">
                            <span style="width:96%"></span>
                            </span>
                            <a href="http://www.coolicool.com/i9500-mtk6589-5-0-inch-capacitive-android-4-2-smartphone-with-dual-sim-p24682.html#Reviews">(18)</a>
                        </p>
                    </dd>
                </dl>
             </div>
            
        </div>
    </div>
    
  </div>
<div style="clear:both;"></div>
</div>






















<?php
  require($template->get_template_dir('tpl_modules_category_new_products.php',
									  DIR_WS_TEMPLATE, 
									  $current_page_base,
									  'templates'). '/tpl_modules_category_new_products.php');
?>
<!--</div>-->