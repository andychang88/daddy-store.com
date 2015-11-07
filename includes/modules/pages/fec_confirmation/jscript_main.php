<?php
/**
 * jscript_main
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: jscript_main.php 90 2009-08-27 21:57:47Z numinix $
 */
?>
<script type="text/javascript"><!--
var submitter = null;
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=320,screenX=150,screenY=150,top=150,left=150')
}

function couponpopupWindow(url) {
  window.open(url,'couponpopupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=320,screenX=150,screenY=150,top=150,left=150')
}

function submitFunction($gv,$total) {
   if ($gv >=$total) {
     submitter = 1; 
   }
}

function submitonce() {
  var button = document.getElementById("btn_submit");
  button.style.cursor="wait";
  button.disabled = true;
  //button.style.color = "red";
  setTimeout('button_timeout()', 4000);  
}
function button_timeout() {
  var button = document.getElementById("btn_submit");
  button.style.cursor="pointer";
  button.disabled = false;
}

// jquery for submit
<?php if (FEC_ONE_PAGE == 'true') { ?>
$(document).ready(function() {
  $("[name=fec_confirmation]").submit();
});
<?php } ?>
//--></script>
