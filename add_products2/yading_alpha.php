<?php 
include 'includes/init.php';
include 'includes/CommonBase.php';
include 'includes/zencart_product_model.php';
include 'includes/zencart_product_attr_model.php';

$act = $_REQUEST['act']?$_REQUEST['act']:'';
$is_iframe_url = (int)$_GET['is_iframe_url'];
$url_is_cat = $_REQUEST['url_is_cat'];

echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
if(!empty($act)){
	$pm = new ZencartProductModel();
}


$sql = "select smt_account from 2012add_products_setting  group by  smt_account";
$setting_smt_account = $db->getAll($sql);


//echo file_get_contents('http://www.aliexpress.com/item/Retro-Candy-Color-Women-Lady-Girl-Shoulder-Bag-Satchel-Messenger-Handbag-Totes/1408711712.html');exit;
/**
$content = '<div id="display" class="new-6-images">
<div class="image-nav">
<ul>
<li><a href="#"><img src="http://i00.i.aliimg.com/wsphoto/v1/1145479516_1/Free-shipping-2013-girls-princess-dress.jpg_50x50.jpg" alt="Free shipping 2013 girls princess dress" /></a></li> 
<li><a href="#"><img src="http://i00.i.aliimg.com/wsphoto/v1/1145479516_2/Free-shipping-2013-girls-princess-dress.jpg_50x50.jpg" alt="Free shipping 2013 girls princess dress" /></a></li> 
</ul>
</div>';
preg_match_all($preg,$content,$arr);
print_r($arr);

echo 'finish';exit;
/**/
/**

	$str = '   <div id="product-info-sku">
								                                                <dl class="product-info-color">
                                                    <dt class="pp-dt-ln sku-color-title">
                                                        Color:
                                                    </dt>
                                                    <dd>
                                                        <ul id="sku-color" class="sku-attr sku-color clearfix">
																						<li><a class="sku-value attr-sku1" id="sku-1-173" title="Blue" href="javascript:void(0)"><span class="color sku-color-173" title="Blue"></span></a></li>
																														<li><a class="sku-value attr-sku1" id="sku-1-200001438" title="Khaki" href="javascript:void(0)"><span class="color sku-color-200001438" title="Khaki"></span></a></li>
															                                                        </ul>
                                                        <div class="msg-error sku-msg-error" style="display:none;">
															Please select a Color
                                                        </div>
                                                    </dd>
                                                </dl>
	
								                                                <dl class="product-info-size">
                                                    <dt class="pp-dt-ln sku-title">
                                                        Kid US Size:
                                                    </dt>
                                                    <dd>
																																																																																																							<ul id="sku-sku2" class="sku-attr sku-checkbox clearfix">
																						<li><a class="sku-value attr-checkbox" id="sku-2-200004188" href="javascript:void(0)"><span>3T</span></a></li>
																							<li><a class="sku-value attr-checkbox" id="sku-2-200004189" href="javascript:void(0)"><span>4T</span></a></li>
																							<li><a class="sku-value attr-checkbox" id="sku-2-200004191" href="javascript:void(0)"><span>5</span></a></li>
																							<li><a class="sku-value attr-checkbox" id="sku-2-200004192" href="javascript:void(0)"><span>6</span></a></li>
																							<li><a class="sku-value attr-checkbox" id="sku-2-200004193" href="javascript:void(0)"><span>7</span></a></li>
															                                                        </ul>
                                                        <div class="msg-error sku-msg-error" style="display:none;">
															Please select a Kid US Size
                                                        </div>
                                                    </dd>
                                                </dl>
	
					
	    </div>
								';
			
	preg_match_all("#<dl[^>]*?>[\s\S]+?<\/dl>#i",$str,$arr);
	
	if(!empty($arr)){
		foreach($arr[0] as $key=>$val){
			
			//匹配属性标题
			$preg_dt = "/<dt.*?>([\s\S]+?)</i";
			preg_match($preg_dt,$val,$arr);
			
			$attr_name_tmp = "";
			$attr_val_tmp_arr = array();
			
			if(!empty($arr)){
				$attr_name_tmp = $arr[1];
			}
			
			//匹配属性值
			
			//<span class="color sku-color-173" title="Blue"></span>
			$preg_li = '/<span.*?title="([^"]+)"/i';
			preg_match_all($preg_li,$val,$arr);
			//echo '==========<pre>';print_r($arr);exit;
			if(!empty($arr)){
				$attr_val_tmp_arr = $arr[1];
			}else{
				
				//<span>3T</span>
				$preg_li = '/<span>([^<]+)<"/i';
				preg_match_all($preg_li,$val,$arr);
				if(!empty($arr)){
					$attr_val_tmp_arr = $arr[1];
				}
			}
			
			
			
			
		}
	}
		/**/
		
		
		
		
		
		
		
		
		
		
		
		
			
