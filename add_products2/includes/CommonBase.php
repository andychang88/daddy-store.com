<?php
class CommonBase{
/*
 * 把一段字符串从另外一个大段落中抽取出来
 */
function extractStr($filter_content_arr, $content){
	
	$pos_start = strpos($content, $filter_content_arr['start_str']);
		$pos_end = strpos($content, $filter_content_arr['end_str'],$pos_start);
		$len = $pos_end - $pos_start;
		
		$content = substr( $content, $pos_start, $len);
	return $content;
}
/*
 * 把一段字符串从另外一个大段落中去掉
 */
function minusStr($filter_content_arr, $content){
	
	$pos_start = strpos($content, $filter_content_arr['start_str']);
		$pos_end = strpos($content, $filter_content_arr['end_str'], $pos_start);
		
		$content_head = substr( $content, 0, $pos_start);
		$content_foot = substr( $content, $pos_end + strlen($filter_content_arr['end_str']));
		
		$content = $content_head . $content_foot;
	return $content;
}
function pregReplaceStr($filter_content_arr, $content){
		$start_str = $filter_content_arr['start_str'];
		$end_str = $filter_content_arr['end_str'];
		
		$preg = $this->buildPregByStr($start_str, $end_str);
		$filter_content_arr['preg'] = $preg;
	
		preg_match($preg, $content, $arr);
		$content = $arr[1];
		return $content;
}
function getReplaceResult($filter_content_arr, $content, $is_debug=''){

					if(isset($filter_content_arr['use_extract'])){
						$content = $this->extractStr($filter_content_arr, $content);
					}else if(isset($filter_content_arr['use_minus'])){
						$content = $this->minusStr($filter_content_arr, $content);
					}else{
						$content = $this->pregReplaceStr($filter_content_arr, $content);
					}
		/**
	if($is_debug=='desc'){
		echo '<pre>';print_r($filter_content_arr);echo '$content:'.$content;echo '<br>aaa:'.$this->html_content;exit;
	}
	/**/

		if(!empty($filter_content_arr['delete_str']) && is_array($filter_content_arr['delete_str'])){
			
			$delete_preg = array();
			
			foreach ($filter_content_arr['delete_str'] as $key=>$val){

				if(is_array($val)){
					
					if(isset($val['use_extract'])){
						$content = $this->extractStr($val, $content);
					}else if(isset($val['use_minus'])){
						$content = $this->minusStr($val, $content);
					}else{
						$content = $this->pregReplaceStr($val, $content);
					}
	

				}else{
					
					$preg = "/".preg_quote($val,'/')."/";
					$filter_content_arr['delete_preg'][] = $preg;
					
					$content = preg_replace($preg, '', $content);
				}
			}
		}
	
		return $content;
	}
	
function createDirIfNotExists($image_file, $abs_parent_path=false){
	
	if(!defined('ROOT_PATH')){
		define('ROOT_PATH','./');
	}
	
	if(!$abs_parent_path){
		$abs_parent_path = ROOT_PATH;
	}
	//echo $image_file.'<br>';echo $abs_parent_path;exit;
	if(strpos($image_file, $abs_parent_path)!==false){
		$image_file = str_replace($abs_parent_path, '', $image_file);
	}
	
	$arr = explode("/", $image_file);//echo "<pre>";print_r($arr);
	if(count($arr)>0){
		
		$tmp = $abs_parent_path.'';
		
		if(preg_match("/\.\w+$/i",$image_file)){
			$len=count($arr)-1;//最后一个是文件，不用创建目录
		}else{
			$len=count($arr);
		}
		for($i=0; $i<$len; $i++){
			$arr[$i] = str_replace('%20', ' ', $arr[$i]);
			//$arr[$i] = str_replace(' ', '_', $arr[$i]);
			if(substr($tmp,-1)!='/'){
				$tmp .= "/".$arr[$i];
			}else{
				$tmp .= $arr[$i];
			}
			//echo $tmp."<br>";exit;
			if(!is_dir($tmp)){
				
				mkdir($tmp);
			}
		}
	}
}
function saveFile($remote_url,$local_url){
	
	if(is_file($local_url)){
		$ext = pathinfo($local_url,PATHINFO_EXTENSION);
		$img_name = time().'.'.$ext;
		$local_url = pathinfo($local_url,PATHINFO_DIRNAME).'/'.$img_name;
	}
	$data = file_get_contents($remote_url);
	file_put_contents($local_url, $data);
	
}

function buildPregByStr($start_str, $end_str){
	$start_str_preg = $this->compilePregPart($start_str);
	$end_str_preg = $this->compilePregPart($end_str);
	$preg = "/".$start_str_preg."((?:.|\s)+?)".$end_str_preg."/";
	
	return $preg;
}
function compilePregPart($start_str){
	$tmp_preg = "/PBOF(.+?)PEOF/";
	
	preg_match_all($tmp_preg, $start_str, $start_tmp_arr);
	$start_str = preg_replace($tmp_preg, 'PBOFPEOF', $start_str);
	
	$start_str_preg = preg_quote($start_str,'/');
	$start_str_preg = preg_replace('/\s+/', '\s*', $start_str_preg);
	
	if(count($start_tmp_arr[1]) >0){
		foreach ($start_tmp_arr[1] as $key=>$val){
			$start_str_preg = preg_replace("/PBOFPEOF/", $val, $start_str_preg);
		}
	}
	
	return $start_str_preg;
}
/*
 * generate a regexp pattern, but it does not contains the start and end signals
 */
function escape_preg_chars($preg,$deli='/'){
	
	$preg = preg_replace('/(\!|\-|\.|\(|\)|\[|\]|\*|\\' . $deli . ')/', '\\\\$1', $preg);
	$preg = preg_replace('/(\s+)/', '\s*', $preg);

	return $preg;
	
}

function parseImgUrlFromImgTag($img_tag_str){
	preg_match('/src=("|\')(.+?)\1/', $img_tag_str, $arr);
	return empty($arr)?'':$arr[2];
	
}
	
}