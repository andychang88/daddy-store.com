<?php


?>

<div class="ucright">
  <div class="ucpwd">
            <h2><?php echo HEADING_TITLE;?></h2>
            <div class="margintop10px">
               <div class="ucpunkte lineheight20px margintop10px padding10px">
                	<div class="fontsize12px fontbold"><?php echo RECOMMEND_TITLE;?></div>
                    <div class="color666">
                        <?php echo $message_array['notice_title'];?><br>
                    </div>
                </div>
                
                <div class="lineheight20px margintop10px">
                	<table border="0" width="100%" class="uccoupon">
                      <tbody><tr>
                        <td colspan="4"><span class="fontbold fontsize12px"><?php echo LIST_TITLE;?></span></td>
                      </tr>
                      <tr>
                        <td align="center"><?php echo RECOMMEND_ONE;?></td>
                        <td align="center"><?php echo REWORD_POINT;?></td>
                        <td align="center"><?php echo REWORD_TIME;?></td>
                      </tr>
                      <?php if(count($rows)>0){?>
                      	<?php foreach($rows as $row){?>
                      <tr>
                        <td align="center"><?php echo $row['customers_email_address'];?></td>
                        <td align="center"><?php echo $row['reward_points'];?></td>
                        <td align="center"><?php echo $row['add_time'];?></td>
                      </tr>
                      <?php }
                      	}else{?>
                      	<tr><td colspan="3"><?php echo NOT_FOUND;?></td></tr>
                      	<?php }?>
                    </tbody></table>
                </div>
                
               <?php if(false){//链接推荐暂时去掉?> 
                <div class="ucpunkte lineheight20px margintop10px">
                    <p class="bgfffafa"><?php echo SHARE_TITLE;?></p>
                    <div class="padding10px">
                       <div><?php echo SHARE_COPY;?></div>
                       <div><span><input id="txturl" type="text" name="textfield" value="<?php echo $message_array['notice_link'].$_SESSION['customer_id'];?>" class="shareinput"></span><span class="paddingleft10px"><input type="submit" value="<?php echo BTN_SHARE;?>" onclick="copyLink()"></span></div>
                       
                    </div>
                </div>
               <?php }?> 
               
               <?php echo zen_draw_form('my_recommend', zen_href_link('my_recommend','ucenter=1'), 'post','onsubmit="return checkForm(this);"');?>
               <input type="hidden" name="action" value="process" />
               <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                <div class="ucpunkte lineheight20px margintop10px">
                    <p class="bgfffafa"><?php echo EMAIL_TITLE;?></p>
                    <div class="padding10px">
                    	<table border="0" width="100%" class="ucsharemail">
                          <tbody><tr>
                            <td colspan="2"><?php echo EMAIL_BOX_TITLE;?></td>
                          </tr>
                          <tr>
                            <td align="right" width="10%" valign="middle"><?php echo EMAIL;?></td>
                            <td><input type="text" id="email" name="email" class="shareinput"></td>
                          </tr>
                          <tr>
                            <td align="right" width="10%" valign="middle"><?php echo SUBJECT;?></td>
                            <td><input type="text" id="subject" name="subject" class="shareinput"></td>
                          </tr>
                          <tr>
                            <td align="right" width="10%" valign="middle"><?php echo CONTENT;?></td>
                            <td>
                            <textarea style="display:none;"  readonly="readOnly"  name="content"><?php echo $message_array['notice_email'];?></textarea>
                            <textarea id="content" disabled="disabled" readonly="readOnly" class="ucsharetextarea" name="content2"><?php echo $message_array['notice_email'];?></textarea></td>
                          </tr>
                          <tr>
                            <td width="10%">&nbsp;</td>
                            <td><input type="submit" value="<?php echo BTN_SUBMIT;?>"></td>
                          </tr>
                        </tbody></table>
                    </div>
                </div>
                </form>
            </div>
 </div>
</div>



<script language="javascript">
var size, types, n, pid, cpid, imgsize;
var product_display_url = '<?php echo zen_href_link("my_recommend", ""); ?>';

