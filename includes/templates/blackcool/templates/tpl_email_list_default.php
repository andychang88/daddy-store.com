  <style type="text/css">
table,td,th{border:1px solid #ccc;border-collapse:collapse;}
table{width:100%;}
	
  </style>
  
  
  <?php
  
  if($act == 'del_unsubscriber'){
	echo '<div><h2>delete unsubscriber successfully.</h2></div>';
  }else if($act == 'unsubscribe'){
  ?>
  
  <div><h2>We will unsubscribe your email next time. Apologized for any inconvenience.</h2></div>
  
  <?php
  }else{
  ?>
  <h2>订阅客户</h2>
<table>
	<tr>
		<th>Id</th>
		<th>邮件</th>
		<th>客户 IP</th>
		<th>查看时间</th>
		<th>产品</th>

	</tr>
	
	<?php
	
	
	foreach($email_viewed as $key=>$val){
		if(empty($val)){
			continue;
		}
		
		$url = zen_href_link(zen_get_info_page($products_id), ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id='.$products_id );
		
		$products_id= $val['products_id'];
		
		$sql = "select products_image from products where products_id=".$products_id;
		$result_sql = $db->Execute($sql);
		$products_image = $result_sql->fields['products_image'];
		$img = zen_image(DIR_WS_IMAGES.$products_image,$products_id,50,50);
		
		echo '<tr>';
		echo "<td>".$val['id']."</td><td>".$val['email']."</td><td>".$val['remote_ip']."</td><td>".$val['add_time']."</td>";
		echo "<td><a href='".$url."' target='_blank'>".$img."</a></td>";
		echo '</tr>';
	}
	?>
</table>



<h2>退订客户</h2>
<table>
	<tr>
		<th>Id</th>
		<th>邮件</th>
		<th>客户 IP</th>
		<th>查看时间</th>
		<th>产品</th>

	</tr>
	
	<?php
	
	
	foreach($email_viewed_unsubscribe as $key=>$val){
		if(empty($val)){
			continue;
		}
		
		$url = zen_href_link('email_list', 'act=del_unsubscriber&email='.$val['email'] );
		
		$products_id= $val['products_id'];
		
		
		
		echo '<tr>';
		echo "<td>".$val['id']."</td><td>".$val['email']."</td><td>".$val['remote_ip']."</td><td>".$val['add_time']."</td>";
		echo "<td><a href='".$url."' target='_blank'>删除</a></td>";
		echo '</tr>';
	}
	?>
</table>


<?php
  }
  ?>