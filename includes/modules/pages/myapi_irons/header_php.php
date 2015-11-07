<?php
/**
 * 获取http://www.flatironsalliance.com上面的产品
 */
if(!is_dir(DIR_FS_SQL_CACHE)){
	die(DIR_FS_SQL_CACHE.' is not dir.');
}
set_time_limit(0);
error_reporting(1);
$action = $_REQUEST['action']?$_REQUEST['action']:'';


if(empty($action)){
	outputHtml();
	exit;
}

$model_prefix = "mia_";//产品型号前缀
$img_own_dir = 'flatiron/';
$img_default_dir = DIR_WS_IMAGES . $img_own_dir;
$remote_host = 'http://www.flatironsalliance.com';
$cache_url = 'cache/flatirons/purls.txt';
$only_get_image=0;

//backever这边的分类id
$products_cat = 1065;



if($action == 'save_cat'){
	//产品上一级分类的url
	if(!empty($_REQUEST['remote_url'])){
		$remote_url = $_REQUEST['remote_url'];
	}else{
		die('empty remote url.');
	}
	

	$html_content = trim(file_get_contents($remote_url));

	//点击分类，产品列表页面匹配产品的url
	$preg_url = '#<div\s+class="limitheiht"><a\s+href="([^"]+)"#';
	preg_match_all($preg_url, $html_content, $url_arr);
	//echo "<pre>";print_r($url_arr);
	

	if(empty($url_arr[1])){
		echo "not found products url.";exit;
	}
	createDirIfNotExists2($cache_url);
	$content = implode("\n", $url_arr[1]);
	file_put_contents($cache_url, $content);
	
	outputHtml();
	die('success save products url');
}



$urls_arr = file($cache_url);
$tmp=array();
foreach ($urls_arr as $key=>$val){
	$val = trim($val);
	$val = preg_replace("#\\\n#", "", $val);
	$val = preg_replace("#^\s+|\s+$#", "", $val);
	if(!empty($val)){
		$tmp[]=$val;
	}
	
}
$urls_arr = $tmp;


