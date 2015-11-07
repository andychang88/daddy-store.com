<?php
if(is_file('../includes/configure.php')){
	include '../includes/configure.php';
	//连接数据库信息
	$db_host = DB_SERVER;
	$db_user = DB_SERVER_USERNAME;
	$db_pass = DB_SERVER_PASSWORD;

}else{
	//连接数据库信息
	$db_host = 'localhost';
	$db_user = 'root';
	$db_pass = '1314521';	
}

date_default_timezone_set('PRC');

//需要更新的数据库。在本地测试只需要更新一个数据库即可。
//在线更新产品适合，需要更新2个数据库changah_andy02和changah_usbexporter
//$update_database = array('backever'=>'usbexporter');

$http_host = $_SERVER[HTTP_HOST];
$doc_root = $_SERVER[DOCUMENT_ROOT];

if(defined('DB_DATABASE')){
	$update_database = array('main_db'=>DB_DATABASE);
} else {
	$update_database = array('main_db'=>'glstore2');
}





//网站的根目录（绝对路径，方便正确的存储图片）
!defined('DIR_FS_CATALOG') && define('DIR_FS_CATALOG',$doc_root);

define('DEFAULT_LANGUAGE_ID', '3');

