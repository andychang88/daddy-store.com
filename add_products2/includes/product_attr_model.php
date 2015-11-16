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
class ProductAttrModel extends CommonBase{
	
	var $language = 3;	//default language code is english
	var $options_id = 0;
	var $options_values_id_arr = array();
	
	
	function __construct($config=array()){
		
	}
	
	function getAllAttributes(){
		$sql = "select * from products_options where language_id=".$this->language." and trim(products_options_name) !='' and not isnull(products_options_name) order by products_options_name asc ";
		$rows = $GLOBALS['db']->getAll($sql);
		return $rows;
	}
	
	function getAttributeValues($attr_id){
		$sql = "select pov.* 
			from products_options_values_to_products_options povtp 
			left join products_options_values pov on povtp.products_options_values_id=pov.products_options_values_id 
			where  pov.language_id = ".$this->language." and povtp.products_options_id = ".(int)$attr_id;
		$rows = $GLOBALS['db']->getAll($sql);
		return $rows;
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
	* 一个产品属性对应多个属性值;添加属性值（如果属性值已经存在，就跳过不再添加了）
	*/
	function addProductsOptionsValues($arr_insert=array('option_val'=>array(),'attr_sort'=>array())){
		$option_val_arr = $arr_insert['option_val'];
		$attr_sort_arr = $arr_insert['attr_sort'];
		$msg = '';
		$val_id_arr = array();
		
		foreach ($option_val_arr as $key=>$option_val){
			if(empty($option_val)){
				continue;
			}
			
			$sql = "select products_options_values_id 
					from products_options_values 
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
					
					$val_id_arr[] = $GLOBALS['db']->getOne($sql.$order_by);

					$msg .= "<br>属性值".$option_val."添加成功。";
		
			}else{
				$msg .= "<br>属性值".$option_val."已经存在。";
				$val_id_arr[] = $max_id;
			}
			
			
		}
		
		$this->options_values_id_arr = $val_id_arr;

	    return $msg;
			
	}
	
	function addProductsAttributes($arr_insert){
		$products_id = $arr_insert['products_id']?trim($arr_insert['products_id']):'';
		$attr_price = $arr_insert['attr_price']?$arr_insert['attr_price']:array();
		$attr_weight = $arr_insert['attr_weight']?$arr_insert['attr_weight']:array();
		$attr_sort = $arr_insert['attr_sort']?$arr_insert['attr_sort']:array();
		
		$attr_options_id_arr = $this->options_values_id_arr;
		$options_id = $this->options_id;
		//echo '$options_id:'.$options_id;exit;
		if(count($attr_options_id_arr) != count($attr_price)){
			print("属性值和价格个数不匹配");
			echo '<pre>POST值：<br>';print_r($_POST);
			echo 'values_id_arr:<br>';print_r($attr_options_id_arr);
			exit;
		}
		
			//该产品的该属性，如果以及设置过，则删除掉，重新设置
			$sql = "delete from products_attributes where products_id=".$products_id." and options_id=".$options_id." ";
			$GLOBALS['db']->query($sql);
			
		foreach ($attr_options_id_arr as $key=>$options_value_id){
			
			
			$price_str = (int)($attr_price[$key]);
			$weight_str = (int)($attr_weight[$key]);
			
			list($price_prefix, $options_values_price) = splitNumberStr($price_str);
			list($products_attributes_weight_prefix, $products_attributes_weight) = splitNumberStr($weight_str);
			
			
			//把options 和 options_values关联起来，供以后使用
			$options_select = "select count(*) as cnt 
								from products_options_values_to_products_options 
								where products_options_id=".$options_id." and products_options_values_id=".$options_value_id;
			$cnt = $GLOBALS['db']->getOne($options_select);
			
			if ( $cnt == 0 ){
				$arr_options = array('products_options_id'=>$options_id, 'products_options_values_id'=>$options_value_id);
				$GLOBALS['db']->autoExecute('products_options_values_to_products_options', $arr_options);
			}
			
			
			//产品和属性关联起来
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