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

  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_TITLE', 'Vorkasse/Überweisung');
  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANKNAME','<b>Bank:</b>');
  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANKCODE','<b>BLZ:</b>');
  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BRANCHCODE','<b>BIC:</b>');
  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_ACCOUNT_NAME','<b>Inhaber:</b>');
  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_ACCOUNT_NUMBER_DOMESTIC','<b>Konto nummer:</b>');
  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_ACCOUNT_NUMBER_INTERNATIONAL','<b>IBAN:</b>');
  define('MODULE_PAYMENT_BANKTRANSFER_TEXT_TIP1','<br>Verwendungszweck: Name und Kundenummer</br><font color=red> Wir werden die Waren innerhalb von ca.2 Arbeitstagen nach dem Zahlungseingang ausliefern.</font>');
  
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
 define('MODULE_PAYMENT_BANKTRANSFER_LOGO_ICON','<img src="images/banktransfer.gif" title="'.MODULE_PAYMENT_BANKTRANSFER_TEXT_TITLE.'" alt="'.MODULE_PAYMENT_BANKTRANSFER_TEXT_TITLE.'"/>');														  
?>