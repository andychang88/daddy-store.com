<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @translator: cyaneo/hugo13/wflohr	http://www.zen-cart.at	2006-11-02
 * @version $Id: meta_tags.php 293 2008-05-28 21:10:40Z maleborg $
 */

// page title
define('TITLE', 'eFox-shop');

// Site Tagline
define('SITE_TAGLINE', 'China handy Großhandel,Handyshop für Dual Sim Handy,Tablet PC,CECT Handys efox-shop.com');
// Custom Keywords
define('CUSTOM_KEYWORDS', '');
// Home Page Only:
  define('HOME_PAGE_META_DESCRIPTION', 'Efox-shop der beste Handyshop für Dual Sim handy,Tablet PC,CECT Handys und Handy Zubehöre-China handy Großhandel,Handy ohne Vertrag.');
  define('HOME_PAGE_META_KEYWORDS', 'China handys,Handyshop,China handy Großhandel,dual sim handy,Tablet PC,CECT,Handy Zubehöre');

  // NOTE: If HOME_PAGE_TITLE is left blank (default) then TITLE and SITE_TAGLINE will be used instead.
  define('HOME_PAGE_TITLE', 'China handy Großhandel,Dual sim Handy,Tablet PC,Brautkleider,Handy Shop efox-shop.com'); // usually best left blank
//added by john for SEO Modification 4/6
define('TOP_LOGO_ALT','handyshop efox-shop.com');
define('TOP_BANNER_ALT','RC Modellbau Shop,Modellbau onlineshop');
define('TOP_HEAD_H1_TITLE_HOME_PAGE','RC Modellbau, RC Modellbau Shop');

// EZ-Pages meta-tags.  Follow this pattern for all ez-pages for which you desire custom metatags. Replace the # with ezpage id.
// If you wish to use defaults for any of the 3 items for a given page, simply do not define it. 
// (ie: the Title tag is best not set, so that site-wide defaults can be used.)
// repeat pattern as necessary
  define('META_TAG_DESCRIPTION_EZPAGE_#','');
  define('META_TAG_KEYWORDS_EZPAGE_#','');
  define('META_TAG_TITLE_EZPAGE_#', '');

