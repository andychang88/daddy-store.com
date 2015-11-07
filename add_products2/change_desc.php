<?php

/**
 * ECSHOP 广告处理文件
 * ============================================================================
 * 版权所有 2005-2010 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liuhui $
 * $Id: affiche.php 17063 2010-03-25 06:35:46Z liuhui $
*/

include 'includes/init.php';

$select_db = $_REQUEST['db'];
if(empty($select_db)){
	die('empty db request.');
}

$db->query('use '.$select_db);


$sql = 'select products_id,products_description from products_description where products_id>159000';
$rows = $db->getAll($sql);
$count = 0;

if(count($rows)==0){
	die('not found any record.');
}

foreach ($rows as $row){
	$products_description = $row['products_description'];
	
	
	/**/
	$preg = '#<div\s+class="pint_rows">(?:.|\s)+?</div>#';
	$preg2 = '#<div\s+class="pint_title">(?:.|\s)+?</div>#';
	if(preg_match($preg, $products_description)){
		$products_description = preg_replace($preg, '', $products_description);
		$products_description = preg_replace($preg2, '', $products_description);
		
		$db->query('update products_description set products_description="'.addslashes($products_description).'" where products_id='.$row['products_id']);
		$count++;
	}
	/**/
}

echo '$count:'.$count;










