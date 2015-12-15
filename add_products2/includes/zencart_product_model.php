<?php
/*
 * usage:
$pm = new AddProductModel();

$pm->description_filter = $filter_content_arr;
$pm->title_filter = $title_filter_content_arr;
$pm->price_filter = $price_filter_content_arr;
$pm->product_img_filter = $litter_img_filter_content_arr;


$pm->html_content = file_get_contents("http://www.aliexpress.com/product-gs/538280811-Silver-Mens-Manual-Skeleton-Mechanical-Watch-Wrist-Watch-RT032-Xmas-Gift-Free-Ship-wholesalers.html");

$pm->filter();
//$pm->addToDB();
$pm->debug(0);

 */
class ZencartProductModel extends CommonBase{
	
	var $reduce_price_num = 0;
	var $language_id = 3;
	var $new_products_id = 0;
	var $products_weight = 500;
	var $is_debug = false;
	var $site_name = 'all';
	//product description
	var $description_filter = array('start_str'=>'','end_str'=>'','preg'=>'','delete_preg'=>array(),
			'delete_str'=>array(
				array('start_str'=>'','end_str'=>'',),
			),
	);
	
	var $short_description_filter = array('start_str'=>'','end_str'=>'','preg'=>'','delete_preg'=>array(),
			'delete_str'=>array(
				array('start_str'=>'','end_str'=>'',),
			),
	);
	
	//product title
	var $title_filter = array('start_str'=>'','end_str'=>'','preg'=>'',);
	
	//product price
	var $price_filter = array('start_str'=>'','end_str'=>'','preg'=>'',
						'discount'=>array('start_str'=>'','end_str'=>'','preg'=>'',),
						);
	
	//product image
	var $product_img_filter = array(
			'start_str'=>'',
			'end_str'=>'',
			'preg'=>'',
			'enlarge_image_a_preg'=>'',
			'img_url_from_enlarge_page_preg'=>'/<div\s+class="image">(?:.|\s)*?<ul>(?:.|\s)*?<li><img src="([^"]+)"/',
	);
	var $gallery_img_filter = array(
			'start_str'=>'',
			'end_str'=>'',
			'preg'=>'',
			'enlarge_image_a_preg'=>'',
			'img_url_from_enlarge_page_preg'=>'/<img src="([^"]+)"/',
	);
	var $products_cat = '';
	var $update_products_id = '';
	var $products_model = '';
	var $products_afterbuy_model = '';
	var $short_description = '';
	var $product_info = array('title'=>'', 'price'=>'', 'product_image'=>'', 'description'=>'','short_description'=>'');
	var $html_content = '';
	var $from_url = '';
	var $error_msg = array();
	
	var $meta_title = '';
	var $meta_description = '';
	var $meta_keywords = '';
	
	function __construct($config=array()){
		
		$this->products_cat = isset($config['products_cat'])? $config['products_cat'] : $_REQUEST['products_cat'];
		$this->update_products_id = isset($config['update_products_id'])? $config['update_products_id'] : (int)$_REQUEST['update_products_id'];
	}
	
	function getShortDescription(){
		$str = $this->getReplaceResult($this->short_description_filter, $this->html_content, 'shortdesc');
		
		if(!empty($str)){
			
			$this->product_info['short_description'] = addslashes($str);
		}
	}
	
	function getDescription(){
		/**
		$content = $this->html_content;
		
		$pos_start = strpos($content, '<div class="ui-box ui-box-normal product-params">');
		
		$pos_end = strpos($content, '<div id="transaction-history">');
		$len = $pos_end - $pos_start;
		
		$content = substr( $content, $pos_start, $len);
		echo $content;exit;
		/**/
		
		
		
		$str = $this->getReplaceResult($this->description_filter, $this->html_content, 'desc');
		
		if(empty($str)){ 
			$this->error_msg['description_error']='error: empty product description';
		}else{
		
			//$str = preg_replace("/free\s+shipping\W*/i", '', $str);
			//$str = preg_replace("/free\s+ship\W*/i", '', $str);
			
			$this->product_info['description'] = addslashes($str);
		}
		//echo "content is: ".$this->product_info['description'];exit;
	}
	
	function getTitle(){
		$str = $this->getReplaceResult($this->title_filter, $this->html_content);
		
		if(empty($str)){ 
			$this->error_msg['title_error']='error: empty product title';
		}else{
			
			$this->product_info['title'] = trim($str);
		}
		
		//echo "title is: ".$this->product_info['title'];exit;
	}
	