if(count($urls_arr)>0){
	//$detail_url = $url_arr[1][0];
	$now = date("Y-m-d H:i:s");
	$insert_product = array(
	'products_quantity' => '10000','products_status' => '1','manufacturers_id' => '0','products_quantity_mixed' => '1',
	'products_model'=>'','products_afterbuy_model'=>'','products_price'=>0,'products_image'=>'',
	'master_categories_id'=>$products_cat,'products_discount_type'=>'1',
	'products_date_added'=>$now,'products_last_modified'=>$now);
	
	if($products_cat == 130){
		$insert_product['products_weight'] = '1400';
	}else{
		$insert_product['products_weight'] = '300';
	}
	
	$insert_product_desp = array('products_id'=>'','language_id'=>3,'products_name'=>'','products_description'=>'','products_short_description'=>'');
	
	//$detail_url = 'http://localhost/web_remote/detail.txt';
	$detail_url = array_shift($urls_arr);
	if(empty($detail_url)){
		die('error url.');
	}
	$detail_content = trim(file_get_contents($detail_url));
	
	//$preg_product_img = '#<img\s+src="([^"]+)\s+alt="[^"]+"\s+title="[^"]+"\s+width="250"\s+height="183"#';
	
	//获取产品id, 生产产品型号
	$preg_product_model = '#-p-(\d+)/?#';
	preg_match($preg_product_model, $detail_url, $product_model_arr);
	//echo "<pre>";print_r($product_model_arr);
	if(count($product_model_arr)==2){
		$products_model = $model_prefix.$product_model_arr[1];
		$sql_check_model = "select * from products where products_afterbuy_model='".$products_model."'";
		$result_model = $db->Execute($sql_check_model);
		//这个产品已经存在了
		if(!$only_get_image && $result_model->RecordCount()>0){
			$content = implode("\n", $urls_arr);
			file_put_contents($cache_url, $content);
			updatePage();
			exit;
		}
		$insert_product['products_model'] = $products_model;
		$insert_product['products_afterbuy_model'] = $products_model;
	}else{
		die('product model error.');
	}
	
	//产品图片
	$preg_product_img = '#<div\s*id="productMainImage"\s*class="centeredContent\s*back">(?:.|\s)+?<img\s+src="([^"]+)"\s+alt="[^"]+"\s+title="[^"]+"\s+#';
	preg_match($preg_product_img, $detail_content, $content_img_arr);
	//echo "<pre>";print_r($content_img_arr);exit;
	if(count($content_img_arr)==2){
		$img_name = basename($content_img_arr[1]);
		
		$main_image_name = $product_model_arr[1].'.'.substr($img_name,strrpos($img_name,'.')+1);
		
		saveIronImage($remote_host.'/'.$content_img_arr[1],$img_default_dir.$main_image_name);
		
		
		$insert_product['products_image'] = $img_own_dir.$main_image_name;
	}
	//echo "<pre>";print_r($insert_product);exit;
	
	//产品标题，和简短描述
	$preg_product_name = '#<h1\s+id="productName"\s+class="productGeneral">(.+?)</h1>\s+<!--eof Product Name-->\s+<div>(.+?)</div>#';
	preg_match($preg_product_name, $detail_content, $product_name_arr);
	//echo "<pre>";print_r($product_name_arr);exit;
	if(count($product_name_arr)>=2){
		$insert_product_desp['products_name'] = $product_name_arr[1];
		if(isset($product_name_arr[2])){
			$insert_product_desp['products_short_description'] = $product_name_arr[2];
		}
	}
	
	
	//产品价格
	$preg_product_price = '#<span\s+class="productSpecialPrice">\s*\D(.+?)</span>#';
	preg_match($preg_product_price, $detail_content, $product_price_arr);
	//echo "<pre>";print_r($product_price_arr);
	if(count($product_price_arr)==2){
		$insert_product['products_price'] = $product_price_arr[1];
	}
	
	//产品缩略图片
	$preg_product_little_img = "#products_image_large_additional=(.+?)\\\'#";
	preg_match_all($preg_product_little_img, $detail_content, $product_little_img_arr);
	//echo "<pre>";print_r($product_little_img_arr);
	if(count($product_little_img_arr)==2){
		$img_counter = 1;
		foreach ($product_little_img_arr[1] as $little_img){
			
			list($tmp_name,$tmp_ext) = explode(".", $main_image_name);
			$img_name = $img_default_dir.$tmp_name.'_0'.$img_counter.'.'.$tmp_ext;
			$img_counter++;
			
			saveIronImage($remote_host.'/'.$little_img,$img_name);
		}
	}
	
	if($only_get_image){
		$content = implode("\n", $urls_arr);
	file_put_contents($cache_url, $content);
		updatePage();
		exit;
	}
	//产品介绍
	$preg_product_desp = '#<div\s+id="productDescription"\s+class="productGeneral\s+biggerText">((?:.|\s)+?)<!--bof guide begin\s+-->\s*<div\s+class="guide">#';
	preg_match($preg_product_desp, $detail_content, $product_desp_arr);
	//echo "<pre>";print_r($product_desp_arr);
	if(count($product_desp_arr)==2){
		$insert_product_desp['products_description'] = $product_desp_arr[1];
	}
	
	//插入产品表数据
	zen_db_perform(TABLE_PRODUCTS, $insert_product);
	$new_products_id = mysql_insert_id();
	//$new_products_id = addNewProducts($insert_product);
	//echo "<pre>";print_r($insert_product);exit;
	
	$insert_product_desp['products_id'] = $new_products_id;
	//插入产品描述表数据
	zen_db_perform("products_description", $insert_product_desp);
	
	//插入产品---分配表数据
	zen_db_perform("products_to_categories", array('products_id'=>$new_products_id,'categories_id'=>$products_cat));
	
	$content = implode("\n", $urls_arr);
	file_put_contents($cache_url, $content);
}else{
	outputHtml();
	die("finish.");
}



updatePage();

function outputHtml(){
	echo "<a href='".zen_href_link('myapi_irons','action=getdetail')."'>get products info</a><br><br><br>";
	
	echo '<form style="margin:100px;" method="post" action="'.zen_href_link('myapi_irons','').'">';
	echo '<input type="hidden" name="action" value="save_cat" />';
	echo 'remote_url:<input type="text" name="remote_url" value="" />';
	echo '<input type="submit" name="submit" value="submit" />';
	echo '</form>';
}

