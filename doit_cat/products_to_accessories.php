<?php
    //
	// +----------------------------------------------------------------------+
	// |Oasis International Gmbh  John                                 |
	// +----------------------------------------------------------------------+
	// | Copyright (c) 2003 The zen-cart developers                           |
	// |                                                                      |
	// | http://www.zen-cart.com/index.php                                    |
	// |                                                                      |
	// | Portions Copyright (c) 2003 osCommerce         
	// | Portions Copyright (c) 2003 zen-cart                          |
	// +----------------------------------------------------------------------+
	// | This source file is subject to version 2.0 of the GPL license,       |
	// | that is bundled with this package in the file LICENSE, and is        |
	// | available through the world-wide-web at the following url:           |
	// | http://www.zen-cart.com/license/2_0.txt.                             |
	// | If you did not receive a copy of the zen-cart license and are unable |
	// | to obtain it through the world-wide-web, please send a note to       |
	// | license@zen-cart.com so we can mail you a copy immediately.          |
	// +----------------------------------------------------------------------+
	//  $Id: products_to_accessories.php 2909 2010-06-04 13:51:35Z john $
      require('includes/application_top.php');
     
	  // verify products exist
	  /*$chk_products = $db->Execute("select * from " . TABLE_PRODUCTS . " limit 1");
	  if ($chk_products->RecordCount() < 1) {
		$messageStack->add_session(ERROR_DEFINE_PRODUCTS, 'caution');
		zen_redirect(zen_href_link(FILENAME_CATEGORIES));
	  }*/
	  $products_model_filter=isset($_GET['products_model_filter'])?$_GET['products_model_filter'] :$_POST['products_model_filter'];
	  $products_id_filter=isset($_GET['products_id_filter'])?$_GET['products_id_filter'] :$_POST['products_id_filter'];
	  
	  
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script type="text/javascript">
  <!--
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  }
  // -->
</script>
<!-- <body onload="init()"> -->
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->
</body>