	function getPrice(){//echo '<pre>';print_r($this->price_filter);exit;
		
		$str = $this->getReplaceResult($this->price_filter, $this->html_content,'price');
		
		
		if(empty($str)){
			if(count($this->price_filter['addition'])>0){
				
				foreach($this->price_filter['addition'] as $key=>$val){
					$str = $this->getReplaceResult($val, $this->html_content,'price');
				}
			}
		}
		
		//echo 'price============:'.$str;exit;
		if(!empty($str)){
			$price = str_replace(',', '', $str);
			
			$this->reduce_price_num = floatval($this->reduce_price_num);
			if( ($price - $this->reduce_price_num) >0){
				$price = $price - $this->reduce_price_num;
			}
			
			$this->product_info['price'] = $price;
		}
		
		
		
	}
	function getGalleryImage($product_image='20120712/12232818.jpg',$content){
		
		if(!empty($content)){
			
			preg_match_all($this->gallery_img_filter['img_url_from_enlarge_page_preg'], $content, $matches);
			//echo $this->html_content;
			
			
			if(count($matches)==2){
				foreach ($matches[1] as $key=>$tmp_url){
					
					if($key == 0) continue;
					
					
					$tmp_remote_img_url = $tmp_url;
						
					$ext = strrchr($product_image, '.');
					$new_gallary_img = str_replace($ext, '_'.$key.$ext, $product_image);
						
					$this->handleSaveGalleryImage($tmp_remote_img_url, $new_gallary_img);
				}
				
			}
		}
		
	}
	function handleSaveGalleryImage($tmp_remote_img_url, $new_gallary_img){
		
		if(defined('DIR_FS_CATALOG')){
			if(!is_dir(DIR_FS_CATALOG)){
				die(DIR_FS_CATALOG.'不是一个有效目录');
			}
			$local_img_url = DIR_FS_CATALOG .'images/' . $new_gallary_img;
		}else{
			$local_img_url = IMAGE_PATH . $new_gallary_img;
		}

		$this->saveFile($tmp_remote_img_url,$local_img_url);

	}
	function getProductImage(){
	
	
	
			preg_match($this->product_img_filter['enlarge_image_a_preg'], $this->html_content, $arr);
			
			
			if(empty($arr)){
				$this->error_msg['main_image_error']='error: empty product enlarge_image_a_preg string';
				return ;
			} 
				

	
	
	
			$content_img = file_get_contents($arr[1]);
			//file_put_contents("testa.txt",$content_img);
			
			//$content_img = file_get_contents('b_enlarg_img.txt');
			$img_tag_str = $this->getReplaceResult($this->product_img_filter['img_url_from_enlarge_page_arr'], $content_img);
			
			unset($content_img);

			//echo '$img_tag_str:'.$img_tag_str;exit;
			//echo '$img_tag_str:'.$img_tag_str;
			//echo $this->product_img_filter['img_url_from_enlarge_page_preg'];
			preg_match_all($this->product_img_filter['img_url_from_enlarge_page_preg'], $img_tag_str, $arr);
			//echo '===<pre>';print_r($arr);exit;
			
			
			if(empty($arr)) die('<br>error: empty product img_url_from_enlarge_page_preg string');
			
			$large_img_url = $arr[1][0];
			
			
		
		
		
			if(empty($large_img_url)){
				$this->error_msg['main_image_error']='error: empty product large_img_url string';
			}
			
			
			$ext = pathinfo($large_img_url,PATHINFO_EXTENSION);
			$save_img_url = date("Ymd")."/".$this->products_model.'.'.$ext;//保存到数据库中的产品图片的的url
			
			if(defined('DIR_FS_CATALOG')){
				if(!is_dir(DIR_FS_CATALOG)){
					die(DIR_FS_CATALOG.'不是一个有效目录');
				}
				$local_img_url = DIR_FS_CATALOG .'images/' . $save_img_url;
			}else{
				$local_img_url = IMAGE_PATH . $save_img_url;
			}
			
			
			$this->createDirIfNotExists($local_img_url,$_SERVER[DOCUMENT_ROOT]);
			$this->saveFile($large_img_url,$local_img_url);
			
			$this->getGalleryImage($save_img_url,$img_tag_str);
			
			$this->product_info['product_image'] = $save_img_url;
	}
	
