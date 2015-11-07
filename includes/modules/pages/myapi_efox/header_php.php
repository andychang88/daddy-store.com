<?php
/**
 * 获取http://www.myefox.com/上面的图片文件
 * http://localhost/usbexporter/index.php?main_page=myapi_efox
 */
set_time_limit(0);
$action = $_REQUEST['action']? $_REQUEST['action']:'';
$is_debug = false;
$cache_url = 'cache/efox/purls.txt';

if(empty($action)){
	outputForm();
}

if(!empty($_REQUEST['remote_url'])){
	$remote_url = $_REQUEST['remote_url'];
}else{
	if(!$is_debug){
		//die('empty remote url.');
	}else{
		$remote_url = 'http://localhost/usbexporter/cache/efox/a.txt';
	}
	
	//$remote_url = 'http://localhost/usbexporter/cache/efox/a.txt';
}
if($action == 'save_cat'){//echo '$remote_url:'.$remote_url;
	if(empty($_REQUEST['remote_url'])){
		die('empty remote url.');
	}
	$html_content = trim(file_get_contents($remote_url));
	//点击分类，产品列表页面匹配产品的url
	$preg_url = '#<h2>\s+<a\s+href="([^"]+)"\s+class="ih"#';
	preg_match_all($preg_url, $html_content, $url_arr);
	//echo "<pre>";print_r($url_arr);exit;
	if(empty($url_arr[1])){
		echo "not found products url.";exit;
	}
	//echo "dddddddddddddddd";exit;
	createDirIfNotExists2($cache_url);
	$content = implode("\n", $url_arr[1]);
	file_put_contents($cache_url, $content);
	echo 'success save products url';
	outputForm();
	//die('success save products url');
}

//在缓存文件中获取一个url
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
$urls_arr = array_reverse($urls_arr);

if(!empty($_REQUEST['products_cat'])){
	$products_cat = $_REQUEST['products_cat'];
}else{
	if(!$is_debug) die('empty products_cat.');
}

	$now = date("Y-m-d H:i:s");
	$insert_product = array(
	'products_quantity' => '10000','products_status' => '1','manufacturers_id' => '0','products_quantity_mixed' => '1',
	'products_model'=>'','products_afterbuy_model'=>'','products_discount_type'=>'1',
	'products_price'=>0,
	'products_image'=>'',
	'master_categories_id'=>$products_cat,
	'products_date_added'=>$now,'products_last_modified'=>$now);
	
	if($products_cat == 130){
		$insert_product['products_weight'] = '1400';
	}else{
		$insert_product['products_weight'] = '300';
	}
	$insert_product_desp = array('products_id'=>'','language_id'=>3,'products_name'=>'','products_description'=>'','products_short_description'=>'');
	
//抓取单个产品页面
if(empty($_REQUEST['remote_url'])){
   $remote_url = array_shift($urls_arr);
}	
	
$html_page = file_get_contents($remote_url);

//商品属性名
//$preg_attr = '#class="wrapperAttribsOptions"(?:.|\s)*?class="optionName"(?:.|\s)*?class="attribsSelect"[^>]+>(\w+)#';
//preg_match_all($preg_attr, $html_page, $arr_attr);
//echo "<pre>";print_r($arr_attr);


	
//标题
$preg_title = '#<div\s*class="produkte_info">\s*<h1>((?:.|\s)+?)<#';
preg_match($preg_title, $html_page, $arr_title);
//echo "<pre>";print_r($arr_title);
if(empty($arr_title[1])){
	echo 'empty product name.';
	echo 'url:'.$remote_url."<br>";
	outputForm();
	//die('empty product name.');
}
$arr_title[1] = replaceMyEfox($arr_title[1]);

$insert_product_desp['products_name'] = $arr_title[1];
	
	
//产品图片
//此处不用保存产品图片
//$preg_product_img = '#jqimg="images/([^"]+)"#';
$img_new_dir = date('Ymd') . '/';

