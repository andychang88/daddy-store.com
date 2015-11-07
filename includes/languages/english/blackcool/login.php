<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: J_Schilz for Integrated COWOA - 30 April 2007
 */

define('NAVBAR_TITLE', 'Login');
define('HEADING_TITLE', 'Welcome, Please Sign In');
define('HEADING_CONFIDENCE', 'Shop With Confidence');

define('HEADING_NEW_CUSTOMER', 'New? Please Provide Your Billing Information');

define('TEXT_NEW_CUSTOMER_INTRODUCTION', 'Create a login profile with <strong>' . STORE_NAME . '</strong> which allows you to shop faster, track the status of your current orders and review your previous orders.');
define('TEXT_NEW_CUSTOMER_POST_INTRODUCTION_DIVIDER', '<span class="larger">Or</span><br />');
define('TEXT_NEW_CUSTOMER_POST_INTRODUCTION_SPLIT', 'Returning customers may benefit from creating an account with <strong>' . STORE_NAME . '</strong> which allows you to shop faster, track the status of your current orders, review your previous orders and take advantage of our other member\'s benefits.');

define('HEADING_RETURNING_CUSTOMER', 'Returning Customers: Please Log In');
define('HEADING_RETURNING_CUSTOMER_SPLIT', 'Returning Customers');
define('TXXT_BOX','You have to accept our Terms of Use');

define('TEXE_ACCORD','I agree to '.STORE_NAME.' <a href="'.HTTP_SERVER.DIR_WS_CATALOG.'terms_of_use" style="color:#FB915E; ">Terms and Conditions</a>.');

define('TEXT_LOGIN_TS','If you'."'".'ve been our customer already, please complete your personal information by entering your telephone number so that delivery service can be reached if necessary.Thank you!');

define('TEXT_RATHER_COWOA', 'For a faster checkout experience, we offer the option to checkout without creating an account.<br />');
define('COWOA_HEADING', 'Checkout Without An Account');

define('TEXT_RETURNING_CUSTOMER_SPLIT', '<strong>' . STORE_NAME . '</strong> account holders may login below.');

define('TEXT_PASSWORD_FORGOTTEN', 'Forgot your password?');

define('TEXT_LOGIN_ERROR', 'Error: Sorry, there is no match for that email address and/or password.');
define('TEXT_VISITORS_CART', '<strong>Note:</strong> Your &quot;Visitors Cart&quot; contents will be merged with your &quot;Members Cart&quot; contents once you have logged on. <a href="javascript:session_win();">[More Info]</a>');

define('TABLE_HEADING_BILLING_ADDRESS', 'Billing Address');
define('TABLE_HEADING_SHIPPING_ADDRESS', 'Shipping Address');
define('TABLE_HEADING_SHOPPING_CART', 'Shopping Cart Contents');
define('TABLE_HEADING_PRIVACY_CONDITIONS', '<span class="privacyconditions">Privacy Statement</span>');
define('TEXT_PRIVACY_CONDITIONS_DESCRIPTION', '<span class="privacydescription">Please acknowledge you agree with our privacy statement by ticking the following box. The privacy statement can be read</span> <a href="' . zen_href_link(FILENAME_PRIVACY, '', 'SSL') . '"><span class="pseudolink">here</span></a>.');
define('TEXT_PRIVACY_CONDITIONS_CONFIRM', '<span class="privacyagree">I have read and agreed to your privacy statement.</span>');

define('HEADING_PAYPAL', 'PayPal Express Checkout');
define('TEXT_PAYPAL_INTRODUCTION_SPLIT', 'Have a PayPal account? Want to pay quickly with a credit card? Use the PayPal button below to use the Express Checkout option.');
define('HEADING_NEW_CUSTOMER_SPLIT', 'New Customer? Please enter your checkout information here');
//displayed if the customer does not have any items in their shopping cart (ie. they have elected to register or sign in)
define('TEXT_NEW_CUSTOMER_INTRODUCTION_SPLIT_NO_CART', 'To begin the checkout procedure, please enter your billing information as it appears on your credit card statement.');
//displayed if the customer has items in their shopping cart (to promote registering and continuing the checkout process)
define('TEXT_NEW_CUSTOMER_INTRODUCTION_SPLIT', 'To create an account, please enter your billing information as it appears on your credit card statement.');
define('ENTRY_EMAIL_ADDRESS', 'Email:');
define('ENTRY_EMAIL_ADDRESS_CONFIRM', 'Confirm email:');
define('ENTRY_EMAIL_ADDRESS_CONFIRM_ERROR', 'Your email address confirmation does not match.'); 
define('ENTRY_COPYBILLING', 'Same Address for Shipping/Billing');
define('ENTRY_COPYBILLING_TEXT', '');

