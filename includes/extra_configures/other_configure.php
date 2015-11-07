<?php 
  define('PID_VIEW_HISTORY_DAYS',3600*24*30); 
//for the page of main_page=new_recommend 
$recommend_new_products_listing_filtered_categories=array(1343,1343,1346);

//for the page of main_page=products_new
 define('NEW_PRODUCTS_LISTING_FITLERED_BY_CATEGORIES',false);
 $new_products_listing_filtered_categories=array(110,129);


  $main_page_content_chk=array('account','account_edit','account_history','account_newsletters','account_notification',
							   'account_password','address_book','address_book_process','checkout_success','checkout',
							   'contact_us','create_account_success','login','logoff','password_forgotten','site_map',
							   'shopping_cart','time_out','checkout_payment','checkout_shipping','products_tag','fec_confirmation',
							   'checkout_shipping_address','checkout_payment_address','account_notifications','account_history_info',
  'new_recommend'
  );
  $p_recommend_content_chk=array('index','product_info','login','products_new','shippinginfo','privacy','advanced_search_result',
							     'shopping_cart','products_tag','subscribe_confirm','subscribe','specials','about_us','conditions','account_notifications');
								 
  $bottom_tags_keyword_chk=array('index','product_info','logoff','products_new','conditions','shippinginfo',
							     'shopping_cart','specials','about_us','privacy','site_map','advanced_search_result');								 
  $china_shopping_service=array(243,244,245,246,247,248,249,250,251,252,253,254,255,256,257,258,259,260,261,262,263,264,265,266,279,280,281,282,283,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,299,300,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319,320,321,322,323,324,325,326,327,328,329,330,331,332,333,334,335,336,337,338,339,340,341,342,343,344,345,346,347,348,349,350,351,352,353,354,355,356,357,358,359,360,361,362,363,267,268,269,270,271,272,273,274,275,277,278,364,365,366,367,368,369,370,371,372,373,374,375,376,377,378,379,380,381,382,383,384,385);
  $wedding_shopping_service=array(466,467,490,468,469,470,471,472,473,474,475,477,480,481,483,484,259,260,263);			
  $tabletpc_shopping_service=array(130,131,132,145,235,492,185);
  $handy_shopping_service=array(111,112,113,115,116,117,118,119,120,121,122,123,124,125,126,127,128);
  
  define('PRODUCTS_REVIEW_PER_PAGE',10);
  define('DIG_COOKIE_SAVE_TIME',30);
  define('CATEGORIES_BANNER_DIR',DIR_WS_IMAGES.'banners/categories_banners/');
  define('PRICE_FILTER_CLASS',3);
  //set the default display order for products listing
  //6=products ordered desc
  //5=products ordered asc
  //4=date added desc 
  //3=date added asc
  //2=price desc
  //1=price asc
  define('DEFAULT_DISP_ORDER',6);
  define('SHIPPING_LONGER_TIME_TIP_ENABLED',true);
  define('GOOGLE_TRACKING_ENABLED',true);
//begin weixuefeng 20110408 
   define('AJAX_ADD_TO_CART_ENABLED',true);
   //end
?>
