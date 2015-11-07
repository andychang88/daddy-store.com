<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// | Simplified Chinese version   http://www.zen-cart.cn                  |
// +----------------------------------------------------------------------+
// $Id: moneyorder.php 290 2004-09-15 19:48:26Z wilt $
//

  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_TITLE', 'Wire Transfer');
  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANKNAME','<b>Bank:</b>');
  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANKCODE','<b>BLZ:</b>');
  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BRANCHCODE','<b>BIC:</b>');
  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_ACCOUNT_NAME','<b>Account name:</b>');
  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_ACCOUNT_NUMBER_DOMESTIC','<b>Account:</b>');
  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_ACCOUNT_NUMBER_INTERNATIONAL','<b>IBAN:</b>');
  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_TIP1','<br>Note:Name and Account Number </ br> <font color=red> We deliver the goods to be within about 2 working days as loog as we receive your payment.</font>');  
  
  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_DESCRIPTION', '');
  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_EMAIL_FOOTER',MODULE_PAYMENT_BANKTRANSFER_TEXT_ACCOUNT_NAME.MODULE_PAYMENT_BANKTRANSFER_PAYTO.  '<br>
														 '.MODULE_PAYMENT_BANKTRANSFER_TEXT_BANKCODE.MODULE_PAYMENT_BANKTRANSFER_CODE.'<br>									                                                         '.MODULE_PAYMENT_BANKTRANSFER_TEXT_BANKNAME.MODULE_PAYMENT_BANKTRANSFER_BANKNAME.'<br>
														 '.MODULE_PAYMENT_BANKTRANSFER_TEXT_ACCOUNT_NUMBER_DOMESTIC.MODULE_PAYMENT_BANKTRANSFER_DOMESTIC_ACCOUNT. '<br>'.EMAIL_TEXT_OVERSEA.'<br>'
														  .MODULE_PAYMENT_BANKTRANSFER_TEXT_ACCOUNT_NAME.MODULE_PAYMENT_BANKTRANSFER_PAYTO.'<br>'
														  .MODULE_PAYMENT_BANKTRANSFER_TEXT_BANKNAME.MODULE_PAYMENT_BANKTRANSFER_BANKNAME. '<br>
														 '.MODULE_PAYMENT_BANKTRANSFER_TEXT_ACCOUNT_NUMBER_INTERNATIONAL.
														   MODULE_PAYMENT_BANKTRANSFER_INTERNATIONAL_ACCOUNT.'<br>'
														  .MODULE_PAYMENT_BANKTRANSFER_TEXT_BRANCHCODE.MODULE_PAYMENT_BANKTRANSFER_BRANCHCODE. '<br>'											                                                    .MODULE_PAYMENT_BANKTRANSFER_TEXT_TIP1);
//added by john 2010-06-25
//define('MODULE_PAYMENT_BANKTRANSFER_LOGO_ICON','<img src="images/banktransfer.gif" title="'.MODULE_PAYMENT_BANKTRANSFER_TEXT_TITLE.'" alt="'.MODULE_PAYMENT_BANKTRANSFER_TEXT_TITLE.'"/>');
//begin weixuefeng 20110416 

define('MODULE_PAYMENT_BANKTRANSFER_EXTRA_TEXT','<div class="payment_text"><span  name="spBox" id="spBoxbk" style="display: none;">
	<ul>
		<li><b>NAME：</b> Zhang Xiu Hua</li>
		<li><b>ACCOUNT:</b> 509527305833</li>
		<li><b>BANK NAME:</b> The Hongkong and Shanghai Banking Corporation Limited</li>
		<li><b>Bank SWIFT:</b> HSBCHKHHHKH</li>
		<li><b>BANK ADDRESS:</b>Head Office 1 Queens Road Central Hongkong</li>
		<li style="background-image: none;"><b>NOTICE:</b>We want to remind all customers that they are responsible for all local handling fees and intermediary bank handling fees.Therefore,customers should confirm the total payment amount with their local bank.</li>
	</ul>
	</span></div>');
//end
?>