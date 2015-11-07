<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=address_book_process.<br />
 * Allows customer to add a new address book entry
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_address_book_process_default.php 2949 2006-02-03 01:09:07Z birdbrain $
 */
?>

<div class="ucright">
<?php if ($messageStack->size('addressbook') > 0) echo $messageStack->output('addressbook'); ?> 

<form method="post" name="addressbook" id="addressbook_form" onsubmit="return check_form('addressbook');" action="<?php echo zen_href_link("my_address_book_process",'ucenter=1&edit='.$_GET['edit']);?>">
<?php 
   if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
?>
<input type="hidden" name="action" value="update" />
<input type="hidden" name="edit" value="<?php echo $_GET['edit'];?>" />
<?php 
   }else{
?>
  <input type="hidden" name="action" value="process" />                  	
<?php 
   }
 ?>
       <div class="ucaddads">
       	<p class="borderbottomccc lineheight30px"><span class="fontsize14px fontbold"><?php echo HEADING_TITLE;?></span><span class="paddingleft10px color666"></span></p>
        <div>
        	<table border="0" width="100%" class="ucaddtable">
              <tbody>
<?php

  if (ACCOUNT_GENDER == 'true') {
    if (isset($gender)) {
      $female = ($gender == 'm') ? true : false;
    } else {
      $female = ($entry->fields['entry_gender'] == 'f') ? true : false;
    }
    $male = !$female;
    
?>
              <tr>
                <td align="right" width="20%" >
   				 <strong><?php echo GENDER;?></strong>
                </td>
                <td width="50%"><label for="textfield"></label>
                 <?php echo zen_draw_radio_field('gender', 'm', $male, 'id="gender-male"');?>
                <label class="radioButtonLabel" for="gender-male"><?php echo GENDER_MALE;?></label>
                <?php echo zen_draw_radio_field('gender', 'f', $female, 'id="gender-female"');?>
                <label class="radioButtonLabel" for="gender-female"><?php echo GENDER_FEMALE;?></label>
                </td>
                <td>&nbsp;</td>
                
              </tr>
<?php } //end if ACCOUNT_GENDER?>
              <tr>
                <td align="right" width="20%"><strong><?php echo FIRST_NAME;?></strong></td>
                <td width="50%"><label for="textfield"></label>
                <input type="text" id="textfield" name="firstname" value="<?php echo empty($firstname)?$entry->fields['entry_firstname']:$firstname;?>" class="uc_input">
                <span class="alert">*</span></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right" width="20%"><strong><?php echo LAST_NAME;?></strong></td>
                <td width="50%"><label for="textfield"></label>
                <input type="text" id="textfield" name="lastname" value="<?php echo empty($lastname)?$entry->fields['entry_lastname']:$lastname;?>" class="uc_input">
                <span class="alert">*</span></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right" width="20%"><strong><?php echo EMAIL;?></strong></td>
                <td width="50%"><label for="textfield"></label>
                <input type="text" value="<?php echo empty($email)?$entry->fields['email']:$email;?>" id="textfield" name="email" class="uc_input">
                <span class="alert">*</span></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right" width="20%"><strong><?php echo TELEPHONE;?></strong></td>
                <td width="50%"><label for="textfield"></label>
                <input type="text" value="<?php echo empty($telphone)?$entry->fields['telphone']:$telphone;?>" id="textfield" name="telphone" class="uc_input">
                <span class="alert">*</span></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right" width="20%"><strong><?php echo ADDRESS;?></strong></td>
                <td width="50%"><label for="textfield"></label>
                <input type="text" value="<?php echo empty($street_address)?$entry->fields['entry_street_address']:$street_address;?>" id="textfield" name="street_address" class="uc_input">
                <span class="alert">*</span></td>
                <td>&nbsp;</td>
              </tr>

              <tr>
                <td align="right" width="20%"><strong><?php echo CITY;?></strong></td>
                <td width="50%"><label for="textfield"></label>
                <input type="text" id="textfield" name="city" value="<?php echo empty($city)?$entry->fields['entry_city']:$city;?>" class="uc_input">
                <span class="alert">*</span></td>
                <td>&nbsp;</td>
              </tr>
              

              <tr>
                <td align="right" width="20%"><strong><?php echo POSTCODE;?></strong></td>
                <td width="50%"><label for="textfield"></label>
                <input type="text" value="<?php echo empty($postcode)?$entry->fields['entry_postcode']:$postcode;?>" id="textfield" name="postcode" class="uc_input">
                <span class="alert">*</span></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right" width="20%"><strong><?php echo COUNTRY;?></strong></td>
                <td width="50%"><label for="textfield"></label>
                <?php echo zen_get_country_list('zone_country_id', $entry->fields['entry_country_id'], ' style="border:1px solid #ccc;" id="country" ' . ($flag_show_pulldown_states == true ? 'onchange="update_zone(this.form);"' : '')) ; ?>
                <span class="alert">*</span></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right" width="20%"><strong></strong></td>
                <td width="50%"><label for="textfield"></label>
                <input type="checkbox" value="on" id="textfield" name="primary" id="primary" >&nbsp;&nbsp;<?php echo PRIMARY_ADDRESS;?></td>
                <td>&nbsp;</td>
              </tr>
              
              
              
              
              <tr>
                <td align="right" width="20%">&nbsp;</td>
                <td width="50%">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right" width="20%"><strong>

                <input type="submit" value=" <?php echo BTN_SUBMIT;?> " id="button" name="button">
                </strong></td>
                <td>&nbsp;</td>
                <td><input type="button" onclick="window.open('<?php echo zen_href_link('my_address_book','ucenter=1');?>','_self');" value=" <?php echo BTN_BACK;?> " id="btn_back" name="button2"></td>
              </tr>
            </tbody></table>
            
        </div>
       </div>
       </form>
    </div>