$filter_attr_arr = array(
'start_str'=>'<div class="det-cont-hd">Available Options',
'end_str'=>'<div class="det-rt">',
'preg'=>'',
'use_extract'=>true,

);



$filter_content_arr = array(
'start_str'=>'<td class="main"><p><p>',
'end_str'=>'<!-- attributes -->',
'preg'=>'',
'use_extract'=>true,
'extract_arr'=>array(
		     array(
		'start_str'=>'',
		'end_str'=>'<div class="ui-box ui-box-normal product-custom-desc" id="custom-description"'),
		     array(
		'start_str'=>'<div id="transaction-history">',
		'end_str'=>'</table>'),
		     array(
		'start_str'=>'<table style="border-bottom: #d6d6d6 1.0px solid;border-left: #d6d6d6 1.0px solid;',
		'end_str'=>'</table>'),
		     
		     
		     ),
'delete_str'=>array(
		'<td class="main">',
		'</td>',
		'</tr>',
	
)
);
 
$title_filter_content_arr = array(
//'start_str'=>'<h1 id="product-name" class="PBOF[^"]+PEOF" itemprop="name">',
'start_str'=>'<span itemprop="name"><div class="det-hd">',
'end_str'=>'</div></span>',
);
$price_filter_content_arr = array(
'start_str'=>'<span class="productSpecialPrice">AU$<span itemprop="price">',
'end_str'=>'</span>',
'addition'=>array(
array('start_str'=>'id="sku-price"','end_str'=>'</span>','use_extract'=>true),

),

);

$litter_img_filter_content_arr = array(
//'start_str'=>'<li class="image-nav-item" ><span>',
//'end_str'=>'</span>',



'enlarge_image_a_preg'=>'/id="lnk-enlarge-image"\s*href="(.+?)"/',
'img_url_from_enlarge_page_preg'=>'/<img src="([^"]+)"/',
'img_url_from_enlarge_page_arr'=>array(
				       'start_str'=>'<ul class="new-img-border">',
					'end_str'=>'</ul>',
					'use_extract'=>true,
				       ),
);


