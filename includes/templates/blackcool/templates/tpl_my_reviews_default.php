<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account_history.<br />
 * Displays all customers previous orders
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_account_history_default.php 2580 2005-12-16 07:31:21Z birdbrain $
 */
?>
<div class="ucright">

		<div class="ucpwd">
            <h2><?php echo HEADING_TITLE;?></h2>
            <div class="margintop10px">
            	<table width="100%" class="uccoupon">
                  <tbody><tr class="bgfffafa">
                    <td colspan="6">
                    <span class="fontbold fontsize12px"><?php echo REVIEWS_LIST;?></span>
                    </td>
                  </tr>
                  <tr class="fontbold">
                    <td align="center" width="15%"><?php echo REVIEWS_PRODUCT_NAME;?></td>
                    <td align="center" width="10%"  ><?php echo REVIEWS_DATE;?></td>
                    <td align="center"><?php echo REVIEWS_CONTENT;?></td>
                    
                    <td align="center" width="10%"><?php echo REVIEWS_ACTION;?></td>
                  </tr>
                  <?php if(count($reviews_arr)>0){
                  			foreach($reviews_arr as $row){
                  ?>
                  <tr>
                    <td align="center" width="15%">
                  <?php 
                  				echo '<a target="_blank" href="'.zen_href_link('product_info','products_id='.$row['products_id']).'" title="'.$row['products_name'].'">';
                        		echo zen_image(DIR_WS_IMAGES.$row['products_image'],$row['products_name'],50,50);
                        		echo '</a>';
                  ?>  
                  </td>
                    <td align="center" width="10%"  ><?php echo $row['date_added'];?></td>
                    <td align="center"><?php echo $row['reviews_text'];?></td>
                    
                    <td align="center" width="10%">
                    <a class="colorCC0406" href="<?php echo zen_href_link('my_reviews','ucenter=1&action=delete&review_id='.$row['reviews_id']);?>"><?php echo REVIEW_ACTION_DELETE;?></a>
                   
                    </td>
            
                  </tr>
                 <?php }
                  } else { ?>
                  <tr><td colspan=4 align="center"><?php echo NO_REVIEWS;?></td></tr>
                  <?php }?>
                </tbody></table>
<?php if( $page_split->number_of_pages>0){?>
<br><div class="navSplitPagesLinks forward"><?php echo $page_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page_not_used', 'info', 'x', 'y', 'main_page'))); ?></div>
<?php }?>
            </div>
         
         
            
        <?php
		//begin modify reviews
        if(isset($review_arr) &&　count($review_arr)>0) {
        ?>    
            <div class="margintop10px">
        <?php     
   echo zen_draw_form('review_form',zen_href_link('product_info',zen_get_all_get_params(array('action'))),

												  'post', 

												  ' enctype="multipart/form-data" id="review_form"');  
		?> 
		<input type="hidden" value="process" name="action" /> 
		<input type="hidden" value="<?php echo $review_arr['reviews_id'];?>" name="review_id" /> 
		<input type="hidden" value="<?php echo $_SESSION['token'];?>" name="token" />      
            <div class="ucpunkte lineheight20px margintop10px">
                    <p class="bgfffafa">修改评论</p>
                    <div class="padding10px">
                    	<table border="0" width="100%" class="ucsharemail">
                          <tbody>
                         <tr>
                            <td align="right" width="10%" valign="middle">商品名</td>
                            <td colspan="3"><a href=""><?php 
                            	echo '<a target="_blank" href="'.zen_href_link('product_info','products_id='.$review_arr['products_id']).'" title="'.$review_arr['products_name'].'">';
                        		echo zen_image(DIR_WS_IMAGES.$review_arr['products_image'],$review_arr['products_name'],50,50);
                        		echo '</a>';
                            ?></a></td>
                          </tr>
                          <tr>
                          <tr>
                            <td align="right" width="10%" valign="middle">评论内容</td>
                            <td colspan="3"><textarea name="content" class="ucsharetextarea" id="content">
                            <?php echo $review_arr['reviews_description'];?>
                            </textarea></td>
                          </tr>
                          <tr>
                            <td width="10%">&nbsp;</td>
                            <td colspan="3"><input type="submit" value="提交"></td>
                          </tr>
                        </tbody></table>
                    </div>
                </div>
                
       </form>           
            </div>
 <?php }//end modify reviews?>  
             
             
             
             
      </div>
    </div>
 
    
    
    
    
    