$preg_product_img = '#<a\s+href="images/([^"]+)"(?:.|\s)+?jqimg#';
preg_match($preg_product_img, $html_page, $arr_product_img);
//echo "<pre>";print_r($arr_product_img);exit;
if(empty($arr_product_img[1])){
	echo 'empty product img.<br>';
}
$insert_product['products_image'] = $img_new_dir . $arr_product_img[1];
//保存主图片
if(!is_file(DIR_WS_IMAGES.$img_new_dir.$arr_product_img[1])){
	createDirIfNotExists($img_new_dir.$arr_product_img[1]);//创建对应的目录
	$img_content = file_get_contents('http://www.myefox.com/images/'.$arr_product_img[1]);
	file_put_contents(DIR_WS_IMAGES.$img_new_dir.$arr_product_img[1], $img_content);//保存图片
}

//产品其他图片
$preg_product_other_img = '#popimg="images/([^"]+)"#';
preg_match_all($preg_product_other_img, $html_page, $product_little_img_arr);
//echo "<pre>";print_r($product_little_img_arr);exit;
if(!empty($product_little_img_arr[1])){//保存小图片和主图片
		$img_counter = 1;
		foreach ($product_little_img_arr[1] as $little_img){
			//saveIronImage('http://www.myefox.com/'.$little_img,$img_name);
			if(!is_file(DIR_WS_IMAGES.$img_new_dir.$little_img)){
				createDirIfNotExists($img_new_dir.$little_img);//创建对应的目录
				$img_content = file_get_contents('http://www.myefox.com/images/'.$little_img);
				file_put_contents(DIR_WS_IMAGES.$img_new_dir.$little_img, $img_content);//保存图片
			}
		}
}
	

//简短描述
$preg_desp_short = '#<p\s*class="info_p1">\s*<strong>[^<]+</strong>\s*([^<]*)</p>#';
preg_match($preg_desp_short, $html_page, $arr_desp_short);
//echo "<pre>";print_r($arr_desp_short);
if(empty($arr_desp_short[1])){
	echo '<br>empty product short desciption.<br>';
}
$arr_desp_short[1] = replaceMyEfox($arr_desp_short[1]);
$insert_product_desp['products_short_description'] = $arr_desp_short[1];
	


//产品型号
$preg_model = '#<div\s*class="info">(?:.|\s)*?<span\s*class="span_l">[^:]+:\s*([^<]+)</span>#';
preg_match($preg_model, $html_page, $arr_model);
//echo "<pre>";print_r($arr_model);
 if(empty($arr_model[1])){
	die('empty product model desciption.');
}
//检查产品型号是否已经有了
$sql_check_model = "select * from products where products_afterbuy_model='".$arr_model[1]."'";
		$result_model = $db->Execute($sql_check_model);
		//这个产品已经存在了
		if($result_model->RecordCount()>0){
			echo "the product has exists.";
			$img1=$result_model->fields['products_image'];
			
			if( strlen($img1)==0 && strlen($insert_product['products_image'])>0 ){
				$sql = 'update products set products_image="'.$insert_product['products_image'].'" 
				where products_afterbuy_model="'.$arr_model[1].'"';
				$db->Execute($sql);
			}
			
			$urls_arr = array_reverse($urls_arr);
			$content = implode("\n", $urls_arr);
			file_put_contents($cache_url, $content);
			updatePage();
			exit;
		}
		
$insert_product['products_model'] = $arr_model[1];
$insert_product['products_afterbuy_model'] = $arr_model[1];

//产品价格
$preg_price = '#neue_text3(?:.|\s)*?Price:\D([\d\.]+)(?:</span>)?\s*</strong>#';
preg_match($preg_price, $html_page, $arr_price);

//echo $html_page;
 if(empty($arr_price[1])){
	$preg_price = '#neue_text3(?:.|\s)*?Price:\D([\d\.]+)(?:</span>)?\s*(?:</strong>)?\s*#';//have no normalprice
	preg_match($preg_price, $html_page, $arr_price);
}
//echo "<pre>";print_r($arr_desp_short);
 if(empty($arr_price[1])){
	die('empty product price. remote_url is :'.$remote_url);
}
$insert_product['products_price'] = $arr_price[1];


//产品详细描述
$pos1 = strpos($html_page, '<div class="num_2">');
if(strpos($html_page, '<div class="neue2"') !== false){
	$pos2 = strpos($html_page, '<div class="neue2"');//以其他关键字为临界点
}else{
	$pos2 = strpos($html_page, '<div class="reviews"');//以评论为临界点
}
$desp_long = substr($html_page, $pos1, $pos2 - $pos1);