if($act == 'save_product_to_cache' || (!empty($url_is_cat) && $url_is_cat==1) ){
	
	
	
	$smt_account = $_REQUEST['smt_account']?trim($_REQUEST['smt_account']):'';
	$cat_id = $_POST['products_cat']?$_POST['products_cat']:130;
		
		
		
		$reduce_price_num = $_POST['reduce_price_num']?$_POST['reduce_price_num']:0;
		
		
		$products_weight = $_POST['products_weight']?$_POST['products_weight']:50;
		
		
		$language_id = $_POST['language_id']?$_POST['language_id']:3;
		$is_set_attr = $_POST['is_set_attr']?$_POST['is_set_attr']:0;
		$site_name = $_POST['site_name']?$_POST['site_name']:0;
		
		
		$from_url = $_POST['aliexpress_url'];
		
		
		
	
	
	
	
	
	$sql = "select 1 from 2012add_products_setting where from_url = '".$from_url."'  limit 1";
	$status = $GLOBALS['db']->getOne($sql);	
	if(strlen($status)>0){
		die("该分类已经存在");
	}else{
		$sql = "insert into 2012add_products_setting(from_url,reduce_price_num,website_name,weight,language_id,cat_id,smt_account)
					values('$from_url','$reduce_price_num','$site_name','$products_weight','$language_id','$cat_id','$smt_account')";
		$GLOBALS['db']->query($sql);
		
		$setting_id = $GLOBALS['db']->insert_id();
	}
	
	
	
	
	//$remote_url_cat = 'http://www.aliexpress.com/store/433188';

	$preg = '/<a\s+class="pic-rind"\s+href="([^"]+)"\s*>/';
	$content = file_get_contents($from_url);
	
	preg_match_all($preg,$content,$url_arr);
	//print_r($arr);
	
	if(empty($url_arr[1])){
		$preg = '/<a\s+class="picRind"\s+href="([^"]+)"/';
		preg_match_all($preg,$content,$url_arr);
	}
	
	
	if(empty($url_arr[1])){
		die("没有匹配到任何产品");
	}
	
	foreach($url_arr[1] as $key=>$val){
		preg_match("/(\d+)\.html/i",$val,$arr);
		if(!empty($arr)){
			
			$sql = "select status from 2012add_products where from_url like '%".$arr[1]."%'  limit 1";
			$status = $GLOBALS['db']->getOne($sql);//var_dump($status);
			
			if(strlen($status)>0){
				echo "该产品已经抓取过";
			}else{
				
				$add_time = date("Y-m-d H:i:s");
				
				
				$sql = "insert into 2012add_products(products_id,from_url,add_time,status,smt_account,cat_id,setting_id)
					values('','$val','$add_time',0,'$smt_account','$cat_id','$setting_id')";
				$GLOBALS['db']->query($sql);
			}
		}
	}
	
	
	
	echo 'finish';exit;


	
}
	
	
	
if($act == 'delete_product'){
	$products_id_str = $_REQUEST['products_id_str']?trim($_REQUEST['products_id_str']):'';
	
	
	
	$pm = new ZencartProductModel();
	$msg = $pm->deleteProduct($products_id_str);
	
	echo "finish<br>";
	
	die($msg);
	
}


