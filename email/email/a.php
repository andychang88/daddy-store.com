<?php
if(extension_loaded(gd)) {
echo '�����ʹ��gd';
foreach(gd_info() as $cate=>$value)
echo $cate.':' .$value.'<br>';

}
else echo '��û�а�װgd��';


phpinfo();
?>