jQuery(function(){
	//ckeckcode();
	<?php if(isset($mail_recommend_success)){
	echo "alert('".EAMIL_RECOMMEND_SUCCESS."');";
	}?>
});
function checkForm(frm){
	var email=$.trim(frm.email.value);
	var subject = $.trim(frm.subject.value);
	if(email.length==0){
		alert("<?php echo PLEASE_INPUT_EMAIL;?>");
		frm.email.focus();
		return false;
	}
	if(email.indexOf('@')==-1){
		alert("<?php echo EMAIL_ERROR;?>");
		frm.email.focus();
		return false;
	}
	if(subject.length==0){
		alert("<?php echo PLEASE_INPUT_SUBJECT;?>");
		frm.subject.focus();
		return false;
	}
	return true;
	
}
function copyLink() {
    var obj = document.getElementById("txturl");
    obj.select();
    copyToClipBoard(obj.value);
    alert("<?php echo COPY_SUCCESSS;?>");
}

function copyToClipBoard(str) {
    var clipBoardContent = "";
    clipBoardContent += str; //document.getElementById("txturl").value;
    if (window.clipboardData) {
        window.clipboardData.clearData();
        window.clipboardData.setData("Text", clipBoardContent);
    } else if (navigator.userAgent.indexOf("Opera") != -1) {
        //window.location = clipBoardContent; 
    } else if (window.netscape) {
        try {
            netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
        } catch (e) {
            alert("<?php echo FIREFOX_COPY_TIP;?>");
        }
        var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
        if (!clip) return;
        var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
        if (!trans) return;
        trans.addDataFlavor('text/unicode');
        var str = new Object();
        var len = new Object();
        var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
        var copytext = clipBoardContent;
        str.data = copytext;
        trans.setTransferData("text/unicode", str, copytext.length * 2);
        var clipid = Components.interfaces.nsIClipboard;
        if (!clip) return false;
        clip.setData(trans, null, clipid.kGlobalClipboard);
    }
    return true;
}
function ckeckimg() {
    ckeckcode();
    if (types == 'custom') {
        customCode();
    }
}

function ckeckcode() {
    var sizeBar = document.getElementsByName('imgsiza');
    for (var i = 0; i < sizeBar.length; i++) {
        if (sizeBar[i].checked) {
            size = sizeBar[i].value; break;
        }
    }
    //var types;
    var typesBar = document.getElementsByName('rdlink');
    for (var i = 0; i < typesBar.length; i++) {
        if (typesBar[i].checked) {
            types = typesBar[i].value; break;
        }
    }
    if (types == 'custom') {
        document.getElementById('trnum').style.display = 'none';
        document.getElementById('trpid').style.display = '';
        pid = "&pid=" + document.getElementById('pids').value;
        document.getElementById("txtrec").value = "";
        document.getElementById('txtrec').style.display = "";
        n = 0;
        if (document.getElementById('pids').value != "") {
            customCode();
        }
    }
    else {

        pid = ""; cpid = "";
        recCode();
    }
}
function recCode() {
    var drp = document.getElementById('drprow');
    n = drp.options[drp.selectedIndex].value;
    var params = '&action=getCode&ucenter=1&ImgSize=' + size + '&type=' + types + '&sid=changanti&n=' + n ;
    var prev_url = product_display_url + '&roid=' + Math.random() + '&prev=1'+params;
    var user_url = product_display_url + params;
	var jscode = '\u003cscript type=\"text/javascript\"\u003edocument.write(\"\u003cscript type=\u0027text\\/javascript\u0027 src=\u0027'+
	user_url + '\u0027\u003e\u003c\\/script\u003e\");\u003c/script\u003e';
    /**/
    jQuery.get(prev_url,{},function(result){
		if(typeof result == 'object' && result.status){
           $('#friendPanel').html(result.content);
           $('#txtrec').val(jscode);
		}
	},'json');
	/***/
}


</script>