<?php
error_reporting(E_ALL^E_NOTICE);

@ini_set('memory_limit',          '640M');
@ini_set('session.cache_expire',  180);
@ini_set('session.use_trans_sid', 0);
@ini_set('session.use_cookies',   1);
@ini_set('session.auto_start',    0);
@ini_set('display_errors',        1);

set_time_limit(0);

define('PREG_ANY_CHARACTER_LIMIT','(?:\s|.)+?');


if (defined('DEBUG_MODE') == false)
{
    define('DEBUG_MODE', 2);
}

$host_addr = $_SERVER['REMOTE_ADDR'];
if(($host_addr=='127.0.0.1')||($host_addr=='localhost')){
	 define('IS_LOCALHOST', true);
}else{
	 define('IS_LOCALHOST', false);
}

$php_self = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
if ('/' == substr($php_self, -1))
{
    $php_self .= 'index.php';
}
define('PHP_SELF', $php_self);

/* 取得当前ecshop所在的根目录 */
define('ROOT_PATH', dirname(dirname( str_replace('\\', '/', __FILE__))).'/');
define('STORE_ROOT_PATH', dirname(ROOT_PATH).'/');
define('IMAGE_PATH', STORE_ROOT_PATH.'images/');
define('JS_JUQERY', STORE_ROOT_PATH.'includes/templates/blackcool/jscript/jscript_a_jquery-1.3.2.js');


include ROOT_PATH.'includes/config.php';
include ROOT_PATH.'includes/cls_mysql.php';

$db = new cls_mysql($db_host, $db_user, $db_pass,$update_database['main_db']);
$db->query("use ".$update_database['main_db']);


include ROOT_PATH.'includes/lib_main.php';
include ROOT_PATH.'includes/common.php';






