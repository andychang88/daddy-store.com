<?php
/**
 *
 * @copyright Copyright 2003-2008 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: pushorder.php,  v 3.02 2008/05/28 paulm
*/
// add a pushorder password (must match the admin pushorder password)
define('PAYPAL_PUSHORDER_PASS', 'WtRgkG{l3iN7w<PY[1aA');
// replace by your admin ip-address (empty string will skip ip-address check)
define('PAYPAL_PUSHORDER_IP', '');
// (un)checks the "send notification emails" checkbox
define('PAYPAL_PUSHORDER_SEND_EMAIL', 'true'); // true / false

// move to language file if desired 
define('PAYPAL_PUSHORDER_COMMENTS', "\n" . '(pushed paypal order)');
?>