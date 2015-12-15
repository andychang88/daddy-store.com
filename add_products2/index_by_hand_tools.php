<?php 
include 'includes/init.php';
include 'includes/CommonBase.php';
include 'includes/zencart_product_model.php';
include 'includes/zencart_product_attr_model.php';

$act = $_REQUEST['act']?$_REQUEST['act']:'';
$is_iframe_url = (int)$_GET['is_iframe_url'];
$url_is_cat = $_REQUEST['url_is_cat'];


if(!empty($act)){
	$pm = new ZencartProductModel();
}


$sql = "select smt_account from 2012add_products_setting  group by  smt_account";
$setting_smt_account = $db->getAll($sql);

		
if($act == 'product_url_get_img_url'){
	$url = $_REQUEST['product_url']?($_REQUEST['product_url']):'';
	$content = file_get_contents($url);
	preg_match('/<meta\s+property="og:image"\s+content="([^"]+)"/i', $content, $arr);
	
	if($arr){
		$product_url_get_img_url = $arr[1];
	}else{
		$product_url_get_img_url = 'not found';
	}
	
}	

if($act == 'resetProductImg'){
	$products_id = $_REQUEST['products_id']?(int)($_REQUEST['products_id']):'';
	$products_image_url = trim($_REQUEST['products_image']);
	$products_image_url = preg_replace('/\?.*/i', '', $products_image_url);
	
	$sql = "select products_image from products where products_id= ".$products_id;
	$old_products_image = $db->getOne($sql);
	if( is_file(IMAGE_PATH . $old_products_image) ){
		@unlink(IMAGE_PATH . $old_products_image);
	}
	
	$new_products_image = date('Ymd').'/'.date('YmdHis').strrchr($products_image_url,'.');
	if( !is_dir(dirname(IMAGE_PATH.$new_products_image)) ){
		@mkdir(dirname(IMAGE_PATH.$new_products_image), 0777, true);
	}
	
	if( !is_file(IMAGE_PATH.$new_products_image) ){//如果文件不存在，再保存
		file_put_contents( IMAGE_PATH.$new_products_image, http_request($products_image_url));
	}
	
	//处理产品小缩略图（其他图片）
	$little_images = $_REQUEST['little_image'];
	if ($little_images) {
		foreach ($little_images as $key=>$little_img){
			
			$little_img = preg_replace('/\?.*/i', '', $little_img);
			
			$suffix = strrchr($new_products_image,'.');
			$little_img_path = substr($new_products_image, 0, strpos($new_products_image, $suffix)).'_'.($key+1).$suffix;
			
			if( !is_file(IMAGE_PATH.$little_img_path) ){//如果文件不存在，再保存
				file_put_contents( IMAGE_PATH.$little_img_path, http_request($little_img));
			}
		}
	}
	
	$sql = "update products set products_image='{$new_products_image}' where products_id=".$products_id;
	echo $sql.'<br>';
	$db->query($sql);
	echo "finish<br>";
	
	die($msg);
	
}
	
if($act == 'delete_product'){
	$products_id_str = $_REQUEST['products_id_str']?trim($_REQUEST['products_id_str']):'';
	
	
	
	$pm = new ZencartProductModel();
	$msg = $pm->deleteProduct($products_id_str);
	
	echo "finish<br>";
	
	die($msg);
	
}



if($act == 'move_product_cat'){
	
	$msg = $pm->moveProductCategory();
	echo "finish<br>";
	
	die($msg);
}
if($act == 'del_product_cat'){
	
	$msg = $pm->delProductCategory();
	echo "finish<br>";
	
	die($msg);
}
if($act == 'del_product_in_cat'){
	
	$msg = $pm->delProductInCategory();
	echo "finish<br>";
	
	die($msg);
}

