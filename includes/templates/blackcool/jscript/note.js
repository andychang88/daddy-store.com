jQuery(document.body).ready(function(){
$('#hai_note').css('color','red');
$('#hai_note').live('mouseover',function(){
		  $('#hai_note').css('cursor','pointer');
		});
$('#hai_note').live('click',function(){									 
if($('#hai_info').css('display') == 'none')
{
   $('#hai_info').show(1000);
   $('#hai_note').html('Close');
}
else if($('#hai_info').css('display') == 'block'){
	$('#hai_note').html('Learn More');
	$('#hai_info').hide("slow");
	}
});
});