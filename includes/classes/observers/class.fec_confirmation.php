<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2007-2008 Numinix Technology http://www.numinix.com    |
// |                                                                      |
// | Portions Copyright (c) 2003-2006 Zen Cart Development Team           |
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
//  $Id: class.fec.php 88 2009-08-27 21:03:25Z numinix $
//
/**
 * Observer class used to redirect to the FEC page
 *
 */
class FECConfirmationObserver extends base 
{
	function FECConfirmationObserver()
	{
		global $zco_notifier;
		$zco_notifier->attach($this, array('NOTIFY_HEADER_END_FEC_CONFIRMATION'));
	}
	
	function update(&$class, $eventID, $paramsArray) {
    global $messageStack; 
    if (FEC_ONE_PAGE != 'true') {
      zen_redirect(zen_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'));
    }
	}
}
// eof