if($act == 'open_ali_url'){
	
	$products_id = preg_replace("/\D/","",$_REQUEST['products_id']);
	if(empty($products_id)){
		die("empty products_id");
	}
	
	$url = 'http://www.aliexpress.com/item/title/'.$products_id.'.html';
	header("location:".$url);
	exit;
	
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
	
	$('#save_to_cache').click(function(){
		$('#hide_act').val('save_product_to_cache');
		$('#add_form_submit').click();
		
		
	})
	
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


 
<div class="wrap">


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
function setDefaultFormAction(){
	$('#hide_act').val('save_detail');
}
function addProductImage(){
	var main_image = $('#products_image');
	var little_image = main_image.clone(true);

	var count_little_img = $('input[name="little_image\[\]"]').length;
	var little_img_id = 'little_image'+(count_little_img * 1 + 1);
	
	little_image.attr('name', 'little_image[]');
	little_image.attr('id', little_img_id);
	little_image.val('');
	
	main_image.parent().append(little_image);
	main_image.parent().append('<a href="javascript:void(0);" style="color:red;" onclick="$(\'#'+little_img_id+'\').remove();$(this).remove();">&nbsp;&nbsp;删除该子图</a>');
}
</script><div id="test"><?php echo $msg;?></div>
<form action="" method="post" id="addForm" onsubmit="return beforeAddProductSubmit();"  target="info_iframe1111111">
<input type="hidden" name="act" id="hide_act" value="save_detail" />


<?php 
//include 'templates/aliexpress_attr_html.php';
?>



<div><center>
<br><input type="button" style="display: none;" name="save_to_cache" id="save_to_cache" value=" 保存该分类下的产品到缓存   " /><br></center>
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
	
	
	<form action="" method="post" target="_blank">
<input type="hidden" name="act" value="resetProductImg" />
<table>
	<tr><td colspan=2><h2><center>重新抓取产品图片</center></h2></td></tr>
	
	<tr><td width="20%" class="align_right">产品id:</td>
	<td><input type="text" style="width:100%;" name="products_id" value="" /></td>
	</tr>
	
	
	<tr><td class="align_right">主图片地址:<br><a href="javascript:addProductImage();">添加子图</a></td>
	<td><input type="text" style="width:90%;" name="products_image"  id="products_image" value="<?php echo $products_image;?>" /></td>
	</tr>
	
	
	<tr><td colspan=2 align="center"><input type="submit" name="submit" value="抓取" />
	
	</td>
	
	</tr>
	
</table>
</form>



	<form action="" method="post" target="_self">
<input type="hidden" name="act" value="product_url_get_img_url" />
<table>
	<tr><td colspan=2><h2><center>产品url获取图片地址</center></h2></td></tr>
	
	<tr><td width="20%" class="align_right">产品url:</td>
	<td><input type="text" style="width:100%;" name="product_url" value="" /></td>
	</tr>
	
	<tr><td width="20%" class="align_right">图片地址:</td>
	<td><input type="text" style="width:100%;" name="img_url" value="<?php echo $product_url_get_img_url;?>" /></td>
	</tr>
	
	<tr><td colspan=2 align="center"><input type="submit" name="submit" value="提交" />
	
	</td>
	
	</tr>
	
</table>
</form>



	
<form action="" method="post" target="_blank">
<input type="hidden" name="act" value="del_product_cat" />
<table>
	<tr><td colspan=2><h2><center>删除目录</center></h2></td></tr>
	
	
	
	
	
	
	<tr><td width="20%" class="align_right">需要删除的目录id:</td>
	<td><input type="text" style="width:100%;" name="cat_id" value="" /></td>
	</tr>
	
	<tr><td colspan=2 align="center"><input type="submit" name="submit" value="  保存  " />
	
	</td>
	
	</tr>
	
</table>
</form>
		
	<form action="" method="post" target="_blank">
<input type="hidden" name="act" value="del_product_in_cat" />
<table>
	<tr><td colspan=2><h2><center>删除目录下的产品</center></h2></td></tr>
	
	
	
	
	
	
	<tr><td width="20%" class="align_right">需要删除的产品所在目录id:</td>
	<td><input type="text" style="width:100%;" name="cat_id" value="" /></td>
	</tr>
	
	<tr><td colspan=2 align="center"><input type="submit" name="submit" value="  保存  " />
	
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
	

<form action="aliexpress_alpha.php" method="post" id="save_product_to_cache_frm" target="save_product_to_cache">
<input type="hidden" name="act" value="save_product_to_cache" />
<table>
	<tr><td colspan=2><h2><center>保存外部产品到缓存</center></h2></td></tr>
	
	<tr><td width="20%" class="align_right">外部产品的url:</td>
	<td><input type="text" style="width:100%;" name="products_url" value="" /></td>
	</tr>
	
	<tr><td width="20%" class="align_right">自己网站的目录ID:</td>
	<td><input type="text" style="width:100%;" name="cat_id" value="" /></td>
	</tr>
	
	
	
	<tr><td class="align_right">SMT账号:</td>
	<td>
		<select name="smt_account">
			<option value="">请选择</option>
			<option selected=selected value="SMTN">SMTN</option>
			<option value="usbexporter">usbexporter</option>
		</select>
	</td>
	</tr>
	
	

	
	<tr><td colspan=2 align="center"><input type="submit" id="save_product_to_cache_btn" name="submit" value="  提交  " />
	
	</td>
	
	</tr>
	
</table>
</form>




<form action="" method="post" target="_blank">
<input type="hidden" name="act" value="move_product_cat" />
<table>
	<tr><td colspan=2><h2><center>在目录之间中移动产品</center></h2></td></tr>
	
	
	
	
	
	<tr><td width="20%" class="align_right">是否禁用旧的目录:</td>
	<td><input type="checkbox" checked  name="is_disable_old_cat" value="0" /></td>
	</tr>
	
	
	
	<tr><td width="20%" class="align_right">产品ID:</td>
	<td><input type="text" style="width:80%;" name="product_ids" value="" />(多个产品用英文逗号隔开;如果要移动两个产品id之间的产品。2个产品id使用-隔开)</td>
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



<form action="" method="post" target="_blank">
<input type="hidden" name="act" value="open_ali_url" />
<table>
	<tr><td colspan=2><h2><center>打开速卖通产品</center></h2></td></tr>
	
	
	
	
	<tr><td width="20%" class="align_right">速卖通产品id:</td>
	<td><input type="text" style="width:100%;" name="products_id" value="" /></td>
	</tr>
	
	
	<tr><td colspan=2 align="center"><input type="submit" name="submit" value="  保存  " />
	
	</td>
	
	</tr>
	
</table>
</form>
		
	
</div>     
      
</body>
</html>
