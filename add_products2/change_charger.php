<?php
include 'includes/init.php';



$db->query('use changah_andy02');

$sql = 'select products_model,products_image from products where 
products_image like "charger/%" ';

$rows = $db->getAll($sql);

$new_sql = '';

$db->query('use changah_usbexporter');


foreach ($rows as $row){
	$new_sql = "update products set products_image='$row[products_image]' where products_model='$row[products_model]' ;";
	$db->query($new_sql);
}

echo 'ok';exit;