<?php
/**
* @package languageDefines
* @copyright Copyright 2003-2006 Zen Cart Development Team
* @copyright Portions Copyright 2003 osCommerce
* @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
* @version $Id: header.php 2940 2006-02-02 04:29:05Z drbyte $
*/

//common 
define('POP_ERROR_IMG',"<img src='includes/templates/blackcool/images/error_img.gif' class='error_img' /><br/>");
define('POP_OK_IMG',"<img src='includes/templates/blackcool/images/isrightimg.gif'  class='error_img' />");
define('POP_LOADING_IMG',"<img src='includes/templates/blackcool/images/loading_btn.gif'/>");

//pop dialog esay enroll lang
define('POP_TEXT_NEW_ACCOUNT_TITLE', 'New customer');
define('POP_TEXT_REGISTER_TO_LOGIN', '(Hello! New customer? <span><a class="colorCC0406" href="javascript:void()" onclick="login()">Please Sign in</a></span>)');
define('POP_ENTRY_EMAIL_ADDRESS', 'E-mail Address:');
define('POP_ENTRY_NICK', 'Forum Nickname:');
define('POP_ENTRY_EMAIL_ADDRESS_CONFIRM', 'Confirm Email');
define('POP_ENTRY_PASSWORD', 'Password:');
define('POP_ENTRY_PASSWORD_CONFIRMATION', 'Confirm Password:');

//pop dialog js validate esay enroll lang
define('POP_TEXT_JS_TIP_EMAIL_REQUIRED','Please enter your e-mail address');
define('POP_TEXT_JS_TIP_EMAIL_FORMAT','Invalid E-mail Address !');
define('POP_TEXT_JS_TIP_EMAIL_ALREADY_EXITS','Account already exists !');
define('POP_TEXT_JS_TIP_PASSWORD_REQUIRED','Please type in your password');
define('POP_TEXT_JS_TIP_PASSWORD_LENGTH','Must be 5 to 20 characters');
define('POP_TEXT_JS_TIP_PASSWORD2_REQUIRED','Please repeat your password');
define('POP_TEXT_JS_TIP_PASSWORD_MATCH','The password confirmation does not match the newly entered password.');

//pop dialog account enroll success
define('POP_TEXT_SUCCESS_TITLE', 'Your account has been created!');
define('POP_TEXT_SUCCESS_BIAOYU','A confirmation has been sent to the provided email address. If you have not received it within the hour, please contact us.');
define('POP_TEXT_SUCCESS_LEFT', 'Finally, click Registration and enter your personal information. Then you can shop without entering additional information in the web '.STORE_NAME.'.');
define('POP_TEXT_SUCCESS_REIGHT', 'Click to buy at once, and then you can buy directly in '.STORE_NAME.' . When completing the order, you will be asked to enter your personal data.');


//pop dislog enroll Detailed address lang
define('POP_ENTRY_TITLE','Required Information');
define('POP_TEXT_GENDER','Title:');
define('POP_MALE', 'Mr.');
define('POP_FEMALE', 'Ms.');
define('POP_TEXT_FIRTNAME','First Name:');
define('POP_TEXT_LASTNAME','Last Name:');
define('POP_ENTRY_TELEPHONE_NUMBER', 'Phone number:');
define('POP_TEXT_COMPANY','Company data');
define('POP_TEXT_STREET','Street Address:');
define('POP_TEXT_POSTCODE','Post/ZIP Code:');
define('POP_TEXT_CITY','City:');
define('POP_TEXT_COUNTRY','Country:');
define('POP_TEXT_NEWSLETTER','Yes, I want to subscribe to the newsletter '.STORE_NAME.'.');
define('ZCZ_POP_TEXT_BEDINGUNGEN_UND_KONDITIONEN','I agree to '.STORE_NAME.' <a style="color: rgb(251, 145, 94);" href="javascript:void();" onclick="window.open(\''.HTTP_SERVER.DIR_WS_CATALOG.'terms_of_use\')">Terms and Conditions</a>.');
define('POP_TEXT_BEDINGUNGEN_UND_KONDITIONEN','I agree to '.STORE_NAME.' <a style="color: rgb(251, 145, 94);" href="javascript:void();" onclick="window.open(\''.HTTP_SERVER.DIR_WS_CATALOG.'terms_of_use\')">Terms and Conditions</a>.');
define('POP_TEXT_TISHI_NAME','Enter your First name');
define('POP_TEXT_TISHI_XINGSHI','Enter your Last name');
define('POP_TEXT_TISHI_TEL','Please enter your phone number');
define('POP_TEXT_TISHI_JEIDAO','Please enter your address details');
define('POP_TEXT_TISHI_YOUBIAN','Post Code');
define('POP_TEXT_TISHI_CHENGSHI','Enter the name of your City');
define('POP_TEXT_TISHI_GUOJIA','Enter the name of your Country');

define('POP_TEXT_CHECKOUT_L_TITLE', 'You already have an account? Sign in, please.');
define('POP_TEXT_CHECKOUT_R_TITLE', 'Register and enter your delivery address.');
define('POP_TEXT_ADDRESS_SUCCESS_TITLE','Congratulations, information is saved successfully!');
define('POP_TEXT_ADDRESS_SUCCESS','Information is saved successfully!');