	function getMetaInfo(){
		$preg_meta = "#<title>(.+?)</title>#";
		preg_match($preg_meta, $this->html_content, $arr);
		if(!empty($arr)){
			$this->meta_title = preg_replace("/ali\w+\.?\w*/i","",$arr[1]);
			
		}
		
		$preg_meta = '#<meta\s+name="description"\s+content="(.+?)"#';
		preg_match($preg_meta, $this->html_content, $arr);
		if(!empty($arr)){
			$this->meta_description = $arr[1];
			$this->meta_description = preg_replace("/ali\w+\.?\w*/i","",$arr[1]);
		}
		
		
		$preg_meta = '#<meta\s+name="keywords"\s+content="(.+?)"#';
		preg_match($preg_meta, $this->html_content, $arr);
		if(!empty($arr)){
			$this->meta_keywords = $arr[1];
			$this->meta_keywords = preg_replace("/ali\w+\.?\w*/i","",$arr[1]);
		}
		//echo $this->meta_keywords;exit;
	}
	function getAttr(){
		$str = $this->getReplaceResult($this->filter_attr_arr, $this->html_content);
		
		//echo '==========================';print_r($this->filter_attr_arr);
		//echo $str;exit;
		//preg_match_all("/\<dl[^>]+\>(?:.|\s)+?\</dl\>/i",$str,$arr);
		preg_match_all('#name="id[^>]*?>([^<]*?)<#i',$str,$arr);
		
		if(!empty($arr[1])){
			$this->attr_str_arr = $arr[1];
		}else{
			$this->attr_str_arr = array($str);
		}
		
		
		//echo "<pre>attr is: ";print_r($this->attr_str_arr);exit;
	}
	
	
	function filter(){
		
		$this->getDescription();
		
		$this->getAttr();
		
		/**/
		$this->getTitle();
		$this->getPrice();
		$this->getProductImage();
		
		$this->getShortDescription();
		$this->getMetaInfo();
		/**/
		
	}
	function checkRequiredFields(){
		
		if(count($this->error_msg)>0){
			
			echo '<pre>出现了一下致命错误：<br>';
			echo 'from_url:'.$this->from_url;
			
			echo '<br><pre>';
			echo 'errors are as follow:<br>';
			print_r($this->error_msg);
			
			echo '<br>match result as follow:<br>';
			print_r($this->product_info);
			exit;
		}
		
	
	}
	function isExistsFromUrl($from_url=''){
		if(empty($from_url)){
			$from_url = $this->from_url;
		}
		$sql = "select products_id from 2012add_products where from_url='$from_url' and status=1 limit 1";
		$products_id = $GLOBALS['db']->getOne($sql);
		if($products_id){
			return $products_id;
		}
		return false;
	}
	function debug(){
		echo '<pre>';
		echo '<br><br>reduce_price_num:'.$this->reduce_price_num;
		echo '<br><br>description_filter:'; $this->getFilterPreg($this->description_filter);
		echo '<br><br>title_filter:'; $this->getFilterPreg($this->title_filter);
		echo '<br><br>price_filter:'; $this->getFilterPreg($this->price_filter);
		echo '<br><br>product_img_filter:'; $this->getFilterPreg($this->product_img_filter);
		echo '<br><br><br>product info:';
		print_r($this->product_info);
		exit;
	}
	
