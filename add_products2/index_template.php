<?php 

include 'includes/init.php';

$act = $_REQUEST['act']?$_REQUEST['act']:'';

if($act == 'save_detail'){
	include 'add_product_init.php';
	
	/**/
	//产品主图----begin
	$preg = '~<td class="news3">&nbsp;Description</td>(?:\s|.)+?<img.+?src="([^"]+)"~';
	preg_match($preg, $content,$arr);
	//print_r($arr);
	$pic_main = $arr[1];
	
	$remote_img_url = $remote_host.'/'.$pic_main;
	$local_img_url = './images/'.$save_img_dir.'/'.basename($pic_main);
	//保存产品主图
	createDirIfNotExists($local_img_url);
	saveFile($remote_img_url, $local_img_url);
	
	$insert_product['products_image'] = '/images/'.$save_img_dir.'/'.basename($pic_main);
	//产品主图----end
	
	
	//产品详情图----begin
	$preg = '~<img src="([^"]+)" width="769" height="307" />~';
	preg_match($preg, $content,$arr);
	//print_r($arr);
	$pic_desp = $arr[1];
	
	$remote_img_url = $remote_host.'/'.$pic_desp;
	$local_img_url = './images/'.$save_img_dir.'/'.basename($pic_desp);
	//保存产品详情图
	createDirIfNotExists($local_img_url);
	saveFile($remote_img_url, $local_img_url);
	//产品详情图----end
	
	

	//产品详情1
	$preg = '~<td class="news3">&nbsp;Product Specifications</td>(?:\s|.)+?<td height="165" valign="top" style="color:#333333;">((?:\s|.)+?)</td>~';
	preg_match($preg, $content,$arr);
	$pro_desp = $arr[1];
	//print_r($arr);
	
	//产品详情2
	$preg = '~<td class="news3">&nbsp;User Guide</td>(?:\s|.)+?<td height="165" valign="top" style="color:#333333;">((?:\s|.)+?)</td>~';
	preg_match($preg, $content,$arr);
	$pro_desp2 = $arr[1];
	//print_r($arr);
	
	
	$insert_product_desp['products_description'] = $pro_desp . $pro_desp2 . '<img src="/images/'.$save_img_dir.'/'.basename($pic_desp);
	
	//添加记录
	addProductBackEver(	array(
	'products'=>$insert_product,
	'products_description'=>$insert_product_desp,
	'categories_id'=>$products_cat));
	
	$msg='添加产品成功。';
	
}
$FCKeditor = create_html_editor('test','');
   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>add product</title>
<style type="text/css">
html,body{font-family:tahoma,arial,宋体,sans-serif;font-size:12px;padding:0px;margin:0px;}
.wrap{border:1px solid #ccc;margin:50px 100px;}
table{width:100%;border-collapse:collapse;border:1px solid #ccc;}
td{padding:5px 10px;border:1px solid #ccc;}
.align_right{text-align:right;}
</style>
</head>

<body>
<div class="wrap">
<form action="" method="post">
<input type="hidden" name="act" value="save_detail" />
<table>
	<tr><td class="align_right">要抓取页面的url:</td>
	<td><input type="text" style="width:600px;" name="remote_url" value="" /></td>
	</tr>
	<?php 
	$products_name = $_REQUEST['products_name']?$_REQUEST['products_name']:'';
	$products_cat = $_REQUEST['products_cat']?$_REQUEST['products_cat']:'130';
	$products_price = $_REQUEST['products_price']?$_REQUEST['products_price']:'112.5';
	?>
	<tr><td class="align_right">要抓取的产品名:</td>
	<td><input type="text" style="width:600px;" name="products_name" value="<?php echo $products_name;?>" /></td>
	</tr>
	<tr><td class="align_right">要抓取的产品分类ID:</td>
	<td><input type="text" style="width:600px;" name="products_cat" value="<?php echo $products_cat;?>" /></td>
	</tr>
	<tr><td class="align_right">产品价格:</td>
	<td><input type="text" style="width:600px;" name="remote_url" value="<?php echo $products_price;?>" /></td>
	</tr>
	
	<tr><td class="align_right">产品描述:</td>
	<td>
	<?php echo $FCKeditor;?>
	</td>
	</tr>
	
	<tr><td colspan=2 align="center"><input type="submit" name="submit" value="save_detail" /></p></td>
	
	</tr>
	
	
	
	
</table>
</form>
</div>

	


</body>
</html>