// greeting salutation
define('EMAIL_SUBJECT', 'Welcome to ' . STORE_NAME);
define('EMAIL_GREET_MR', 'Dear Mr. %s,' . "\n\n");
define('EMAIL_GREET_MS', 'Dear Ms. %s,' . "\n\n");
define('EMAIL_GREET_NONE', 'Dear %s' . "\n\n");
define('EMALL_GREET','Dear friend'. "\n\n");
define('TEXT_EASY_SIGNUP_CUSTOMER_NAME','Guest');
// First line of the greeting
define('EMAIL_WELCOME', 'Congratulations! You have successfully registered with '.STORE_NAME.' .Welcome to '.STORE_NAME.' and become a member of us!'."<br /><br />".'Congratulations! To make your next visit to our online shop a more rewarding experience, listed below are details for a Discount Coupon created just for you!'."<br /><br /> thank you for your choosing and would like to give you a gift discount coupon valued 5 USD (Code is: 4a9bda0e0f).<br /><br />");
define('EMAIL_SEPARATOR', '--------------------');
define('EMAIL_COUPON_INCENTIVE_HEADER', 'Congratulations! To make your next visit to our online shop a more rewarding experience, listed below are details for a Discount Coupon created just for you!' ."<br /><br />");
// your Discount Coupon Description will be inserted before this next define
define('EMAIL_COUPON_REDEEM', 'To use the Discount Coupon, enter the ' . TEXT_GV_REDEEM . ' code during checkout:  <strong>%s</strong>' . "\n\n");
define('TEXT_COUPON_HELP_DATE', '<p>The coupon is valid between %s and %s</p>');

define('EMAIL_GV_INCENTIVE_HEADER', 'Just for stopping by today, we have sent you a ' . TEXT_GV_NAME . ' for %s!' . "\n");
define('EMAIL_GV_REDEEM', 'The ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM . ' is: %s ' . "\n\n" . 'You can enter the ' . TEXT_GV_REDEEM . ' during Checkout, after making your selections in the store. ');
define('EMAIL_GV_LINK', ' Or, you may redeem it now by following this link: ' . "\n");
// GV link will automatically be included before this line

define('EMAIL_GV_LINK_OTHER','Once you have added the ' . TEXT_GV_NAME . ' to your account, you may use the ' . TEXT_GV_NAME . ' for yourself, or send it to a friend!' . "\n\n");

define('EMAIL_TEXT', '');
define('EMAIL_CONTACT', 'At any time you can connect to the "<a href="'.HTTP_SERVER.DIR_WS_CATALOG.'login">My Account</a>", you can track your orders in real time, manage your personal information, access to practical information.'."\n\n".'Thanks again for selecting us: The Chinese professional tablet pc, mobile phone, electronics supplier.'."\n\n".'Should you have any questions, please feel free to contact us by sending an email to: '.STORE_OWNER_EMAIL_ADDRESS.' at any time!'."<br />");
define('EMAIL_GV_CLOSURE','Enjoy your shopping journey with '.STORE_NAME.'!'."\n\n".'Gong Xi Fa Cai!'."\n\n".STORE_NAME.' Customer Service Center'."\n\n".'Know more about us, please visit <a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'.HTTP_SERVER . DIR_WS_CATALOG ."</a>\n\n");

// email disclaimer - this disclaimer is separate from all other email disclaimers
define('EMAIL_DISCLAIMER_NEW_CUSTOMER', 'This email address is given to us by you or one of our customers. If You Did not signup for an account, if you have not registered for an account or feel that you have received this email in error, please send an email to %s'."\n\n".STORE_NAME.' Customer Service Center');
// eof
//added by john 2010-06-17 for add english language
define('TEXT_LOGIN_PANEL_TITLE','Log in');

define('TEXT_NEW_ACCOUNT_TITLE','New Customer? Please enter your checkout information here');
define('TEXT_NEW_ACCOUNT_DESC','Through your registration at our shop you are able to shop faster, know at any time the status of your orders and have always a current survey of your previous orders.');
define('TEXT_RETURNING_TITLE','Returning Customers');
define('TEXT_RETURNING_DESC','');
define('TEXT_EMAIL','E-mail Address:');
define('TEXT_PASSWORD','Password:');
define('TEXT_LOST_PASSWORD','Forgot your password?');
//added by john 2010-07-26
//js validate lang
define('TEXT_JS_TIP_EMAIL_REQUIRED','Email can \'t be empty');
define('TEXT_JS_TIP_EMAIL_FORMAT','Invalid email address !!!');
define('TEXT_JS_TIP_PASSWORD_REQUIRED','please type your password ');
define('TEXT_JS_TIP_PASSWORD_LENGTH','Char length must be between 3 and 20');
define('TEXT_JS_TIP_PASSWORD2_REQUIRED','please confirm your password');
define('TEXT_JS_TIP_PASSWORD_MATCH','The password confirmation does not match the newly entered password.');

define('TEXT_JS_TIP_LOGIN_EMAIL_REQUIRED','pleas type your email address');
define('TEXT_JS_TIP_LOGIN_EMAIL_FORMAT','it is not an valid email address !!!');
define('TEXT_JS_TIP_LOGIN_PASSWORD_REQUIRED','please type your password ');
define('TEXT_JS_TIP_LOGIN_PASSWORD_LENGTH','Char length must be between 3 and 20');
?>