	function getFilterPreg($var){
		if(is_array($var) && isset($var['preg'])){
			echo  htmlentities($var['preg']);
		}else if(is_array($var)){
			echo '<pre>'; print_r($var);
		}else{
			echo  htmlentities($var);
		}
	}
	
		
function getUpdateDB($site_name){
	
	$site_arr=$GLOBALS['update_database'];
	if(empty($site_arr)){
		die('error config argument update_database.');
	}
	/**
	if($site_name == 'all'){
		$site_arr=$GLOBALS['update_database'];
		
	}elseif($site_name == 'backever'){
		if(!isset($GLOBALS['update_database'][$site_name])){
			echo 'error setting update_database in config file.<br><pre>';
			print_r($GLOBALS['update_database']);
			exit;
		}
		$site_arr=array($GLOBALS['update_database'][$site_name]);
		
	}
	
	if(IS_LOCALHOST && isset($GLOBALS['update_database'])){
		$site_arr=$GLOBALS['update_database'];
	}
	/**/
	return $site_arr;
}
function getUpdateType(){

			$update_products_id = (int)$_REQUEST['update_products_id'];
			if($update_products_id>0){
				$update_mode = 'UPDATE';
				$where = " products_id='".$update_products_id."' ";
			}else{
				$update_mode = 'INSERT';
				$where = "";
			}
			return array($update_mode,$where);
}
/*
 * update a product from a category to another category
 */
	function updateProductCategory(){
		
		$start_products_id = $_POST['start_products_id']?$_POST['start_products_id']:0;
		$end_products_id = $_POST['end_products_id']?$_POST['end_products_id']:0;
		$old_cat_id = $_POST['old_cat_id']?$_POST['old_cat_id']:0;
		$new_cat_id = $_POST['new_cat_id']?$_POST['new_cat_id']:0;
		$site_name = $_POST['site_name']?$_POST['site_name']:0;
		
		if(empty($start_products_id) || empty($end_products_id) ||
		empty($old_cat_id) || empty($new_cat_id) || empty($site_name)){
			die("缺少参数");
		}
		
		$site_arr = $this->getUpdateDB($site_name);
		
		foreach ($site_arr as $key=>$site){
			$GLOBALS['db']->query("use $site");
			$sql = "update products set master_categories_id=$new_cat_id where products_id>=$start_products_id 
			and products_id<=$end_products_id and master_categories_id=$old_cat_id";
			$db->query($sql);
			
			$sql = "update products_to_categories set categories_id=$new_cat_id where products_id>=$start_products_id 
			and products_id<=$end_products_id ";
			$db->query($sql);
		
		}
		
		return '更新产品目录成功';
	}
	
	function addProduct(){
		

			
		$this->filter();
		
		$this->checkRequiredFields();
		
		if($this->is_debug){
			$this->debug();
		}
		
		$insert_product = array();
		$insert_product_desp = array();
		$update_products_id = $this->update_products_id;
		$products_cat = $this->products_cat;
		$language_id = $this->language_id;
		
		if(empty($products_cat)) die('error: empty category.');
		
		
		/****************begin init*******************/		
		$now = date("Y-m-d H:i:s");
		$insert_product = array(
			'products_quantity' => '10000','products_status' => '1','manufacturers_id' => '0','products_quantity_mixed' => '1',
			'products_model'=>'','products_afterbuy_model'=>'','products_discount_type'=>'0',
			'products_price'=>0,
			'products_image'=>'',
			'master_categories_id'=>$products_cat,
			'products_date_added'=>$now,'products_last_modified'=>$now);
			
		$insert_product['products_weight'] = $this->products_weight;
		
		$is_insert_meta_tags_products_description = false;
		$meta_tags_products_description_arr = array();

		if(!empty($this->meta_title) && !empty($this->meta_description) && !empty($this->meta_keywords) ){
			$insert_product['metatags_title_status'] = 1;
			$insert_product['metatags_products_name_status'] = 0;
			$insert_product['metatags_model_status'] = 0;
			$insert_product['metatags_title_tagline_status'] = 0;
			$is_insert_meta_tags_products_description = true;
			
			$meta_tags_products_description_arr = array('language_id'=>$this->language_id,
			'metatags_title'=>$this->meta_title, 'metatags_keywords'=>$this->meta_keywords, 
			'metatags_description'=>$this->meta_description,
			);
		}
			
			
	    $insert_product_desp = array('products_id'=>'','language_id'=>$this->language_id,'products_name'=>'','products_description'=>'','products_short_description'=>'');
			
		/****************end init*******************/	
	
	
		$insert_product['products_image'] = trim($this->product_info['product_image']);
		$insert_product['products_image'] = preg_replace('#^/?images?/?#i', '', $insert_product['products_image']);//过滤掉路径中的/images/
		if(strlen($insert_product['products_image'])>=64){
			$new_products_image = dirname($insert_product['products_image']).'/'.date('YmdHis').strrchr($insert_product['products_image'],'.');
			@rename(IMAGE_PATH.$insert_product['products_image'], IMAGE_PATH.$new_products_image);
			$insert_product['products_image'] = $new_products_image;
		}
		
		$insert_product['products_model'] = $this->products_model;
		$insert_product['products_afterbuy_model'] = $this->products_afterbuy_model;
	
		$insert_product['products_price'] = $this->product_info['price'];
		
		$insert_product_desp['products_name'] = $this->product_info['title'];
		
		$remove_table_height = '/table.+?(height="\d+")/i';
		preg_match($remove_table_height,$this->product_info['description'],$tmp_arr);
		
		if(!empty($tmp_arr[1])){
			$this->product_info['description'] = str_replace($tmp_arr[1],"",$this->product_info['description']);
		}
		
		$insert_product_desp['products_description'] = $this->product_info['description'];
		
		if(empty($this->product_info['short_description'])){
			$insert_product_desp['products_short_description'] = $this->product_info['title'];
		}else{
			$insert_product_desp['products_short_description'] = $this->product_info['short_description'];
		}
		
		
		$site_name = $this->site_name;
		
		//添加记录
		$this->new_products_id = $this->handleAddProduct(	array(
		'from_url'=>$this->from_url,
		'site_name'=>$site_name,
		'products'=>$insert_product,
		'products_description'=>$insert_product_desp,
		'update_products_id'=>$update_products_id,
		
		'is_insert_meta_tags_products_description'=>$is_insert_meta_tags_products_description,
		'meta_tags_products_description'=>$meta_tags_products_description_arr,
		
		'categories_id'=>$products_cat));
		
		//echo '$this->new_products_id:'. $this->new_products_id;exit;
		return $msg='添加产品成功。';
	
	}

