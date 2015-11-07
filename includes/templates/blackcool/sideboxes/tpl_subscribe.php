<div class="newsletter_2">
<h6><?php echo BOX_HEADING_NEWSLETTER;?></h6>
<ul>
<li><p><?php echo BOX_HEADING_NEWSLETTER_DESC;?></p></li>
<?php
   echo zen_draw_form('subscribe', zen_href_link(FILENAME_SUBSCRIBE, '', 'SSL'),'post',' id="nl_subscribe_form"');
   echo zen_draw_hidden_field('act', 'subscribe');
   echo zen_draw_hidden_field('main_page',FILENAME_SUBSCRIBE);
   if(EMAIL_USE_HTML == 'true') {
     echo zen_draw_hidden_field('email_format','HTML');
   }else{
     echo zen_draw_hidden_field('email_format','TEXT');
   }   
   
   echo '<li style="float:right">'.zen_image_submit(BUTTON_IMAGE_SUBSCRIBE,HEADER_SUBSCRIBE_BUTTON,' value="'.HEADER_SUBSCRIBE_BUTTON .'" class="align_middle" ').'</li>';

   echo '<li>'.zen_draw_input_field('email', '', ' size="20" maxlength="50" class="a_input" id="email" ').'</li>';
   
?>
</form>
</div>              