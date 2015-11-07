<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_product_listing.php 3241 2006-03-22 04:27:27Z ajeh $
 */
 $has_avaiable_products=false;
 //################start: customed  display order ######################

 $disp_order_default = PRODUCT_ALL_LIST_SORT_DEFAULT;
 require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_LISTING_DISPLAY_ORDER2));
 ####################end: customed  display order ######################

 include(DIR_WS_MODULES . zen_get_module_directory("product_listing.php"));
 
?>
<script type="text/javascript">
$(document).ready(function(){
   $(".categorise").hide();

   $('.view_listp').click(function(){
   		 $('#godlistbox').removeClass();
		 $('#godlistbox').addClass('w_pro_liste');
		 $('#hid_cur_view').val(1);
		 // $('#godlistbox').attr('class','w_pro_liste');
	});
	$('.view_gitp').click(function(){
	      $('#godlistbox').removeClass();
		 $('#godlistbox').addClass('w_pro_gitte');
		 $('#hid_cur_view').val(2);
		 //$('#godlistbox').attr('class','w_pro_gitte');
	});

	 $('.view_galp').click(function(){
	     $('#godlistbox').removeClass();
		 $('#godlistbox').addClass('w_pro_gallery');
		 $('#hid_cur_view').val(3);
		 //$('#godlistbox').attr('class','w_pro_gallery');
	});

});
</script>




  <div class="subfield_lf">
     <div class="banr">
      <?php
      echo zen_display_banner_by_groupd('ProductList');
      ?>
      
      
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
    
    
    <?php
    if(false){
    ?>
    <div class="vedidos">
         <?php
	 
       
	 
	 require($template->get_template_dir('tpl_modules_category_best_seller.php',
											   DIR_WS_TEMPLATE, 
											   $current_page_base,
											   'templates'). '/tpl_modules_category_best_seller.php');
	 
       
       
		?>
    </div> 
    <?php
    }
    ?>
    
 </div>
  
  
  
  
  
 <div class="subfield_lr">
   
   <?php if (DEFINE_BREADCRUMB_STATUS == '1' || (DEFINE_BREADCRUMB_STATUS == '2' && !$this_is_home_page) ) { ?>
    <div class="subfield_note"><?php echo $breadcrumb->trail(" > "); ?></div>
<?php } ?>

 	
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
       <?php if($has_avaiable_products){    

	if ( $show_split_page && ($listing_split->number_of_rows>0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3')) ){
          require_once($template->get_template_dir('tpl_modules_listing_display_order2.php',
												   DIR_WS_TEMPLATE, 
												   $current_page_base,
												   'templates').'/tpl_modules_listing_display_order2.php');
	  }
      }
	  
      ?>
    </div>
    
    <?php
    
    if(empty($_GET['cur_view'])){
      $cur_view = "w_pro_gitte";
    }else{
      switch($_GET['cur_view']){
	case 1:$cur_view='w_pro_liste';break;
	case 2:$cur_view='w_pro_gitte';break;
	case 3:$cur_view='w_pro_gallery';break;
	default:$cur_view='w_pro_gitte';break;
      }
      }
    
    ?>
      <div id="gods">
	  
			  <div id="godlistbox" class="<?php echo $cur_view;?>">
				  <div class="flist_box rows4">
				    <?php  foreach($products as $product){?>
			     <div class="plist">
					  <dl>
					  <dt>
					    
					    
					<a href="<?php echo $product['products_url_link'];?>" class="ih" title="<?php echo $product['products_name'];?>">
					       <?php echo zen_image(DIR_WS_IMAGES.$product['products_image'],addslashes($product['products_name']),IMAGE_PRODUCT_LISTING_WIDTH,IMAGE_PRODUCT_LISTING_HEIGHT);?>
					    </a>
					    </dt>
					  <dd>
						   <p class="gods_totl">
						   
						<a href="<?php echo $product['products_url_link'];?>" class="ih" title="<?php echo $product['products_name'];?>">
							    <?php echo zen_trunc_string($product['products_name'],150,true);?>
						    </a>
						    </p>
						  <p>
						  <span class="sale_price"><?php echo $product['products_price'];?></span>
						  </p>  
					    </dd>
				       </dl>                   
				  </div>
			     
				    <?php  }//end foreach ?>
		  
		  
		  
			      
			  </div>
		      </div>
      
    </div>
      
      
<div style="clear:both;"></div>
</div>















<?php if ( $show_split_page && ($listing_split->number_of_rows > 1) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3')) ) {
  //echo "<h3 style='margin-left:600px;'>not found any product.</h3>";
?>


    <div class="grid">
     
	

	   <div class="scott">
          <?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS,
		                                                                    zen_get_all_get_params(array('page', 'info', 'x', 'y'))); 
		   ?>         
        </div>

   </div>
    <?php }?>
    <div style="clear:both;"></div>
    