$preg = '#<div\s+class="pint_rows">(?:.|\s)+?</div>#';
$preg2 = '#<div\s+class="pint_title">(?:.|\s)+?</div>#';

 $desp_long = preg_replace($preg, '', $desp_long);
 $desp_long = preg_replace($preg2, '', $desp_long);




if(empty($desp_long)){
	//$preg_desp_long = '#<div\s*class="num_2">((?:.|\s)*?<table\s+border="1"\s+width="547">((?:.|\s)+?)</table>)#';
	//preg_match($preg_desp_long, $html_page, $arr_desp_long);
}
//产品详细描述中的图片
if(!empty($desp_long)){
 $preg_desp_img = '~<img\s*src="([^"]+)"~';
 preg_match_all($preg_desp_img, $desp_long, $arr_desp_img);
 //echo "<pre>";print_r($arr_desp_img);
 if(!empty($arr_desp_img[1])){
 	foreach ($arr_desp_img[1] as $desp_img){
 		$tmp_image_file = str_replace('http://www.myefox.com/images/', '', $desp_img);
 		$tmp_image_file = str_replace('http://www.myefox.it/images/', '', $tmp_image_file);
 		$tmp_image_file = preg_replace("#^images/#", "", $tmp_image_file);
 		
 		createDirIfNotExists($img_new_dir.$tmp_image_file);
 		
 		if(strpos($desp_img, 'http://')===false){
 			$desp_img = 'http://www.myefox.com/' . $desp_img;
 		}
 		
 		$img_data = file_get_contents($desp_img);
 		$tmp_image_file = str_replace('%20', ' ', $tmp_image_file);
 		file_put_contents(DIR_WS_IMAGES.$img_new_dir.$tmp_image_file, $img_data);
 	}
 }
}
 $desp_long = str_replace('http://www.myefox.com/images/', HTTP_SERVER.DIR_WS_CATALOG.'images/', $desp_long);
 $desp_long = str_replace('http://www.myefox.it/images/', HTTP_SERVER.DIR_WS_CATALOG.'images/', $desp_long);
 
if(empty($desp_long)){
	//die('empty product description.');
}
$insert_product_desp['products_description'] = $desp_long;
 

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
	
	
	
//商品属性
/**
 * 仅仅限制于以前已经添加过的属性
 */
$preg_attr = '#class="wrapperAttribsOptions"(?:.|\s)*?class="optionValues"(?:.|\s)*?'.
'<select\s+name="id\[\d+\]"(?:.|\s)*?'.
'(?:<option\s+value="\d+">[^<]+</option>\s*)+#';
preg_match_all($preg_attr, $html_page, $arr_attr);
if(!empty($arr_attr[0])){
	foreach ($arr_attr[0] as $attr){
		$tmp_preg = '#'.
		'<select\s+name="id\[(\d+)\]"[^>]+?>\s*'.
		'((?:<option\s+value="\d+">[^<]+?</option>\s*)+)#';
		preg_match($tmp_preg, $attr, $tmp_attr);
		if(count($tmp_attr)==3){
			$options_id = $tmp_attr[1];//属性的id
			$values_id = $tmp_attr[2];//所有的属性值
			$preg_values_id = '#<option\s+value="(\d+)">(?:.|\s)*?\$([\d\.]+).+?</option>#';
			preg_match_all($preg_values_id, $values_id, $tmp_attr_values_id);
			//echo "<pre>";print_r($tmp_attr_values_id);exit;
			if(count($tmp_attr_values_id)==3){
				$insert_attr_arr = array('price_prefix'=>'+',
				'products_attributes_weight_prefix'=>'+',
				'products_attributes_weight'=>0,
				'products_id'=>$new_products_id,
				'options_id'=>$options_id,
				'options_values_id'=>0,
				'options_values_price'=>0,
				'products_options_sort_order'=>1);
				if(strpos($tmp_attr_values_id[0][0], 'options')!==false){
					$preg_value_opt='#value="(\d+)"#';
					preg_match_all($preg_value_opt, $tmp_attr_values_id[0][0], $arr_value_opt);
					if(!empty($arr_value_opt[1])){
						$tmp_attr_values_id[1][0]=$arr_value_opt[1][1];//修正获取到得第一个属性
						$tmp_attr_values_id[1][]=$arr_value_opt[1][0];//默认属性options
						$tmp_attr_values_id[2][]=0;//默认属性值,一般指的是价钱
					}
				}
				//print_r($tmp_attr_values_id);echo "------";
				foreach ($tmp_attr_values_id[1] as $tmp_v_id_key=>$tmp_v_id){//添加每一个属性
					$insert_attr_arr['options_values_id'] = $tmp_v_id;
					$insert_attr_arr['options_values_price'] = $tmp_attr_values_id[2][$tmp_v_id_key];
					
					if((int)$insert_attr_arr['options_values_price']!=0){
						$insert_attr_arr['products_options_sort_order'] = $tmp_v_id_key+2;
					}else{
						$insert_attr_arr['products_options_sort_order'] = 1;
					}
					
					if(isset($tmp_attr_values_id[0][$tmp_v_id_key])){
						if($tmp_v_id_key==4){
							print_r($tmp_attr_values_id);
						}
						if(strpos($tmp_attr_values_id[0][$tmp_v_id_key], 'lbs')!==false){//重量
							preg_match('#(\d+)lbs#', $tmp_attr_values_id[0][$tmp_v_id_key],$arr_weight);
							$insert_attr_arr['products_attributes_weight'] = $arr_weight[1];
						}
					}else{
						$insert_attr_arr['products_attributes_weight'] = 0;
					}
					
					zen_db_perform("products_attributes", $insert_attr_arr);
					//echo "<pre>";print_r($insert_attr_arr);
					
				}
			}
			
		}
		
	}
}
if(!empty($_REQUEST['remote_url'])){
	echo "the product done finished.";
	outputForm();
	exit;
}
if(!empty($urls_arr)){	
	$urls_arr = array_reverse($urls_arr);
	$content = implode("\n", $urls_arr);
	file_put_contents($cache_url, $content);	
	updatePage();
}

