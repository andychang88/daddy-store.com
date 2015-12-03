<?php
function zen_get_categories($parent_id = '0', $indent = '&nbsp;&nbsp;&nbsp;&nbsp;', $status_setting = '1') {
    global $db;

    $categories_array = array();

    // show based on status
    if ($status_setting != '') {
      $zc_status = " c.categories_status='" . (int)$status_setting . "' and ";
    } else {
      $zc_status = '';
    }

    $categories_query = "select c.categories_id, cd.categories_name, c.categories_status
                         from categories c, categories_description cd
                         where " . $zc_status . "
                         parent_id = '" . (int)$parent_id . "'
                         and c.categories_id = cd.categories_id
                         and cd.language_id = '3'
                         order by sort_order, cd.categories_name";

    $categories = $db->getAll($categories_query);
	
    if($categories){
    	
	    foreach ($categories as $row) {
	      $categories_array[$row['categories_id']] = array( 'id' => $row['categories_id'],
	                                  						'text' => $indent . $row['categories_name']);
	
	      if ($row['categories_id'] != $parent_id) {
	        $categories_array[$row['categories_id']]['children'] = zen_get_categories($row['categories_id'], $indent . '&nbsp;&nbsp;&nbsp;&nbsp;', $status_setting);
	      }
	      
	    }
	    
    }
    
   

    return $categories_array;
  }
  
  function getCategoryOptions($categories_array, $selected_id=0){
  	if(!$categories_array) return $categories_array;
  	
  	$options = '<option>Please select...</option>';
  	
  	foreach ($categories_array as $category){
  		$options .= '<option ' . ($category['id'] == $selected_id? 'selected':'') . ' value="'.$category['id'].'">'.$category['text'].'</option>';
  		if($category['children']){
  			$options .= getCategoryOptions($category['children']);
  		}
  	}
  	
  	return $options;
  }
  
function deleteProductBackEver($products_id){
	
	$site_arr = array();
	
	if($site_name == 'all'){
		
		$site_arr=array('changah_andy02','changah_usbexporter');
		
	}elseif($site_name == 'backever'){
		
		$site_arr=array('changah_andy02');
		
	}elseif($site_name == 'usbexporter'){
		
		$site_arr=array('changah_usbexporter');
		
	}
	
	if(preg_match('/www.bk.com/',$_SERVER[HTTP_HOST])){
		$site_arr=array('usbexporter');
	}
	
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
	
}

function addProductBackEver($arr=array()){
	$products_arr = $arr['products'];
	$products_description_arr = $arr['products_description'];
	$categories_id = $arr['categories_id'];
	$site_name = $arr['site_name'];
	$from_url = $arr['from_url'];
	
	global $is_added_by_hand;
	
	$update_products_id = $arr['update_products_id'];
	
	if(empty($site_name)){
		die('Please select a site.');
	}
	
	
	$site_arr=array('changah_daddystore');

	foreach ($site_arr as $site){
		
		$GLOBALS['db']->query("use $site");
		
		//插入数据到表products
		$sql = genSqlByArr($products_arr,'products');//echo $sql;exit;
		$GLOBALS['db']->query($sql);
		
		if($update_products_id){
			$new_products_id = $update_products_id;
		}else{
			$new_products_id = $GLOBALS['db']->insert_id();
		}
		
		
		$products_description_arr['products_id'] = $new_products_id;
		//插入数据到表products_description
		$sql = genSqlByArr($products_description_arr,'products_description');
		$GLOBALS['db']->query($sql);
		
		//插入数据到表products_to_categories
		$products_to_categories_arr = array('products_id'=>$new_products_id,'categories_id'=>$categories_id);
		$sql = genSqlByArr($products_to_categories_arr,'products_to_categories');
		$GLOBALS['db']->query($sql);
		
		if (!$is_added_by_hand && $from_url){
			$add_time = date("Y-m-d H:i:s");
			
			$sql = "select status from 2012add_products where from_url='$from_url'  limit 1";
			$status = $GLOBALS['db']->getOne($sql);
			if($status !== false){
				if($status == 0){
					$sql = "update 2012add_products set status=1,products_id='$new_products_id' where from_url='$from_url' ";
					$GLOBALS['db']->query($sql);
				}
				
			}else{
				$sql = "insert into 2012add_products(products_id,from_url,add_time,status)
					values('$new_products_id','$from_url','$add_time',1)";
				$GLOBALS['db']->query($sql);
			}
		}
		
	}
	
	return $new_products_id;
	
}
function getUpdateSqlByArray($products_arr,$config=array()){
	$config_arr = array( 
	'table_name'=>'', 
	'primary_key'=>'products_id', 
	'primary_value'=>'', 
	'is_update'=>false);
	
	if(is_array($config)){
		$config = array_merge($config_arr, $config);
		extract($config);
	}else{
		$table_name = $config;
	}
	
	
	if($config['is_update']){
		
		if (empty($primary_key) || empty($primary_value) || empty($table_name)) {
			die('error: you must set primary_key, primary_value and table_name');
		}
		$sql = 'update '.$table_name.' set ';
		foreach ($products_arr as $field=>$val){
			$sql .= $field.'="'.$val.'",';
		}
		$sql = trim($sql,',') . ' where '.$primary_key.'="'.$primary_value.'" ';
		return $sql;
	}
	
	if (empty($table_name) ) {
			die('error: you must set table_name');
	}
		
	$products_table_fields = '('.implode( ',' , array_keys($products_arr)) . ')';
	$products_table_values = '("'.implode( '","' , array_values($products_arr)) .'")';
	$sql = 'insert into '.$table_name.$products_table_fields.'values'.$products_table_values;
	return $sql;
}
function genSqlByArr($products_arr,$table){
	
	$update_products_id = (int)$_REQUEST['update_products_id'];
	if($update_products_id){
		$sql = 'update '.$table.' set ';
		foreach ($products_arr as $field=>$val){
			$sql .= $field.'="'.$val.'",';
		}
		$sql = trim($sql,',') . ' where products_id="'.$update_products_id.'" ';
		return $sql;
	}
	
	$products_table_fields = '('.implode( ',' , array_keys($products_arr)) . ')';
	$products_table_values = '("'.implode( '","' , array_values($products_arr)) .'")';
	$sql = 'insert into '.$table.$products_table_fields.'values'.$products_table_values;
	return $sql;
}
function create_html_editor($input_name, $input_value = '',$height=320)
{
	include_once('includes/fckeditor/fckeditor.php'); // 包含 html editor 类文件
	
    $editor = new FCKeditor($input_name);
    $editor->BasePath   = './includes/fckeditor/';
    $editor->ToolbarSet = 'Default';
    $editor->Width      = '100%';
    $editor->Height     = $height;
    $editor->Value      = $input_value;
    $FCKeditor = $editor->CreateHtml();
    return $FCKeditor;
}




function mark_time()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}










