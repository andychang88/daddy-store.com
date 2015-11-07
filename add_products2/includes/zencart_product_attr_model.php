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
class ZencartProductAttrModel extends CommonBase{
	
	var $language = 3;	//default language code is english
	var $options_id = 0;
	var $options_values_id_arr = array();
	var $options_values_id_arr_price = array();
	
	
	function __construct($config=array()){
		
	}
	
	function addProductsOptions($arr_insert=array('attr_name'=>'','attr_type'=>'')){
		$attr_name = $arr_insert['attr_name'];
		$attr_type = $arr_insert['attr_type'];
		$msg = '';
		
		$sql = "select products_options_id from products_options where language_id=".$this->language;
		$cond = "  and products_options_name='$attr_name'   and products_options_type=".$attr_type ;
		$order_by = " order by products_options_id desc limit 1";
		
		$max_products_options_id = $GLOBALS['db']->getOne($sql.$cond.$order_by);
		
		if(!empty($max_products_options_id)){
			$msg .= "要添加的属性名".$attr_name."已经存在";
			$this->options_id = $max_products_options_id;
		}else{
			//属性添加到数据库表
			$max_products_options_id = $GLOBALS['db']->getOne($sql.$order_by);
			
			$new_products_options_id = $max_products_options_id + 1;
			
			$arr_insert = array(
			'products_options_id'=>$new_products_options_id,
			'language_id'=>$this->language,
			'products_options_name'=>$attr_name,
			'products_options_type'=>$attr_type
			);
			
			$GLOBALS['db']->autoExecute('products_options', $arr_insert);
			$this->options_id = $GLOBALS['db']->getOne($sql.$order_by);
			$msg .= "<br>添加属性成功";
			
		}
		
		return $msg;
	
	}
	/*
	* 一个产品属性对应多个属性值
	*/
	function addProductsOptionsValues($arr_insert=array('option_val'=>array(),'price_arr'=>array(),'attr_sort'=>array())){
		$option_val_arr = isset($arr_insert['option_val'])?$arr_insert['option_val']:array();
		$price_arr = isset($arr_insert['price_arr'])?$arr_insert['price_arr']:array();
		$attr_sort_arr = isset($arr_insert['attr_sort'])?$arr_insert['attr_sort']:array();
		
		$msg = '';
		$val_id_arr = array();
		$val_id_price_arr = array();
		
		foreach ($option_val_arr as $key=>$option_val){
			if(empty($option_val)){
				continue;
			}
			
			
			
			$sql = "select products_options_values_id from products_options_values 
			where language_id=".$this->language."  ";
			$cond = " and products_options_values_name='$option_val' " ;
			$order_by = " order by products_options_values_id desc limit 1";
			$max_id = $GLOBALS['db']->getOne($sql.$cond.$order_by);
			
			if(empty($max_id)){
				
					$max_id = $GLOBALS['db']->getOne($sql.$order_by);
					$max_id = $max_id + 1;
					
					$products_options_values_sort_order = $attr_sort_arr['attr_sort'][$key]?(int)$attr_sort_arr['attr_sort'][$key]:0;

					$arr_insert = array('products_options_values_id'=>$max_id,
										'language_id'=>$this->language, 
										'products_options_values_name'=>$option_val,
										'products_options_values_sort_order'=>$products_options_values_sort_order,
												);
					$GLOBALS['db']->autoExecute('products_options_values', $arr_insert);
					
					$tmp_id = $GLOBALS['db']->getOne($sql.$order_by);
					$val_id_arr[] = $tmp_id;
					
					if(isset($price_arr[$key])){
						$val_id_price_arr[$tmp_id] = $price_arr[$key];
					}else{
						$val_id_price_arr[$tmp_id] = 0;
					}

					$msg .= "<br>属性值".$option_val."添加成功。";
					
					
					
					//products_options_values_to_products_options 如果不添加这个表，前台可以正常显示。后台添加属性的时候，看不到这个属性
					$options_id = $this->options_id;
					
					$sql = "select * from products_options_values_to_products_options where products_options_id='".$options_id."' and products_options_values_id='".$tmp_id."' limit 1";
					$tmp = $GLOBALS['db']->getOne($sql);
					
					if(empty($tmp)){
						$arr_insert = array('products_options_id'=>$options_id,'products_options_values_id'=>$tmp_id);
						$GLOBALS['db']->autoExecute('products_options_values_to_products_options', $arr_insert);
					}
		
			}else{
				$msg .= "<br>属性值".$option_val."已经存在。";
				$val_id_arr[] = $max_id;
				
					if(isset($price_arr[$key])){
						$val_id_price_arr[$max_id] = $price_arr[$key];
					}else{
						$val_id_price_arr[$max_id] = 0;
					}
			}
			
			
		}
		
		$this->options_values_id_arr = $val_id_arr;
		$this->options_values_id_arr_price = $val_id_price_arr;

	    return $msg;
			
	}
	
