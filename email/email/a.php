<?php
if(extension_loaded(gd)) {
echo '你可以使用gd';
foreach(gd_info() as $cate=>$value)
echo $cate.':' .$value.'<br>';

}
else echo '你没有安装gd扩';


phpinfo();
?>

