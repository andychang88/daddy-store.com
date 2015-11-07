<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account_password.<br />
 * Allows customer to change their password
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_account_password_default.php 2896 2006-01-26 19:10:56Z birdbrain $
 */

?>

<div class="ucright">

		<div class="ucpwd">
            <h2><?php echo HEADING_TITLE;?></h2>
            <div class="margintop10px">
<table border="0" width="100%" class="pinfo">
                  <tbody><tr>
                    <td align="right" width="15%"><?php echo LOGIN_NAME;?></td>
                    <td colspan="2"><?php echo $customers_arr['customers_email_address'];?></td>
                  </tr>
                  <tr>
                    <td align="right" width="15%"><?php echo TELPHONE;?></td>
                    <td width="20%"><?php echo $customers_arr['telphone'];?></td>
                    <td><span class="paddingleft10px"></span></td>
                  </tr>
                  <tr>
                    <td align="right" width="15%"><?php echo ADDRESS;?></td>
                    <td colspan="2"><?php echo $customers_arr['entry_street_address'];?></td>
                  </tr>
                  <tr>
                    <td align="right"><?php echo POSTCODE;?></td>
                    <td colspan="2"><?php echo $customers_arr['entry_postcode'];?></td>
                  </tr>
                  <tr>
                    <td align="right" width="15%"><?php echo POINTS;?></td>
                    <td colspan="2"><span class="colorCC0406"><?php echo $customers_arr['reward_points'];?></span></td>
                  </tr>
                </tbody></table>
            </div>
      </div>
    </div>
    
    
    
    





