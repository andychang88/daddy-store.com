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
class AddProductModel extends CommonBase{
	
	var $reduce_price_num = 0;
	var $language_id = 3;
	var $new_products_id = 0;
	var $site_name = 'all';
	//product description
	var $description_filter = array('start_str'=>'','end_str'=>'','preg'=>'','delete_preg'=>array(),
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
	
	var $products_cat = '';
	var $update_products_id = '';
	var $products_model = '';
	var $products_afterbuy_model = '';
	var $product_info = array('title'=>'', 'price'=>'', 'product_image'=>'', 'description'=>'',);
	var $html_content = '';
	var $from_url = '';
	var $error_msg = array();
	
	function AddProductModel($config=array()){
		$this->products_cat = isset($config['products_cat'])? $config['products_cat'] : $_REQUEST['products_cat'];
		$this->update_products_id = isset($config['update_products_id'])? $config['update_products_id'] : (int)$_REQUEST['update_products_id'];
	}
	
	function getDescription(){
		
		$str = $this->getReplaceResult($this->description_filter, $this->html_content, 'desc');
		
		if(empty($str)){ 
			$this->error_msg['description_error']='error: empty product description';
		}else{
		
			$str = preg_replace("/free\s+shipping\W*/i", '', $str);
			$str = preg_replace("/free\s+ship\W*/i", '', $str);
			
			$this->product_info['description'] = addslashes($str);
		}
	}
	
	function getTitle(){
		$str = $this->getReplaceResult($this->title_filter, $this->html_content);
		
		if(empty($str)){ 
			$this->error_msg['title_error']='error: empty product title';
		}else{
			$str = preg_replace("/free.*?shipping\W*/i", '', $str);
			$str = preg_replace("/free\s*ship\W*/i", '', $str);
			$this->product_info['title'] = trim($str);
		}
		
		
	}
	
	function getPrice(){//echo '<pre>';print_r($this->price_filter);exit;
		
		$str = $this->getReplaceResult($this->price_filter, $this->html_content,'price');
		
		if(empty($str)){
			
			for($i=0,$len=count($this->price_filter['discount']); $i<$len; $i++){
				$str = $this->getReplaceResult($this->price_filter['discount'][$i], $this->html_content);
				if(strlen($str)>0){
					break;
				}
			}
			
			if(empty($str)){
				$this->error_msg['price_error']='error: empty product price and discount price';
			}
			
		} 
		
		if(!isset($this->error_msg['price_error'])){
			$str = preg_replace("/^\D+|\D+$/", '', $str);
			$str = floatval($str);
		$this->reduce_price_num = floatval($this->reduce_price_num);	
			if($str - $this->reduce_price_num >0){
				$str = $str - $this->reduce_price_num;
			}
			
			$this->product_info['price'] = $str;
		}
	}
	
	function getProductImage(){
		$img_tag_str = $this->getReplaceResult($this->product_img_filter, $this->html_content);
		
		$litter_img_url = $this->getImgUrl($img_tag_str);
		
		if(empty($litter_img_url)){
			preg_match($this->product_img_filter['enlarge_image_a_preg'], $this->html_content, $arr);
			
			
			if(empty($arr)){
				$this->error_msg['main_image_error']='error: empty product enlarge_image_a_preg string';
				return ;
			} 
			
			$content_img = file_get_contents($arr[1]);
			preg_match($this->product_img_filter['img_url_from_enlarge_page_preg'], $content_img, $arr);
			
			unset($content_img);
			
			if(empty($arr)) die('<br>error: empty product img_url_from_enlarge_page_preg string');
			
			if(count($arr) == 2){
				$large_img_url = $arr[1];
			}
			
		}else{
			$large_img_url = str_replace('.summ','', $litter_img_url);
		}
		
		if(empty($large_img_url)) die('error: empty product large_img_url string');
		
		$ext = pathinfo($large_img_url,PATHINFO_EXTENSION);
		$save_img_url = date("Ymd")."/".date("dHis").'.'.$ext;//保存到数据库中的产品图片的的url
		
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
		
		$this->product_info['product_image'] = $save_img_url;
	}

	function filter(){
		$this->getTitle();
		$this->getPrice();
		$this->getProductImage();
		$this->getDescription();
		
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
	function addToDB(){
		if(count($this->error_msg)>0){
			echo '<pre>出现了一下致命错误：<br>';
			echo 'from_url:'.$this->from_url;
			echo '<br>';
			print_r($this->error_msg);
			exit;
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
			'products_model'=>'','products_afterbuy_model'=>'','products_discount_type'=>'1',
			'products_price'=>0,
			'products_image'=>'',
			'master_categories_id'=>$products_cat,
			'products_date_added'=>$now,'products_last_modified'=>$now);
			
			if($products_cat == 130){
				$insert_product['products_weight'] = '1400';
			}else{
				$insert_product['products_weight'] = '600';
			}
			
			
	    $insert_product_desp = array('products_id'=>'','language_id'=>$language_id,'products_name'=>'','products_description'=>'','products_short_description'=>'');
			
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
		$insert_product_desp['products_description'] = $this->product_info['description'];
		$insert_product_desp['products_short_description'] = $this->product_info['title'];
		
		$site_name = $this->site_name;
		
		//添加记录
		$this->new_products_id = addProductBackEver(	array(
		'from_url'=>$this->from_url,
		'site_name'=>$site_name,
		'products'=>$insert_product,
		'products_description'=>$insert_product_desp,
		'update_products_id'=>$update_products_id,
		'categories_id'=>$products_cat));
		
		//echo '$this->new_products_id:'. $this->new_products_id;exit;
		return $msg='添加产品成功。';
	
	}
	


	
	
	
}
