<?php
	function place_paypal_order(){
		global $db,$order,$order_totals;
		if(!isset($_SESSION['pp_enomen_order_id'])){			
			
			$order->info['payment_method']='PayPal';
			$order->info['payment_module_code']='paypal';
			
			$insert_id = $order->create($order_totals);
			
			$order->create_add_products($insert_id,2);
			//save products_details			
			$_SESSION['products_details_for_email']=$order->products_ordered_html;
			$_SESSION['order_totals']=$order_totals;
			return $insert_id;
		}else{
			return $_SESSION['pp_enomen_order_id'];
		}		
	}
?>