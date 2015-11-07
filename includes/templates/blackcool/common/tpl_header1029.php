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
	$('.fast_box').hover(function(){
		$('.subnav_div').show();
		$('.fast_left').addClass('fast_left1');
		$('.fast_left2').addClass('fast_left21');
		$('.font_span').addClass('font_span1');
	},function(){
		$('.subnav_div').hide();
		$('.fast_left').removeClass('fast_left1');
		$('.fast_left2').removeClass('fast_left21');
		$('.font_span').removeClass('font_span1');
	});
	$('.subnav_div').hover(function(){
		$('.subnav_div').show();
		$('.subnav_div').show();
		$('.fast_left').addClass('fast_left1');
		$('.fast_left2').addClass('fast_left21');
		$('.font_span').addClass('font_span1');
	},function(){
		$('.subnav_div').hide();
		$('.fast_left').removeClass('fast_left1');
		$('.fast_left2').removeClass('fast_left21');
		$('.font_span').removeClass('font_span1');
	});
	
	

   $('.car_left').hover(function(){
		$('.subnav_car').show();
		$('.car_left').addClass('car_left1');
		$('.car_left2').addClass('car_left21');
		$('.car_span').addClass('car_span1');
		$('.imgp').addClass('imgp2');
	},function(){
		$('.subnav_car').hide();
		$('.car_left').removeClass('car_left1');
		$('.car_left2').removeClass('car_left21');
		$('.car_span').removeClass('car_span1');
		$('.imgp').removeClass('imgp2');
	});
	$('.subnav_car').hover(function(){
		$('.subnav_car').show();
		$('.car_left').addClass('car_left1');
		$('.car_left2').addClass('car_left21');
		$('.car_span').addClass('car_span1');
		$('.imgp').addClass('imgp2');
	},function(){
		$('.subnav_car').hide();
		$('.car_left').removeClass('car_left1');
		$('.car_left2').removeClass('car_left21');
		$('.car_span').removeClass('car_span1');
		$('.imgp').removeClass('imgp2');
	});
});
</script>
<style type="text/css">
	
</style>


<div class="header wauto">
    <div class="logo fl">
    	<img width="192" height="90" title=" www.glstore.com " alt="www.glstore.com"  src="includes/templates/blackcool/common/img/logo.jpg">
    </div>

    <ul class="nav_links">
       <li>
        <a href="http://www.efox-shop.com/products_new.htm">Hot Deals</a>
        </li>
        <li>
        <a href="http://www.efox-shop.com/specials.htm">New Arrivals</a>
        </li>
        <li>
        <a href="http://www.efox-shop.com/quick_shopping">
        $3 Gadgets
        </a>
        </li>
        <li>
        <a href="http://www.efox-shop.com/versand-aus-deutschland-c-5591">Dropshipping</a>
        </li>
        <li>
        <a href="http://www.efox-shop.com/specials/salewill/index">
        Wholesale
        <img src="img/clear_gods_new.png" style="border:0px;">
        </a>
        </li>
       
    </ul>
    <div class="clear"></div>

<div class="nav_line"></div>
<div class="nav_headbg">

    <Div class="head_left">
       <span>All<br /><b>Categories</b><p></p></span>
  	  <div class="head_left2"></div>
      <div class="clear"></div>
   </Div>
   
	<Div id="care_right">
       <span class="searchnote">Artikel:</span>
       <input class="btn_search" type="submit" value="Suchen">
        <div class="searchsum defaltB">
        	<div class="search_gavy">
            	<div class="search">
                  <div class="search_input">
                    <input type="text" value="Geben Sie hier Ihre Suchbegriffe ein" onblur="if (this.value == '') this.value = 'Geben Sie hier Ihre Suchbegriffe ein'" onfocus="if (this.value == 'Geben Sie hier Ihre Suchbegriffe ein') this.value = ''" name="keywords">
                 </div>
              </div>
            </div>
        </div>
    </Div>
    
    
       <div class="zhuce">
        <span class="fast_box">
              <Div class="fast_left">
                 <span class="font_span">Hallo,Anmelden<br /><b>Kategorien</b><p></p></span>
                 <div class="fast_left2"></div>
                 <div class="clear"></div>
              </Div>         
          
	       <div class="subnav_div" style="display:none;">
	           qqqqqqqqqqqqqqqqq
	        </div>
          </span>  
       </div> 
       
          
        <div class="shop_car">
          <span class="shop_carbox">
              <Div class="car_left">
                 <span class="car_span">
                    <span class="imgp"><span>0</span></span>
                    <p style="height:38px; display:block; line-height:38px;">Artikel im Warenkorb</p>
                  </span>
                 <div class="car_left2"></div>
                 <div class="clear"></div>
              </Div>         
          
	       <div class="subnav_car" style="display:none;">
	           qqqqqqqqqqqqqqqqq
	        </div>
          </span> 
       </div>  
       
    
</div>

</div>

dddddddddddddddd<br>
dddddddddddddddd<br>
dddddddddddddddd<br>

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


<script type="text/javascript" src="<?php echo DIR_WS_INCLUDES; ?>templates/blackcool/login/register_or_login_html.js?<?php echo strtotime(date('Y-m'));?>" ></script>

