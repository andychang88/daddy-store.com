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
  $content .='<ul id="menu_index_top">
                <li><a href="'.zen_href_link(FILENAME_SITE_MAP).'">All Categories</a></li>
              </ul>';
  $content .='<div class="menu" id="light_menu">';  
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

	 




        $content .='<ul>';       	                                                                    
        foreach($categories as $cate_id=>$category){
			   
			  $content .='<li>';
			  $content .='<a title="'.$category['category_name'].'" href="'.$category['category_url_link'].'">
			             '.$category['category_name'];			 			  
			    
			  if($category['has_sub_cate']==true && sizeof($category['sub_categories'])>0 ){
			        $content .='<!--[if ie 7]><!--></a><!--<![endif]-->';
					$content .='<!--[if lte ie 6]><table><tr><td><![endif]-->';
				    $content .='<ul>';  
					$chk_top=0;
					
					//usort($category['sub_categories'], "cmp");
					
			        foreach($category['sub_categories'] as $sub_cate_id=>$sub_category){
			        	
			        	 
			        						      
						  if($chk_top==0){
						     $content .='<li class="b_top">';
							 $chk_top=1;
						  }else{
						 	 $content .='<li>';
						  }
						  $content .='<a title="'.$sub_category['category_name'].'" href="'.$sub_category['category_url_link'].'">';
					      
						  $content .=$sub_category['category_name'];
						  /*if($sub_category['has_sub_cate']==true && sizeof($sub_category['sub_categories'])>0){
						        $content .='<!--[if ie 7]><!--></a><!--<![endif]-->';
								$content .='<!--[if lte ie 6]><table><tr><td><![endif]-->';
								$content .='<dl>';  
								$chk2_top=0;
								foreach($sub_category['sub_categories'] as $t3_sub_category){
								      if($chk2_top==0){
										 $content .='<dd class="b_top">';
										 $chk2_top=1;
									  }else{
										 $content .='<dd>';
									  }
									  $content .='<a title="'.$t3_sub_category['category_name'].'" href="'.$t3_sub_category['category_url_link'].'">';
									  $content .=$t3_sub_category['category_name'];
					                   
									  $content .='</a>';			  
									  $content .='</dd>';
								}
								$content .= '</dl>';
								$content .= '<!--[if lte ie 6]></td></tr></table></a><![endif]-->';
						  }else{
						         $content .='</a>';
						  }	*/					  
						  $content .='</a>';			  
						  $content .='</li>';
					}
					$content .= '</ul>';
					$content .= '<!--[if lte ie 6]></td></tr></table></a><![endif]-->';
			  }else{
			        $content .='</a>';
			  }
			  $content .='</li>';
       }        
       $content .= '</ul>';
   }      
   $content .='</div>'; 
   $content .='<div class="clear"></div>';
   $content .='</div>';  
    
?>