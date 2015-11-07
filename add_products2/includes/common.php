<?php
 function http_request($url,$timeout=30,$header=array()){ 
        if (!function_exists('curl_init')) { 
            throw new Exception('server not install curl'); 
        } 
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_HEADER, true); 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); 
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 

        if (!empty($header)) { 
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
        } 
        $data = curl_exec($ch); 
        list($header, $data) = explode("\r\n\r\n", $data); 
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
        if ($http_code == 301 || $http_code == 302) { 
            $matches = array(); 
            preg_match('/Location:(.*?)\n/', $header, $matches); 
            $url = trim(array_pop($matches)); 
            curl_setopt($ch, CURLOPT_URL, $url); 
            curl_setopt($ch, CURLOPT_HEADER, false); 
            $data = curl_exec($ch); 
        } 

        if ($data == false) { 
            curl_close($ch); 
        } 
        @curl_close($ch); 
        return $data; 
} 
function splitNumberStr($price_str,$price_prefix = "+"){
			
			if(substr($price_str, 0, 1) == '+' || substr($price_str, 0, 1) == '-'){
				$price_prefix = substr($price_str, 0, 1);
				$options_values_price = substr($price_str, 1);
			}else{
				
				$options_values_price = $price_str;
			}
			
			return array($price_prefix,$options_values_price);
			
}
function getImgUrl($img_tag_str){
	preg_match('/src=("|\')(.+?)\1/', $img_tag_str, $arr);
	return empty($arr)?'':$arr[2];
	
}
function getReplaceResult($filter_content_arr, $content){
	$start_str = $filter_content_arr['start_str'];
	$end_str = $filter_content_arr['end_str'];

	preg_match(buildPregByStr($start_str, $end_str), $content, $arr);
	$content = $arr[1];
	
	if(!empty($filter_content_arr['delete_str'])){
		foreach ($filter_content_arr['delete_str'] as $key=>$val){
			if(is_array($val)){
				$delete_start_str = $val['start_str'];
				$delete_end_str = $val['end_str'];

				$content = preg_replace(buildPregByStr($delete_start_str, $delete_end_str), '', $content);
				
			}else{
				$content = preg_replace("/".escape_preg_chars($val)."/", '', $content);
			}
		}
	}

	return $content;
}
function compilePregPart($start_str){
	$tmp_preg = "/PBOF(.+?)PEOF/";
	
	preg_match_all($tmp_preg, $start_str, $start_tmp_arr);
	$start_str = preg_replace($tmp_preg, 'PBOFPEOF', $start_str);
	
	$start_str_preg = escape_preg_chars($start_str);
	
	if(count($start_tmp_arr[1]) >0){
		foreach ($start_tmp_arr[1] as $key=>$val){
			$start_str_preg = preg_replace("/PBOFPEOF/", $val, $start_str_preg);
		}
	}
	
	return $start_str_preg;
}
function buildPregByStr($start_str, $end_str){
	
	$start_str_preg = compilePregPart($start_str);
	$end_str_preg = compilePregPart($end_str);
	
	return "/".$start_str_preg."((?:.|\s)+?)".$end_str_preg."/";
}
/*
 * generate a regexp pattern, but it does not contains the start and end signals
 */
function escape_preg_chars($preg,$deli='/'){
	
	//$preg = preg_replace('/(\!|\-|\.|\(|\)|\[|\]|\*|\\' . $deli . ')/', '\\\\$1', $preg);
	$preg = preg_quote($preg, $deli);
	$preg = preg_replace('/(\s+)/', '\s*', $preg);
	

	return $preg;
	
}
function generate_goods_sn($goods_id)
{
    $goods_sn = $GLOBALS['_CFG']['sn_prefix'] . str_repeat('0', 6 - strlen($goods_id)) . $goods_id;

    $sql = "SELECT goods_sn FROM " . $GLOBALS['ecs']->table('goods') .
            " WHERE goods_sn LIKE '" . mysql_like_quote($goods_sn) . "%' AND goods_id <> '$goods_id' " .
            " ORDER BY LENGTH(goods_sn) DESC";
    $sn_list = $GLOBALS['db']->getCol($sql);
    if (in_array($goods_sn, $sn_list))
    {
        $max = pow(10, strlen($sn_list[0]) - strlen($goods_sn) + 1) - 1;
        $new_sn = $goods_sn . mt_rand(0, $max);
        while (in_array($new_sn, $sn_list))
        {
            $new_sn = $goods_sn . mt_rand(0, $max);
        }
        $goods_sn = $new_sn;
    }

    return $goods_sn;
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
				echo 'begin:'.$tmp.'<br>';
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



