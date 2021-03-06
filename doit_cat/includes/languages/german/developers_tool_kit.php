<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2004 The zen-cart developers                           |
// |                                                                      |
// |  http://www.zen-cart.at/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.at/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
//  $Id: developers_tool_kit.php 297 2008-05-29 21:16:41Z maleborg $
//
define('HEADING_TITLE', 'Developers Tool Kit');
define('TABLE_CONFIGURATION_TABLE', 'KONSTANTEN Definition suchen');
define('SUCCESS_PRODUCT_UPDATE_PRODUCTS_PRICE_SORTER', '<strong>Erfolgreiche</strong> Aktualisierung der Artikelpreis Sortierung');
define('ERROR_CONFIGURATION_KEY_NOT_FOUND', '<strong>Fehler:</strong> Keine passenden Konfigurationsschlüssel gefunden ...');
define('ERROR_CONFIGURATION_KEY_NOT_ENTERED', '<strong>Fehler:</strong> Kein Konfigurationsschlüssel oder Text eingegeben ... Suche abgebrochen');
define('TEXT_INFO_PRODUCTS_PRICE_SORTER_UPDATE', '<strong>Aktualisiere ALLE Artikelpreis Sortierungen</strong><br />damit nach angezeigtem Preis sortiert wird: ');
define('TEXT_CONFIGURATION_CONSTANT', '<strong>KONSTANTEN und LANGUAGE Definition suchen</strong>');
define('TEXT_CONFIGURATION_KEY', 'Schlüssel oder Name:');
define('TEXT_INFO_CONFIGURATION_UPDATE', '<strong>Anmerkung:</strong> KONSTANTEN groß schreiben!<br />Dateien werden erst durchsucht wenn nichts in der Datenbank gefunden werden konnte');
define('TABLE_TITLE_KEY', '<strong>Schlüssel:</strong>');
define('TABLE_TITLE_TITLE', '<strong>Titel:</strong>');
define('TABLE_TITLE_DESCRIPTION', '<strong>Beschreibung:</strong>');
define('TABLE_TITLE_GROUP', '<strong>Gruppe:</strong>');
define('TABLE_TITLE_VALUE', '<strong>Wert:</strong>');
define('TEXT_LOOKUP_NONE', 'Keine');
define('TEXT_INFO_SEARCHING', 'Durchsuche ');
define('TEXT_INFO_FILES_FOR', ' Dateien ... nach: ');
define('TEXT_INFO_MATCHES_FOUND', 'Anzahl gefundener Zeilen: ');
define('TEXT_LANGUAGE_LOOKUPS', 'Sprachdateien durchsuchen:');
define('TEXT_LANGUAGE_LOOKUP_CURRENT_LANGUAGE', 'Alle Sprachdateien für ' . strtoupper($_SESSION['language']) . ' - Webshop/Admin');
define('TEXT_LANGUAGE_LOOKUP_CURRENT_CATALOG', 'Alle Haupt-Sprachdateien - Webshop (' . DIR_WS_CATALOG . DIR_WS_LANGUAGES . 'english.php /espanol.php etc.)');
define('TEXT_LANGUAGE_LOOKUP_CURRENT_CATALOG_TEMPLATE', 'Alle Sprachdateien - Webshop ' . DIR_WS_CATALOG . DIR_WS_LANGUAGES . $_SESSION['language'] . '/*.php');
define('TEXT_LANGUAGE_LOOKUP_CURRENT_ADMIN', 'Alle Haupt-Sprachdateien - Admin (' . DIR_WS_ADMIN . DIR_WS_LANGUAGES . 'english.php /espanol.php etc.)');
define('TEXT_LANGUAGE_LOOKUP_CURRENT_ADMIN_LANGUAGE', 'Alle Sprachdateien -Admin (' . DIR_WS_ADMIN . DIR_WS_LANGUAGES . $_SESSION['language'] . '/*.php)');
define('TEXT_LANGUAGE_LOOKUP_CURRENT_ALL', 'Alle Sprachdateien - Webshop/Admin');
define('TEXT_FUNCTION_CONSTANT', '<strong>Funktionsdateien nach Funktionen und Texten durchsuchen</strong>');
define('TEXT_FUNCTION_LOOKUPS', 'Funktionsdateien durchsuchen:');
define('TEXT_FUNCTION_LOOKUP_CURRENT', 'Alle Funktionsdateien - Webshop/Admin');
define('TEXT_FUNCTION_LOOKUP_CURRENT_CATALOG', 'Alle Funktionsdateien - Webshop');
define('TEXT_FUNCTION_LOOKUP_CURRENT_ADMIN', 'Alle Funktionsdateien - Admin');
define('TEXT_CLASS_CONSTANT', '<strong>Klassendateien nach Klassen und Texten durchsuchen</strong>');
define('TEXT_CLASS_LOOKUPS', 'Klassendateien durchsuchen:');
define('TEXT_CLASS_LOOKUP_CURRENT', 'Alle Klassendateien - Webshop/Admin');
define('TEXT_CLASS_LOOKUP_CURRENT_CATALOG', 'Alle Klassendateien - Webshop');
define('TEXT_CLASS_LOOKUP_CURRENT_ADMIN', 'Alle Klassendateien - Admin');
define('TEXT_TEMPLATE_CONSTANT', '<strong>Templatedateien durchsuchen</strong>');
define('TEXT_TEMPLATE_LOOKUPS', 'Templatedateien durchsuchen:');
define('TEXT_TEMPLATE_LOOKUP_CURRENT', 'Alle Templatedateien - /templates sideboxes /pages etc.');
define('TEXT_TEMPLATE_LOOKUP_CURRENT_TEMPLATES', 'Alle Templatedateien - /templates');
define('TEXT_TEMPLATE_LOOKUP_CURRENT_SIDEBOXES', 'Alle Templatedateien - /sideboxes');
define('TEXT_TEMPLATE_LOOKUP_CURRENT_PAGES', 'Alle Templatedateien - /pages');
define('TEXT_ALL_FILES_CONSTANT', '<strong>Alle Dateien durchsuchen</strong>');
define('TEXT_ALL_FILES_LOOKUPS', 'Alle Dateien durchsuchen:');
define('TEXT_ALL_FILES_LOOKUP_CURRENT', 'Alle Dateien - Webshop/Admin');
define('TEXT_ALL_FILES_LOOKUP_CURRENT_CATALOG', 'Alle Dateien - Webshop');
define('TEXT_ALL_FILES_LOOKUP_CURRENT_ADMIN', 'Alle Dateien - Admin');
define('TEXT_INFO_NO_EDIT_AVAILABLE', 'Editieren nicht verfügbar');
define('TEXT_INFO_CONFIGURATION_HIDDEN', ' oder, versteckt');
define('TEXT_SEARCH_ALL_FILES', 'Durchsuche ALLE Dateien nach: ');
define('TEXT_SEARCH_DATABASE_TABLES', 'Durchsuche die Konfigurationstabellen in der Datenbank nach: ');