if( ($act == 'save_detail' || $act == 'auto_get_product')  && empty($url_is_cat) ){
	
	if($act == 'auto_get_product'){//自动抓取产品

		$sql = "select from_url,setting_id from 2012add_products where 1 and status=0 order by add_time asc ";
		$row = $db->getRow($sql);
		if(!empty($row)){
			
			$is_set_attr = 0;
			//echo '<pre>';print_r($row);exit;
			$setting_id = $row['setting_id'];
			$from_url = $row['from_url'];
			
			$sql = "select * from 2012add_products_setting where 1 and setting_id ='$setting_id'  ";
			$row = $db->getRow($sql);
			if(empty($row)){
				die('在表2012add_products_setting中没有找到'.$from_url.'的对应设置信息');
			}
			$products_cat = $row['cat_id'];
			$reduce_price_num = $row['reduce_price_num'];
			$site_name = $row['website_name'];
			$products_weight = $row['weight'];
			$language_id = $row['language_id'];
			$site_name = $row['website_name'];
		
		}else{
			die('数据抓取完成了');
		}
	}else{
		$products_cat = $_POST['products_cat']?$_POST['products_cat']:130;
		
		
		
		$reduce_price_num = $_POST['reduce_price_num']?$_POST['reduce_price_num']:0;
		
		
		$products_weight = $_POST['products_weight']?$_POST['products_weight']:500;
		
		
		$language_id = $_POST['language_id']?$_POST['language_id']:3;
		$is_set_attr = $_POST['is_set_attr']?$_POST['is_set_attr']:0;
		$site_name = $_POST['site_name']?$_POST['site_name']:0;
		
		
		$from_url = $_POST['aliexpress_url'];
	}
	
	
	if(empty($from_url)){
		die('error:empty aliexpress_url');
	}
/**
	$from_url_tmp = "http://www.aliexpress.com/item/title/pid.html";
	preg_match("/(\d+)\.html/i",$from_url,$arr);
	if(!empty($arr)){
		$from_url = str_replace("pid",$arr[1],$from_url_tmp);
		
		$get_again = $_REQUEST['get_again'];
		
		if($get_again == 1){
			
		}else{
			
			$sql = "select status from 2012add_products where from_url like '%".$arr[1]."%'  limit 1";
			$status = $GLOBALS['db']->getOne($sql);//var_dump($status);
			
			if($status == 1){
				die("该产品已经抓取过");
			}
			
		}
		
		
	}
	/**/
	$pm->from_url = $from_url;
	
	
	
	
	$pm->reduce_price_num = $reduce_price_num;
	$pm->site_name = $site_name;
	
	if(!empty($language_id)){
		$pm->language_id = $language_id;
	}elseif(defined('DEFAULT_LANGUAGE_ID')){
		$pm->language_id = DEFAULT_LANGUAGE_ID;
	}
	
	$pm->products_cat = $products_cat;
	$pm->products_weight = $products_weight;
	
	$pm->description_filter = $filter_content_arr;
	$pm->title_filter = $title_filter_content_arr;
	$pm->price_filter = $price_filter_content_arr;
	$pm->product_img_filter = $litter_img_filter_content_arr;
	//echo '<pre>====';print_r($pm->product_img_filter);exit;
	
	$pm->filter_attr_arr = $filter_attr_arr;
	
	$pm->products_model = 'ali'.date('YmdHis');
	$pm->products_afterbuy_model = $pm->products_model;
	
	
	
	//$url = 'http://www.aliexpress.com/fm-store/604445/211047357-530629675/Free-Shipping-Newest-Visible-Green-Smart-Charger-Sync-Cable-for-iPhone-iPod-Touch-iPad-indicate-how.html?promotionId=100009102';

	//$url = 'aa.txt';
	
	//$pm->html_content = file_get_contents('a.txt');
	$pm->from_url = 'http://localhost/data/a.txt';
	$pm->html_content = file_get_contents($pm->from_url);
	
	
	$msg = $pm->addProduct();
	
	
	//$pm->getAttr();
	
	$products_id = $pm->new_products_id;
	//$products_id = 159807;//echo $products_id;exit;
	echo '新增产品id:'.$products_id;
	echo '<br>';
	
	if(1){
		
		$product_attr = new ZencartProductAttrModel();
		
		
		$attr_str_arr = $pm->attr_str_arr;
		
		
		$base_price = $pm->product_info['price'];
		
		foreach($attr_str_arr as $key=>$val){
			//匹配属性标题
			$preg_dt = "/<dt.*?>([\s\S]+?)</i";
			preg_match($preg_dt,$val,$arr);
			
			$attr_name_tmp = "";
			$attr_val_tmp_arr = array();
			
			if(!empty($arr)){
				$attr_name_tmp = str_replace(":","",trim($arr[1]));
			}
			
			
			
			
			//forexample: size,color
			$opt_name_arr = array('attr_name'=>$attr_name_tmp,'attr_type'=>0);
			$product_attr->language = 3;
			//echo '<pre>';print_r($opt_name_arr);exit;
			$msg .= $product_attr->addProductsOptions($opt_name_arr);
			
		
			
			//匹配属性值
			
			//forexample: red,blue,purse
			//<span class="color sku-color-173" title="Blue"></span>
			$preg_li = '/id="sku\-\d+\-(\d+).+?<span.*?title="([^"]+)"/i';
			preg_match_all($preg_li,$val,$arr);
			//echo '====88======<pre>';print_r($arr);exit;
			if(!empty($arr[1])){
				$attr_val_id_tmp_arr = $arr[1];
				$attr_val_tmp_arr = $arr[2];
			}else{
				
				//<span>3T</span>
				$preg_li = '/id="sku\-\d+\-(\d+).+?<span>([^<]+)</i';
				preg_match_all($preg_li,$val,$arr);
				if(!empty($arr)){
					$attr_val_id_tmp_arr = $arr[1];
					$attr_val_tmp_arr = $arr[2];
				}
			}
			
			
			
			$price_arr = array();
			
			
			if(count($attr_val_id_tmp_arr) > 1){
				//获取属性对应的价格
				foreach($attr_val_id_tmp_arr as $key=>$val){
					$find_p_preg = '/skuPropIds":"'.$val.'.+?"skuCalPrice":"([^"]+)"/i';
					preg_match($find_p_preg,$pm->html_content,$arr_tmp);
					
					if(empty($arr_tmp)){
						$price_arr[] = 0;
					}else{
						
						
						$sku_price = $arr_tmp[1];
						if( ($sku_price - $pm->reduce_price_num) >0){
								$sku_price = $sku_price - $pm->reduce_price_num;
						}
							
							
						if($base_price<=$sku_price){
							$price_arr[] = "+".($sku_price-$base_price);
						}else{
							$price_arr[] = "-".($base_price - $sku_price);
						}
						
					}
				}
			}
			
			//echo '<pre>';print_r($arr);print_r($price_arr);exit;
			
			//属性id,为了匹配到属性价格
			$preg_attr_id = '';
			
			
			//echo $val;echo '<pre>';print_r($attr_val_tmp_arr);exit;
			
			//添加属性值到数据库，同时设置 属性对应的价格
			if(!empty($attr_val_tmp_arr)){
				
				$attr_val_arr = array('option_val'=>$attr_val_tmp_arr,'price_arr'=>$price_arr, 'attr_sort'=>array());
				$msg .= $product_attr->addProductsOptionsValues($attr_val_arr);
				
			}
			
			//把产品和属性关联起来
			
			$arr = array('products_id'=>$products_id);
			$msg .= $product_attr->addProductsAttributes($arr);
			
			
			
		}
		//include 'includes/zencart_products_attr_handle_v2.php';
	}
	
	
	//echo '<div style="width:500px;background:#ddd;word-wrap:break-word;">';
	//$pm->debug(0);
	//echo '</div>';
}

