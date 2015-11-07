<?php if(isset($_REQUEST[main_page]) && (($_REQUEST[main_page] == 'login') || ($_REQUEST[main_page] == 'time_out') || ($_REQUEST[main_page] == 'logoff'))){
	$trend = "window.location.href='".zen_href_link(FILENAME_DEFAULT)."';";
}else{
	$trend ='window.location.reload();';
} ?>

<script type="text/javascript">

//$(document).ready(function(){    
//	$.validator.addMethod("exists",function(value,element,params){
//		var html = $.ajax({
//			url: "ajax/efox/ajax_easy_create_account.php?email="+value,
//			cache: false,
//			async: false
//		}).responseText;
//		if(html=='1'){
//			return true;
//		}else{
//			return false;
//		}
//	},"is exists");
//});
function enroll(){
	if($('#register_div').length > 0 ){
		close_dialog('login_div');
		show_dialog('pop_up_dialog','register_div');
		
	//	alert($('#register_div').width()+'--'+$('#register_div').height());
	//	var register_dialog = $.ajax({
	//		url: "ajax_draw_dialog.php?type=register_dialog",
	//		cache: false,
	//		async: false
	//	}).responseText;	
	//	$('#pop_up_dialog').html('');
	//	$('#pop_up_dialog').append(register_dialog);
	
	
		$('#register_success_div').css('display','none');
		$('#register_address_div').css('display','none');
		$('#register_div').css('display','inline');
		
		$("#email_address_pop").select();
	}                
	$.validator.addMethod("exists",function(value,element,params){	
//		if($('#hide_email_address').val() == $('#email_address_pop').val()){
			var html = $.ajax({
				url: "ajax/efox/ajax_check_account.php?email="+value,
				cache: false,
				async: false
			}).responseText;
			if(html=='1'){
				return true;
			}else{
				return false;
			}
//		}else{
//			return false;
//		}
	},"Account already exist.");
                
	$.validator.addMethod("specialSymbols",function(value,element,params){		
		if(value.indexOf("'") >= 0){
			return false;
		}else{
			return true;
		}
	}," invalid Email address.");


	$('#pop_register_form').validate({

		event:'blur',
		onkeyup:false,
		rules:{		
			email_address_pop:{
				required:true,
				email:true,
				exists:function (){return $('#email_address_pop').val();}
				//specialSymbols:function (){return $('#email_address_pop').val();}		
		 	},
		
			customers_password_pop:{
				required:true,
				rangelength:[5,20]
			},
		
			confirmation_pop:{
				required:true,
				rangelength:[5,20],
				equalTo:"#customers_password_pop"
			}
		},					  
		
		messages:{
			email_address_pop:{
			   	required:"<img src='includes/templates/blackcool/images/error_img.gif' class='error_img' /><br/> <?php echo POP_TEXT_JS_TIP_EMAIL_REQUIRED;?>",
			   	email:"<img src='includes/templates/blackcool/images/error_img.gif' class='error_img' /><br/> <?php echo POP_TEXT_JS_TIP_EMAIL_FORMAT;?>",
			   	exists:"<img src='includes/templates/blackcool/images/error_img.gif' class='error_img' /><br/> <?php echo POP_TEXT_JS_TIP_EMAIL_ALREADY_EXITS;?>"
//				specialSymbols:"<img src='includes/templates/blackcool/images/error_img.gif' class='error_img' /><br/>  <?php echo POP_TEXT_JS_TIP_EMAIL_FORMAT;?>"
			},		
		
			customers_password_pop:{
				required:"<img src='includes/templates/blackcool/images/error_img.gif' class='error_img' /><br/> <?php echo POP_TEXT_JS_TIP_PASSWORD_REQUIRED;?>",
				rangelength:"<img src='includes/templates/blackcool/images/error_img.gif' class='error_img' /><br/> <?php echo POP_TEXT_JS_TIP_PASSWORD_LENGTH;?>"
			},															
		
			confirmation_pop:{
				required:"<img src='includes/templates/blackcool/images/error_img.gif' class='error_img' /><br/> <?php echo POP_TEXT_JS_TIP_PASSWORD2_REQUIRED;?>",
				rangelength:"<img src='includes/templates/blackcool/images/error_img.gif' class='error_img' /><br/> <?php echo POP_TEXT_JS_TIP_PASSWORD_LENGTH;?>",
				equalTo:"<img src='includes/templates/blackcool/images/error_img.gif' class='error_img' /><br/> <?php echo POP_TEXT_JS_TIP_PASSWORD_MATCH; ?>"
			}
		},
		
		success: function(label) {
			    label.html("<img src='includes/templates/blackcool/images/isrightimg.gif'  class='error_img' />");
			    //label.addClass("colorCC0406");
		}
	});

}
function check_register_form(){

	if($("#pop_register_form").validate().form()){      		

		$('#register_btn').html('<img src="includes/templates/blackcool/buttons/german/loading_btn.gif" />');

		var nick = '';if($('#nick').val()){nick = '&nick='+$('#nick').val()};
		var html = $.ajax({
			url: "ajax/efox/ajax_easy_create_account.php?email_address="+$('#email_address_pop').val()+"&customers_password="+$('#customers_password_pop').val()+"&confirmation="+$('#confirmation_pop').val()+nick+'&email_format='+$('#email_format').val(),
			cache: false,
			async: false
		}).responseText;
		
//alert(html);return false;
		(html.indexOf('<') < 0) ? eval(html) : alert('system error!');
		if(!email_address && !password && status){//valid OK
			if(nick != '' && s_nick){
				alert(s_nick);return false;
			}else{
//				close_dialog('loading_div');
				$('#register_btn').html('<img src="includes/templates/blackcool/buttons/german/button_register.gif" />');
				close_dialog('register_div');
				
				show_dialog('pop_up_dialog','register_success_div');	
				$('#register_success_div').css('display','inline');	
				
				$('#register_address_div').css('display','none');
				$('#login_div').css('display','none');
			}
		}else{			
			if(email_address)alert(email_address);return false;
			if(password)alert(password);return false;
		}		
	}else{
		return $('#pop_register_form').valid();
	}
	return false;
}


