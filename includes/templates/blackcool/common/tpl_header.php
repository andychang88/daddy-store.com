<?php
/**
 * Common Template - tpl_header.php
 *
 * this file can be copied to /templates/your_template_dir/pagename<br />
 * example: to override the privacy page<br />
 * make a directory /templates/my_template/privacy<br />
 * copy /templates/templates_defaults/common/tpl_footer.php to /templates/my_template/privacy/tpl_header.php<br />
 * to override the global settings and turn off the footer un-comment the following line:<br />
 * <br />
 * $flag_disable_header = true;<br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_header.php 4813 2006-10-23 02:13:53Z drbyte $
 <link href="includes/templates/blackcool/css/header.css" rel="stylesheet" type="text/css" />
 */
?>
<script type="text/javascript">
function OnEnter( field ) { if( field.value == field.defaultValue ) { field.value = ""; } }
function OnExit( field ) { if( field.value == "" ) { field.value = field.defaultValue; } }
</script>
<script type="text/javascript">
$(document).ready(function(){
	
	$('#main_search_form').submit(function(){
		var keyword = $(this).find('input[name="keyword"]').val();
		if(keyword.length == 0){
			return false;
		}

		location.href = '<?php echo zen_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '');?>&keyword='+keyword;
		return false;
	});
	
	<?php if(!$this_is_home_page){?>
	
   $('.menu_left').hover(function(){
        $('.categorise').show();	 
	},function(){
		$('.categorise').hide();	
	});
	
	
	<?php }?>
	
	function addclassA(){
	   $('.subnav_car').show();
		$('.car_left').addClass('car_left1');
		$('.car_left2').addClass('car_left21');
		$('.car_span').addClass('car_span1');
		$('.imgp').addClass('imgp2');
		$('.car_bottom').addClass('car_bottom2');
	}
	
	function removeClassA(){
     	$('.subnav_car').hide();
		$('.car_left').removeClass('car_left1');
		$('.car_left2').removeClass('car_left21');
		$('.car_span').removeClass('car_span1');
		$('.imgp').removeClass('imgp2');
		$('.car_bottom').removeClass('car_bottom2');
	}
  
  	$('.shop_carbox').hover(function(){
		addclassA();		
	},function(){
		removeClassA();
	});
	
  
   function addClassB(){
       $('.subnav_div').show();
		$('.fast_left').addClass('fast_left1');
		$('.fast_left2').addClass('fast_left21');
		$('.font_span').addClass('font_span1');
		$('.fast_bottom').addClass('fast_bottom2');
   }
   function removeClassB(){
   	   $('.subnav_div').hide();
		$('.fast_left').removeClass('fast_left1');
		$('.fast_left2').removeClass('fast_left21');
		$('.font_span').removeClass('font_span1');
		$('.fast_bottom').removeClass('fast_bottom2');
   }
	
	
	
	
	$('.fast_box').hover(function(){
		addClassB();
	},function(){
		removeClassB();
	});
	$('.subnav_div').hover(function(){
		addClassB();
	});
<?php /*?>	,function(){
		$('.subnav_div').hide();
		$('.fast_left').removeClass('fast_left1');
		$('.fast_left2').removeClass('fast_left21');
		$('.font_span').removeClass('font_span1');
		$('.fast_bottom').removeClass('fast_bottom2');
	}<?php */?>
	


});
</script>
<style type="text/css">
	
</style>


 <div class="header wauto">
    <div class="logo fl">
    	
		<a href="<?php echo HTTP_SERVER.DIR_WS_CATALOG;?>"><?php 
		echo zen_image(DIR_WS_TEMPLATE_IMAGES.'logo.gif',$_SERVER['HTTP_HOST'],'');
		?></a>
    </div>

    <ul class="nav_links">
       <li>
        <a href="<?php echo HTTP_SERVER;?>">Home</a>
        </li>
        <li>
        <a href="<?php echo zen_href_link('products_new', '', 'SSL');?>">New Arrivals</a>
        </li>
	<li>
        <a href="<?php echo zen_href_link('new_recommend', '', 'SSL');?>">Recommended</a>
        </li>
	<li>
        <a href="<?php echo zen_href_link('specials', '', 'SSL');?>">Specials</a>
        </li>
	
	
	
	
	
       
    </ul>
    <div class="clear"></div>