// Per-Page meta-tags. Follow this pattern for individual pages you wish to override. This is useful mainly for additional pages.
// replace "page_name" with the UPPERCASE name of your main_page= value, such as ABOUT_US or SHIPPINGINFO etc.
// repeat pattern as necessary
  define('META_TAG_DESCRIPTION_page_name','');
  define('META_TAG_KEYWORDS_PAGE_page_name','');
  define('META_TAG_TITLE_PAGE_page_name', '');
  
  //added for SEO (about us page)
  define('META_TAG_DESCRIPTION_ABOUT_US','China handy Anbieter, eine große Menge von handy Speicherung,Ipad Anbieter,IPAD Speicherung,handy kaufen von handy laden, China Handys Shop ,Service und handy website');
  define('META_TAG_KEYWORDS_ABOUT_US','handy Anbieter,handy laden,handy restposten,Ipad Anbieter handy kaufen');
  define('META_TAG_TITLE_ABOUT_US', 'eFox-shop:handy laden,handy Anbieter,handy restposten Ipad Anbieter,IPAD restposten  handy website');
  //added for SEO (shopping cart page)
  define('META_TAG_DESCRIPTION_SHOPPING_CART','Mobilfunk handy shop, China Mobilfunk ,günstig Mobilfunk kaufen , Großhandel Mobilfunk Willkommen! zugesetzt Shopping cart im efox-shop.com.');
  define('META_TAG_KEYWORDS_SHOPPING_CART','Mobilfunk shop, China Mobilfunk, günstig Mobilfunk');
  define('META_TAG_TITLE_SHOPPING_CART', 'Shopping cart -China Mobilfunk ,Mobilfunk shop efox-shop.com');
  
  define('META_TAG_DESCRIPTION_PRIVACY','Wifi Mobilfunk, billige Windows Mobilfunk, handyshop Gps Mobilfunk,TV Mobilfunk im efox-shop.com privacy.');
  define('META_TAG_KEYWORDS_PRIVACY','Wifi Mobilfunk, billige Windows Mobilfunk, Gps Mobilfunk, TV Mobilfunk');
  define('META_TAG_TITLE_PRIVACY', 'privacy - Wifi Mobilfunk, billige Windows Mobilfunk,TV Mobilfunk i efox-shop.com');
  
  define('META_TAG_DESCRIPTION_SHIPPINGINFO','wir Chinese Mobilfunk, handy Mobilfunk laden, handyshop Mobilfunk website And accept the following credit cards for online or phone purchases. ');
  define('META_TAG_KEYWORDS_SHIPPINGINFO','Chinese Mobilfunk, Mobilfunk website, Mobilfunk handyshop laden');
  define('META_TAG_TITLE_SHIPPINGINFO', 'shippinginfo - Chinese handyshop Mobilfunk, Mobilfunk laden, china Mobilfunk website efox-shop.com.');
  
  define('META_TAG_DESCRIPTION_GROSSHANDEL','efox-shop.com bietet eine hohe Qualität zum günstigen Preis. Starten Sie jetzt mit unserem China handyshop Großhandel-Zentrum!');
  define('META_TAG_KEYWORDS_GROSSHANDEL','Großhandel,Großhändeler,Großhandel Produkte');
  define('META_TAG_TITLE_GROSSHANDEL', 'efox-shop.com China Großhandel handyshop -Zentrum');
  
  define('META_TAG_DESCRIPTION_PRODUCTS_NEW','Mobilfunk  Anbieter,handy mobilfunk restposten,Chinesische handy Mobilfunk Handyverträge exclusiv bei uns zu erwerben im efox-shop.com');
  define('META_TAG_KEYWORDS_PRODUCTS_NEW','Mobilfunk Anbieter,Mobilfunk  restposten,Chinesische handy Mobilfunk');
  define('META_TAG_TITLE_PRODUCTS_NEW', 'Neue Artikel - Chinesische Mobilfunk, Mobilfunk handy restposten efox-shop.com');
  
  define('META_TAG_DESCRIPTION_CONTACT_US','eFox-shop : Wir Abverkauf Mobilfunk Mit Dual Sim of China Mobilfunk hersteller, Chinesische Mobilfunk marken: Wenn Sie Frage, Anregungen oder Vorschläge haben, bitte wenden Sie sich an unseren Kundenservice.');
  define('META_TAG_KEYWORDS_CONTACT_US','China Mobilfunk hersteller, Chinesische handyshop Mobilfunk marken, Mobilfunk Mit Dual Sim');
  define('META_TAG_TITLE_CONTACT_US', 'contact us - China Mobilfunk hersteller, Mobilfunk Mit Dual Sim im efox-shop');
// Review Page can have a lead in:
define('META_TAGS_REVIEW', 'Bewertungen: ');

// separators for meta tag definitions
// Define Primary Section Output
define('PRIMARY_SECTION', ' : ');

// Define Secondary Section Output
define('SECONDARY_SECTION', ' - ');

// Define Tertiary Section Output
define('TERTIARY_SECTION', ', ');

// Define divider ... usually just a space or a comma plus a space
define('METATAGS_DIVIDER', ' ');

// Define which pages to tell robots/spiders not to index
// This is generally used for account-management pages or typical SSL pages, and usually doesn't need to be touched.
define('ROBOTS_PAGES_TO_SKIP','login,logoff,create_account,account,account_edit,account_history,account_history_info,account_newsletters,account_notifications,account_password,address_book,advanced_search,advanced_search_result,checkout_success,checkout_process,checkout_shipping,checkout_payment,checkout_confirmation,cookie_usage,create_account_success,contact_us,download,download_timeout,customers_authorization,down_for_maintenance,password_forgotten,time_out,unsubscribe,info_shopping_cart,popup_image,popup_image_additional,product_reviews_write,ssl_check');


// favicon setting
// There is usually NO need to enable this unless you wish to specify a path and/or a different filename
define('FAVICON','images/favicon.ico');
?>