function enroll_address(){
	if($('#register_address_div').length > 0 ){
		close_dialog('register_success_div');
		show_dialog('pop_up_dialog','register_address_div');	
		
		$('#register_div').css('display','none');
		$('#login_div').css('display','none');	
		$('#register_address_div').css('display','inline');
		
		$("#firstname").select();
	}
	$('#checkout_address_form').validate({
	                  event:'blur',
	                  //ignore:".quanzui",
					  rules:{
					         firstname:{
							           required:true,
									   minlength:2
							 },
							 lastname:{
							           required:true,
									   minlength:2
							 },		
							 <?php if (ACCOUNT_TELEPHONE == 'true') { ?> 
									telephone:{
												required:true,
												number:true,
												minlength:6
									},
							 <?php }?>							 	 
							 street_address:{
							                 required:true,
										     minlength:5
							 },
							 postcode:{
							           required:true,
									  //number:true,
									   minlength:4
							 },
							 city:{
							       required:true,
								   minlength:2
							 },
							 zone_country_id:{
							                  required:true										          
							 },
							 Bedingungen:{
							 	required:true
							 }
					  },
						messages:{
						         firstname:{
										   required:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><?php echo POP_ENTRY_FIRST_NAME_ERROR; ?>',
										   minlength:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><?php echo POP_ENTRY_FIRST_NAME_ERROR; ?>'
								 },
								 lastname:{
										   required:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><?php echo POP_ENTRY_LAST_NAME_ERROR; ?>',
										   minlength:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><?php echo POP_ENTRY_LAST_NAME_ERROR; ?>'
								 },		
								 <?php if (ACCOUNT_TELEPHONE == 'true') { ?> 
									telephone:{
											required:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><?php echo POP_ENTRY_TELEPHONE_NUMBER_ERROR;?>',
											number:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><?php echo POP_ENTRY_TELEPHONE_NUMBER_EFFECTIVENESS;?>',
											minlength:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><?php echo POP_ENTRY_TELEPHONE_NUMBER_ERROR;?>'
									},
								 <?php }?>								 				 
								 street_address:{
												 required:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><?php echo POP_ENTRY_STREET_ADDRESS_ERROR; ?>',
												 minlength:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><?php echo POP_ENTRY_STREET_ADDRESS_ERROR; ?>'
								 },
								 postcode:{
										   required:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><?php echo POP_ENTRY_POST_CODE_ERROR; ?>',
										  //number:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><?php echo POP_ENTRY_POST_CODE_EFFECTIVENESS; ?>',
										   minlength:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><?php echo POP_ENTRY_POST_CODE_ERROR; ?>'
								 },
								 city:{
									   required:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><?php echo POP_ENTRY_CITY_ERROR; ?>',
									   minlength:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><?php echo POP_ENTRY_CITY_ERROR; ?>'
								 },
								 zone_country_id:{
												  required:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><br/><?php echo POP_ENTRY_COUNTRY_ERROR; ?>'
								 },
								 Bedingungen:{
								 	required:'<img src="includes/templates/blackcool/images/error_img.gif" style="margin-left: 15px;margin-top: 8px;" /><?php echo POP_RECOGNIZED_AGREEMENT_ERROR; ?>'
								 }
						},
						
					errorPlacement: function(error, element) {
						if ( element.is(":radio") )
							error.appendTo ( element.parent() );
						else if ( element.is(":checkbox") )
							error.appendTo ( element.parent() );
						//else if ( element.is("#zone_country_id") )
							//element.parent.after('<span></span>');
							//$('#test9').after(error);
							//error.after( element );
						else
							error.insertAfter(element);
					},					
						
					success: function(label,element) {
						if(label.attr('for')=='quanzui'){
							label.html('');			
						}else{    
							label.html("<img src='includes/templates/blackcool/images/isrightimg.gif'  class='error_img' />");
						}
						    //label.addClass("colorCC0406");
					}
	   
	});	
}
function check_address_form(){

	if($("#checkout_address_form").validate().form()){  	
		
		var daihao = $('#quanzui').val();if(daihao == ''){alert('<?php echo POP_ENTRY_DIAHAO_ERROR; ?>');$('#quanzui').select();return false;}
		if(isNaN(daihao)){alert('<?php echo POP_ENTRY_DIAHAO_NO_NUMBER_ERROR; ?>');$('#quanzui').select();return false;}
		
		var telephone = ''; if($('#telephone_z').val()){ telephone = "&telephone="+$('#telephone_z').val(); }
		var company = ''; if($('#company').val()){ company = "&company="+$('#company').val(); }
		
		var html = $.ajax({
			url: "ajax/efox/ajax_easy_create_account_further.php?sex_hid="+$('#sex_hid').val()+"&firstname="+$('#firstname').val()+"&lastname="+$('#lastname').val()+telephone+company+"&street_address="+$('#street_address').val()+"&postcode="+$('#postcode').val()+"&city="+$('#city').val()+"&zone_country_id="+$('#zone_country_id').val()+'&action='+$('#action').val(),
			cache: false,
			async: false
		}).responseText;
		
//alert(html);	return false;
		(html.indexOf('<') < 0) ? eval(html) : alert('system error!');
		if(!firstname && !lastname && !street_address && !postcode && !city && !country && status){//valida ok
			if((telephone != '' && s_telephone) || (company != '' && s_company)){
				if(s_telephone)alert(s_telephone);return false;
				if(s_company)alert(s_company);return false;				
			}else{
				close_dialog('register_address_div');
				if($('#register_success_affirm_dialog').length > 0 ){
					show_dialog('register_success_affirm_dialog','register_success_affirm_dialog');
				}
			}
		}else{
			if(firstname)alert(firstname);return false;
			if(lastname)alert(lastname);return false;
			if(street_address)alert(street_address);return false;
			if(postcode)alert(postcode);return false;
			if(city)alert(city); return false;
		}
	}else{
		return $('#checkout_address_form').valid();
	}
	
	return false;
}
function affirm_register(){
	//alert('<?php echo POP_TEXT_ADDRESS_SUCCESS; ?>');
	close_dialog('register_success_affirm_dialog');
	<?php echo $trend; ?>					
}
function reset_address_form(){
	$("#checkout_address_form").validate().resetForm();
}