<div class="nav_line"></div>
<div class="nav_headbg">

    <Div class="menu_left">
     <div class="menu_navright">
     <p>All</p>
     <p><strong>Categories</strong><span class="triangle_bottom"></span></p>

  	  </div>
      <div class="clear"></div>
      
      
       <?php
      require(DIR_WS_MODULES . 'sideboxes/' . $template_dir . '/categories.php');
      //require(DIR_WS_MODULES . zen_get_module_directory('column_left.php'));
												     
      ?>
      
      
   </Div>
   
	<Div id="care_right"><form method="get" id="main_search_form" >
       <span class="searchnote">Search:</span>
       <input class="btn_search" type="submit" value="Search">
        <div class="searchsum defaltB">
        	<div class="search_gavy">
            	<div class="search">
                  <div class="search_input">
                    <input type="text" value="<?php echo $keywords?$keywords:'Enter your keywords...';?>" onblur="if (this.value == '') this.value = 'Enter your keywords...'" onfocus="if (this.value == 'Enter your keywords...') this.value = ''" name="keyword">
                 </div>
              </div>
            </div>
        </div></form>
    </Div>
    
    
    
    <?php

	if(isset($_SESSION['customer_id'])){
		$head_url = zen_href_link('account');
		$logout_url = zen_href_link(FILENAME_LOGOFF);
	}else{(isset($_REQUEST[main_page]) && ($_REQUEST[main_page] == 'login')) ? $head_url = 'javascript:void()' : $head_url = 'javascript:login()';}
?>


       <div class="zhuce">
        <span class="fast_box">
              <Div class="fast_left">
                 <span class="font_span">
		 
		 <?php
		 if(isset($_SESSION['customer_first_name']) && $_SESSION['customer_first_name'] != ''){
        		echo "Hello,".$_SESSION['customer_first_name']."!&nbsp;";  
	        }elseif (isset($_SESSION['customer_id']) && !isset($_SESSION['customer_first_name'])){
	        	echo 'Hello, Dear customer!&nbsp;';
	        }else{
			echo 'Hello, Sign in&nbsp;';
		}
		?>
	
		
		
	<p class="fast_bottom"></p></span>
                 <div class="fast_left2"></div>
                 <div class="clear"></div>
              </Div>         
         
	       <div class="subnav_div" style="display:none;">
	            <ul class="pop_nav">
                    <li class="first border">
                        <div>
                        <a class="btn_suzu"  href="<?php echo $head_url;?>" rel="nofollow" title="<?php echo isset($_SESSION['customer_id'])?'Sign out':'Sign in';?>">
			
			
                        <span class="btn_suzuin"><?php echo isset($_SESSION['customer_id'])?'User Center':'Sign in';?></span>
                        </a>
			<?php
			if(isset($_SESSION['customer_id'])){
			 
			 echo '<br><a href="'.$logout_url.'">Sign out</a>';
			}
			?>
                        </div>
			<?php
			if(!isset($_SESSION['customer_id'])){
			?>
                    <p>
                    New customer?
                    <a   href="javascript:<?php echo (isset($_REQUEST[main_page]) && ($_REQUEST[main_page] == 'login')) ? 'void()' : 'checkout_L_to_R(1)'; ?>" rel="nofollow" title="Join Free">Register</a>
                    </p>
		    <?php
		    }
			?>
                    </li>
                 </ul>
	        </div>
          </span>  
       </div> 
       
          
        <div class="shop_car">
          <span class="shop_carbox">
              <Div class="car_left">
                 <span class="car_span">
                    <span class="imgp"><span>0</span></span>
                    <p style="height:38px; display:block; line-height:38px;font-weight:bold;">Shopping Cart</p><p class="car_bottom"></p>
                  </span>
                 <div class="car_left2"></div>
                 <div class="clear"></div>
                 
              </Div>         
          
	       <div class="subnav_car" style="display:none;">
		
		
		
		<div  id="nav_cart_info" >
			
			
			
			<div class="havegods" style="display:none;">
                	<dl>
                        <dt>
                            <a href="http://www.efox-shop.com/2013-zopo-c2-mtk6589t-1-5ghz-quad-core-android-4-2-5-0-zoll-13-millionen-high-definition-dual-kamer-p-284937">
                            <img width="50" height="50" src="http://img.efox-shop.com//20130705/MHZPC2T/MHZPC2T.images.160x160.jpg">
                            </a>
                        </dt>
                        <dd>
                            <p class="godatot">
                            <a href="http://www.efox-shop.com/2013-zopo-c2-mtk6589t-1-5ghz-quad-core-android-4-2-5-0-zoll-13-millionen-high-definition-dual-kamer-p-284937">ZOPO C2 MTK6589T 1.5GHz Quad-Core-Android 4.2 5.0 Zoll, 13 Millionen High-Definition</a>
                            </p>
                            <p class="godsinfo">Inhalt: 2 Artikel</p>
                        </dd>
                    </dl>
                </div>
			
			
			<div class="nogods">
                	<p class="nogods_note">Your Shopping Cart is empty.</p>
			<p class="nogods_tail">
			If you don't have an account, you can
			<a href="#">register</a>
			here.
			</p>
			<p class="nogods_logn">
			If you have an account already,
			<a href="/user/member/login">Sign In</a>
			</p>
		    </div>
			
			
			
		</div>
           		
                
		
		
		
		
		
	           
                <div class="view_cart">
                		
			           <a rel="nofollow" href="<?php echo zen_href_link(FILENAME_SHOPPING_CART,'','SSL');?> " class="btn_suzu">
                    
                        <span class="btn_suzuin">
                            Shopping Cart(
                            <span class="godsnum"><?php echo $_SESSION['cart']->count_contents();?></span>
                            items)
                        </span>
                    </a>
                </div>
	        </div>
          </span> 
       </div>  
       
    