echo "success.<br>";
if($new_products_id){
	outputForm($new_products_id);
}else{
	outputForm();
}

echo "Finish."; 
exit;
function updatePage(){
	global $detail_url,$remote_url;
	echo "Done.";
if(empty($detail_url)){
	$detail_url = $remote_url;
}
	echo "after 1500,window will refresh. last url is ".$detail_url;
	//window.location.reload();
	echo "<script>setTimeout(function(){ window.location.reload();},1500);</script>";
	exit;
}
function replaceMyEfox($str){
	$str = str_replace('Myefox', '', $str);
	$str = str_replace('myefox', '', $str);
	$str = str_replace('MYEFOX', '', $str);
	return $str;
}

function outputForm($products_id=0){
	global $is_debug;
	echo '<br>使用说明：如果直接抓取单个产品，直接使用第一个；<br>如果从目录下抓取多个产品，先使用第二个，再使用第一个（第一个的remote_url留空）<br>';
	
	echo '<form style="margin:100px;" method="post" action="'.zen_href_link('myapi_efox').'">';
	echo '<input type="hidden" name="action" value="save_detail" />';
	//echo '<input type="hidden" name="main_page" value="myapi_efox" />';
	echo 'remote_url:<input type="text" name="remote_url" value="" />';
	$products_cat = $_REQUEST['products_cat']?$_REQUEST['products_cat']:'130';
	echo 'products_cat:<input type="text" name="products_cat" value="'.$products_cat.'" />';
	echo '<input type="submit" name="submit" value="save_detail" />';
	echo '</form>';
	
	echo '<br>--------------------------------------------------------<br>';
	
	echo '<form style="margin:100px;" method="post" action="'.zen_href_link('myapi_efox').'">';
	echo '<input type="hidden" name="action" value="save_cat" />';
	echo 'remote_url:<input type="text" name="remote_url" value="" />';
	$products_cat = $_REQUEST['products_cat']?$_REQUEST['products_cat']:'130';
	echo 'products_cat:<input type="text" name="products_cat" value="'.$products_cat.'" />';
	echo '<input type="submit" name="submit" value="save_cat" />';
	echo '</form>';
	
	if($products_id){
		echo '<a href="'.zen_href_link('product_info','products_id=158574').'" target="_blank">查看该产品</a>';
	}
	
	
	if(!$is_debug) exit;
	
}
function createDirIfNotExists($image_file){
	if(preg_match("#images/#", $image_file)){
		$image_file = preg_replace("#images/#", "", $image_file);
	}
	$arr = explode("/", $image_file);//echo "<pre>";print_r($arr);
	if(count($arr)>0){
		$tmp = DIR_WS_IMAGES.'';
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

/**/