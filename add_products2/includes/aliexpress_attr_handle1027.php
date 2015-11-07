<?php

	$product_attr = new ProductAttrModel();
	//把属性名添加到数据库表
	$attr_name = $_POST['attr_name']?trim($_POST['attr_name']):'';
	$attr_type = $_POST['attr_type']?trim($_POST['attr_type']):'0';
	$arr = array('attr_name'=>$attr_name,'attr_type'=>$attr_type);
	
	if(empty($language_id)){
		$language_id = $_POST['language_id']?trim($_POST['language_id']):'3';
	}

	$product_attr->language = $language_id;
	$msg .= $product_attr->addProductsOptions($arr);
	
	
	
	//把属性值添加到数据库表
	$attr_values = $_POST['attr_value']?$_POST['attr_value']:array();
	$attr_sort = $_POST['attr_sort']?$_POST['attr_sort']:array();
	
	$arr = array('option_val'=>$attr_values, 'attr_sort'=>$attr_sort);
	$msg .= $product_attr->addProductsOptionsValues($arr);
	
	//把产品和属性关联起来
	if(empty($products_id)){
		$products_id = $_POST['products_id']?trim($_POST['products_id']):'';
	}
	
	if(empty($products_id)){
		die('产品id为空，不能添加产品属性');
	}
	$attr_price = $_POST['attr_price']?$_POST['attr_price']:array();
	$attr_weight = $_POST['attr_weight']?$_POST['attr_weight']:array();
	
	$arr = array('products_id'=>$products_id, 'attr_price'=>$attr_price, 'attr_weight'=>$attr_weight, 
	'attr_sort'=>$attr_sort);
	$msg .= $product_attr->addProductsAttributes($arr);