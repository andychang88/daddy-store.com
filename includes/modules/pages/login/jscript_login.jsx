// JavaScript Document
$(document).ready(function(){
  $('#register_form input[type=text]').each(function(){
				$(this).focus(function(){
									     $(this).attr('class','focus_input_border');
									    }
							 );
				$(this).blur(function(){
									     $(this).attr('class','input_text_border');
									    }
							 );
  });	
  $('#register_form input[type=password]').each(function(){
				$(this).focus(function(){
									     $(this).attr('class','focus_input_border');
									    }
							 );
				$(this).blur(function(){
									     $(this).attr('class','input_text_border');
									    }
							 );
  });	
});