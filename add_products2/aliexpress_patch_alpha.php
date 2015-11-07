<?php 
include 'includes/init.php';
include 'includes/add_product_base.php';
include 'includes/add_product_model.php';
include 'includes/product_attr_model.php';

$act = $_REQUEST['act']?$_REQUEST['act']:'';



if($act == 'save_detail'){
	
	
	
	$products_cat = $_POST['products_cat']?$_POST['products_cat']:130;
	setcookie('products_cat', $products_cat);
	
	
	$reduce_price_num = $_POST['reduce_price_num']?$_POST['reduce_price_num']:0;
	//setcookie('reduce_price_num', $reduce_price_num);
	
	$products_weight = $_POST['products_weight']?$_POST['products_weight']:500;
	setcookie('products_weight', $products_weight);
	
	$language_id = $_POST['language_id']?$_POST['language_id']:3;
	$is_set_attr = $_POST['is_set_attr']?$_POST['is_set_attr']:0;
	
	$site_name = $_POST['site_name']?$_POST['site_name']:0;
	
	$from_url = $_POST['aliexpress_url'];
	
	if(empty($from_url)){
		die('error:empty aliexpress_url');
	}
	
	$preg = '/<a\s+class="history-item product" href="([^"]+)"/';
	
	$content = file_get_contents($from_url);
	
	preg_match_all($preg, $content, $matches);
	
	if(count($matches[1])>0){
		
		//
		$sql = "select count(1) from 2012add_products_setting where from_url='$from_url' limit 1";
		$result = $db->getOne($sql);
		if($result){
			die('该url已经保存过了'.$from_url);
		}
		//配置数据插入到设置表
		$sql = "insert into 2012add_products_setting(from_url, reduce_price_num, website_name, weight, language_id)
		values('$from_url', '$reduce_price_num', '$site_name', '$products_weight', '$language_id')";
		
		$db->query($sql);
		$setting_id = $db->insert_id();
		
		$add_time = date('Y-m-d H:i:s');
	
		foreach ($matches[1] as $key=>$val){
			$sql = "select count(1) from 2012add_products where from_url='$val' limit 1";
			$tmp = $db->getOne($sql);
			if($tmp){
				continue;
			}
			$sql = "insert into 2012add_products(from_url, add_time, status, setting_id)
			values('$val', '$add_time', '0', '$setting_id')";
			$db->query($sql);
		}
		
		
		$msg = '数据保存完成，下一步可以开始自动抓取单个产品页面了';
			
	}
	
	
	
	//echo '<pre>';print_r($matches);exit;

	
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
</script>
</head>
<body>
<?php if($act == 'save_detail' && !empty($msg)){?>

	<div class="tip"><?php echo $msg;?></div>

<?php
exit;
}

?>

<iframe id="info_iframe" src="" style="margin-left:100px;margin-bottom:-40px;"  name="info_iframe" width="1200px" height="100px"></iframe>
 
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

</script><div id="test"><?php echo $msg;?></div>
<form action="" method="post" id="addForm" target="_info_iframe">
<input type="hidden" name="act" value="save_detail" />
<table>
	<tr><td colspan=2><h2><center>把页面上列表的产品添加到数据库</center></h2></td></tr>
	
	<tr><td width="20%" class="align_right">Aliexpress产品列表页面的url:</td>
	<td><input type="text" style="width:100%;" id="aliexpress_url" name="aliexpress_url" value="" /><a href="javascript:clearUrl();" style="font-weight:bold;color:blue;">清空</a>
	&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="  把页面上列表的产品添加到数据库   " />
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
	<td><input type="text" style="width:100%;" name="products_cat" value="<?php echo $_COOKIE['products_cat']?>" /></td>
	</tr>
	
	<tr><td class="align_right">产品重量:</td>
	<td><input type="text" style="width:100%;" name="products_weight" value="<?php echo $_COOKIE['products_weight']?>" /> 单位：克</td>
	</tr>
	
	<tr><td class="align_right">英语语言id:</td>
	<td><input type="text" style="width:100%;" name="language_id" value="3" /> <span class="tip">对于我自己的backever网站来说，英语语言id是3；其他人的网站英语语言一般是1（如果这个设置错误，在zencart网站上面看不到新添加的产品）</span></td>
	</tr>
	
	<tr><td class="align_right">是否设置产品属性:</td>
	<td><input type="radio" name="is_set_attr" value="0" onclick="setAttrState(0)" checked />不设置   
	<input type="radio" name="is_set_attr" id="is_set_attr_1" value="1" onclick="setAttrState(1)"  />设置   
	</td>
	</tr>
	
	
	
</table>

<?php 
include 'aliexpress_attr_html.php';
?>

<div><center>
<br><input type="submit" name="submit" value="  把页面上列表的产品添加到数据库  " /><br></center>
</div>
</form>


	
		
	
</div>     
      
</body>
</html>
