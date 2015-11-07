<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_listing_display_order.php 3369 2006-04-03 23:09:13Z drbyte $
 */
?>

<?php echo zen_draw_form('sorter_form', HTTP_SERVER.$_SERVER['REQUEST_URI'], 'GET');?>
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
            
            <?php  
  echo zen_draw_hidden_field('main_page', $_GET['main_page']);
  echo zen_draw_hidden_field('cPath',$_GET['cPath']);
  echo zen_draw_hidden_field('cur_view',$_GET['cur_view'],'id="hid_cur_view"');
  
?><?php echo TEXT_INFO_SORT_BY; ?>
             <select name="disp_order" onchange="this.form.submit();" id="disp-order-sorter">
<?php //if ($disp_order == $disp_order_default) { ?>
    <option value="0" <?php echo ($disp_order == '0' ? 'selected="selected"' : ''); ?>><?php echo PULL_DOWN_ALL_RESET; ?></option>
<?php //} // reset to store default ?>
    <option value="1" <?php echo ($disp_order == '1' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_PRICE; ?></option>
    <option value="2" <?php echo ($disp_order == '2' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_PRICE_DESC; ?></option>
    <option value="3" <?php echo ($disp_order == '3' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_DATE; ?></option>
    <option value="4" <?php echo ($disp_order == '4' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC; ?></option>
    <option value="5" <?php echo ($disp_order == '5' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_ORDERED; ?></option>
    <option value="6" <?php echo ($disp_order == '6' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_ORDERED_DESC; ?></option>
    </select>
          </div>
       </div>
   </form>
   
   
<?php
// NOTE: to remove a sort order option add an HTML comment around the option to be removed
if(0){
?>
<div class="show_top">
<p class="span_l"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></p>
<?php echo zen_draw_form('sorter_form', HTTP_SERVER.$_SERVER['REQUEST_URI'], 'GET');?>
<p class="span_r">
<?php  
  echo zen_draw_hidden_field('main_page', $_GET['main_page']);
  echo zen_draw_hidden_field('cPath',$_GET['cPath']);
?><?php echo TEXT_INFO_SORT_BY; ?>
    <select name="disp_order" onchange="this.form.submit();" id="disp-order-sorter">
<?php //if ($disp_order == $disp_order_default) { ?>
    <option value="0" <?php echo ($disp_order == '0' ? 'selected="selected"' : ''); ?>><?php echo PULL_DOWN_ALL_RESET; ?></option>
<?php //} // reset to store default ?>
    <option value="1" <?php echo ($disp_order == '1' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_PRICE; ?></option>
    <option value="2" <?php echo ($disp_order == '2' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_PRICE_DESC; ?></option>
    <option value="3" <?php echo ($disp_order == '3' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_DATE; ?></option>
    <option value="4" <?php echo ($disp_order == '4' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC; ?></option>
    <option value="5" <?php echo ($disp_order == '5' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_ORDERED; ?></option>
    <option value="6" <?php echo ($disp_order == '6' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_ORDERED_DESC; ?></option>
    </select>
</p>
</form>
</div>
<?php }?>