<script type="text/javascript">
<?php if((!isset($_SESSION['customer_id']) || !zen_get_customer_validate_session($_SESSION['customer_id'])) && $_REQUEST['main_page']=='checkout'){?>	
                $(document).ready(function(){
                        checkout_L_to_R(2);
                });
<?PHP }
        if(isset($_SESSION['customer_id']) && $_SESSION['address_exist_status']==0 && (!$_SESSION['sendto']) && $_REQUEST['main_page']=='checkout'){
?>
                $(document).ready(function(){
                        enroll_address();
                });
<?php } ?> 
</script>
<input type="hidden" id="is_hom_page" value="<?PHP echo zen_href_link(FILENAME_DEFAULT); ?>" />
<?php /***************** end 2011-06-02 zhengcongzhen************************/ ?>

<div class="head">
    <div class="logo">
	    <a href="<?php echo HTTP_SERVER.DIR_WS_CATALOG;?>"><?php 
		echo zen_image(DIR_WS_TEMPLATE_IMAGES.'logo.jpg',$_SERVER['HTTP_HOST'],'192');
		?></a>
	</div>
    <!--zhanglu 2011-5-16 id ""-->
	<DIV class="head_r">
<a class="rec_pro" href="http://www.backever.com/2012-original-eroda-gps-cheapest-7-4gb-avin-bt-fm-128m-car-gps-navigation-p-159159"></a>



<!--head zuo ce dao hang-->
<DIV class="head_tab">
	
    <!--huo bi qie huan -->
    <div id="tabs_top">
      <ul><!--end-->
        <li> <a rel="nofollow" href="/?currency=USD" title="Currencies" class="three outer">Currencies:&nbsp;<em>US$</em>
          <!--[if IE 7]><!--></a><!--<![endif]-->
          <!--[if lte IE 6]><table><tr><td style="position:absolute;left:0;top:0;"><![endif]-->
          <div class="tab_right"><!--zhanglu 2011-5-16 img /-->
            <p><img width="16" height="11" alt="" src="includes/templates/blackcool/images/EUR.gif" /> <a href="/?currency=EUR" rel="nofollow" title="Euro" target="_top">Euro</a> </p>
            <p><img width="16" height="11" alt="" src="includes/templates/blackcool/images/GBP.gif" /> <a href="/?currency=GBP" rel="nofollow" title="GB Pound" target="_top">GB Pound</a> </p>
            <p><img width="16" height="11" alt="" src="includes/templates/blackcool/images/CAD.gif" /> <a href="/?currency=CAD" rel="nofollow" title="Canadian Dollar" target="_top">Canadian Dollar</a> </p>
            <p><img width="16" height="11" alt="" src="includes/templates/blackcool/images/AUD.gif" /> <a href="/?currency=AUD" rel="nofollow" title="Australian Dollar" target="_top">AustralianDollar</a> </p>
          </div><!--end-->
          <!--[if lte IE 6]></td></tr></table></a><![endif]-->
        </li>
      </ul>
    </div>
    
    
    <p>
        <?php if(isset($_SESSION['customer_first_name']) && $_SESSION['customer_first_name'] != ''){
        		echo "Hello,".$_SESSION['customer_first_name']."!&nbsp;";  
	        }elseif (isset($_SESSION['customer_id']) && !isset($_SESSION['customer_first_name'])){
	        	echo 'Hello, Dear customer!&nbsp;';
	        }else{
        ?> 
        
        <a href="javascript:<?php echo (isset($_REQUEST[main_page]) && ($_REQUEST[main_page] == 'login')) ? 'void()' : 'checkout_L_to_R(1)'; ?>" rel="nofollow" title="Join Free"><font class="red">Join Free</font></a>        
        																													<!--enroll()<?php echo HEADER_TITLE_UP; ?>-->
        <?PHP } ?>
        
        |
        <a href="<?php echo $head_url;?>" rel="nofollow" title="<?php echo isset($_SESSION['customer_id'])?'Sign out':'Sign in';?>"><font class="green"><?php echo isset($_SESSION['customer_id'])?'Sign out':'Sign in';?></font></a>
    
<!--	<a href="<?php echo zen_href_link(FILENAME_ACCOUNT);?>"><font class="red">Join Free</font></a>
        |<a href="<?php echo zen_href_link(isset($_SESSION['customer_id'])?FILENAME_LOGOFF:FILENAME_LOGIN);?>"><font class="green"><?php echo isset($_SESSION['customer_id'])?'Sign out':'Sign in';?></font></a>
-->
        |<a rel="nofollow" href="<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING);?>"><font class="green">Checkout</font></a>
        |<a rel="nofollow" href="<?php echo zen_href_link(FILENAME_ACCOUNT);?>"><font class="green">My Account</font></a>
        |<a rel="nofollow" href="<?php echo HTTP_SERVER.DIR_WS_CATALOG ?>yh_contact_us">Help</a>  <b>sales@backever.com</b></p>
</DIV>

</DIV>

</div>


<div class="clear"></div>
<?php   
}
?>