if($act == 'move_product_cat'){
	
	$msg = $pm->moveProductCategory();
	echo "finish<br>";
	
	die($msg);
}
if($act == 'del_product_cat'){
	
	$msg = $pm->delProductCategory();
	echo "finish<br>";
	
	die($msg);
}
if($act == 'del_product_in_cat'){
	
	$msg = $pm->delProductInCategory();
	echo "finish<br>";
	
	die($msg);
}

if($act == 'open_ali_url'){
	
	$products_id = preg_replace("/\D/","",$_REQUEST['products_id']);
	if(empty($products_id)){
		die("empty products_id");
	}
	
	$url = 'http://www.aliexpress.com/item/title/'.$products_id.'.html';
	header("location:".$url);
	exit;
	
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<script language="javascript" src="<?php echo JS_JUQERY;?>"></script>
<style type="text/css">
.test{
border:1px solid red;width:300px;height:300px;overflow:hidden;
}
</style>
<style type="text/css">
html,body{font-family:tahoma,arial,宋体,sans-serif;font-size:12px;padding:0px;margin:0px;}
.wrap{border:1px solid #ccc;margin:50px 100px;}
table{width:100%;border-collapse:collapse;border:1px solid #ccc;}
td{padding:5px 10px;border:1px solid #ccc;}
.align_right{text-align:right;}
.tip{font-weight:bold;padding:10px;color:red;text-align:center;}
.steps{margin:10px;}
.tip{color:#999;font-weight:normal;}
</style>
<script language=javascript>
$(function(){
	if($('#is_set_attr_1').is(':checked')){
		setAttrState(1);
	}else{
		setAttrState(0);
	}
	
})
function clearUrl(){
	var d = document.getElementById('aliexpress_url');
	d.value = '';
	d.focus();
}
function deleteAttrValue(obj_a){
	if($(obj_a).parents('table').find('tr.attr_tr').length>1)
	$(obj_a).parents('tr:first').remove();
}
function addAttrValue(obj_a){
	var tr = $(obj_a).parents('tr:first').clone(true);
	$(obj_a).parents('tr:first').after(tr);
}
function setAttrState(s){
	if(s==0){
		$('#attr_container').hide();
	}else{
		$('#attr_container').show();
	}
}

function continueAutoCrach(){
	setTimeout(function(){
		$('#auto_get_product_btn').click();
	},2000);
	
}

function test_fun(){
	top.continueAutoCrach();
}
var action = '<?php echo $act;?>';
var is_iframe_url=<?php echo $is_iframe_url;?>;

$(function(){

	if(action == 'auto_get_product'){
		top.continueAutoCrach();
	}
	
	$('#save_to_cache').click(function(){
		$('#hide_act').val('save_product_to_cache');
		$('#add_form_submit').click();
		
		
	})
	
});


</script>
</head>
<body>

<?php if($is_iframe_url || ($act == 'save_detail' && !empty($msg)) ){?>

	<div class="tip"><?php echo $msg;?></div>

<?php
exit;
}

?>

<iframe id="info_iframe" src="aliexpress_alpha.php?is_iframe_url=1" style="margin-left:100px;margin-bottom:-40px;"  name="info_iframe" width="1200px" height="350px"></iframe>
 
<div class="wrap">
<p class="steps">
<b>使用步骤：</b><br>
1. 保存第三方网站图片到本地电脑上；以待第二步上传<br>
2. 填写上面框中的项目，以及上传图片<br>
3. 提交<br>
<b>注意：如果是现在本地更新，然后再由本地数据更新到外网数据，记得要上传本地图片(本地图片路径是：E:\cat\dhtml\images\)</b>

</p>

<?php if(!empty($msg)){?>
	<div class="tip"><?php echo $msg;?></div>
<?php }?>
<script language="javascript">
function clearUrl(){
	var d = document.getElementById('aliexpress_url');
	d.value = '';
	d.focus();
}
function beforeAddProductSubmit(){
	var val = $.trim($('#update_products_id').val());
	
	var products_cat = $.trim($('#products_cat').val());
	if(products_cat.length==0){
		alert('请输入分类');
		return false;
	}
	
	if(val.length>0){
		if(confirm('确实要更新产品'+val+'吗？')){
			return true;
		}else{
			$('#update_products_id').val('');
			return false;
		}
	}else{
		return true;
	}
}
function setDefaultFormAction(){
	$('#hide_act').val('save_detail');
}
</script><div id="test"><?php echo $msg;?></div>
<form action="" method="post" id="addForm" onsubmit="return beforeAddProductSubmit();"  target="info_iframe1111111">
<input type="hidden" name="act" id="hide_act" value="save_detail" />
<table>
	<tr><td colspan=2><h2><center>添加新产品</center></h2></td></tr>
	
	<tr><td width="20%" class="align_right">Aliexpress产品的url:</td>
	<td><input type="text" style="width:100%;" id="aliexpress_url" name="aliexpress_url" value="" /><a href="javascript:clearUrl();" style="font-weight:bold;color:blue;">清空</a>
	&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" onclick="setDefaultFormAction();" name="submit" value="  保存  " />
	</td>
	</tr>
	
	<tr><td class="align_right">是否是分类url:</td>
	<td><input type="checkbox" name="url_is_cat" value="1" /> </td>
	</tr>
	
	<tr><td class="align_right">重复抓取:</td>
	<td><input type="checkbox" name="get_again" value="1" /> </td>
	</tr>
	
	
	<tr><td class="align_right">在原价基础上减:</td>
	<td><input type="text" style="width:100%;" name="reduce_price_num" value="0" /> (输入负值为加)</td>
	</tr>
	
	
	
	<tr><td class="align_right">SMT账号:</td>
	<td><input type="text" style="width:20%;" name="smt_account" value="SMTO" /> 
		<select name="smt_account_done">
			<option value="">请点击查看</option>
			<?php
			foreach($setting_smt_account as $key=>$val){
				echo '<option selected=selected value="'.$val['smt_account'].'">'.$val['smt_account'].'</option>';
			}
			?>
		
		</select>
	</td>
	</tr>
	
	
	
	
	<tr><td class="align_right">网站名:</td>
	<td>
		<select name="site_name">
			<option value="all">2个</option>
			<option value="glstore2">glstore2</option>
		
		</select>
	</td>
	</tr>
	
	<tr><td class="align_right">要抓取的产品分类ID:</td>
	<td><input type="text" style="width:100%;" id="products_cat" name="products_cat" value="<?php echo $_COOKIE['products_cat']?>" /></td>
	</tr>
	
	<tr><td class="align_right">产品重量:</td>
	<td><input type="text" style="width:100%;" name="products_weight" value="<?php if(!empty($_COOKIE['products_weight'])) echo $_COOKIE['products_weight']; else echo 50;?>" /> 单位：克</td>
	</tr>
	
	<tr><td class="align_right">英语语言id:</td>
	<td><input type="text" style="width:100%;" name="language_id" value="3" /> <span class="tip">对于我自己的backever网站来说，英语语言id是3；其他人的网站英语语言一般是1（如果这个设置错误，在zencart网站上面看不到新添加的产品）</span></td>
	</tr>
	
	
	<tr><td class="align_right">要更新产品的id:</td>
	<td><input type="text" style="width:100%;color:red;font-weight:bold;" id="update_products_id" name="update_products_id" value="" /> <span class="tip">（更新指定的产品内容）</span></td>
	</tr>
	
	<tr><td class="align_right">是否设置产品属性:</td>
	<td><input type="radio" name="is_set_attr" value="0" onclick="setAttrState(0)"  />不设置   
	<input type="radio" name="is_set_attr" id="is_set_attr_1" value="1" checked onclick="setAttrState(1)"  />设置   
	</td>
	</tr>
	
	
	
</table>

<?php 
//include 'templates/aliexpress_attr_html.php';
?>

<div><center>
<br><input type="submit" id="add_form_submit" name="submit" onclick="setDefaultFormAction();"  value="  保存  " /><br></center>
</div>

<div><center>
<br><input type="button" style="display: none;" name="save_to_cache" id="save_to_cache" value=" 保存该分类下的产品到缓存   " /><br></center>
</div>




</form>



<form action="" method="post" target="_blank">
<input type="hidden" name="act" value="delete_product" />
<table>
	<tr><td colspan=2><h2><center>删除一个产品</center></h2></td></tr>
	
	<tr><td class="align_right">网站名:</td>
	<td>
		<select name="site_name">
			<option value="all">2个</option>
			<option value="backever">backever</option>
			<option value="usbexporter">usbexporter</option>
		</select>
	</td>
	</tr>
	
	
	<tr><td width="20%" class="align_right">产品的url或者产品id:</td>
	<td><input type="text" style="width:100%;" name="products_id_str" value="" /></td>
	</tr>
	
	
	<tr><td colspan=2 align="center"><input type="submit" name="submit" value="  删除  " />
	
	</td>
	
	</tr>
	
</table>
</form>
	
	
		<form action="" method="post" target="_blank">
<input type="hidden" name="act" value="del_product_cat" />
<table>
	<tr><td colspan=2><h2><center>删除目录</center></h2></td></tr>
	
	
	
	
	
	
	<tr><td width="20%" class="align_right">需要删除的目录id:</td>
	<td><input type="text" style="width:100%;" name="cat_id" value="" /></td>
	</tr>
	
	<tr><td colspan=2 align="center"><input type="submit" name="submit" value="  保存  " />
	
	</td>
	
	</tr>
	
</table>
</form>
		
	<form action="" method="post" target="_blank">
<input type="hidden" name="act" value="del_product_in_cat" />
<table>
	<tr><td colspan=2><h2><center>删除目录下的产品</center></h2></td></tr>
	
	
	
	
	
	
	<tr><td width="20%" class="align_right">需要删除的产品所在目录id:</td>
	<td><input type="text" style="width:100%;" name="cat_id" value="" /></td>
	</tr>
	
	<tr><td colspan=2 align="center"><input type="submit" name="submit" value="  保存  " />
	
	</td>
	
	</tr>
	
</table>
</form>		
		

<form action="aliexpress_alpha.php" method="post" id="auto_get_product_frm" target="_auto_get_product">
<input type="hidden" name="act" value="auto_get_product" />
<table>
	<tr><td colspan=2><h2><center>自动抓取产品</center></h2></td></tr>
	

	
	<tr><td colspan=2 align="center"><input type="submit" id="auto_get_product_btn" name="submit" value="  开始自动抓取  " />
	
	</td>
	
	</tr>
	
</table>
</form>
	

<form action="aliexpress_alpha.php" method="post" id="save_product_to_cache_frm" target="save_product_to_cache">
<input type="hidden" name="act" value="save_product_to_cache" />
<table>
	<tr><td colspan=2><h2><center>保存外部产品到缓存</center></h2></td></tr>
	
	<tr><td width="20%" class="align_right">外部产品的url:</td>
	<td><input type="text" style="width:100%;" name="products_url" value="" /></td>
	</tr>
	
	<tr><td width="20%" class="align_right">自己网站的目录ID:</td>
	<td><input type="text" style="width:100%;" name="cat_id" value="" /></td>
	</tr>
	
	
	
	<tr><td class="align_right">SMT账号:</td>
	<td>
		<select name="smt_account">
			<option value="">请选择</option>
			<option selected=selected value="SMTN">SMTN</option>
			<option value="usbexporter">usbexporter</option>
		</select>
	</td>
	</tr>
	
	

	
	<tr><td colspan=2 align="center"><input type="submit" id="save_product_to_cache_btn" name="submit" value="  提交  " />
	
	</td>
	
	</tr>
	
</table>
</form>




<form action="" method="post" target="_blank">
<input type="hidden" name="act" value="move_product_cat" />
<table>
	<tr><td colspan=2><h2><center>在目录之间中移动产品</center></h2></td></tr>
	
	
	
	
	
	<tr><td width="20%" class="align_right">是否禁用旧的目录:</td>
	<td><input type="checkbox" checked  name="is_disable_old_cat" value="1" /></td>
	</tr>
	
	
	
	<tr><td width="20%" class="align_right">原来的目录id:</td>
	<td><input type="text" style="width:100%;" name="old_cat_id" value="" /></td>
	</tr>
	
	
	
	<tr><td width="20%" class="align_right">后来的目录id:</td>
	<td><input type="text" style="width:100%;" name="new_cat_id" value="" /></td>
	</tr>
	
	<tr><td colspan=2 align="center"><input type="submit" name="submit" value="  保存  " />
	
	</td>
	
	</tr>
	
</table>
</form>



<form action="" method="post" target="_blank">
<input type="hidden" name="act" value="open_ali_url" />
<table>
	<tr><td colspan=2><h2><center>打开速卖通产品</center></h2></td></tr>
	
	
	
	
	<tr><td width="20%" class="align_right">速卖通产品id:</td>
	<td><input type="text" style="width:100%;" name="products_id" value="" /></td>
	</tr>
	
	
	<tr><td colspan=2 align="center"><input type="submit" name="submit" value="  保存  " />
	
	</td>
	
	</tr>
	
</table>
</form>
		
	
</div>     
      
</body>
</html>
