<?php

	$product_attr = new ProductAttrModel();
	//把属性名添加到数据库表
	$attr_name = $_POST['attr_name'];
	$attr_name_selects = $_POST['attr_name_selects'];
	$attr_type = $_POST['attr_type'];
	$attr_value = $_POST['attr_value'];
	$attr_price = $_POST['attr_price'];
	$attr_weight = $_POST['attr_weight'];
	$attr_sort = $_POST['attr_sort'];
	
	
	if(empty($language_id)){
		$language_id = $_POST['language_id']?trim($_POST['language_id']):'3';
	}
	
	$product_attr->language = $language_id;
	
	
	
	//把产品和属性关联起来
	if(empty($products_id)){
		$products_id = $_POST['products_id']?trim($_POST['products_id']):'';
	}
	
	if(empty($products_id)){
		die('产品id为空，不能添加产品属性');
	}
	
	
	foreach($attr_name as $tmp_attr_name_key=>$tmp_attr_name){
		
		//如果指定了属性名，则添加新的属性
		if(!empty($tmp_attr_name)){
			$attr_arr = array('attr_name'=>$tmp_attr_name,'attr_type'=>$attr_type[$tmp_attr_name_key]);
			$msg .= $product_attr->addProductsOptions($attr_arr);//添加属性名
		} else {
			$product_attr->options_id = $attr_name_selects[$tmp_attr_name_key];//需要手动指定
		}
		
		//尝试添加属性值（如果属性值已经存在，就自动生成options_values_id_arr数组，跳过不再添加了）
		$arr = array('option_val'=>$attr_value[$tmp_attr_name_key], 'attr_sort'=>$attr_sort[$tmp_attr_name_key]);
		$msg .= $product_attr->addProductsOptionsValues($arr);
		
		//把产品和属性关联起来
		$arr = array('products_id'=>$products_id, 
					'attr_price'=>$attr_price[$tmp_attr_name_key], 
					'attr_weight'=>$attr_weight[$tmp_attr_name_key], 
					'attr_sort'=>$attr_sort);
		$msg .= $product_attr->addProductsAttributes($arr);
	}
	
	
	
	
	
	
	
	
	