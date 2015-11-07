<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=adress_book.<br />
 * Allows customer to manage entries in their address book
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_address_book_default.php 5369 2006-12-23 10:55:52Z drbyte $
 */

?>
<style type="text/css">
.alignright{padding-right:8px;}
</style>
<div class="ucright">

<?php if ($messageStack->size('addressbook') > 0) echo $messageStack->output('addressbook'); ?> 

<?php //个人信息 ?>
		<div class="ucpwd">
            <h2><?php echo HEADING_TITLE;?></h2>
            <div class="margintop10px">
<table border="0" width="100%" class="pinfo">
                  <tbody><tr>
                    <td align="right" width="15%"><?php echo LOGIN_NAME;?></td>
                    <td colspan="2"><?php echo $customers_arr['customers_email_address'];?></td>
                  </tr>
                  
                  <tr>
                    <td align="right" width="15%"><?php echo POINTS;?></td>
                    <td colspan="2"><span class="colorCC0406"><?php echo $customers_arr['reward_points'];?></span></td>
                  </tr>
                </tbody></table>
            </div>
      </div>
  <br><br>    <br><br> 
<?php //地址薄 ?>      
        <div class="uctab">
            <ul>
                <li class="uctab_current"><span class="uctagbg11"></span><span class="uctag_tit02"><?php echo TAB_TITLE;?></span><span class="uctagbg12"></span></li>
               
            </ul>
        </div>
        
        <div class="uctab_cont2">
                <div>
                	
                   <?php
					/**
					 * Used to loop thru and display address book entries
					 */
                   
					  foreach ($addressArray as $key=>$addresses) {
					?>
                    <div class="ucads <?php if($key>0){?>margintop10px<?php }?>">
                        <span class="ucads_num"><?php echo $key+1;?></span>
                        <div>
                            <table border="0" width="100%">
                              <tbody><tr>
                                <td width="10%" class="alignright fontbold"><?php echo NAME;?></td>
                                <td><?php echo zen_output_string_protected($addresses['firstname'] . ' ' . $addresses['lastname']); ?></td>
                              </tr>
                              <tr>
                                <td width="10%" class="alignright fontbold"><?php echo ADDRESS;?></td>
                                <td><?php 
                                $tmp_addr = zen_address_format($addresses['format_id'], $addresses['address'], true, ' ', '&nbsp;&nbsp;'); 
                                $tmp_addr = str_replace($addresses['firstname'], '', $tmp_addr);
                                $tmp_addr = str_replace($addresses['lastname'], '', $tmp_addr);
                                $tmp_addr = preg_replace("/(&nbsp;)*/", '', $tmp_addr);
                                echo trim($tmp_addr);
                                ?></td>
                              </tr>
                           
                              <tr>
                                <td width="10%" class="alignright fontbold"><?php echo TELEPHONE;?></td>
                                <td><?php echo $addresses['address']['telphone'];?></td>
                              </tr>
                              <tr>
                                <td width="15%" class="alignright fontbold"><?php echo EMAIL;?></td>
                                <td><?php echo $addresses['address']['email'];?></td>
                              </tr>
                            </tbody></table>
                    	</div>
                        <div class="alignright">
                        <?php if($addresses['is_customer_default_address_id']){?>
                        <span class="marginright20px" style="font-style:italic;"><?php echo PRIMARY_ADDRESS;?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php }else{?>
                        <span class="marginright20px"><input style="font-weight:bold;" onclick="window.open('<?php echo zen_href_link('my_address_book', 'edit=' . $addresses['address_book_id'] . '&action=changePrimary&ucenter=1', 'SSL');?>','_self');" type="button" value=" <?php echo PRIMARY_ADDRESS;?> "></span>
                        <?php }?>
                        
                            <span class="marginright20px"><input style="font-weight:bold;" onclick="window.open('<?php echo zen_href_link('my_address_book_process', 'edit=' . $addresses['address_book_id'] . '&ucenter=1', 'SSL');?>','_self');" type="button" value=" <?php echo BTN_CHANGE;?> "></span>
                            <span class="marginright20px"><input style="font-weight:bold;" onclick="deleteAddressBook('<?php echo zen_href_link('my_address_book_process', 'action=del&delete=' . $addresses['address_book_id'] . '&ucenter=1', 'SSL');?>','_self');"  type="button" value=" <?php echo BTN_DELETE;?> "></span>
                           
                        </div>
                    </div>
			       <?php
					  }
					  if(empty($addressArray)){?>
					  <div class="ucads"><?php echo NO_REVIEWS;?></div>
					  <?php 	
					  }
					?>             
                </div>
               
            </div>
            
        <?php
		  if (zen_count_customer_address_book_entries() < MAX_ADDRESS_BOOK_ENTRIES) {
		?>
		   <div class="buttonRow forward">
		     <span class="marginright20px"><input onclick="window.open('<?php echo zen_href_link('my_address_book_process',  'ucenter=1', 'SSL');?>','_self');" type="button" value=" <?php echo BTN_ADDNEW;?> "></span>
		  </div>
		<?php
		  }
		?>
</div>
<script language="javascript">
function deleteAddressBook(url){
	if(confirm('<?php echo DO_YOU_DELETE;?>')){
		window.open(url,'_self');
	}
}
</script>