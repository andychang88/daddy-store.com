<?php
	function place_moneybooker_order(){
		global $db,$order,$order_totals;
		if(!isset($_SESSION['mb_cs_order_id'])){			
			
			$order->info['payment_method']='MoneyBookers';
			$order->info['payment_module_code']='moneybookers';
			
			$insert_id = $order->create($order_totals);
			
			$order->create_add_products($insert_id,2);
			
			//save products_details			
			$_SESSION['products_details_for_email']=$order->products_ordered_html;			
			
			return $insert_id;
		}else{
			return $_SESSION['mb_cs_order_id'];
		}		
	}
?>