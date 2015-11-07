<?php 
include 'includes/init.php';
include 'includes/CommonBase.php';
include 'includes/zencart_product_model.php';
include 'includes/zencart_product_attr_model.php';


$act = $_REQUEST['act']?$_REQUEST['act']:'';
$default_language = 3;


if($act == 'save_detail'){
	$msg = '';
	
	include 'includes/zencart_products_attr_handle.php';
		
	
	
	//echo '<div style="width:500px;background:#ddd;word-wrap:break-word;">';
	//$pm->debug(0);
	//echo '</div>';
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
.wrap{border:1px solid #eee;margin:50px 100px;}
table{width:100%;border-collapse:collapse;border:1px solid #ccc;}
td{padding:5px 10px;border:1px solid #ccc;}
.align_right{text-align:right;}
.align_left{text-align:left;}
.align_center{text-align:center;}
.w50{width:50px;}
.tip{font-weight:bold;padding:10px;color:red;text-align:center;}
.steps{margin:10px;}
fieldset{width:700px;}
legend{font-weight:bold;}
</style>
<script language=javascript>
$(function(){

	
})
</script>
</head>
<body>


 
<div class="wrap">
<p class="steps">

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
function deleteAttrValue(obj_a){
	if($(obj_a).parents('table').find('tr.attr_tr').length>1)
	$(obj_a).parents('tr:first').remove();
}
function addAttrValue(obj_a){
	var tr = $(obj_a).parents('tr:first').clone(true);
	$(obj_a).parents('tr:first').after(tr);
}
</script>


<form action="" method="post" target="_blank">


<?php 
include 'aliexpress_attr_html.php';
?>

<div><center>
<br><input type="submit" name="submit" value="  保存  " /><br></center>
</div>


</form>



	
	
	
</div>     
      
</body>
</html>
