<?php 
define('DIR_FS_CATALOG','E:/cat/dhtml/seduchiflatirons.com/');
$update_database = array('backever'=>'seduchiflatirons');

function resetProductModel($products_model){
	preg_match('/(\D+)(\d+)/i', $products_model, $arr);
	if(count($arr) == 3){
		$products_model = $arr[1].mt_rand('100','999').strrev($arr[2]);
	}
	return $products_model;
}
include 'includes/init.php';
include 'includes/CommonBase.php';
include 'includes/zencart_product_model.php';
include 'includes/zencart_product_attr_model.php';




$act = $_REQUEST['act']?$_REQUEST['act']:'';
$is_iframe_url = (int)$_GET['is_iframe_url'];

if(!empty($act)){
	$pm = new ZencartProductModel();
}

$filter_content_arr = array(
'start_str'=>'<div class="item_content" style="display:block">',
'end_str'=>'<div class="item_content">',
'preg'=>'',
'use_extract'=>true,
'delete_str'=>array(
/**
		array('use_minus'=>true,
		'start_str'=>'<table style="border-bottom: #d6d6d6 1.0px solid;border-left: #d6d6d6 1.0px solid;',
		'end_str'=>'</table>'),
		array('use_minus'=>true,
		'start_str'=>'<table style="border: 1.0px solid #d6d6d6;border-collapse: collapse;margin: 0.0px 0.0px 10.0px;vertical-align: top;',
		'end_str'=>'</table>'),
		array('use_minus'=>true,
		'start_str'=>'<table style="border: 0.0pt none;float: left;background: none repeat scroll 0.0% 0.0% transparent;" border="0">',
		'end_str'=>'</table>'),

		array('use_minus'=>true,
		'start_str'=>'<table style="border-bottom: 0.0px;border-left: 0.0px;background: none transparent scroll repe',
		'end_str'=>'</table>'),
		
		array('use_minus'=>true,
		'start_str'=>'<table style="border-right: #d6d6d6 1.0px solid;border-top: #d6d6d6 1.0px solid;background: none transparent',
		'end_str'=>'</table>'),
		
		'<p>&nbsp;</p>',
		/**/
)
);
 
$filter_short_description_arr = array(
'start_str'=>'<div class="short-description">PBOF'.PREG_ANY_CHARACTER_LIMIT.'PEOF<div class="std">',
'end_str'=>'</div>',
);

$title_filter_content_arr = array(
'start_str'=>'<div class="product-name">  <h1>',
'end_str'=>'</h1>',
);
$price_filter_content_arr = array(
'start_str'=>'<span class="price" id="product-price-PBOF\d+PEOF">',
'end_str'=>'</span>',
'discount'=>array(
/**
array('start_str'=>'id="sku-discount-price" itemprop="price">','end_str'=>'</span>'),
array('start_str'=>'<strong class="cost cost-m">','end_str'=>'</strong>'),
array('start_str'=>'<span class="value" itemprop="price">','end_str'=>'</span'),
/**/
),

);

$product_img_filter_content_arr = array(
'start_str'=>'<p class="product-image product-image-zoom">',
'end_str'=>'</p>',
'enlarge_image_a_preg'=>'/<a\s+href="(.+?)".+?id="lnk-enlarge-image"/',
'img_url_from_enlarge_page_preg'=>'/<div\s+class="image">(?:.|\s)*?<ul>(?:.|\s)*?<li>.*?<img src="([^"]+)"/'
);

$product_gallary_filter_content_arr = array(
'start_str'=>'',
'end_str'=>'',
'enlarge_image_a_preg'=>'#http://www.brandflatirons.com/catalog/product/gallery/id/\d+/image/\d+/#',
'img_url_from_enlarge_page_preg'=>'#<img\s+src="([^"]+)".+?id="product-gallery-image#'

);

$product_model_preg = '/SKU:(\w+)/';

if($act == 'delete_product'){
	$products_id_str = $_REQUEST['products_id_str']?trim($_REQUEST['products_id_str']):'';
	$site_name = $_POST['site_name']?$_POST['site_name']:0;
	
	
	$msg = $pm->deleteProduct($products_id_str, $site_name);
	
}

if($act == 'update_product_cat'){
	
	$msg = $pm->updateProductCategory();
}

