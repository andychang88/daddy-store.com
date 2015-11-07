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

define('TEXT_RATHER_COWOA', 'For a faster checkout experience, we offer the option to checkout without creating an account.<br />');
define('COWOA_HEADING', 'Checkout Without An Account');

define('TEXT_RETURNING_CUSTOMER_SPLIT', '<strong>' . STORE_NAME . '</strong> account holders may login below.');

define('TEXT_PASSWORD_FORGOTTEN', 'Haben Sie Ihr Passwort vergessen?');

define('TEXT_LOGIN_ERROR', 'Fehler: Entschuldigung, es gibt Nichtübereinstimmung für die Email Adresse und/oder das Passwort.');
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
define('EMAIL_SUBJECT', 'Herzlich Willkommen bei ' . STORE_NAME . '!');
define('EMAIL_GREET_MR', 'Sehr geehrter Herr %s,' . "\n\n");
define('EMAIL_GREET_MS', 'Sehr geehrte Frau %s,' . "\n\n");
define('EMAIL_GREET_NONE', 'Sehr geehrte(r) Frau/Herr %s' . "\n\n");
define('EMALL_GREET','Dear firend'. "\n\n");
define('TEXT_EASY_SIGNUP_CUSTOMER_NAME','Guest');
// First line of the greeting
define('EMAIL_WELCOME', 'Herzlich Willkommen bei <strong>' . STORE_NAME . '</strong>.');
define('EMAIL_SEPARATOR', '--------------------');
define('EMAIL_COUPON_INCENTIVE_HEADER', 'Herzlichen Glückwunsch! Um Ihren nächsten Besuch in unserem Online Shop zu belohnen, haben wir für Sie einen Aktionskupon reserviert!' . "\n\n");
// your Discount Coupon Description will be inserted before this next define
define('EMAIL_COUPON_REDEEM', 'Diesen Aktionskupon können Sie bei Ihrem nächsten Einkauf einlösen. Geben Sie dazu die ' . TEXT_GV_REDEEM . ':<br /> %s während des Bestellvorgangs ein' . "\n\n");
define('TEXT_COUPON_HELP_DATE', '<p>Der Gutschen ist gültig zwischen %s und %s</p>');

define('EMAIL_GV_INCENTIVE_HEADER', 'Wenn Sie heute bei uns einkaufen, erhalten Sie den ' . TEXT_GV_NAME . ' für %s!' . "\n\n");
define('EMAIL_GV_REDEEM', 'Ihr ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM . ' im Wert von: %s ' . "\n\n" . 'Geben Sie dazu bitte den ' . TEXT_GV_REDEEM . ' während des Bestellvorgangs ein, nachdem Sie Ihre Artikel ausgesucht haben.' . "\n\n");
define('EMAIL_GV_LINK', 'Oder lösen Sie den Gutschein mithilfe des folgenden Links ein: ' . "\n\n");
// GV link will automatically be included before this line

define('EMAIL_GV_LINK_OTHER', 'Einmal angegeben, können Sie den ' . TEXT_GV_NAME . ' verwenden. Oder machen Sie mit dem ' . TEXT_GV_NAME . ' doch anderen eine Freude und schenken Ihn an Ihre Freunde weiter!' . "\n\n");

define('EMAIL_TEXT', 'Sie können ab sofort unsere umfangreichen Dienstleistungen in Anspruch nehmen, die wir für Sie bereit gestellt haben.' . "\n\n" . 'Einige unserer Highlights:' . "\n\n" . '<li><strong>Ihr permanenter Warenkorb: ' . "\n" . '</strong>Artikel, die Sie in Ihren Warenkorb gelegt haben, bleiben so lange darin erhalten,' . "\n" . 'bis Sie diese kaufen oder wieder aus dem Warenkorb entfernen.' . "\n\n" . '
<li><strong>Ihr persönliches Adressbuch: </strong>' . "\n" . 'Mit Ihrem persönlichen Adressbuch können Sie Ihre Einkäufe sofort und unkompliziert an eine andere Person senden.' . "\n" . 'Optimal, um z.B. Ihren Freunden ein Geburtstagsgeschenk zu machen!' . "\n\n" . '
<li><strong>Ihre persönliche Bestellhistorie: </strong>' . "\n" . 'Betrachten Sie in Ruhe Ihre gesamten Bestellvorgänge, die Sie hier in unseren Shop gemacht haben!' . "\n" . 'Ideal, um z.B. Rechnungskopien auszudrucken, oder um sich einfach einen Überblick zu verschaffen!' . "\n\n" . '
<li><strong>Bewertungen: </strong>' . "\n" . 'Teilen Sie uns und anderen Kunden Ihre Erfahrungen mit unseren Dienstleistungen und Artikeln mit!' . "\n\n\n" . '');
define('EMAIL_CONTACT', 'Sollten Sie einmal Hilfe zu unseren Diensten und Artikeln benötigen, kontaktieren Sie uns unter: <a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">' . STORE_OWNER_EMAIL_ADDRESS . '</a>' . "\n\n\n" . '');
define('EMAIL_GV_CLOSURE', 'Mit freundlichen Grüssen,' . "\n\n" . STORE_OWNER . "\nShopinhaber\n\n" . '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">' . HTTP_SERVER . DIR_WS_CATALOG . "</a>\n\n");

// email disclaimer - this disclaimer is separate from all other email disclaimers
define('EMAIL_DISCLAIMER_NEW_CUSTOMER', 'Diese E-Mail Adresse haben wir von Ihnen oder einer unserer Kunden erhalten. Sollten Sie diese Nachricht zu Unrecht erhalten haben, kontaktieren Sie uns bitte unter %s');
// eof
define('TEXT_LOGIN_PANEL_TITLE','Melden Sie sich an');

define('TEXT_NEW_ACCOUNT_TITLE','Ich bin ein neuer Kunde');
define('TEXT_NEW_ACCOUNT_DESC','Durch Ihre Anmeldung bei uns sind Sie in der Lage schneller zu bestellen, kennen jederzeit den Status Ihrer Bestellungen und haben immer eine aktuelle &Uuml;bersicht &uuml;ber Ihre bisher get&auml;tigten Bestellungen.');

define('TEXT_RETURNING_TITLE','Ich bin bereits Kunde');
define('TEXT_RETURNING_DESC','');
define('TEXT_EMAIL','eMail-Adresse:');
define('TEXT_PASSWORD','Passwort:');
define('TEXT_LOST_PASSWORD','Passwort vergessen?');
?>