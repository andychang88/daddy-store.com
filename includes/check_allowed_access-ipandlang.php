<?php
	$allowed_ip=array();
	$allowed_ip[]='27.38.55.12';// SEO
	$allowed_ip[]='27.38.100.101';// SEO
	$allowed_ip[]='112.95.147.213';// 2F guding
	$allowed_ip[]='27.38.105.253'; //2F .
	$allowed_ip[]='27.38.106.23'; //2F
	$allowed_ip[]='58.250.180.125';//2F 
	$allowed_ip[]='27.38.104.90';
	$allowed_ip[]='58.250.187.196';// M 
	$allowed_ip[]='58.250.187.116';
	$allowed_ip[]='121.35.85.167';//you	 
	$allowed_ip[]='183.11.16.241';//you
	$allowed_ip[]='116.30.248.83';//you
	$allowed_ip[]='116.24.117.89';//Hua qiang bei 1
	$allowed_ip[]='116.24.118.20';//Hua qiang bei 2
	$allowed_ip[]='119.139.185.209';//Hua qiang bei 3
	$allowed_ip[]='119.139.184.24';//Hua qiang bei 4
	$allowed_ip[]='112.95.64.209';//S
	$allowed_ip[]='27.38.56.224';//2010
	//$allowed_ip[]='116.24.74.239'; //nei mao always be limited
	//$allowed_ip[]='58.250.184.192'; //S always be limited
	//$allowed_ip[]='';
	//$allowed_ip[]='';
	
    //$allowed_ip=array('27.38.55.12','58.250.187.196','112.95.147.213','116.24.74.239');
	
	$client_lng=$_SERVER['HTTP_ACCEPT_LANGUAGE'];
	$client_ip=trim($_SERVER['REMOTE_ADDR']);
	if(preg_match("/zh-c/i", $client_lng)){
	   if(!(in_array($client_ip,$allowed_ip,false))){
	       header('location:updating.htm');
		   exit;
	   }
	}
?>