<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2007 Numinix Technology http://www.numinix.com         |
// |                                                                      |
// | Portions Copyright (c) The Zen Cart Development Team                 |
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

//BREADCRUMB
define('NAVBAR_TITLE', 'Checkout');

//SECTION HEADINGS
define('HEADING_TITLE_ORDER_TOTAL', 'Your Order Total:');
define('HEADING_TITLE_SHIPPING', 'Lieferadresse'); 
define('HEADING_TITLE_PAYMENT', 'Zahlungsinformationen'); 
define('HEADING_TITLE_PAYMENT_VIRTUAL', 'Step 1 - Payment Information');

//TABLE HEADINGS
define('TABLE_HEADING_PAYMENT_METHOD', 'Payment Method');
define('TABLE_HEADING_SHIPPING_METHOD', 'Shipping Method'); 
define('TABLE_HEADING_COMMENTS', 'Besondere Anweisungen oder Kommentare bezüglich Ihrer Bestellung'); 
define('TABLE_HEADING_SHIPPING_ADDRESS', 'Shipping Adresse');
define('TABLE_HEADING_SHOPPING_CART', 'Warenkorb Inhalt');
define('TABLE_HEADING_BILLING_ADDRESS', 'Rechnungsadresse');
define('TABLE_HEADING_DROPDOWN', 'Drop Down Heading');
define('TABLE_HEADING_GIFT_MESSAGE', 'Gift Message');
define('TABLE_HEADING_FEC_CHECKBOX', 'Optional Checkbox');

//TITLES
define('TITLE_BILLING_ADDRESS', 'Billing Address:'); 
define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', '<strong>Continue to Step 3</strong>'); 
define('TITLE_CONTINUE_CHECKOUT_PROCEDURE_VIRTUAL', '<strong>Continue to Step 2</strong>'); 
define('TITLE_CONFIRM_CHECKOUT', '<strong>Bestätigen Sie bitte Ihre Bestellung</strong>');
define('TITLE_SHIPPING_ADDRESS', 'Shipping Information:'); 

//TEXT
define('TEXT_CHOOSE_SHIPPING_DESTINATION', 'Ihre Bestellung wird an die Adresse links versandt. Sie können die Lieferadresse ändern, indem Sie auf die Schaltfläche <em>Adresse &Auml;ndern</em> klicken.'); 
define('TEXT_SELECTED_BILLING_DESTINATION', 'Ihre Rechnungsadresse sehen Sie links. Sie können die Rechnungsadresse ändern, indem Sie auf die Schaltfläche <em>Adresse Ändern</em> klicken.'); 
define('TEXT_YOUR_TOTAL','Your Total'); 
define('TEXT_SELECT_PAYMENT_METHOD', 'Bitte wählen Sie eine Zahlungsmethode für diese Bestellung'); 
define('TEXT_SELECT_SHIPPING_METHOD','Bitte wählen Sie eine Versandmethode für diese Bestellung');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', "- by clicking 'continue checkout'"); 
define('TEXT_ENTER_SHIPPING_INFORMATION', 'Dies ist derzeit die einzige verfügbare Versandmethode für diese Bestellung zu verwenden.'); 
define('TEXT_CONFIRM_CHECKOUT', '- Klicken Sie auf „Zur Kassa“ um die Bestellung abzuschließen');
define('TEXT_FIELD_REQUIRED', '&nbsp;<span class="fieldRequired">* Required</span>');
define('TEXT_DROP_DOWN', 'Select an option: ');
define('TEXT_FEC_CHECKBOX', 'Signature Option?');

//ERROR MESSAGES DISPLAYED
define('ERROR_CONDITIONS_NOT_ACCEPTED', 'Please confirm the terms and conditions bound to this order by ticking the box below.'); 
define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Please select a payment method for your order.');
// eof
define('TEXT_NEW_ADDRESS','Bitte nutzen Sie dieses Formular, um eine neue Adresse für Ihre Bestellung zu erfassen');
define('TEXT_NEW_ADDRESS_TITLE','Neue Adresse');
define('TEXT_DATA_REQUIRED','* notwendige Informationen');
define('TEXT_COMPANY_TITLE','Firmendaten');
define('TEXT_COMPANY','Firmendaten');
define('TEXT_GENDER','Anrede:');
define('TEXT_FIRTNAME','Vorname:');
define('TEXT_LASTNAME','Nachname:');
define('TEXT_USTID','UstID:');
define('TEXT_ADDRESS','Ihre Adresse');
define('TEXT_STREET','Strasse/Nr.:');
define('TEXT_SUBURB','Stadtteil:');
define('TEXT_POSTCODE','Postleitzahl:');
define('TEXT_CITY','Ort:');
define('TEXT_ZONE','Zone');
define('TEXT_STATE','Bundesland:');
define('TEXT_COUNTRY','Land:');
define('TEXT_MORE_EXTRA_ADDRESS_DETAIL','Mehr Details(Klicken und Schreiben)');
define('TEXT_FINISH_ADDRESS','Füllen Lieferadresse');
?>