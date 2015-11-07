<?php

//$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$url = $_GET['url'];
if(empty($url)) exit;

$url = urldecode($url);

$logfile = './my/site.txt';

addLog($logfile, $url);

function addLog($logfile, $msg){
	    
	    $handle = fopen($logfile, "a+");
	
	    $date = date("Y-m-d H:i:s");
	    fwrite($handle, "\r\n================log bigin at ".$date."\r\n");
	    fwrite($handle, $msg);
	
	    fclose($handle);
    }

