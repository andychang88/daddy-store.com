<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account_password.<br />
 * Allows customer to change their password
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_account_password_default.php 2896 2006-01-26 19:10:56Z birdbrain $
 */
?>
<div class="ucright">
<div class="ucpwd">
            <h2><?php echo HEADING_TITLE;?></h2>
            <div class="margintop10px">
            	<ul class="ucmsg">
                	<li class="width_51 fontbold"><?php echo SUBJECT;?></li>
                    <li class="width_13 fontbold aligncenter"><?php echo SENDER;?></li>
                    <li class="width_13 fontbold aligncenter"><?php echo ACTION;?></li>
                </ul>
                <?php if(count($result_arr)>0){
                		foreach ($result_arr as $message) {
                ?>
                <ul message_id='<?php echo $message["message_id"];?>' class="ucmsg message"> 
                    <li class="width_51"><span class="ucmsgtit <?php if(!$message["is_readed"]) echo 'fontbold'?>" id="ucmsgtit">
                    <?php 
                    echo $message["subject"];
                    ?>
                    </span></li>
                    <li class="width_13 aligncenter">System Message</li>
                    <li class="width_13 aligncenter"><?php echo ACTION_VIEW;?></li>
                </ul>
                <div style="display: none;"  class="ucmsgcont"><p class="padding5px bgf1f1f1"><?php echo $message["content"];?></p></div>
                <?php }
                 }else{?>
                 <div style="text-align:center;padding-top:10px;"><?php echo NOT_FOUND;?></div>
                 <?php }?>
            </div>
<?php if( $page_split->number_of_pages>0){?>
<br><div class="navSplitPagesLinks forward"><?php echo $page_split->display_links(10, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?></div>
<?php }?>

 </div>
 </div>
<script language="javascript">
function resetAll(obj){
	$('ul.message').each(function(){
		if(this!=obj){
			$(this).next('div').hide();
			$(this).removeClass('ucmsg2');
		}
		
	})
}
var Cache={};
function addReadHistory(message_id){
	if(Cache[message_id] || !message_id || message_id.length==0) return;
	jQuery.get('<?php echo zen_href_link('my_system_message','ucenter=1');?>',{message_id:message_id,action:'add_history'},function(result){
		Cache[message_id] = 1;
	},'json');
}
jQuery(function(){
	
	$('ul.message').each(function(){
        $(this).click(function(){
        	resetAll(this);
           var div = $(this).next('div');
           if(div.is(':visible')){
        	   div.hide();
        	   $(this).removeClass('ucmsg2');
           }else{
        	   div.show();
        	   $(this).addClass('ucmsg2');
        	   if($(this).find('span:first').hasClass('fontbold')){
				addReadHistory($(this).attr('message_id'));
        	   }
           }
        });
	});
})
</script>



