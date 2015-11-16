<?php
	if( !isset($_REQUEST)){
		echo json_encode(array('error'=>'Invalid request'));
		die();
	}
	if( !isset($_POST['products_id']) || !is_numeric($_POST['products_id']) ||  $_POST['products_id']<=0){
		echo json_encode(array('error'=>'Invalid parameter'));
		//echo json_encode(array('error'=>print_r($_REQUEST,true).'Invalid parameter'));
		exit;
	}
	if( !isset($_POST['cart_quantity']) || !is_numeric($_POST['cart_quantity']) || $_POST['cart_quantity']<=0){
		echo json_encode(array('error'=>'Invalid parameter'));
		//echo json_encode(array('error'=>print_r($_REQUEST,true).'Invalid parameter'));
		exit;
	}
	
	include('includes/application_top.php');
	if(isset($_SESSION['cart'])){
		$_SESSION['cart']->actionAJAXAddProduct();
		$items_count=$_SESSION['cart']->count_contents();
		$total_amount=$_SESSION['cart']->show_total();
		$items_in_cart=$_SESSION['cart']->get_products();
		
		
		$result_data=array('items_count'=>$items_count,
						   'total_amount'=>$currencies->display_price($total_amount)
						   );
		echo json_encode($result_data);
		exit;
	}else{
		echo json_encode(array('error'=>'failed,please try later...'));
		exit;
	}
?>