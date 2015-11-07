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
define('TITLE', STORE_NAME);

// Site Tagline
define('SITE_TAGLINE', 'Android Tablet PC Android Mobile Phone Car DVD Player Dropship Electronics');
// Custom Keywords
define('CUSTOM_KEYWORDS', '');
// Home Page Only:
  define('HOME_PAGE_META_DESCRIPTION', 'Buy Tablet PC, iPad, Android Tablet, UMPC, Netbook, Dual Sim Phone, PS3 Break, Hiphone, Wifi Watch Phones,Car DVD Players,Surveillance Camera, Jailbreak PS3, OBD2, aPad iRobot, ePad, Wopad.');
  define('HOME_PAGE_META_KEYWORDS', 'Tablet PC, aPad ,ePad ,iPad, Android Tablet, UMPC, Netbook, Hiphone , Dual Sim Phone, Wifi Unlocked Watch Phones, PS3 Break , Jailbreak PS3, OBD2, Spay Camera, Surveillance Camera, Laser Pointer, E-Cigarette');

  // NOTE: If HOME_PAGE_TITLE is left blank (default) then TITLE and SITE_TAGLINE will be used instead.
  define('HOME_PAGE_TITLE', ''); // usually best left blank
//added by john for SEO Modification 4/6
define('TOP_LOGO_ALT',STORE_NAME);
define('TOP_BANNER_ALT','RC model shop, model shop online');
define('TOP_HEAD_H1_TITLE_HOME_PAGE','RC Model, RC Model Shop');


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
  define('META_TAG_TITLE_ABOUT_US', 'handy laden,handy Anbieter,handy restposten Ipad Anbieter,IPAD restposten  handy website');
// Review Page can have a lead in:
define('META_TAGS_REVIEW', 'Reviews: ');

// separators for meta tag definitions
// Define Primary Section Output
define('PRIMARY_SECTION', ' ');

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
