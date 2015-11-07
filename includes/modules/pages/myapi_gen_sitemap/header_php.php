<?php
/**
 * 获取http://www.myefox.com/上面的图片文件
 * http://localhost/usbexporter/index.php?main_page=myapi_efox
 */
unset($breadcrumb->_trail);
set_time_limit(0);
error_reporting(0);

$action = $_REQUEST['action']?$_REQUEST['action']:'';
$name_suffix = $_REQUEST['name_suffix']?$_REQUEST['name_suffix']:'';

if(strlen($name_suffix)>0){
	$name_suffix = str_replace(' ', '-', $name_suffix);
}

if(empty($action)){
	outputHtml();
	exit;
}
if($action == 'gen_sitemap_by_pid'){
	$begin_products_id = (int)$_REQUEST['begin_products_id'];
	if(empty($begin_products_id)){
		echo "Error products id.";
		exit;
	}
	$sql = 'select products_id from products where products_id>="'.$begin_products_id.'" and products_status=1 order by products_id desc';
	$sitemap_name = 'sitemap'.date("Ymd").'_p'.$begin_products_id.$name_suffix.'.xml';
}

if($action == 'gen_sitemap_by_catid'){
	$category_id = (int)$_REQUEST['category_id'];
	$begin_products_id = (int)$_REQUEST['begin_products_id'];
	if(empty($category_id)){
		echo "Error category_id id.";
		exit;
	}
	$sql = 'select products_id from products where ';
	
	if(!empty($begin_products_id)){
		$sql.=' products_id>="'.$begin_products_id.'"  and ';
	}
	
	$sql.='  master_categories_id="'.$category_id.'" and products_status=1 order by products_id desc';
	$sitemap_name = 'sitemap'.date("Ymd").'_cat'.$category_id.$name_suffix.'.xml';
}

$head='<?xml version="1.0" encoding="UTF-8"?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<!-- created with Free Online Sitemap Generator www.xml-sitemaps.com -->
';

$tail = '
</urlset>';



$result = $db->Execute($sql);

$tmp_urls='';
while(!$result->EOF){
	$tmp_urls .= "
	<url>
	   <loc>".zen_href_link('product_info','products_id='.$result->fields['products_id'])."</loc>
	   <changefreq>weekly</changefreq>
	</url>";
	$result->MoveNext();
}

if(strlen($tmp_urls)==0){
	die('empty products found.');
}

$sitemap_content = $head.$tmp_urls.$tail;

if(!is_dir('sitemaps')){
	mkdir('sitemaps');
}

file_put_contents('sitemaps/'.$sitemap_name, $sitemap_content);
echo "<br><br><br>finish.<br>";
echo HTTP_SERVER.DIR_WS_CATALOG.'sitemaps/'.$sitemap_name;

outputHtml();
exit;

function outputHtml(){

	echo '<form style="margin:100px;" method="post" action="">';
	
	echo '<fieldset><legend>begin products id</legend>';
	
	echo '<input type="hidden" name="action" value="gen_sitemap_by_pid" /><br>';
	echo 'begin products id:<input type="text" name="begin_products_id" value="" /><br>';
	echo 'sitemap name suffix:<input type="text" name="name_suffix" value="" /><br>';
	echo '<input type="submit" name="submit" value="submit" />';
	
	echo '</fieldset>';
	
	echo '</form>';
	
	
	
	
	
	
	echo '<form style="margin:100px;" method="post" action="">';
	
	echo '<fieldset><legend>begin products id</legend>';
	
	echo '<input type="hidden" name="action" value="gen_sitemap_by_catid" />';
	echo 'category id:<input type="text" name="category_id" value="" /><br>';
	echo 'begin products id:<input type="text" name="begin_products_id" value="" /><br>';
	
	echo 'sitemap name suffix:<input type="text" name="name_suffix" value="" /><br>';
	
	echo '<input type="submit" name="submit" value="submit" />';
	
	echo '</fieldset>';
	
	echo '</form>';
	
	echo "<br><br><br>";
	//输出所有的xml文件
	foreach (glob("sitemaps/*.xml") as $filename) {
	    echo HTTP_SERVER.DIR_WS_CATALOG.$filename."<br>";
	}

}

