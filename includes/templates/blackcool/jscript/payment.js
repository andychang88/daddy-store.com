
	$("#pmt-paypal").live('click',function(){
		$("#spBox").hide("fast");
		$("#spBoxbk").hide("fast");
		});
		$("#pmt-paypalwpp").live('click',function(){
			$("#spBox").hide("fast");
	        $("#spBoxbk").hide("fast");
		});
		$("#pmt-moneybookers").live('click',function(){
			$("#spBox").hide("fast");
	        $("#spBoxbk").hide("fast");
		});
		$("#pmt-westernunion").live('click',function(){
			$("#spBox").show("slow");
	        $("#spBoxbk").hide("fast");
		});
		$("#pmt-banktransfer").live('click',function(){
			$("#spBox").hide("fast");
	        $("#spBoxbk").show("slow");
		});


