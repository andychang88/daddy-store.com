<?php 

include 'includes/init.php';
include 'includes/add_product_base.php';
include 'includes/product_attr_model.php';

$act = $_REQUEST['act']?$_REQUEST['act']:'';

//getAttrValues
if($act == 'getAttrValues'){
	$attr_id = $_REQUEST['attr_id']?$_REQUEST['attr_id']:'0';
	$attr_model = new ProductAttrModel();
	$attr_values = $attr_model ->getAttributeValues($attr_id);
	
	$result = array('status'=>'success', 'content'=>$attr_values);
	die(json_encode($result));
	
}
 
if($act == 'save_detail'){
	$is_added_by_hand = true;
	include 'add_product_init.php';
	
	$is_set_attr = $_POST['is_set_attr']?$_POST['is_set_attr']:0;
	
	
	/**/
	//产品主图----begin
	//产品图片前面不能有images/
	$products_image = trim($_REQUEST['products_image']);
	
	//如果输入的产品图片是外站的url
	if(preg_match("#^http(s?)://#", $products_image)){
		$new_products_image = date('Ymd').'/'.date('YmdHis').strrchr($products_image,'.');
		if( !is_dir(dirname(IMAGE_PATH.$new_products_image)) ){
			@mkdir(dirname(IMAGE_PATH.$new_products_image), 0777, true);
		}
		
		if( !is_file(IMAGE_PATH.$new_products_image) ){//如果文件不存在，再保存
			file_put_contents( IMAGE_PATH.$new_products_image, http_request($products_image));
		}
		
		$insert_product['products_image'] = $new_products_image;
	}
	
	if(empty($insert_product['products_image'])){
		$insert_product['products_image'] = $products_image;
	}
	
	
	//处理产品小缩略图（其他图片）
	$little_images = $_REQUEST['little_image'];
	if ($little_images) {
		foreach ($little_images as $key=>$little_img){
			$suffix = strrchr($insert_product['products_image'],'.');
			$little_img_path = substr($insert_product['products_image'], 0, strpos($insert_product['products_image'], $suffix)).'_'.($key+1).$suffix;
			
			if( !is_file(IMAGE_PATH.$little_img_path) ){//如果文件不存在，再保存
				file_put_contents( IMAGE_PATH.$little_img_path, http_request($little_img));
			}
		}
	}
	
	
	$insert_product['products_image'] = preg_replace('#^/?images?/#i', '', $insert_product['products_image']);
	if(strlen($insert_product['products_image'])>=64){
		$new_products_image = dirname($insert_product['products_image']).'/'.date('YmdHis').strrchr($insert_product['products_image'],'.');
		@rename(IMAGE_PATH.$insert_product['products_image'], IMAGE_PATH.$new_products_image);
		$insert_product['products_image'] = $new_products_image;
	}
	
	$insert_product['products_model'] = $_REQUEST['products_model'];
	$insert_product['products_afterbuy_model'] = $_REQUEST['products_model'];
	$insert_product['products_price'] = $_REQUEST['products_price'];
	
	$products_cat = $_REQUEST['products_cat'];
	//产品主图----end
	$insert_product_desp['language_id'] = $_REQUEST['language_id'];
	$insert_product_desp['products_name'] = addslashes($_REQUEST['products_name']);
	$insert_product_desp['products_description'] = addslashes($_REQUEST['products_description']);
	$insert_product_desp['products_short_description'] = addslashes($_REQUEST['products_short_description']);
	
	$site_name = 'all';
	
	//添加记录
	$products_id = addProductBackEver(	array(
	'products'=>$insert_product,
	'site_name'=>$site_name,
	'products_description'=>$insert_product_desp,
	'categories_id'=>$products_cat));
	
	$msg='添加产品成功。';
	
	if($is_set_attr){
		include 'includes/aliexpress_attr_handle.php';
	}
	
	
}

$FCKeditor = create_html_editor('products_description','');
$FCKeditor_short_desp = create_html_editor('products_short_description','',160);    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>add product</title>
<script language="javascript" src="<?php echo JS_JUQERY;?>"></script>
<style type="text/css">
html,body{font-family:tahoma,arial,宋体,sans-serif;font-size:12px;padding:0px;margin:0px;}

