/**/
var usr_f_s = '';
function show_dialog(dialogId,contenId){
	$("#categories_search_select").hide();
	var sWidth =0;var sHeight=0;
	
	if(document.documentElement.clientHeight > document.body.clientHeight){
		sWidth = document.documentElement.clientWidth;
		sHeight = document.documentElement.clientHeight;		
	}else{
		sWidth=document.body.clientWidth;
		sHeight=document.body.clientHeight;
	}
	
	$('body').append('<div id="pop_up_zhezhao" style="display:none;" onclick="if($(\'#'+contenId+'\').length ==0 || $(\'#'+contenId+'\').css(\'display\') == \'none\'){close_dialog(\''+dialogId+'\');load_status=true;}"></div>');//
	
	//
	$('#pop_up_zhezhao').css({'display':'inline','width':sWidth+'px','height':sHeight+'px','z-index':'8888'});
	$('#pop_up_zhezhao').css({'position':'absolute','top':'0','left':'0','cursor':'pointer','background':'#777','filter':'progid:DXImageTransform.Microsoft.Alpha(style=3,opacity=25,finishOpacity=60)','opacity':'0.5'});
	
	$('#'+dialogId).fadeIn('slow');
	
	var left = parseInt((sWidth-($('#'+contenId).width()))/2);
	var top= parseInt(((document.documentElement.clientHeight)-($('#'+contenId).height()))/2);
	if(document.documentElement.clientHeight < $('#'+contenId).height()){
		top = 10;
	}
	
	$('#'+dialogId).css({'position':'absolute','left':left+'px','top':top+'px','z-index':'8889'});
        usr_f_s=dialogId;
}

function close_dialog(id){
	$("#categories_search_select").show();
	$('#'+id).fadeOut('slow');
//	var T = setTimeout("mysleep()",500);
//	clearTimeout(T);
	$('#pop_up_zhezhao').remove();
        usr_f_s='';
}
function follow_scroll(){
    if(usr_f_s){
        var scroll_top =document.documentElement.scrollTop;
        
        //alert(top1+'-'+top);
        //var left =document.documentElement.scrollLeft;   
        if(scroll_top < 1){//goolgeä¯ÀÀÆ÷´¦Àí
            scroll_top =document.body.scrollTop;
            //left =document.body.scrollLeft;
        }
        var top= scroll_top + parseInt(((document.documentElement.clientHeight)-($('#'+usr_f_s).height()))/2);
        $('#'+usr_f_s).css({"top":top+"px"});
    }
} 

function mysleep(){
	alert(1);
}
/**
function adv(main,hidediv,alink,hidtime,trp){//抢购广告
	$(main).hover(function(){
			$(hidediv).fadeTo(hidtime,trp,function(){
				$(this).hide();				
			})			
		},function(){
			$(hidediv).fadeTo(0,1);
			$(hidediv).show();
		}
	)
}

$(document).ready(function(){
	load_status = true;
    //window.onscroll=follow_scroll;
    //window.onresize=follow_scroll;
    //window.onload=follow_scroll;
	adv("#adv","#adv_banner",300,0);//执行抢购
	getServerTime();
});
function getXMLHTTPRequest(){
	var req = null;
	try{
		req = new XMLHttpRequest(); //e.g firefox
	}
	catch(err1){
		try{
			req = new ActiveXObject("Msxml2.XMlHTTP"); // some versions IE
		}
		catch(err2){
			try{
				req = new ActiveXObject("Microsoft.XMlHTTP"); // some versions IE
			}
			catch(err3){
				req = false;
			}			
		}
	}
	return req;
}

var http = getXMLHTTPRequest();

function getServerTime(){
	var html = $.ajax({
		url: "getdate.php",
		cache: false,
		async: false
	}).responseText;
	eval(html);
	$("#time_y").val(Year);
	$("#time_m").val(Months);
	$("#time_d").val(Day);
	$("#time_h").val(Hours);
	$("#time_i").val(Minutes);
	$("#time_s").val(Seconds);
}

/**/
