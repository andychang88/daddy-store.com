<?php
	
$products_cat =isset($_REQUEST['products_cat'])?$_REQUEST['products_cat']:'';
$save_img_dir =empty($_REQUEST['save_img_dir'])? date('Ymd') : $_REQUEST['save_img_dir'];


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
	$insert_product_desp = array('products_id'=>'','language_id'=>3,'products_name'=>'','products_description'=>'','products_short_description'=>'');
	

	$insert_product_desp['products_name'] = isset($_REQUEST['products_name'])?$_REQUEST['products_name']:'';
	$insert_product_desp['products_short_description'] = $insert_product_desp['products_name'];
	
	$insert_product['products_model'] = 'mopo-'.date("YmdHis");
	$insert_product['products_afterbuy_model'] = 'mopo-'.date("YmdHis");
	
	$insert_product['products_price'] = isset($_REQUEST['products_price'])?$_REQUEST['products_price']:'112.5';
	
if(empty($is_added_by_hand)){
	
	//要抓取页面的url
	if(empty($_REQUEST['remote_url']) ){
		die('empty remote url error.');
	}else{
		$remote_url = $_REQUEST['remote_url'];
	}
	//要抓取页面的主域名（后面抓取图片会用到）
	$url_arr = parse_url($remote_url);
	$remote_host = $url_arr['scheme'].'://'.$url_arr['host'];
	
	$content = file_get_contents($remote_url);
	
}else{
	
}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	