function login(){
	if($('#login_div').length > 0 ){
		close_dialog('checkout_L_to_R_div');	
		show_dialog('pop_up_dialog','login_div');		
		
		$('#login_div').css('display','inline');	
		$('#register_success_div').css('display','none');	
		$('#register_address_div').css('display','none');
		
		$("#login_email_address").select();
	}
	$('#pop_up_login_form').validate({
		event:'blur',
		
		rules:{		
			login_email_address:{			
				required:true,			
				email:true
			},
			
			password:{			
				required:true,				
				rangelength:[5,20]			
			}		
		},
		
		messages:{		
			login_email_address:{			
				required:"<br/><?php echo TEXT_JS_TIP_LOGIN_EMAIL_REQUIRED;?>",				
				email:"<br/><?php echo TEXT_JS_TIP_LOGIN_EMAIL_FORMAT;?>"						
			},
			
			password:{			
				required:"<br/><?php echo TEXT_JS_TIP_PASSWORD_REQUIRED;?>",				
				rangelength:"<br/><?php echo TEXT_JS_TIP_PASSWORD_LENGTH;?>"
			}		
		}
	});
}
function pop_check_login_form(){
	if($("#pop_up_login_form").validate().form()){
		var html = $.ajax({
			url: "ajax/efox/ajax_login.php?login_email_address="+$('#login_email_address').val()+'&password='+$('#password').val(),
			cache: false,
			async: false
		}).responseText;

//alert(html);	return false;
		(html.indexOf('<') < 0) ? eval(html) : alert('system error!');
		if(!login_email_address && !password){
			close_dialog('login_div');
			<?php echo $trend; ?>		
		}else{
			if(login_email_address)alert(login_email_address);
			if(password)alert(password);
		}
	}else{
		return $('#pop_up_login_form').valid();
	}
   return false;
}


