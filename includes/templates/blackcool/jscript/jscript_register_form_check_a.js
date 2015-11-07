function enroll(){
	if($('#register_div').length > 0 ){
		close_dialog('login_div');
		show_dialog('register_div','register_div');
	
		$('#register_success_div').css('display','none');
		$('#register_address_div').css('display','none');
		$('#register_div').css('display','inline');
		
		$("#email_address_pop").select();
	                
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
				   	required:POP_TEXT_JS_TIP_EMAIL_REQUIRED,
				   	email:POP_TEXT_JS_TIP_EMAIL_FORMAT,
				   	exists:POP_TEXT_JS_TIP_EMAIL_ALREADY_EXITS
				},		
			
				customers_password_pop:{
					required:POP_TEXT_JS_TIP_PASSWORD_REQUIRED,
					rangelength:POP_TEXT_JS_TIP_PASSWORD_LENGTH
				},															
			
				confirmation_pop:{
					required:POP_TEXT_JS_TIP_PASSWORD2_REQUIRED,
					rangelength:POP_TEXT_JS_TIP_PASSWORD_LENGTH,
					equalTo:POP_TEXT_JS_TIP_PASSWORD_MATCH
				}
			},
			
			success: function(label) {
				    label.html(POP_OK_IMG);
				    //label.addClass("colorCC0406");
			}
		});
	}
}
function check_register_form(){

	if($("#pop_register_form").validate().form()){      	
			
		var rawhtml = $('#register_btn').html();
		$('#register_btn').html(POP_LOADING_IMG);

		var nick = '';if($('#nick').val()){nick = '&nick='+$('#nick').val();}
		var html = $.ajax({
			url: "ajax/efox/ajax_easy_create_account.php?email_address="+$('#email_address_pop').val()+"&customers_password="+$('#customers_password_pop').val()+"&confirmation="+$('#confirmation_pop').val()+nick+'&email_format='+$('#email_format').val(),
			cache: false,
			async: false
		}).responseText;
		$('#register_btn').html(rawhtml);
		
//alert(html);return false;
		(html.indexOf('<') < 0) ? eval(html) : alert('system error!');
		if(!email_address && !password && status){//valid OK
			if(nick != '' && s_nick){
				alert(s_nick);return false;
			}else{
				close_dialog('register_div');
				
				show_dialog('register_success_div','register_success_div');	
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

////////////////////////////////////////////////////////////////////

function enroll_address(){
	if($('#register_address_div').length > 0 ){
		close_dialog('register_success_div');
		show_dialog('register_address_div','register_address_div');	
		
		$('#register_div').css('display','none');
		$('#login_div').css('display','none');	
		$('#register_address_div').css('display','inline');
		
		$("#firstname").select();
		
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
                                                                        telephone:{
                                                                                                required:true,
                                                                                                number:true,
                                                                                                minlength:6
                                                                        },						 	 
								 street_address:{
								                 required:true,
											     minlength:5
								 },
								 postcode:{
								           required:true,
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
											   required:POP_ERROR_IMG+POP_ENTRY_FIRST_NAME_ERROR,
											   minlength:POP_ERROR_IMG+POP_ENTRY_FIRST_NAME_ERROR
									 },
									 lastname:{
											   required:POP_ENTRY_LAST_NAME_ERROR,
											   minlength:POP_ENTRY_LAST_NAME_ERROR
									 },		
									 
                                                                            telephone:{
                                                                                    required:POP_ENTRY_TELEPHONE_NUMBER_ERROR,
                                                                                    number:POP_ENTRY_TELEPHONE_NUMBER_EFFECTIVENESS,
                                                                                    minlength:POP_ENTRY_TELEPHONE_NUMBER_ERROR
                                                                            },
									 
									 street_address:{
                                                                                     required:POP_ENTRY_STREET_ADDRESS_ERROR,
                                                                                     minlength:POP_ENTRY_STREET_ADDRESS_ERROR
									 },
									 postcode:{
                                                                                   required:POP_ERROR_IMG+POP_ENTRY_POST_CODE_ERROR,
                                                                                   minlength:POP_ERROR_IMG+POP_ENTRY_POST_CODE_ERROR
									 },
									 city:{
										   required:POP_ENTRY_CITY_ERROR,
										   minlength:POP_ENTRY_CITY_ERROR
									 },
									 zone_country_id:{
                                                                                  required:POP_ENTRY_COUNTRY_ERROR
									 },
									 Bedingungen:{
									 	required:POP_RECOGNIZED_AGREEMENT_ERROR
									 }
							},
							
						errorPlacement: function(error, element) {
							if ( element.is(":radio") )
								error.appendTo ( element.parent() );
							else if ( element.is(":checkbox") )
								error.appendTo ( element.parent() );
							else
								error.insertAfter(element);
						},					
							
						success: function(label,element) {
							if(label.attr('for')=='quanzui'){
								label.html('');			
							}else{    
								label.html(POP_OK_IMG);
							}
						}
		   
		});	
	}
}
function check_address_form(){

	if($("#checkout_address_form").validate().form()){  	
		
		var daihao = $('#quanzui').val();if(daihao == ''){alert(POP_ENTRY_DIAHAO_ERROR);$('#quanzui').select();return false;}
		if(isNaN(daihao)){alert(POP_ENTRY_DIAHAO_NO_NUMBER_ERROR);$('#quanzui').select();return false;}
		
		var telephone = ''; if($('#telephone_z').val()){ telephone = "&telephone="+$('#telephone_z').val(); }
		var company = ''; if($('#company').val()){ company = "&company="+$('#company').val(); }
		var newsletter = 0;if($('#Newsletter').attr("checked")) newsletter = 1;
		
		var rawhtml = $('#submit_address_p').html();
		$('#submit_address_p').html(POP_LOADING_IMG);
		var html = $.ajax({
			url: "ajax/efox/ajax_easy_create_account_further.php?sex_hid="+$('#sex_hid').val()+"&firstname="+$('#firstname').val()+"&lastname="+$('#lastname').val()+telephone+company+"&street_address="+$('#street_address').val()+"&postcode="+$('#postcode').val()+"&city="+$('#city').val()+"&zone_country_id="+$('#zone_country_id').val()+'&action='+$('#action').val()+'&newsletter='+newsletter,
			cache: false,
			async: false
		}).responseText;
		$('#submit_address_p').html(rawhtml);
		
//alert(html);	return false;
		(html.indexOf('<') < 0) ? eval(html) : alert('system error!');
		if(!firstname && !lastname && !street_address && !postcode && !city && !country && status){//valida ok
			if((telephone != '' && s_telephone) || (company != '' && s_company)){
				if(s_telephone)alert(s_telephone);return false;
				if(s_company)alert(s_company);return false;				
			}else{
				close_dialog('register_address_div');
				show_dialog('register_success_affirm_dialog','register_success_affirm_dialog');
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
	$('#affirm_register_p').html(POP_LOADING_IMG);
        var url = window.location.href;
        if(url.indexOf('time_out') > 0 || url.indexOf('logoff') > 0){
            window.location.href=$('#is_hom_page').val();
        }else{
            window.location.reload();
        }        
}
function reset_address_form(){
	$("#checkout_address_form").validate().resetForm();
}

/////////////////////////////////////////////////////////////////////////////////////

function login(){
	if($('#login_div').length > 0 ){
		//close_dialog('register_div');	
		close_dialog('checkout_L_to_R_div');	
		show_dialog('login_div','login_div');		
		
		$('#login_div').css('display','inline');	
		
		$("#login_email_address").select();
		
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
					required:TEXT_JS_TIP_LOGIN_EMAIL_REQUIRED,
					email:TEXT_JS_TIP_LOGIN_EMAIL_FORMAT
				},
				
				password:{			
					required:TEXT_JS_TIP_PASSWORD_REQUIRED,
					rangelength:TEXT_JS_TIP_PASSWORD_LENGTH
				}		
			}
		});
	}
}
function pop_check_login_form(){
    if($("#pop_up_login_form").validate().form()){

            var rawhtml = $('#login_p').html();
            $('#login_p').html(POP_LOADING_IMG);
            var html = $.ajax({
                    url: "ajax/efox/ajax_login.php?login_email_address="+$('#login_email_address').val()+'&password='+$('#password').val(),
                    cache: false,
                    async: false
            }).responseText;
            $('#login_p').html(rawhtml);

//alert(html);	return false;
            (html.indexOf('<') < 0) ? eval(html) : alert('system error!');
            if(!login_email_address && !password){
                    $('#login_p').html(POP_LOADING_IMG); 
                    //trend();	
                    var url = window.location.href;
                    if(url.indexOf('time_out') > 0 || url.indexOf('logoff') > 0){
                        window.location.href=$('#is_hom_page').val();
                    }else{
                        window.location.reload();
                    }
                    return false;
            }else{
                    if(login_email_address)alert(login_email_address);
                    if(password)alert(password);
            }
    }else{
            return $('#pop_up_login_form').valid();
    }
   return false;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////

function checkout_L_to_R(type){//alert(type);
	if($('#checkout_L_to_R_div').length > 0 ){
		if(type==1){//只有注册
			$('#checkout_login_div').hide();
			$('#enroll_title').hide();
			$('#login_or_enroll_title').html('<span class="fontsize16px fontbold">'+POP_TEXT_CHECKOUT_R_TITLE+'</span>'+POP_TEXT_REGISTER_TO_LOGIN);
			$('#checkout_enroll_big_div').css('padding-left','70px');
			$('#address_info_div').css('border-top','1px solid #2F91DC');
			$("#checkout_email_address").select();
			ga();
		}else{//有登陆和注册
			$('#checkout_login_div').show();
			$('#enroll_title').show();	
			$('#login_or_enroll_title').html("<span class=\"fontbold fontsize20px\">"+POP_TEXT_CHECKOUT_L_TITLE+"</span>");
			$('#checkout_enroll_big_div').css('padding-left','0px');
			$('#address_info_div').css('border-top','0px');
			$("#checkout_login_email_address").select();
		}
		
		//close_dialog('login_div');	
		$('#login_div').css('display','none');
		$('#pop_up_zhezhao').remove();
		
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
						required:TEXT_JS_TIP_LOGIN_EMAIL_REQUIRED,
						email:TEXT_JS_TIP_LOGIN_EMAIL_FORMAT
					},
					
					checkout_password:{			
						required:TEXT_JS_TIP_PASSWORD_REQUIRED,
						rangelength:TEXT_JS_TIP_PASSWORD_LENGTH
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
				
				
				
				checkout_lastname:{
				       required:true,
					   minlength:2
				},
				 checkout_city:{
				       required:true,
					   minlength:2
				 },					 	 
				checkout_street_address:{
						required:true,
						minlength:5
				},
				checkout_zone_country_id:{
				       required:true										          
				},		
					checkout_telephone:{
								required:true,
								number:true,
								minlength:6
					},	
				
				 Bedingungen:{
				 	required:true
				 }			
			},					  
					
			messages:{
				checkout_email_address:{
				   	required:POP_TEXT_JS_TIP_EMAIL_REQUIRED,
				   	email:POP_TEXT_JS_TIP_EMAIL_FORMAT,
				   	exists:POP_TEXT_JS_TIP_EMAIL_ALREADY_EXITS
				},		
			
				checkout_customers_password:{
					required:POP_TEXT_JS_TIP_PASSWORD_REQUIRED,
					rangelength:POP_TEXT_JS_TIP_PASSWORD_LENGTH
				},															
			
				checkout_confirmation:{
					required:POP_TEXT_JS_TIP_PASSWORD2_REQUIRED,
					rangelength:POP_TEXT_JS_TIP_PASSWORD_LENGTH,
					equalTo:POP_TEXT_JS_TIP_PASSWORD_MATCH
				},
				
				
				checkout_lastname:{
					   required:POP_ENTRY_LAST_NAME_ERROR,
					   minlength:POP_ENTRY_LAST_NAME_ERROR
				},
				 checkout_city:{
					   required:POP_ENTRY_CITY_ERROR,
					   minlength:POP_ENTRY_CITY_ERROR
				 },							 				 
				checkout_street_address:{
					 required:POP_ENTRY_STREET_ADDRESS_ERROR,
					 minlength:POP_ENTRY_STREET_ADDRESS_ERROR
				},
				checkout_zone_country_id:{
					  required:POP_ENTRY_COUNTRY_ERROR
				},	
				
				checkout_telephone:{
					required:POP_ENTRY_TELEPHONE_NUMBER_ERROR,
					number:POP_ENTRY_TELEPHONE_NUMBER_EFFECTIVENESS,
					minlength:POP_ENTRY_TELEPHONE_NUMBER_ERROR
				},
				
				 Bedingungen:{
				 	required:POP_RECOGNIZED_AGREEMENT_ERROR
				 }				
			},
	
			errorPlacement:function(error,element) {
				if(element.is('#checkout_lastname')){// || element.is('#checkout_lastname')
					//$('#firstname_lastname_error').html('');
					error.appendTo($('#firstname_lastname_error'));
					
				}else if(element.is('#checkout_city')){
					
					error.appendTo($('#checkout_city'));
				
				}else if(element.is('#checkout_telephone')){
					
					error.appendTo($('#checkout_telephone'));
				}else if ( element.is(":checkbox") ){
					error.appendTo ( element.parent() );				
				}else{
					error.insertAfter(element);
				}						
			},
					
			success: function(label) {
				if(label.attr('for')=='checkout_firstname' || label.attr('for')=='checkout_postcode' || label.attr('for')=='checkout_quanzui'){
					label.html('');			
				}else{    
					label.html(POP_OK_IMG);
				}
			}
		});	
	}
}
function checkout_login_submit(){
	if($("#pop_up_checkout_login_form").validate().form()){
		
		var rawhtml = $('#checkout_login_span').html();
		$('#checkout_login_span').html(POP_LOADING_IMG);
		var html = $.ajax({
			url: "ajax/efox/ajax_login.php?login_email_address="+$('#checkout_login_email_address').val()+'&password='+$('#checkout_password').val(),
			cache: false,
			async: false
		}).responseText;
		$('#checkout_login_span').html(rawhtml);
		
//alert(html);	return false;
		(html.indexOf('<') < 0) ? eval(html) : alert('system error!');
		if(!login_email_address && !password){
			//close_dialog('checkout_L_to_R_div');
			$('#checkout_login_span').html(POP_LOADING_IMG);
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
		
		var daihao = $('#checkout_quanzui').val();if(daihao == ''){alert(POP_ENTRY_DIAHAO_ERROR);$('#checkout_quanzui').select();return false;}
		if(isNaN(daihao)){alert(POP_ENTRY_DIAHAO_NO_NUMBER_ERROR);$('#checkout_quanzui').select();return false;}
		
		var firstname_c = $('#checkout_firstname').val();if(firstname_c == '' || firstname_c.length < 2){alert(POP_ENTRY_FIRST_NAME_ERROR);$('#checkout_firstname').select();return false;}
		
		var postcode_c = $('#checkout_postcode').val();if(postcode_c == '' || postcode_c.length < 4){alert(POP_ENTRY_POST_CODE_ERROR);$('#checkout_postcode').select();return false;}
			
		var telephone = ''; if($('#checkout_telephone_z').val() != ''){ telephone = "&telephone="+$('#checkout_telephone_z').val(); }
		var newsletter = 0;if($('#checkout_newsletter').attr("checked")) newsletter = 1;
		
		var rawhtml = $('#checkout_submit_btn').html();
		$('#checkout_submit_btn').html(POP_LOADING_IMG);		
		var html = $.ajax({
			url: "ajax/efox/ajax_create_account_address.php?"+account+"&firstname="+firstname_c+"&lastname="+$('#checkout_lastname').val()+"&sex_hid="+$('#checkout_sex_hid').val()+"&city="+$('#checkout_city').val()+"&postcode="+postcode_c+"&street_address="+$('#checkout_street_address').val()+"&zone_country_id="+$('#checkout_zone_country_id').val()+telephone+'&newsletter='+newsletter,
			cache: false,
			async: false
		}).responseText;
		$('#checkout_submit_btn').html(rawhtml);
		
//alert(html);return false;
		(html.indexOf('<') < 0) ? eval(html) : alert('system error!');
		if(!email_address && !password &&    !firstname && !lastname && !street_address && !postcode && !country && status){//valid OK
			
			if((telephone != '' && s_telephone)){
				if(s_telephone)alert(s_telephone);return false;	
			}else{
                            $('#checkout_submit_btn').html(POP_LOADING_IMG);
                            close_dialog('checkout_L_to_R_div');
                            //checkout_trend();
                            var url = window.location.href;
                            if(url.indexOf('checkout') > 0 && url.indexOf('fecaction') > 0){
                                //window.location.href=$('#is_hom_page').val();
                                window.location.reload();
                            }else{
                                show_dialog("register_success_affirm_dialog","register_success_affirm_dialog");
                            }
                            return false;
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
function ga(){
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-9657837-7']);
    _gaq.push(['_trackPageview']);

    (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
}