function updatePage(){
	global $detail_url;
	echo "Done.";

	echo "after 1500,window will refresh. last url is ".$detail_url;
	//window.location.reload();
	echo "<script>setTimeout(function(){window.location.reload();},1500);</script>";
	exit;
}
function saveIronImage($get_url,$save_url){
	createDirIfNotExists2($save_url);
	$img_content = file_get_contents($get_url);
	file_put_contents($save_url, $img_content);
	resizeimage($save_url,350);
}
function addNewProducts($arr){
	
$sql_data_array = array('products_quantity' => '10000',
                            
                            'products_model' => zen_db_prepare_input($arr['products_model']),
							'products_afterbuy_model'=>zen_db_prepare_input($arr['products_afterbuy_model']),												
                            'products_price' => zen_db_prepare_input($arr['products_price']),	
                            
                            'products_image'=>zen_db_prepare_input($arr['products_image']),

                            'products_status' => '1',
						
                            'manufacturers_id' => '0',
               
                            'products_quantity_mixed' => '1',
                         
                            'products_price_sorter' => zen_db_prepare_input($arr['products_price'])
                            );
zen_db_perform(TABLE_PRODUCTS, $sql_data_array);
$products_id = mysql_insert_id();
return $products_id;
}
/**/
if(!function_exists('checkDirExists')){
function checkDirExists($image_file){
	$arr = explode("/", $image_file);
	if(count($arr)>0){
		$tmp = DIR_WS_IMAGES.'';
		for($i=0,$len=count($arr); $i<$len-1; $i++){
			$tmp .= "/".$arr[$i];
			if(!is_dir($tmp)){
				mkdir($tmp);
			}
		}
	}
}
}
function createDirIfNotExists2($image_file){
	
	$arr = explode("/", $image_file);//echo "<pre>";print_r($arr);
	if(count($arr)>0){
		$tmp = './';
		for($i=0,$len=count($arr); $i<$len-1; $i++){
			$arr[$i] = str_replace('%20', ' ', $arr[$i]);
			//$arr[$i] = str_replace(' ', '_', $arr[$i]);
			if(substr($tmp,-1)!='/'){
				$tmp .= "/".$arr[$i];
			}else{
				$tmp .= $arr[$i];
			}
			//echo $tmp."<br>";exit;
			if(!is_dir($tmp)){
				mkdir($tmp);
			}
		}
	}
}



function getEnableImgTypes() {
    $enabletypes = array(); //服务器支持图片类型(gif/jpeg/jpg/png)
    if(imagetypes() & IMG_GIF) $enabletypes[] = 'image/gif';
    if(imagetypes() & IMG_JPG) $enabletypes[] = 'image/jpg';
    if(imagetypes() & IMG_JPEG) $enabletypes[] = 'image/jpeg';
    if(imagetypes() & IMG_PNG) $enabletypes[] = 'image/png';
    return $enabletypes;
}

function resizeimage($image,$maxwidth=350) { //生成缩略图 或者 改变图片大小
   // $maxwidth = 120; //限制最大宽度作为条件
    $percent = 0;  //设置百分比作为条件
    $quality = 100;  //图片输出的质量范围从 0（最差质量，文件更小）到 100（最佳质量，文件最大）。
    $isview  = 0;    //是否直接输出到浏览器

    if(file_exists($image) && is_file($image)) {
        $opinfo = getimagesize($image);
    }else {
        exit($image.'图片不存在');
    }
    $enabletypes = getEnableImgTypes();
   // if(!in_array($opinfo['mime'], $enabletypes)) exit('系统不支持该图片类型');
    $opwidth = $opinfo[0];
    $opheight = $opinfo[1];
    if($opinfo['mime'] == 'image/gif') {
        $imgtype = 'gif';
        $imgfunc = 'imagegif';
        $crtfunc = 'imagecreatefromgif';
    }elseif($opinfo['mime'] == 'image/jpg') {
        $imgtype = 'jpg';
        $imgfunc = 'imagejpeg';
        $crtfunc = 'imagecreatefromjpeg';
    }elseif($opinfo['mime'] == 'image/jpeg') {
        $imgtype = 'jpeg';
        $imgfunc = 'imagejpeg';
        $crtfunc = 'imagecreatefromjpeg';
    }elseif($opinfo['mime'] == 'image/png') {
        $imgtype = 'png';
        $imgfunc = 'imagepng';
        $crtfunc = 'imagecreatefrompng';
    }else{
    	$imgtype = 'jpeg';
        $imgfunc = 'imagejpeg';
        $crtfunc = 'imagecreatefromjpeg';
    }
    if($percent) {
        $towidth = $opwidth * $percent;
        $toheight = $opheight * $percent;
    }else {
        if($maxwidth) {
            $towidth = $maxwidth;
            $toheight = $towidth*$opheight/$opwidth;
        }elseif($maxheight) {
            $toheight = $maxheight;
            $towidth = $toheight*$opwidth/$opheight;
        }
    }
    if($toheight && $toheight>$towidth){
    	$toheight = $towidth;
    }
    $image_to = imagecreatetruecolor($towidth, $toheight); //创建一个缩略图大小背景为黑色的图片
    $image_fr = $crtfunc($image); //从 JPEG 文件或 URL 新建一图像
    imagecopyresized($image_to, $image_fr, 0, 0, 0, 0, $towidth, $toheight, $opwidth, $opheight); //拷贝部分图像并调整大小
    if($isview) {
        header("Content-type: $dotype");
        $imgfunc($image_to, null, $quality);
    }else {
        $time = time();
        $date = date('Ymd');
        $rand = rand(10000, 99999);
        //$newname = $date.$time.$rand.'.'.$imgtype;
        $newname = $image;
        $imgfunc($image_to, $newname, $quality);
    }

    if(is_resource($image_fr)) imagedestroy($image_fr);
    if(is_resource($image_to)) imagedestroy($image_to);
}



/**/