<?php
error_reporting(1);
if(!is_dir(DIR_FS_SQL_CACHE)){
	die(DIR_FS_SQL_CACHE.' is not dir.');
}
$remote_host = 'http://www.myefox.com/images/';

$pid_tmp_dir = DIR_FS_SQL_CACHE.'/pid_tmp_dir';
if(!is_dir($pid_tmp_dir)){
	mkdir($pid_tmp_dir);
}
$pid_file = $pid_tmp_dir."/pid.txt";
$cur_pid = trim(file_get_contents($pid_file));


$sql = "select banners_image from banners where  not isnull(banners_image) and banners_id<=".$cur_pid." order by banners_id desc limit 10";
$result = $db->Execute($sql);
if(!$result->EOF){
	$saved_arr = array();
	while(!$result->EOF){
		$image_file = $result->fields['banners_image'];
/**
		$image_file = trim($image_file);
		if(strlen($string) == 0){
			continue;
		}
/**/
		checkDirExists($image_file);
		if(!is_file(DIR_WS_IMAGES.$image_file)){
			
			$data = file_get_contents($remote_host.$image_file);
			file_put_contents(DIR_WS_IMAGES.$image_file, $data);
			$saved_arr[] = DIR_WS_IMAGES.$image_file;
		}
		$result->MoveNext();
	}
}else{
	die('all finished.');
}
$next_pid = (int)$cur_pid - 10;
file_put_contents($pid_file, $next_pid);

echo "after 1500,window will refresh. next pid is ".$next_pid;
echo "<br>last image file:".$image_file;
echo "<br>saved files:";
echo implode("<br>", $saved_arr);
echo "<script>setTimeout(function(){window.location.reload();},1500);</script>";
exit;


function checkDirExists($image_file){
	$arr = explode("/", $image_file);
	if(count($arr)>0){
		$tmp = DIR_WS_IMAGES.'';
		for($i=0,$len=count($arr); $i<$len-1; $i++){
			$tmp .= "/".$arr[$i];
			if(!is_dir($tmp)){
				mkdir($tmp);
			}
		}
	}
}