function checkout_L_to_R(type){//alert(type);
	if(type==1){//only register
		$('#checkout_login_div').hide();
		$('#enroll_title').hide();
		$('#login_or_enroll_title').html('<span class="fontsize16px fontbold"><?php echo POP_TEXT_RETURNING_TITLE; ?></span><?php echo POP_TEXT_REGISTER_TO_LOGIN; ?>');
		$('#checkout_enroll_big_div').css('padding-left','70px');
		$('#address_info_div').css('border-top','1px solid #FB8200');
		$("#checkout_email_address").select();
	}else{//having register and logining
		$('#checkout_login_div').show();
		$('#enroll_title').show();	
		$('#login_or_enroll_title').html('<span class="fontbold fontsize20px"><?php echo POP_TEXT_CHECKOUT_L_TITLE; ?></span>');
		$('#checkout_enroll_big_div').css('padding-left','0px');
		$('#address_info_div').css('border-top','0px');
		$("#checkout_login_email_address").select();
	}
	
	close_dialog('login_div');	
	show_dialog('checkout_L_to_R_div','checkout_L_to_R_div');	
	$.validator.addMethod("exists",function(value,element,params){		
		var html = $.ajax({
			url: "ajax/efox/ajax_check_account.php?email="+value,
			cache: false,
			async: false
		}).responseText;
		if(html=='1'){
			return true;
		}else{
			return false;
		}
	},"Account already exist.");
		
	if(type!=1){		
		$('#pop_up_checkout_login_form').validate({
			event:'blur',
			
			rules:{		
				checkout_login_email_address:{			
					required:true,			
					email:true
				},
				
				checkout_password:{			
					required:true,				
					rangelength:[5,20]			
				}		
			},
			
			messages:{		
				checkout_login_email_address:{			
					required:"<br/><?php echo TEXT_JS_TIP_LOGIN_EMAIL_REQUIRED;?>",				
					email:"<br/><?php echo TEXT_JS_TIP_LOGIN_EMAIL_FORMAT;?>"						
				},
				
				checkout_password:{			
					required:"<br/><?php echo TEXT_JS_TIP_PASSWORD_REQUIRED;?>",				
					rangelength:"<br/><?php echo TEXT_JS_TIP_PASSWORD_LENGTH;?>"
				}		
			}
		});			
	}
	
	$('#checkout_create_account_form').validate({

		event:'keyup',
		onkeyup:false,
		rules:{		
			checkout_email_address:{
				required:true,
				email:true,
				exists:function (){return $('#checkout_email_address').val();}
		 	},
		
			checkout_customers_password:{
				required:true,
				rangelength:[5,20]
			},
		
			checkout_confirmation:{
				required:true,
				rangelength:[5,20],
				equalTo:"#checkout_customers_password"
			},
			
			
			
//			checkout_firstname:{
//			       required:true,
//				   minlength:2
//			},
			checkout_lastname:{
			       required:true,
				   minlength:2
			},
			 checkout_city:{
			       required:true,
				   minlength:2
			},
//			checkout_postcode:{
//			       required:true,
//				   number:true,
//				   minlength:4
//			},						 	 
			checkout_street_address:{
					required:true,
					minlength:5
			},
			checkout_zone_country_id:{
			       required:true										          
			},		
			<?php //if (ACCOUNT_TELEPHONE == 'true') { ?> 
				checkout_telephone:{
							required:true,
							number:true,
							minlength:6
				}
			<?php //}?>		
		},					  
				
		messages:{
			checkout_email_address:{
			   	required:"<img src='includes/templates/blackcool/images/error_img.gif' class='error_img' /><br/> <?php echo POP_TEXT_JS_TIP_EMAIL_REQUIRED;?>",
			   	email:"<img src='includes/templates/blackcool/images/error_img.gif' class='error_img' /><br/> <?php echo POP_TEXT_JS_TIP_EMAIL_FORMAT;?>",
			   	exists:"<img src='includes/templates/blackcool/images/error_img.gif' class='error_img' /><br/> <?php echo POP_TEXT_JS_TIP_EMAIL_ALREADY_EXITS;?>"
			},		
		
			checkout_customers_password:{
				required:"<img src='includes/templates/blackcool/images/error_img.gif' class='error_img' /><br/> <?php echo POP_TEXT_JS_TIP_PASSWORD_REQUIRED;?>",
				rangelength:"<img src='includes/templates/blackcool/images/error_img.gif' class='error_img' /><br/> <?php echo POP_TEXT_JS_TIP_PASSWORD_LENGTH;?>"
			},															
		
			checkout_confirmation:{
				required:"<img src='includes/templates/blackcool/images/error_img.gif' class='error_img' /><br/> <?php echo POP_TEXT_JS_TIP_PASSWORD2_REQUIRED;?>",
				rangelength:"<img src='includes/templates/blackcool/images/error_img.gif' class='error_img' /><br/> <?php echo POP_TEXT_JS_TIP_PASSWORD_LENGTH;?>",
				equalTo:"<img src='includes/templates/blackcool/images/error_img.gif' class='error_img' /><br/> <?php echo POP_TEXT_JS_TIP_PASSWORD_MATCH; ?>"
			},
			
			
//			checkout_firstname:{
//					required:'<br/><?php echo POP_ENTRY_FIRST_NAME_ERROR; ?>',
//				    minlength:'<br/><?php echo POP_ENTRY_FIRST_NAME_ERROR; ?>'				
//			},
			checkout_lastname:{
				   required:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/>&nbsp;&nbsp;<?php echo POP_ENTRY_LAST_NAME_ERROR; ?>',
				   minlength:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/>&nbsp;&nbsp;<?php echo POP_ENTRY_LAST_NAME_ERROR; ?>'
			},
			 checkout_city:{
				   required:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><?php echo POP_ENTRY_CITY_ERROR; ?>',
				   minlength:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><?php echo POP_ENTRY_CITY_ERROR; ?>'
			 },
//			checkout_postcode:{
//				   required:'<br/><?php echo POP_ENTRY_POST_CODE_ERROR; ?>',
//				   number:'<br/><?php echo POP_ENTRY_POST_CODE_EFFECTIVENESS; ?>',
//				   minlength:'<br/><?php echo POP_ENTRY_POST_CODE_ERROR; ?>'
//			},								 				 
			checkout_street_address:{
				 required:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><?php echo POP_ENTRY_STREET_ADDRESS_ERROR; ?>',
				 minlength:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><?php echo POP_ENTRY_STREET_ADDRESS_ERROR; ?>'
			},
			checkout_zone_country_id:{
				  required:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><?php echo POP_ENTRY_COUNTRY_ERROR; ?>'
			},	
			<?php //if (ACCOUNT_TELEPHONE == 'true') { ?> 
			checkout_telephone:{
				required:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><?php echo POP_ENTRY_TELEPHONE_NUMBER_ERROR;?>',
				number:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><?php echo POP_ENTRY_TELEPHONE_NUMBER_EFFECTIVENESS;?>',
				minlength:'<img src="includes/templates/blackcool/images/error_img.gif" class="error_img" /><br/><?php echo POP_ENTRY_TELEPHONE_NUMBER_ERROR;?>'
			}
			<?php //}?>		
		},

		errorPlacement:function(error,element) {
			if(element.is('#checkout_lastname')){// || element.is('#checkout_lastname')
				//$('#firstname_lastname_error').html('');
				error.appendTo($('#firstname_lastname_error'));
				
			}else if(element.is('#checkout_city')){
				
				error.appendTo($('#checkout_city'));
			
			}else if(element.is('#checkout_telephone')){
				
				error.appendTo($('#checkout_telephone'));
			}else{
				error.insertAfter(element);
			}						
		},
				
		success: function(label) {
			if(label.attr('for')=='checkout_firstname' || label.attr('for')=='checkout_postcode' || label.attr('for')=='checkout_quanzui'){
				label.html('');			
			}else{    
				label.html("<img src='includes/templates/blackcool/images/isrightimg.gif'  class='error_img' />");
			}
		}
	});	
}
function checkout_login_submit(){
	if($("#pop_up_checkout_login_form").validate().form()){
		var html = $.ajax({
			url: "ajax/efox/ajax_login.php?login_email_address="+$('#checkout_login_email_address').val()+'&password='+$('#checkout_password').val(),
			cache: false,
			async: false
		}).responseText;
		
//alert(html);	return false;
		(html.indexOf('<') < 0) ? eval(html) : alert('system error!');
		if(!login_email_address && !password){
			close_dialog('checkout_L_to_R_div');
			window.location.reload();			
		}else{
			if(login_email_address)alert(login_email_address);
			if(password)alert(password);
		}
	}else{
		return $('#pop_up_checkout_login_form').valid();
	}
   return false;
}
function checkout_enroll_submit(){
	
	if($("#checkout_create_account_form").validate().form()){
		  		
		var account = "email_address="+$('#checkout_email_address').val()+"&customers_password="+$('#checkout_customers_password').val()+"&confirmation="+$('#checkout_confirmation').val();
		
		var daihao = $('#checkout_quanzui').val();if(daihao == ''){alert('<?php echo POP_ENTRY_DIAHAO_ERROR; ?>');$('#checkout_quanzui').select();return false;}
		if(isNaN(daihao)){alert('<?php echo POP_ENTRY_DIAHAO_NO_NUMBER_ERROR; ?>');$('#checkout_quanzui').select();return false;}
		
		var firstname_c = $('#checkout_firstname').val();if(firstname_c == '' || firstname_c.length < 2){alert('<?php echo POP_ENTRY_FIRST_NAME_ERROR; ?>');$('#checkout_firstname').select();return false;}
		
		var postcode_c = $('#checkout_postcode').val();if(postcode_c == '' || postcode_c.length < 4){alert('<?php echo POP_ENTRY_POST_CODE_ERROR; ?>');$('#checkout_postcode').select();return false;}
		//if(isNaN(postcode_c)){alert('<?php echo POP_ENTRY_POST_CODE_EFFECTIVENESS; ?>');$('#checkout_postcode').select();return false;}
		
		var telephone = ''; if($('#checkout_telephone_z').val() != ''){ telephone = "&telephone="+$('#checkout_telephone_z').val(); }

		$('#checkout_submit_btn').html('<img src="includes/templates/blackcool/buttons/german/loading_btn.gif" />');
		
		var html = $.ajax({
			url: "ajax/efox/ajax_create_account_address.php?"+account+"&firstname="+firstname_c+"&lastname="+$('#checkout_lastname').val()+"&sex_hid="+$('#checkout_sex_hid').val()+"&city="+$('#checkout_city').val()+"&postcode="+postcode_c+"&street_address="+$('#checkout_street_address').val()+"&zone_country_id="+$('#checkout_zone_country_id').val()+telephone,
			cache: false,
			async: false
		}).responseText;
		
//alert(html);return false;
		(html.indexOf('<') < 0) ? eval(html) : alert('system error!');
		if(!email_address && !password &&    !firstname && !lastname && !street_address && !postcode && !country && status){//valid OK
			
			if((telephone != '' && s_telephone)){
				if(s_telephone)alert(s_telephone);return false;	
			}else{
				//alert('<?php //echo POP_TEXT_ADDRESS_SUCCESS; ?>');
				$('#checkout_submit_btn').html('<img src="includes/templates/blackcool/buttons/german/popupdate_btn.gif" />');
				close_dialog('checkout_L_to_R_div');
				<?php echo $trend; ?>
				window.location.reload();
			}
		}else{			
			if(email_address)alert(email_address);return false;
			if(password)alert(password);return false;
						
			if(firstname)alert(firstname);return false;
			if(lastname)alert(lastname);return false;
			if(street_address)alert(street_address);return false;
			if(postcode)alert(postcode); return false;
			if(country)alert(country); return false;
		}		
	}else{
		return $('#checkout_create_account_form').valid();
	}
	
	return false;	
}

</script>