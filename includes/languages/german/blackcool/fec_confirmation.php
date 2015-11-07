<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: fec_confirmation.php 88 2009-08-27 21:03:25Z numinix $
 */

define('NAVBAR_TITLE_1', 'Checkout');
define('NAVBAR_TITLE_2', 'Bestätigung');

define('HEADING_TITLE', 'Step 3 of 3 - Order Confirmation');

define('HEADING_BILLING_ADDRESS', 'Rechnungsadresse');
define('HEADING_DELIVERY_ADDRESS', 'Shipping Adresse');
define('HEADING_SHIPPING_METHOD', 'Versandmethode:');
define('HEADING_PAYMENT_METHOD', 'Zahlungsmethode:');
define('HEADING_PRODUCTS', 'Warenkorb Inhalt');
define('HEADING_TAX', 'Tax');
define('HEADING_ORDER_COMMENTS', 'Besondere Anweisungen oder Kommentare für Bestellung');
// no comments entered
define('NO_COMMENTS_TEXT', 'None');
define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', '<strong>Letzter Schritt</strong>');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', '- weiterhin um Ihre Bestellung zu bestätigen. Danke!');

define('OUT_OF_STOCK_CAN_CHECKOUT', 'Products marked with ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' are out of stock.<br />Items not in stock will be placed on backorder.');
//added by john 2010-08-12
define('FEC_CHECKOUT_CONFIRMATION_TEXT2','Ihre Bestellung ist in Bearbeitung, bitte warten Sie mal…');
// eof
?>