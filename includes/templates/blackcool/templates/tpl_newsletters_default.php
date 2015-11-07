<?php
   echo zen_draw_form('sign',zen_href_link(FILENAME_NEWSLETTERS,'action=process','NONSSL'));
   echo zen_draw_input_field('email', zen_db_input($_POST['email']));
   echo zen_draw_input_field('vvcode', '', 'size="6" maxlength="6"', 'text', false);
   echo zen_draw_radio_field('check', 'inp');
   echo zen_draw_radio_field('check', 'del');
   echo zen_image_submit('button_send.gif', IMAGE_BUTTON_LOGIN);
?>
</form>