</div>

</div>



<?php
  if ($_SESSION['cart']->count_contents() > 0) {
	$url = zen_href_link(FILENAME_SHOPPING_CART,'get_cart_p=1','SSL');
?>
<script language="javascript">
	$(function(){
		var url = "<?php echo html_entity_decode(zen_href_link(FILENAME_SHOPPING_CART,'get_cart_p=1'));?>";
		$.get(url,{},function(data){
			data  = eval("("+data+")");
			
			
			
			if(data.html.length>0){
				var arr = data.html;
				
				var html = '';
				
				for(var i=0;i<arr.length;i++){
					html += '<div class="havegods"><dl><dt>';
					var img_src = arr[i]['productsImage'];
					a=img_src.match(/src="([^"]*)/i);
					if(a.length==2){
						img_src = a[1];
					}
					html += '<a href="'+arr[i]['linkProductsName'] +
					'"><img width="50" height="50" src="'+
					img_src+'" /></a></dt><dd><p class="godatot">';
					
					html += '<a href="'+arr[i]['linkProductsName']+'">'+arr[i]['productsName']+'</a></p>';
					html += '<p class="godsinfo">Qty:'+arr[i]['showFixedQuantityAmount']+'</p></dd></dl></div>';
				}
				
				$('#nav_cart_info').html(html);
			}
		},'html');
	})
</script>
<?php
  }
  
?>





<?php

// Display all header alerts via messageStack:
if ($messageStack->size('header') > 0) {
	echo $messageStack->output('header');
}
if (isset($_GET['error_message']) && zen_not_null($_GET['error_message'])) {
	echo htmlspecialchars(urldecode($_GET['error_message']));
}
if (isset($_GET['info_message']) && zen_not_null($_GET['info_message'])) {
    echo htmlspecialchars($_GET['info_message']);
} else {

}
?>
<!--bof-header logo and navigation display-->
<?php
if (!isset($flag_disable_header) || !$flag_disable_header) {
	if(isset($_SESSION['customer_id'])){
		$head_url = zen_href_link(FILENAME_LOGOFF);
	}else{(isset($_REQUEST[main_page]) && ($_REQUEST[main_page] == 'login')) ? $head_url = 'javascript:void()' : $head_url = 'javascript:login()';}
?>
<!-- small ad 7 start -->



<!-- small ad 7 end -->





<div class="clear"></div>
<?php   
}


?>

