<?php
	//#############validate those data from browser############START
	if( !isset($_REQUEST)){
		echo json_encode(array('error'=>'Invalid request'));
		die();
	}
	if( !isset($_POST['products_id'])){
		echo json_encode(array('error'=>'Invalid parameter pid----1'));
		exit;
	}else if(is_string($_POST['products_id'])){
		$pid_check=split(':',$_POST['products_id']);
		$real_pid=$pid_check[0];
		if(!is_numeric($real_pid) || $real_pid<=0){
			echo json_encode(array('error'=>'Invalid parameter1 pid----2'));
			exit;
		}
	}else if(!is_numeric($_POST['products_id']) || $_POST['products_id']<=0){
		echo json_encode(array('error'=>'Invalid parameter1 pid----3'));
		exit;
	}
	
	if(isset($_POST['cart_quantity'])){
		if(!is_numeric($_POST['cart_quantity']) || $_POST['cart_quantity']<0){
			echo json_encode(array('error'=>'Invalid parameter qty---1'));
			exit;
		}
	}else if(isset($_POST['cart_delete'])){
		if(!in_array($_POST['cart_delete'],array(1,0))){
			echo json_encode(array('error'=>'Invalid parameter delete---1'));
			exit;
		}
	}else{
		echo json_encode(array('error'=>'Invalid parameter delete or qty'));
		exit;
	}
	
	if( isset($_POST['id'])){
		if(!isset($_POST['id'][$_POST['products_id']]) || empty($_POST['id'][$_POST['products_id']]) ){
			echo json_encode(array('error'=>'Invalid parameter attribute'));
			exit;
		}
	}
	//#############validate those data from browser############END
	include('includes/application_top.php');
	if(isset($_SESSION['cart'])){
		$pid=$_POST['products_id'];
		$p_qty=$_POST['cart_quantity'];
		$attributes = (isset($_POST['id'][$pid])&& zen_not_null($_POST['id'][$pid])) ? $_POST['id'][$pid]: '';
		$cart_delete=(isset($_POST['cart_delete']) && $_POST['cart_delete']==1)?true:false;
		
		$_SESSION['cart']->actionAJAXUpdateProduct($pid,$p_qty,$attributes,$cart_delete);
		
		$items_count=$_SESSION['cart']->count_contents();
		$total_amount=$_SESSION['cart']->show_total();
		
		$items_in_cart=$_SESSION['cart']->get_products();
		
		$item_qty=1;
		$tax_class_id=0;
		
		foreach($items_in_cart as $item){
			if($item['id']==$pid){
				$item_unit_price=$item['final_price'];
				$tax_class_id=$item['tax_class_id'];
				$item_qty=$item['quantity'];
			}
		}
		$result_data=array('items_count'=>$items_count,
						   'total_amount'=>$currencies->display_price($total_amount),
						   'item_qty'=>$_SESSION['cart']->get_quantity(zen_get_uprid($pid,$attributes)),
						   'item_unit_price'=>$currencies->display_price($item_unit_price,zen_get_tax_rate($tax_class_id),1),
						   'item_total_price'=>$currencies->display_price($item_unit_price,zen_get_tax_rate($tax_class_id),$item_qty)
						   );
		if($cart_delete){
			$result_data['delete_action']=1;
		}
		echo json_encode($result_data);
		exit;
	}else{
		echo json_encode(array('error'=>'Server is busy,please try later...'));
		exit;
	}
?>