<script type=text/javascript>
$(function(){
	$('.firmenu li').hover(function(){
		$(this).children('div').stop(true,true).show();
	},function(){
		$(this).children('div').stop(true,true).hide();
	});
	

});


</script>
<style type="text/css">
html,body,ul,li,ol,dl,dd,dt,p,h1,h2,h3,h4,h5,h6,form,fieldset,legend,img
    {
    margin: 0;
    padding: 0;
}

#marginmenu{
border: 1px solid #d0d0d0 ;
margin-left:18px;
margin-top:8px;
height:520px;
width:172px;
text-align:left; 
-webkit-border-radius:4px;
-moz-border-radius:4px;
border-radius:4px;
-webkit-box-shadow:#E0E0E0  0px 0px 4px;
-moz-box-shadow:#E0E0E0 0px 0px 4px;
box-shadow:#E0E0E0 0px 0px 4px;
background:white;
behavior:url(pie/PIE.htc);
position:absolute;
z-index:999;
}
.childmenu{
border: 1px solid #d0d0d0 ;
text-align:left; 
-webkit-border-radius:4px;
-moz-border-radius:4px;
border-radius:4px;
-webkit-box-shadow:#E0E0E0  0px 0px 4px;
-moz-box-shadow:#E0E0E0 0px 0px 4px;
box-shadow:#E0E0E0 0px 0px 4px;
behavior:url(pie/PIE.htc);
background:white;

}

.firmenu{list-style:none; }
.firmenu li{border-bottom:1px solid #d0d0d0 ;font-family:"ËÎÌו"; font-size:12px; color:#CCCCCC; margin:0px auto;}
.firmenu li a{ text-decoration:none; color:#666666; font-size:12px;display:block; height:30px; padding-left:5px; }
.firmenu li a:hover{ color:#FF9933; text-decoration:underline;}
.childmenu{width:500px; height:620px; position:absolute; margin-left:171px; top:278px; color:#666666; z-index:99;}
.childmenu table{ margin-left:10px;background-image:url(includes/templates/blackcool/images/nav_dress.png); background-repeat:no-repeat; background-position:right bottom;width:505px; height:620px; }
.childmenu p{ font-weight:bold; color:#FF6600;}

.imgposition{border:1px solid green; position:relative; right:0px; bottom:0px;}


</style>
<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_categories.php 4162 2006-08-17 03:55:02Z ajeh $
 */
 //<!--zhanglu 2011-5-16 id ""-->
  $content = ""; 	
  $content .='<div id="left_menu">';

			  
		  

  $content .='<div  id="marginmenu">';  
  //<!--end-->
  if (sizeof($categories)>0){
	  
	  
	  
	  
function cmp($a, $b)
{
    if ($a['category_name'] == $b['category_name']) {
        return 0;
    }
    return ($a['category_name'] < $b['category_name']) ? -1 : 1;
}


//usort($categories, "cmp");

	 




        $content .='<ul class="firmenu">';       	                                                                    
        foreach($categories as $cate_id=>$category){
			   
			  $content .='<li>';
			  $content .='<a title="'.$category['category_name'].'" href="'.$category['category_url_link'].'">
			             '.$category['category_name'].'</a>';			 			  
			    
			  if($category['has_sub_cate']==true && sizeof($category['sub_categories'])>0 ){
			   
			  
			   
			   $content .='<div class="childmenu"  style="display:none;">';
			   
			   
				    
				$content .='<table border="0" cellpadding="0" cellspacing="0"><tr>
						<td  valign="top">';
			
					$chk_top=0;
					
					//usort($category['sub_categories'], "cmp");
					
			        foreach($category['sub_categories'] as $sub_cate_id=>$sub_category){
			        	
			        	 
			        		$content .= '<a href="'.$sub_category['category_url_link'].'"><p>'.$sub_category['category_name'].'</p></a>';
						
				}
				
				$content .= '</td></tr></table>';
			
				//$content .= '<img src="includes/templates/blackcool/images/nav_car.png"  class="imgposition">';
				$content .= '</div>';
					
			  }
			  
			  
			  
			  $content .='</li>';
       }
       
       $content .= '</ul>';
   }      
   $content .='</div>'; 
   $content .='<div class="clear"></div>';
   $content .='</div>';  

    
?>