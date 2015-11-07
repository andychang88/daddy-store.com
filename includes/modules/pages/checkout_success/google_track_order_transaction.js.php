<?php
    if (!defined('IS_ADMIN_FLAG')) {
	  die('Illegal Access');
	}
	if(isset($orders) && $orders_id>0){?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-22262011-1aaaaa']);
		  //_gaq.push(['_trackPageview']);这里应该不需要第二次发送页面查看情况的数据
		  _gaq.push(['_addTrans',
					'<?php echo $orders_id;?>',           // order ID - required
					'<?php echo STORE_NAME;?>',  // affiliation or store name
					'<?php echo $order_paid_total;?>',          // total - required
					'0',           // tax
					'0',              // shipping
					'',       // city
					'',     // state or province
					''             // country
		  ]);
		  
		  <?php foreach($products_array as $p){?>
			  _gaq.push(['_addItem',
						 '<?php echo $p['order_id'];?>',// order ID - required
						 '<?php echo $p['product_sku'];?>',// SKU/code - required
						 '<?php echo $p['product_name'];?>',// product name
						 '',// category or variation
						 '<?php echo $p['product_price'];?>',// unit price - required
						 '<?php echo $p['product_qty'];?>'// quantity - required
			  ]);
		  <?php }?>
		  _gaq.push(['_trackTrans']); //submits transaction to the Analytics servers
	</script>	
<?php		
	}
?>