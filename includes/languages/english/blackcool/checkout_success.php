<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @translator: cyaneo/hugo13/wflohr/maleborg	http://www.zen-cart.at	2007-01-03
 * @version $Id: checkout_success.php 293 2008-05-28 21:10:40Z maleborg $
 */

define('NAVBAR_TITLE_1','Checkout');
define('NAVBAR_TITLE_2','Success');

define('HEADING_TITLE','Thank you ,we have received your order.');

define('TEXT_SUCCESS','Your order will be shipped immediately upon receipt of payment, if you have not ordered cash on delivery for COD orders the shipment leaves usually after 2-3 business days our house.');
define('TEXT_NOTIFY_PRODUCTS','Please inform me of updates to this product:');
define('TEXT_SEE_ORDERS','You can see your order history and <a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">My Account</a> repute.');
define('TEXT_CONTACT_STORE_OWNER','If you have any questions, please contact the  <a href="' . zen_href_link(FILENAME_CONTACT_US) . '">Customer service</a>.');
define('TEXT_THANKS_FOR_SHOPPING','Thank you for your order online !</strong>');

define('TABLE_HEADING_COMMENTS', '');

define('FOOTER_DOWNLOAD','please your items at a later time at \'%s\' downloaden.');

define('TEXT_YOUR_ORDER_NUMBER_1', 'thank you for your purchase your order has been successfully:</strong> ');

define('TEXT_CHECKOUT_LOGOFF_GUEST_1', '<strong>NOTE:</strong> In order to complete your order has created a temporary account, you can close this account by clicking Sign Out Signing out will also ensure that the information about your.. Staying in our shop is not the next person can be seen that uses this computer If you want to continue with your purchase, please remember to click prior to leaving our shop Sign Out .');
define('TEXT_CHECKOUT_LOGOFF_CUSTOMER_1', 'thank you for your purchase Please log off before leaving the shop to make sure the information about your visit to our shop is not visible for the next person, that uses this computer.');
define('TEXT_ORDER_PAYMENT_METHOD','The selected payment method is: ');
define('TEXT_ORDER_SHIPPING_METHOD','The Shipping mode is selected: ');
define('TEXT_MUST_PAY','you must pay: ');
?>