//pop dialog js validate further enroll lang
define('POP_ENTRY_TITLE','Required Information');
define('POP_ENTRY_FIRST_NAME_ERROR', 'Your first name must be at least ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' Characters have.');
define('POP_ENTRY_LAST_NAME_ERROR', 'Your last name must be at least ' . ENTRY_LAST_NAME_MIN_LENGTH . ' Characters have.');
define('POP_ENTRY_TELEPHONE_NUMBER_ERROR', 'The phone number must be at least ' . ENTRY_TELEPHONE_MIN_LENGTH . ' Characters are.');
define('POP_ENTRY_TELEPHONE_NUMBER_EFFECTIVENESS','This number must be entered');
define('POP_ENTRY_STREET_ADDRESS_ERROR', 'The road must be at least ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' Characters are.');
define('POP_ENTRY_POST_CODE_EFFECTIVENESS','Here must be number');
define('POP_ENTRY_DIAHAO_ERROR','By loading the code of the country!');
define('POP_ENTRY_DIAHAO_NO_NUMBER_ERROR','The country code must be number!');
define('POP_ENTRY_POST_CODE_ERROR', 'The post code must consist of at least' . ENTRY_POSTCODE_MIN_LENGTH . ' Characters are.');
define('POP_ENTRY_CITY_ERROR', 'The city must have at least ' . ENTRY_CITY_MIN_LENGTH . ' Characters are.');
define('POP_ENTRY_COUNTRY_ERROR', 'Please select a country from the pulldown menu.');
define('POP_RECOGNIZED_AGREEMENT_ERROR', 'Recognition Agreement');
define('POP_PO_BOX_ERROR', 'Invalid address');

define('POP_PULL_DOWN_DEFAULT', 'Please choose your country');

//pop dislog login lang
define('POP_TEXT_RETURNING_TITLE','I am a new customer');
define('POP_TEXT_LOGIN_TITLE','I am a customer');
define('POP_TEXT_LOGIN_TO_REGISTER', '(Hello! New customer? <span><a class="colorCC0406" href="javascript:void()" onclick="checkout_L_to_R(1)">Please Register</a></span>)');
define('POP_TEXT_PASSWORD_FORGOTTEN', 'Did you forget your password?');
define('POP_TEXT_LOGIN_ERROR','E-mail address or password were not found.');
define('POP_TEXT_LOGIN_BANNED', 'ERROR: Access Denied.');

define('POP_TEXT_LOADING', 'The page is loading, please wait.....');

//email content
define('POP_EMAIL_SUBJECT', 'Welcome to ' . STORE_NAME . '!');
define('POP_TEXT_EASY_SIGNUP_CUSTOMER_NAME','Guest');
define('POP_EMALL_GREET','Dear friend'. "\n\n");
define('POP_EMAIL_WELCOME', 'Welcome to <strong>' . STORE_NAME . '</strong>.');
define('POP_EMAIL_USER_PASSWORD_TEXT','<br/>Your Account is successfully created, and the password is:');
define('POP_EMAIL_TEXT', 'You can enjoy our comprehensive service which we have provided available to you.' . "\n\n" . 'Some of our Highlights:' . "\n\n" . '<li><strong>Your permanent cart: ' . "\n" . '</strong>Items you have placed in your cart will be preserved,' . "\n" . 'until you buy it or remove from cart.' . "\n\n" . '
<li><strong>Your personal address book: </strong>' . "\n" . 'With your personal address book, you can immediately and easily send your purchases to another person.' . "\n" . 'Optimally, for example to buy a birthday present to your friends!' . "\n\n" . '
<li><strong>Your personal order history: </strong>' . "\n" . 'Consider your entire order in peace operations that you have done in our shop!' . "\n" . 'Ideal for e.g. Copies of invoices to print, or to simply gain an overview!' . "\n\n" . '
<li><strong>Reviews: </strong>' . "\n" . 'Tell us and other customers your experience with our services and products!' . "\n\n\n" . '');
define('POP_EMAIL_CONTACT', 'If you ever need help with our services and products, please contact us at: <a href = "mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">' . STORE_OWNER_EMAIL_ADDRESS . '</a>' . "\n\n\n" . '');
//define('POP_EMAIL_GV_CLOSURE', 'Yours sincerely,' . "\n\n" . STORE_OWNER . "\nShop Owner\n\n" . '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">' . HTTP_SERVER . DIR_WS_CATALOG . "</a>\n\n");
define('POP_EMAIL_GV_CLOSURE', 'Yours sincerely,' . "\n\n ".HTTP_SERVER." Customer Service Team \n Shop Owner\n\n" . '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">' . HTTP_SERVER . DIR_WS_CATALOG . "</a>\n\n");
define('POP_EMAIL_DISCLAIMER_NEW_CUSTOMER', 'This e-mail address we have received from you or one of our customers. If you have received this message in error, please contact us at %s');

//added by andy

  // First line of the greeting
  define('EMAIL_WELCOME', 'Congratulations! You have successfully registered with '.STORE_NAME.' .Welcome to '.STORE_NAME.' and become a member of us!');
  define('EMAIL_SEPARATOR', '--------------------');
  define('EMAIL_COUPON_INCENTIVE_HEADER', 'Congratulations! To make your next visit to our online shop a more rewarding experience, listed below are details for a Discount Coupon created just for you!' . "\n\n");
  // your Discount Coupon Description will be inserted before this next define
  define('EMAIL_COUPON_REDEEM', 'To use the Discount Coupon, enter the ' . TEXT_GV_REDEEM . ' during checkout:  <strong>%s</strong>' . "\n\n");
  define('TEXT_COUPON_HELP_DATE', '<p>The coupon is valid between %s and %s</p>');

  define('EMAIL_GV_INCENTIVE_HEADER', 'Just for stopping by today, we have sent you a ' . TEXT_GV_NAME . ' for %s!' . "\n");
  define('EMAIL_GV_REDEEM', 'The ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM . ' is: %s ' . "\n\n" . 'You can enter the ' . TEXT_GV_REDEEM . ' during Checkout, after making your selections in the store. ');
  define('EMAIL_GV_LINK', ' Or, you may redeem it now by following this link: ' . "\n");
  // GV link will automatically be included before this line
//end by andy
?>