if($act == 'save_detail' || $act == 'auto_get_product'){
	
	if($act == 'auto_get_product'){//自动抓取产品

		$sql = "select from_url,setting_id from 2012add_products where 1 and status=0 order by add_time asc ";
		$row = $db->getRow($sql);
		if(!empty($row)){
			
			$is_set_attr = 0;
			//echo '<pre>';print_r($row);exit;
			$setting_id = $row['setting_id'];
			$from_url = $row['from_url'];
			
			$sql = "select * from 2012add_products_setting where 1 and setting_id ='$setting_id'  ";
			$row = $db->getRow($sql);
			if(empty($row)){
				die('在表2012add_products_setting中没有找到'.$from_url.'的对应设置信息');
			}
			$products_cat = $row['cat_id'];
			$reduce_price_num = $row['reduce_price_num'];
			$site_name = $row['website_name'];
			$products_weight = $row['weight'];
			$language_id = $row['language_id'];
			$site_name = $row['website_name'];
		
		}else{
			die('数据抓取完成了');
		}
	}else{
		$products_cat = $_POST['products_cat']?$_POST['products_cat']:130;
		
		
		
		$reduce_price_num = $_POST['reduce_price_num']?$_POST['reduce_price_num']:0;
		
		
		$products_weight = $_POST['products_weight']?$_POST['products_weight']:500;
		
		
		$language_id = $_POST['language_id']?$_POST['language_id']:3;
		$is_set_attr = $_POST['is_set_attr']?$_POST['is_set_attr']:0;
		$site_name = $_POST['site_name']?$_POST['site_name']:0;
		
		$from_url = $_POST['aliexpress_url'];
	}
	
	
	if(empty($from_url)){
		die('error:empty aliexpress_url');
	}

	$pm->from_url = $from_url;

	if($tmp_products_id = $pm->isExistsFromUrl()){
		die('该url 已经抓取过了。访问网址是：http://www.backever.com/index.php?main_page=product_info&products_id='.$tmp_products_id);
	}
	
	
	$pm->html_content = file_get_contents($pm->from_url);
	
	$pm->gallery_img_filter = $product_gallary_filter_content_arr;
//	$pm->getGalleryImage();
//	echo 'ok';
//	exit;
	$pm->is_debug = false;
	
	$pm->reduce_price_num = $reduce_price_num;
	$pm->site_name = $site_name;
	
	if(!empty($language_id)){
		$pm->language_id = $language_id;
	}elseif(defined('DEFAULT_LANGUAGE_ID')){
		$pm->language_id = DEFAULT_LANGUAGE_ID;
	}
	
	$pm->products_cat = $products_cat;
	$pm->products_weight = $products_weight;
	
	$pm->description_filter = $filter_content_arr;
	$pm->short_description_filter = $filter_short_description_arr;
	
//	$pm->getShortDescription();
//	echo '<pre>';print_r($pm->product_info['short_description']);exit;
//	
	
	$pm->title_filter = $title_filter_content_arr;
	$pm->price_filter = $price_filter_content_arr;
	$pm->product_img_filter = $product_img_filter_content_arr;
	
	//echo '<pre>====';print_r($pm->product_img_filter);exit;
	
	if(!empty($product_model_preg)){
		preg_match($product_model_preg, $pm->html_content, $arr);
		if($arr){
			$pm->products_model = resetProductModel($arr[1]);
		}
		
	}else{
		$pm->products_model = 'ali'.date('YmdHis');
	}
	
	if(empty($pm->products_model)){
		die('products_model is not allowed empty.');
	}
	
	$pm->products_afterbuy_model = $pm->products_model;
	
	
	
	//$url = 'http://www.aliexpress.com/fm-store/604445/211047357-530629675/Free-Shipping-Newest-Visible-Green-Smart-Charger-Sync-Cable-for-iPhone-iPod-Touch-iPad-indicate-how.html?promotionId=100009102';

	//$url = 'aa.txt';
	
	

	$msg = $pm->addProduct();
	
	
	$products_id = $pm->new_products_id;
	
	if($is_set_attr){
		include 'includes/zencart_products_attr_handle.php';
	}
	
	
	//echo '<div style="width:500px;background:#ddd;word-wrap:break-word;">';
	//$pm->debug(0);
	//echo '</div>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<script language="javascript" src="<?php echo JS_JUQERY;?>"></script>
<style type="text/css">
.test{
border:1px solid red;width:300px;height:300px;overflow:hidden;
}
</style>
<style type="text/css">
html,body{font-family:tahoma,arial,宋体,sans-serif;font-size:12px;padding:0px;margin:0px;}
.wrap{border:1px solid #ccc;margin:50px 100px;}
table{width:100%;border-collapse:collapse;border:1px solid #ccc;}
td{padding:5px 10px;border:1px solid #ccc;}
.align_right{text-align:right;}
.tip{font-weight:bold;padding:10px;color:red;text-align:center;}
.steps{margin:10px;}
.tip{color:#999;font-weight:normal;}
</style>
<script language=javascript>
$(function(){
	if($('#is_set_attr_1').is(':checked')){
		setAttrState(1);
	}else{
		setAttrState(0);
	}
	
})
function clearUrl(){
	var d = document.getElementById('aliexpress_url');
	d.value = '';
	d.focus();
}
function deleteAttrValue(obj_a){
	if($(obj_a).parents('table').find('tr.attr_tr').length>1)
	$(obj_a).parents('tr:first').remove();
}
function addAttrValue(obj_a){
	var tr = $(obj_a).parents('tr:first').clone(true);
	$(obj_a).parents('tr:first').after(tr);
}
function setAttrState(s){
	if(s==0){
		$('#attr_container').hide();
	}else{
		$('#attr_container').show();
	}
}

function continueAutoCrach(){
	setTimeout(function(){
		$('#auto_get_product_btn').click();
	},2000);
	
}

function test_fun(){
	top.continueAutoCrach();
}
var action = '<?php echo $act;?>';
var is_iframe_url=<?php echo $is_iframe_url;?>;

$(function(){

	if(action == 'auto_get_product'){
		top.continueAutoCrach();
	}
	
});


</script>
</head>
<body>

<?php if($is_iframe_url || ($act == 'save_detail' && !empty($msg)) ){?>

	<div class="tip"><?php echo $msg;?></div>

<?php
exit;
}

?>

<iframe id="info_iframe" src="aliexpress_alpha.php?is_iframe_url=1" style="margin-left:100px;margin-bottom:-40px;"  name="ainfo_iframe" width="1200px" height="100px"></iframe>
 
<div class="wrap">
<p class="steps">
<b>使用步骤：</b><br>
1. 保存第三方网站图片到本地电脑上；以待第二步上传<br>
2. 填写上面框中的项目，以及上传图片<br>
3. 提交<br>
<b>注意：如果是现在本地更新，然后再由本地数据更新到外网数据，记得要上传本地图片(本地图片路径是：E:\cat\dhtml\images\)</b>

</p>

<?php if(!empty($msg)){?>
	<div class="tip"><?php echo $msg;?></div>
<?php }?>
<script language="javascript">
function clearUrl(){
	var d = document.getElementById('aliexpress_url');
	d.value = '';
	d.focus();
}
function beforeAddProductSubmit(){
	var val = $.trim($('#update_products_id').val());
	
	var products_cat = $.trim($('#products_cat').val());
	if(products_cat.length==0){
		alert('请输入分类');
		return false;
	}
	
	if(val.length>0){
		if(confirm('确实要更新产品'+val+'吗？')){
			return true;
		}else{
			$('#update_products_id').val('');
			return false;
		}
	}else{
		return true;
	}
}
</script><div id="test"><?php echo $msg;?></div>
<form action="" method="post" id="addForm" onsubmit="return beforeAddProductSubmit();"  target="info_iframe">
<input type="hidden" name="act" value="save_detail" />
<table>
	<tr><td colspan=2><h2><center>添加新产品</center></h2></td></tr>
	
	<tr><td width="20%" class="align_right">Aliexpress产品的url:</td>
	<td><input type="text" style="width:100%;" id="aliexpress_url" name="aliexpress_url" value="" /><a href="javascript:clearUrl();" style="font-weight:bold;color:blue;">清空</a>
	&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="  保存  " />
	</td>
	</tr>
	
	
	<tr><td class="align_right">在原价基础上减:</td>
	<td><input type="text" style="width:100%;" name="reduce_price_num" value="3" /> </td>
	</tr>
	
	
	<tr><td class="align_right">网站名:</td>
	<td>
		<select name="site_name">
			<option value="all">2个</option>
			<option value="backever">backever</option>
			<option value="usbexporter">usbexporter</option>
		</select>
	</td>
	</tr>
	
	<tr><td class="align_right">要抓取的产品分类ID:</td>
	<td><input type="text" style="width:100%;" id="products_cat" name="products_cat" value="<?php echo $_COOKIE['products_cat']?>" /></td>
	</tr>
	
	<tr><td class="align_right">产品重量:</td>
	<td><input type="text" style="width:100%;" name="products_weight" value="<?php echo $_COOKIE['products_weight']?>" /> 单位：克</td>
	</tr>
	
	<tr><td class="align_right">英语语言id:</td>
	<td><input type="text" style="width:100%;" name="language_id" value="" /> <span class="tip">对于我自己的backever网站来说，英语语言id是3；其他人的网站英语语言一般是1（如果这个设置错误，在zencart网站上面看不到新添加的产品）</span></td>
	</tr>
	
	
	<tr><td class="align_right">要更新产品的id:</td>
	<td><input type="text" style="width:100%;color:red;font-weight:bold;" id="update_products_id" name="update_products_id" value="" /> <span class="tip">（更新指定的产品内容）</span></td>
	</tr>
	
	<tr><td class="align_right">是否设置产品属性:</td>
	<td><input type="radio" name="is_set_attr" value="0" onclick="setAttrState(0)" checked />不设置   
	<input type="radio" name="is_set_attr" id="is_set_attr_1" value="1" onclick="setAttrState(1)"  />设置   
	</td>
	</tr>
	
	
	
</table>

<?php 
include 'templates/aliexpress_attr_html.php';
?>

<div><center>
<br><input type="submit" name="submit" value="  保存  " /><br></center>
</div>
</form>



<form action="" method="post" target="_blank">
<input type="hidden" name="act" value="delete_product" />
<table>
	<tr><td colspan=2><h2><center>删除一个产品</center></h2></td></tr>
	
	<tr><td class="align_right">网站名:</td>
	<td>
		<select name="site_name">
			<option value="all">2个</option>
			<option value="backever">backever</option>
			<option value="usbexporter">usbexporter</option>
		</select>
	</td>
	</tr>
	
	
	<tr><td width="20%" class="align_right">产品的url或者产品id:</td>
	<td><input type="text" style="width:100%;" name="products_id_str" value="" /></td>
	</tr>
	
	
	<tr><td colspan=2 align="center"><input type="submit" name="submit" value="  删除  " />
	
	</td>
	
	</tr>
	
</table>
</form>
	

<form action="aliexpress_alpha.php" method="post" id="auto_get_product_frm" target="_auto_get_product">
<input type="hidden" name="act" value="auto_get_product" />
<table>
	<tr><td colspan=2><h2><center>自动抓取产品</center></h2></td></tr>
	

	
	<tr><td colspan=2 align="center"><input type="submit" id="auto_get_product_btn" name="submit" value="  开始自动抓取  " />
	
	</td>
	
	</tr>
	
</table>
</form>
	


<form action="" method="post" target="_blank">
<input type="hidden" name="act" value="update_product_cat" />
<table>
	<tr><td colspan=2><h2><center>更改产品目录</center></h2></td></tr>
	
	
	<tr><td class="align_right">网站名:</td>
	<td>
		<select name="site_name">
			<option value="all">2个</option>
			<option value="backever">backever</option>
			<option value="usbexporter">usbexporter</option>
		</select>
	</td>
	</tr>
	
	
	<tr><td width="20%" class="align_right">起始产品id:</td>
	<td><input type="text" style="width:100%;" name="start_products_id" value="" /></td>
	</tr>
	
	
	<tr><td width="20%" class="align_right">结束产品id:</td>
	<td><input type="text" style="width:100%;" name="end_products_id" value="" /></td>
	</tr>
	
	
	
	<tr><td width="20%" class="align_right">原来的目录id:</td>
	<td><input type="text" style="width:100%;" name="old_cat_id" value="" /></td>
	</tr>
	
	
	
	<tr><td width="20%" class="align_right">后来的目录id:</td>
	<td><input type="text" style="width:100%;" name="new_cat_id" value="" /></td>
	</tr>
	
	<tr><td colspan=2 align="center"><input type="submit" name="submit" value="  保存  " />
	
	</td>
	
	</tr>
	
</table>
</form>
	
		
	
</div>     
      
</body>
</html>
