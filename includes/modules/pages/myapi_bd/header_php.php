<?php
/**
 * 获取http://www.bondidea.com上面的产品
 */
if(!is_dir(DIR_FS_SQL_CACHE)){
	die(DIR_FS_SQL_CACHE.' is not dir.');
}
$local_img_path = DIR_WS_IMAGES."bondidea/";
$remote_host="http://www.bondidea.com";

if($_REQUEST['bdid']){
	$remote_url = 'http://www.bondidea.com/en/products/view.asp?id='.$_REQUEST['bdid'];
}else{
	$remote_url = 'http://localhost/bondiea/a.txt';	
}

$html_content = file_get_contents($remote_url);
$html_content = iconv('gb2312', 'utf-8', $html_content);
//匹配产品大图片
preg_match("#/uploads/pics/(\w+\.\w+)#", $html_content, $img_arr);
//echo "<pre>";print_r($img_arr);

//匹配产品描述
$reg_head="<tr>\s*<td><strong>Product\s*intro:</strong></td>\s*</tr>\s*<tr>\s*<td>";
$reg_foot ="</TD>";
preg_match("#".$reg_head."((?:.|\s)*?)".$reg_foot."#i", $html_content,$desp_arr);
//echo "<pre>";print_r($desp_arr);
if(count($desp_arr) == 2){
	$desp_html = $desp_arr[1];
	preg_match_all("#/Webeditor/UploadFile/(\w+\.\w+)#i", $desp_html,$desp_img_arr);
	//echo "<pre>";print_r($desp_img_arr);
	if(!empty($desp_img_arr)){
		foreach ($desp_img_arr[0] as $desp_tmp_key=>$desp_tmp){
			$img_data = file_get_contents($remote_host.$desp_tmp);
			file_put_contents($local_img_path.$desp_img_arr[1][$desp_tmp_key], $img_data);
		}
	}
	$desp_html = preg_replace("#/Webeditor/UploadFile/#i", $local_img_path, $desp_html);
	
}
echo htmlspecialchars($desp_html);


/**
$sql =  "insert into products products_type,products_quantity,";
$sql_data_array = array('products_quantity' => '10000',
                            'products_type' => '1',
                            'products_model' => zen_db_prepare_input($_POST['products_model']),
							//added by john 2010-06-04 more close to afterbuy
							'products_afterbuy_model'=>zen_db_prepare_input($_POST['products_afterbuy_model']),												
                            'products_price' => zen_db_prepare_input($_POST['products_price']),	
                            
                            'products_image'=>zen_db_prepare_input($_POST['products_image']),

                            'products_status' => '1',
							'products_stock_status'=>'1',
                            'products_virtual' => '0',
                            'products_tax_class_id' => '0',
                            'manufacturers_id' => '0',
                            'products_quantity_order_min' => '1',
                            'products_quantity_order_units' => '1',
                            'products_priced_by_attribute' => '0',
                            'product_is_free' => '0',
                            'product_is_call' => '0',
                            'products_quantity_mixed' => '1',
                            'product_is_always_free_shipping' => '0',
                            'products_qty_box_status' => '1',
                            'products_quantity_order_max' => '0',
                            'products_sort_order' => 0,
                            'products_discount_type' => '0',
                            'products_discount_type_from' => '0',
                            'products_price_sorter' => zen_db_prepare_input($_POST['products_price'])
                            );
zen_db_perform(TABLE_PRODUCTS, $sql_data_array);
$products_id = zen_db_insert_id();

$sql_data_array = array('products_id' => $products_id,
'language_id'=>3,
'products_name'=>zen_db_prepare_input($_POST['products_name']),
'products_description'=>zen_db_prepare_input($_POST['products_description']),
'products_short_description'=>zen_db_prepare_input($_POST['products_short_description']),
);
zen_db_perform(TABLE_PRODUCTS, $sql_data_array);
/**/
//匹配产品实例图片
/**
echo "after 1500,window will refresh. next pid is ".$next_pid;
echo "<br>last image file:".$image_file;
echo "<br>saved files:";
echo implode("<br>", $saved_arr);
echo "<script>setTimeout(function(){window.location.reload();},1500);</script>";
/**/

exit;