.wrap{border:1px solid #ccc;margin:50px 100px 150px;}
table{width:100%;border-collapse:collapse;border:1px solid #ccc;}
td{padding:5px 10px;border:1px solid #ccc;}
.align_right{text-align:right;}
.tip{font-weight:bold;padding:10px;color:red;text-align:center;}
.steps{margin:10px;}
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

function addAttrValue(obj_a, default_val, suffix_name){
	var tr = $(obj_a).parents('tr:first').clone(true);
	
	if(typeof default_val != 'undefined'){
		tr.find('input[name=attr_value\[\]]:first').val(default_val);
	}
	
	
	
	$(obj_a).parents('tr:first').after(tr);
}

function setAttrState(s){
	if(s==0){
		$('#attr_container').hide();
	}else{
		$('#attr_container').show();
	}
}
function getAttributeValues(obj){
	var attr_id = $(obj).val();
	if(attr_id > 0){
		$.get(location.href+'?', {attr_id : attr_id, act:'getAttrValues'}, function(result){
			if(result.status = 'success'){
				if(result.content.length>0){

					var attr_box = $(obj).parents('.attr_box:first');
					
					//重置属性列表
					attr_box.find('.attr_tr').each(function(tmp_key, tmp_obj){
						if(tmp_key>0){
							tmp_obj.remove();
						}
					});
					
					var obj_tr = attr_box.find('.attr_tr td:first').get(0);
				
					$.each(result.content, function(tmp_key, tmp_obj){
						var default_val = tmp_obj.products_options_values_name;
						addAttrValue(obj_tr, default_val, attr_id);
					});
					
				}else{
					alert('该属性没有属性值');
				}
			} else {
				alert('获取属性值出现错误');
			}
			
			
		}, 'json');
	}
}
function addNewAttr(){
	
	var attr_box_first = $('.attr_box:first');
	var attr_box = attr_box_first.clone(true);
	var cur_index =  $('#curr_attr_number').val();
	var suffix_name = parseInt(cur_index) + 1;
	
	if(typeof suffix_name != 'undefined'){
		attr_box.find('input[name^=attr_],select[name^=attr_]').each(function(tmp_key, tmp_obj){
				var tmp_name = $(tmp_obj).attr('name');
				var new_tmp_name = tmp_name.replace(/\[\d+\]/i,'['+suffix_name+']') ;
				$(tmp_obj).attr('name', new_tmp_name);
		});
		
	}

	$('.attr_box:last').after(attr_box);
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

</script>
</head>

<body>
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
<form action="" method="post" target="_blank">
<input type="hidden" name="act" value="save_detail" />
<table>
	<tr><td colspan=2><h2><center>添加新产品</center></h2></td></tr>
	<?php 
	$products_name = $_REQUEST['products_name']?$_REQUEST['products_name']:'';
	$products_image = $_REQUEST['products_image']?$_REQUEST['products_image']:'';
	$products_cat = $_REQUEST['products_cat']?$_REQUEST['products_cat']:'130';
	$products_price = $_REQUEST['products_price']?$_REQUEST['products_price']:'112.5';
	$products_model = $_REQUEST['products_model']?$_REQUEST['products_model']:'';
	if(empty($products_model)){
		$products_model = 'BK'.date('YmdHis');
	}
	?>
	
	
	<tr><td class="align_right">网站名:</td>
	<td>
		<select name="site_name">
			<option value="all">2个</option>
			<option value="backever">backever</option>
			<option value="usbexporter">usbexporter</option>
		</select>
	</td>
	</tr>
	
	
	<tr><td class="align_right">是否设置产品属性:</td>
	<td><input type="radio" name="is_set_attr" value="0" onclick="setAttrState(0)" checked />不设置   
	<input type="radio" name="is_set_attr" id="is_set_attr_1" value="1" onclick="setAttrState(1)"  />设置   
	</td>
	</tr>
	
	
	
	<tr><td class="align_right">英语语言id:</td>
	<td><input type="text" style="width:100%;" name="language_id" value="3" /> <span class="tip">对于我自己的backever网站来说，英语语言id是3；其他人的网站英语语言一般是1（如果这个设置错误，在zencart网站上面看不到新添加的产品）</span></td>
	</tr>
	
	
	<tr><td class="align_right">要抓取的产品名:</td>
	<td><input type="text" style="width:100%;" name="products_name" value="<?php echo $products_name;?>" /></td>
	</tr>
	<tr><td class="align_right">产品sn:</td>
	<td><input type="text" style="width:100%;" name="products_model" value="<?php echo $products_model;?>" />（默认值为自动生成的sn）</td>
	</tr>
	
	<tr><td class="align_right">主图片地址:<br><a href="javascript:addProductImage();">添加子图</a></td>
	<td><input type="text" style="width:90%;" name="products_image"  id="products_image" value="<?php echo $products_image;?>" /></td>
	</tr>
	
	<tr><td class="align_right">要抓取的产品分类ID:</td>
	<td><input type="text" style="width:100%;" name="products_cat" value="<?php echo $products_cat;?>" /></td>
	</tr>
	<tr><td class="align_right">产品价格:</td>
	<td><input type="text" style="width:100%;" name="products_price" value="<?php echo $products_price;?>" /></td>
	</tr>
	
	<tr><td class="align_right">产品简述:</td>
	<td>
	<?php echo $FCKeditor_short_desp;?>
	</td>
	</tr>
	
	<tr><td class="align_right">产品描述:</td>
	<td>
	<?php echo $FCKeditor;?>
	</td>
	</tr>
	
	<tr><td colspan=2 align="center"><input type="submit" name="submit" value="  保存  " /></p></td>
	
	</tr>
	
</table>


<?php 
include 'aliexpress_attr_html.php';
?>


</form>

</div>

</body>
</html>
