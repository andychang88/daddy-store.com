//js document
$(document).ready(function(){  
	$('#litbBtn').mouseover(function(){
	    closeMenu=false;
		controlMenu();
	});
	
	$('#litbCon2').mousemove(function(){
	    closeMenu=false;
		setTimeout(controlMenu,0);
	});
	
	$('#litbCon2').mouseout(function(){
	    closeMenu=true;
		setTimeout(controlMenu,0);
	});
	
	$('#nl_subscribe_form').validate({
									   event:'keyup',
									   rules:{
											  email:{
													required:true,
													email:true
											  }
									   },
									   messages:{
												 email:{
														required:"<br/>Bitte Ihre Email schreiben",
														email:"<br/>ungültige Email!"
												 }	
									   }/*,
									   debug:true*/
							   
	});
});
var closeMenu=true;
function controlMenu(){
	if(closeMenu){
	   $('#litbCon2').css('display','none');
	   $('#litbBtn').css('background-position','0 0');
	}else{
	   $('#litbCon2').css('display','block');
	   $('#litbBtn').css('background-position','0 -16px');
	}
}
function rollText_new(num){
	if(num==1){
		document.getElementById("rollTextMenu1").style.display="none";
		document.getElementById("rollTextMenu2").style.display="block";
	}else{
		document.getElementById("rollTextMenu2").style.display="none";
		document.getElementById("rollTextMenu1").style.display="block";
	}                    
}
function check_nl_subscribe_form(){
	return $('#nl_subscribe_form').valid();
}