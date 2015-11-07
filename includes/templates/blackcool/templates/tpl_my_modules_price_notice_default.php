<?php

?>

<div id="price_notice_box" class="reprice center_price_notice">
 <div class="price_notice_box_bg">
	<h2><?php echo HEAD_PRICE_NOTICE;?></h2>
	<table width="100%">
	<tr><td class="pn_right"><?php echo PLEASE_INPUT_YOUR_EMAIL;?>:</td><td><input type="text"  id="my_email" name="my_email" class="event_style_a"></td></tr>
	<tr><td class="pn_right"><?php echo PLEASE_INPUT_YOUR_PRICE;?>:</td><td><input type="text" id="my_price" name="my_price" class="event_style_a"></td></tr>
	
	<tr><td class="pn_center" colspan=2>
	<input type="button" style="*padding-top:5px;" value=" <?php echo PRICE_NOTICE_BTN_SUBMIT;?> " onclick="sendPriceNotice('<?php echo $products_afterbuy_model?$products_afterbuy_model:'';?>');" class="repbtn" name="">
	&nbsp;&nbsp;&nbsp;&nbsp; <input  style="*padding-top:5px;" onclick="priceNotice('',1);" type="button" value=" <?php echo PRICE_NOTICE_BTN_CLOSE;?> " class="repbtn">
	</td></tr>
	</table>
	
     </div>
</div>

<style type="text/css">
#add_to_fav,#add_to_login,#price_notice{border:0 none;}
.reprice {font-size:11px; border:1px solid #83ABC6; 
width:330px;height:160px;margin:-120px 0px 0px -165px;
text-transform:capitalize; line-height:22px;
background:#fff;display:none;
}
.price_notice_box_bg{
padding-bottom:10px;background:url(<?php echo DIR_WS_IMAGES?>bg_ico.gif) no-repeat 190px 10px;
}
.price_notice_box_bg .pn_right{
text-align:right;padding:8px;
}
.price_notice_box_bg .pn_center{
text-align:center;padding-top:8px;
}
.color666 {color:#666;}
.aligncenter { text-align:center;}
.reprice h2 { font-size:14px; font-weight:bold; height:30px; line-height:30px; padding-left:10px;}
.repinput {margin-left:10px; margin-top:10px;float:left;clear:both;}
.repbtnC input { width:150px; vertical-align:middle; padding:2px 3px; border:1px solid #83ABC6; margin-right:10px;}
.repinput span {display:block; float:left;}
.reptext { width:100px; text-align:right; padding-right:10px;}
.reprice .repbtn {color:#004B91;}
.reprice .repbtnC{text-align:center;margin-top:2px;}

.center_price_notice{
position:fixed;left:50%;top:50%;_position:absolute;z-index:1000;
_top:expression(function(){return parseInt(document.documentElement.clientHeight)/2 + parseInt(document.documentElement.scrollTop);}());
_left:expression(function(){return parseInt(document.documentElement.clientWidth)/2 + parseInt(document.documentElement.scrollLeft);}());

}
</style>
