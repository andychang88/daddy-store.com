<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @translator: cyaneo/hugo13/wflohr	http://www.zen-cart.at	2006-11-02
 * @version $Id: time_out.php 293 2008-05-28 21:10:40Z maleborg $
 */

define('NAVBAR_TITLE','Time out');
define('HEADING_TITLE','Ups! Ihre Session ist abgelaufen.');
define('HEADING_TITLE_LOGGED_IN', 'Sie sind bei Ihrem Konto angemeldet und können nun weiter einkaufen. Wählen Sie einen Menüpunkt aus.');
define('TEXT_INFORMATION','Es tut uns leid, aber aus Sicherheitsgründen mussten wir Ihre Verbindung unterbrechen,
um Unbefugten nicht die Möglichkeit zu bieten, an Ihre Zugangsdaten zu gelangen.
  <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">Anmeldung</a>
  Ihr Warenkorb wird wiederhergestellt'.
  (DOWNLOAD_ENABLED == 'true' ? ', Sie hatten Download-Artikel und möchte diese(n) erhalten' : '') . ',
  Gehen Sie bitte zu <a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">Mein Konto</a> um Ihre Bestellung anzusehen.');
define('TEXT_INFORMATION_LOGGED_IN', 'Sie sind bei Ihrem Konto angemeldet und können nun weiter einkaufen. Wählen Sie einen Menüpunkt aus.');
define('HEADING_RETURNING_CUSTOMER', 'Anmelden');
define('TEXT_PASSWORD_FORGOTTEN', 'Password vergessen?');
?>