 function handleAddProduct($arr=array()){
	$products_arr = $arr['products'];
	$products_description_arr = $arr['products_description'];
	$categories_id = $arr['categories_id'];
	$site_name = $arr['site_name'];
	$from_url = $arr['from_url'];
	
	$is_insert_meta_tags_products_description = $arr['is_insert_meta_tags_products_description'];
	$meta_tags_products_description_arr = $arr['meta_tags_products_description'];
	
	$update_products_id = $arr['update_products_id'];
	
	$smt_account = $_REQUEST['smt_account'];
	
	if(empty($site_name)){
		die('Please select a update site.');
	}
	
	//need to update database
	$site_arr = $this->getUpdateDB($site_name);
	
	//update or insert
	list($update_mode,$where) = $this->getUpdateType();
	
		foreach ($site_arr as $site){
			
			$GLOBALS['db']->query("use $site");
			
			//插入数据到表products
			$GLOBALS['db']->autoExecute('products', $products_arr, $update_mode, $where);
			
			if($update_mode == 'UPDATE'){
				$new_products_id = $update_products_id;
			}else{
				$new_products_id = $GLOBALS['db']->insert_id();
			}
			
			
			$products_description_arr['products_id'] = $new_products_id;

			//更新数据到表products_description
			
			$GLOBALS['db']->autoExecute('products_description', $products_description_arr, $update_mode, $where);
			
			//插入数据到表products_to_categories
			$products_to_categories_arr = array('products_id'=>$new_products_id,'categories_id'=>$categories_id);
			$GLOBALS['db']->autoExecute('products_to_categories',$products_to_categories_arr, $update_mode, $where);
			
			
			
			if($is_insert_meta_tags_products_description && !empty($meta_tags_products_description_arr)){
				$meta_tags_products_description_arr['products_id'] = $new_products_id;
				$GLOBALS['db']->autoExecute('meta_tags_products_description', $meta_tags_products_description_arr, $update_mode, $where);
			}
			$add_time = date("Y-m-d H:i:s");
			
			
			
			$status = "";
			
			preg_match("/(\d+)\.html/i",$from_url,$arr);
			if(empty($arr)){
				
				
			}else{
				$remote_gid = $arr[1];
			}
			
			if($remote_gid){
				$sql = "select status from 2012add_products where from_url like '%".$remote_gid."%'  limit 1";
				$status = $GLOBALS['db']->getOne($sql);var_dump($status);
			}
			
			if(strlen($status)>0){
				if($status == 0){//echo 2222;echo $from_url;
					$sql = "update 2012add_products set status=1,products_id='$new_products_id',smt_account='$smt_account' where from_url like '%".$remote_gid."%'  ";
					$GLOBALS['db']->query($sql);
				}
				
			}else{
				$sql = "insert into 2012add_products(products_id,from_url,add_time,status,smt_account)
					values('$new_products_id','$from_url','$add_time',1,'$smt_account')";
				$GLOBALS['db']->query($sql);
			}
			
			
		}
		
		return $new_products_id;
	
}	

	
	
