<script type=text/javascript>
$(document).ready(function(){
	$('.navlist li').hover(function(){
		$(this).children('table').stop(true,true).show();		 
		 $('.item1').addClass('current');
	},function(){
		$(this).children('table').stop(true,true).hide();
		 $('.item1').removeClass('current');
	});
	

});


</script>

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
 $display = $this_is_home_page?"block":"none";
 
    
  $content = ""; 
  $content .='<table class="categorise" cellspacing="0"  cellpadding="0" border="0" style="display: '.$display.';">
  <tbody>
  	 <Tr>
     	<Td class="nav_left_top"></Td>
        <td class="nav_cent_top"> </td>
        <td class="nav_right_top">  </td>
     </Tr>
     <Tr>
     	<td class="nav_cent_left"> </td>
        <Td valign="top" style="background-color:white;z-index:99;">
           <ul class="navlist">';


  //<!--end-->
  if (sizeof($categories)>0){
	  
	  
	  
/**	  
function cmp($a, $b)
{
    if ($a['category_name'] == $b['category_name']) {
        return 0;
    }
    return ($a['category_name'] < $b['category_name']) ? -1 : 1;
}
/**/

//usort($categories, "cmp");

	 




           	                                                                    
        foreach($categories as $cate_id=>$category){
			   
			  $content .='<li class="item1">';
			  $content .='<a class="tags_name" title="'.$category['category_name'].'" href="'.$category['category_url_link'].'">
			             '.$category['category_name'].'</a>';			 			  
			    
			  if($category['has_sub_cate']==true && sizeof($category['sub_categories'])>0 ){
			   
			  
			   
			   $content .='<table class="subitem none" cellspacing="0" cellpadding="0" border="0" style="display: none;">
			   <tbody>
                    	<tr>
                       		 <td class="pop_cent_top">  </td>
                       		 <td class="pop_right_top">  </td>
                        </tr>
                        <tr>
                        	<td  valign="top">
                            	<div class="subitem_list">
                                	<div class="sublist_left"><div class="sublist_font">
			   ';
			   
			   
			
					$chk_top=0;
					
					//usort($category['sub_categories'], "cmp");
					
			        foreach($category['sub_categories'] as $sub_cate_id=>$sub_category){
			        	
			        	 
			        		$content .= '<p><a href="'.$sub_category['category_url_link'].'">'.$sub_category['category_name'].'</a></p>';
						
				}
				
				$content .= '</div></div>
								   
								</div>
                            </td>
                         	<td class="pop_right_cent">  </td>
                        </tr>
                        <tr>
                      		 <td class="pop_cent-bottom">  </td>
                       		 <td class="pop_right_bottom">  </td>
                        </tr>
                    </tbody>
                </table>
				
				';
			
				//$content .= '<img src="includes/templates/blackcool/images/nav_car.png"  class="imgposition">';
			//	<div class="sublist_right">
//								      <a href="http://www.coolicool.com/cosplay-c343.html" target="_blank">
//											<img width="200" border="0" src="includes/templates/blackcool/images/nav_car.png">
//										</a>
//								   </div>
				
					
			  }
			  
			  
			  
			  $content .='</li>';
       }
       
       
   }      

$content .= '</ul>
        </Td>
        <td class="nav_cent_right"> </td>
     </Tr>
     <tr>
        <td class="nav_left_bottom">  </td>
        <td class="nav_cent_bottom">  </td>
        <td class="nav_right_bottom">  </td>
      </tr>
  </tbody>
</table>';
    
?>