	function addProductsAttributes($arr_insert){
		$products_id = $arr_insert['products_id']?trim($arr_insert['products_id']):'';
		$attr_price = $arr_insert['attr_price']?$arr_insert['attr_price']:array();
		$attr_weight = $arr_insert['attr_weight']?$arr_insert['attr_weight']:array();
		$attr_sort = $arr_insert['attr_sort']?$arr_insert['attr_sort']:array();
		
		$attr_options_id_arr = $this->options_values_id_arr;
		$options_values_id_arr_price = $this->options_values_id_arr_price;
		
		$options_id = $this->options_id;
		//echo '$options_id:'.$options_id;exit;
		
		/**
		if(count($attr_options_id_arr) != count($attr_price)){
			print("属性值和价格个数不匹配");
			echo '<pre>POST值：<br>';print_r($_POST);
			echo 'values_id_arr:<br>';print_r($attr_options_id_arr);
			exit;
		}
		/**/
		
			//该产品的该属性，如果以及设置过，则删除掉，重新设置
			$sql = "delete from products_attributes where products_id=".$products_id." and options_id=".$options_id." ";
			$GLOBALS['db']->query($sql);
			
		foreach ($attr_options_id_arr as $key=>$options_value_id){
			
			if(empty($attr_price[$key])){
				$price_str = 0;
			}else{
				$price_str = (float)($attr_price[$key]);
			}
			
			//是否设置了  属性价格数组
			if(isset($options_values_id_arr_price[$options_value_id])){
				$price_str = $options_values_id_arr_price[$options_value_id];
			}
			
			
			
			if(empty($attr_weight[$key])){
				$weight_str = 0;
			}else{
				$weight_str = (int)($attr_weight[$key]);
			}
			
			//echo '$options_value_id:'.$options_value_id;
			
			
			list($price_prefix, $options_values_price) = splitNumberStr($price_str);
			list($products_attributes_weight_prefix, $products_attributes_weight) = splitNumberStr($weight_str);
			
			
			
			
			
			$sql = "select 1 from products_attributes
				where products_id=".$products_id." and options_id=".$options_id."
				and options_values_id=".$options_value_id." and options_values_price='".$options_values_price."' limit 1";
			$a = $GLOBALS['db']->getAll($sql);
			
			if(!empty($a)) {
				//echo $sql;
				continue;
			}
			
			
			$arr_insert = array('products_id'=>$products_id, 
			'options_id'=>$options_id, 
			'options_values_id'=>$options_value_id, 
			'options_values_price'=>$options_values_price, 
			'price_prefix'=>$price_prefix,
			'products_options_sort_order'=> $attr_sort[$key],
			'products_attributes_weight'=>$products_attributes_weight, 
			'products_attributes_weight_prefix'=>$products_attributes_weight_prefix);
			
			
			
		
		
			$GLOBALS['db']->autoExecute('products_attributes', $arr_insert);
			
		}
		
		$msg .= "<br>属性和产品关联成功。";
		return $msg;
		
	}
	

	
	
	
}