	function moveProductCategory(){
		
		
		$product_ids = $_POST['product_ids']?$_POST['product_ids']:0;
		
		$old_cat_id = $_POST['old_cat_id']?$_POST['old_cat_id']:0;
		$new_cat_id = $_POST['new_cat_id']?$_POST['new_cat_id']:0;
		$is_disable_old_cat = $_POST['is_disable_old_cat']?$_POST['is_disable_old_cat']:0;
		
		if(empty($old_cat_id) || empty($new_cat_id) ){
			die("缺少参数");
		}
		
		$wherePid = " 1 ";
		
		if(is_numeric($product_ids)){
			$wherePid .= " and products_id = ".$product_ids;
		}
		
		if(strpos($product_ids, "-")){
			list($minPid, $maxPid) = explode("-", $product_ids, 1);
			
			$wherePid .= " and products_id >= ".$minPid." and products_id <= ".$maxPid;
		}
		
		if(strpos($product_ids, ",")){
			$wherePid .= " and products_id in (".$product_ids.")";
		}
		
			
		$sql = "update products set master_categories_id=$new_cat_id where $wherePid and master_categories_id=$old_cat_id";
		$GLOBALS['db']->query($sql);
		
		$sql = "update products_to_categories set categories_id=$new_cat_id where  $wherePid and categories_id=$old_cat_id ";
		$GLOBALS['db']->query($sql);
		
		if($is_disable_old_cat){
			$sql = "update categories set categories_status=0 where categories_id=$old_cat_id 
				 ";
			$GLOBALS['db']->query($sql);
		}
		
		
		
		return '移动产品成功';
	}
	function delProductInCategory(){
		
		
		$cat_id = $_POST['cat_id']?$_POST['cat_id']:0;
		
		
		if(empty($cat_id) ){
			die("缺少参数");
		}
		
		
			
			$sql = "delete from  products where master_categories_id=$cat_id";
			$GLOBALS['db']->query($sql);
			
			$sql = "delete from  products_to_categories where categories_id=$cat_id ";
			$GLOBALS['db']->query($sql);
			
			
		
		
		
		return '删除产品成功';
	}
	
	function delProductCategory(){
		
		
		$cat_id = $_POST['cat_id']?$_POST['cat_id']:0;
		
		
		if(empty($cat_id)  ){
			die("缺少参数");
		}
		
		
			
			$sql = "select * from  products where master_categories_id=$cat_id limit 1 ";
			$row = $GLOBALS['db']->getRow($sql);
			
			if(!empty($row)){
				die("the category is not empty. so can not been delete.");
			}
			
			
			$sql = "delete from products_to_categories where categories_id=$cat_id  ";
			$GLOBALS['db']->query($sql);
			
			$sql = "delete from categories where categories_id=$cat_id  ";
			$GLOBALS['db']->query($sql);
			
			
			
		
		
		
		return '删除目录成功';
	}
	
	
	function moveCategory(){
		
		
		$cat_id_before = $_POST['cat_id_before']?$_POST['cat_id_before']:0;
		$cat_id_after = $_POST['cat_id_after']?$_POST['cat_id_after']:0;
		
		
		if(empty($cat_id_before) || empty($cat_id_after) ){
			die("缺少参数");
		}
		
		
				$sql = "update categories set parent_id=".$cat_id_after." where categories_id=$cat_id_before 
					 ";
				$GLOBALS['db']->query($sql);
		
		
		
		
		return '移动目录成功';
	}
	
	
function deleteProduct($products_id_str, $site_name='all'){
	
		$products_id = '';
		
		//if $products_id_str is products_id directly
		if(is_numeric($products_id_str)){
			$products_id = $products_id_str;
		}
		
		//if $products_id_str is a url containing products_id, need to get it
		if(empty($products_id)){
			$preg = '/p\-(\d+)$/';
			preg_match($preg, $products_id_str, $arr);
			
			if(empty($arr)){
				$preg = '/products_id=(\d+)$/';
				preg_match($preg, $products_id_str, $arr);
			}
			
			if(!empty($arr)){
				$products_id = $arr[1];
			}
		
		}
		
		
	$site_arr = $this->getUpdateDB($site_name);
	
	foreach ($site_arr as $site){
		$GLOBALS['db']->query("use $site");
		
		$sql = "select products_image from products where products_id='$products_id'";
		$products_image = $GLOBALS['db']->getOne($sql);
		if(!empty($products_image)){
			if(is_file(IMAGE_PATH.$products_image)){
				@unlink(IMAGE_PATH.$products_image);
			}
		}
		
		$sql = "delete from products where products_id='$products_id'";
		$GLOBALS['db']->query($sql);
		
		$sql = "delete from products_description where products_id='$products_id'";
		$GLOBALS['db']->query($sql);
		
		$sql = "delete from products_to_categories where products_id='$products_id'";
		$GLOBALS['db']->query($sql);
	}
	
	return $msg = '删除成功';
	
}
	
	
}