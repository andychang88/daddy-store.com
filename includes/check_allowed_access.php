<?php
	/*$allowed_ip=array();
    //$allowed_ip=array('27.38.55.12','58.250.187.196','112.95.147.213','116.24.74.239');*/
	$client_lng=$_SERVER['HTTP_ACCEPT_LANGUAGE'];
	//$client_ip=trim($_SERVER['REMOTE_ADDR']);  
	  
	if(isset($_GET['testa'])){
			//  	$_SESSION['my_debuga']=true;
	} 
			  
/**/	if(preg_match("/zh-c/i", $client_lng) ){//new change for wu 20110225
	   //if(!(in_array($client_ip,$allowed_ip,false))){
	      // header('location:updating.htm');
			  
			  if(!isset($_SESSION['my_debuga'])){
//			  	echo "<h1>Error.</h1>";
			 //   exit;
			  }
			  
		      
	   //}
	} 
	/**/

	$ip =  real_ip();
	$addr = get_geoip($ip);
	if(strpos($addr,'广东')!==false && !isset($_SESSION['my_debuga'])){
	  // exit;
	}


function real_ip()
{
    static $realip = NULL;

    if ($realip !== NULL)
    {
        return $realip;
    }

    if (isset($_SERVER))
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

            /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
            foreach ($arr AS $ip)
            {
                $ip = trim($ip);

                if ($ip != 'unknown')
                {
                    $realip = $ip;

                    break;
                }
            }
        }
        elseif (isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        }
        else
        {
            if (isset($_SERVER['REMOTE_ADDR']))
            {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
            else
            {
                $realip = '0.0.0.0';
            }
        }
    }
    else
    {
        if (getenv('HTTP_X_FORWARDED_FOR'))
        {
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_CLIENT_IP'))
        {
            $realip = getenv('HTTP_CLIENT_IP');
        }
        else
        {
            $realip = getenv('REMOTE_ADDR');
        }
    }

    preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
    $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';

    return $realip;
}

function get_geoip($ip)
{
    static $fp = NULL, $offset = array(), $index = NULL;

    $ip    = gethostbyname($ip);
    $ipdot = explode('.', $ip);
    $ip    = pack('N', ip2long($ip));

    $ipdot[0] = (int)$ipdot[0];
    $ipdot[1] = (int)$ipdot[1];
    if ($ipdot[0] == 10 || $ipdot[0] == 127 || ($ipdot[0] == 192 && $ipdot[1] == 168) || ($ipdot[0] == 172 && ($ipdot[1] >= 16 && $ipdot[1] <= 31)))
    {
        return 'LAN';
    }

    if ($fp === NULL)
    {
        $fp = fopen('ipdata.dat', 'rb');
        if ($fp === false)
        {
            return 'Invalid IP data file';
        }
        $offset = unpack('Nlen', fread($fp, 4));
        if ($offset['len'] < 4)
        {
            return 'Invalid IP data file';
        }
        $index  = fread($fp, $offset['len'] - 4);
    }

    $length = $offset['len'] - 1028;
    $start  = unpack('Vlen', $index[$ipdot[0] * 4] . $index[$ipdot[0] * 4 + 1] . $index[$ipdot[0] * 4 + 2] . $index[$ipdot[0] * 4 + 3]);
    for ($start = $start['len'] * 8 + 1024; $start < $length; $start += 8)
    {
        if ($index{$start} . $index{$start + 1} . $index{$start + 2} . $index{$start + 3} >= $ip)
        {
            $index_offset = unpack('Vlen', $index{$start + 4} . $index{$start + 5} . $index{$start + 6} . "\x0");
            $index_length = unpack('Clen', $index{$start + 7});
            break;
        }
    }

    fseek($fp, $offset['len'] + $index_offset['len'] - 1024);
    $area = fread($fp, $index_length['len']);

    fclose($fp);
    $fp = NULL;

    return $area;
}
