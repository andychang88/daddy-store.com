<?php

// the following IF statement can be duplicated/modified as needed to set additional flags
  if (in_array($current_page_base,explode(",",'list_pages_to_skip_all_right_sideboxes_on_here,separated_by_commas,and_no_spaces')) ) {
    $flag_disable_right = true;
  }

  $header_template = 'tpl_header.php';
  $footer_template = 'tpl_footer.php';
  $left_column_file = 'column_left.php';
  $right_column_file = 'column_right.php';
  $body_id = ($this_is_home_page) ? 'indexHome' : str_replace('_', '', $_GET['main_page']);
  

?>
<body>

<?php if( $_SERVER[HTTP_HOST] != 'local.daddy-store.com') {?>
  <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-46763281-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<?php }?> 

<?php
//网站头部
  $tpl_header = $flow_checkout ? 'tpl_header_checkout.php' : 'tpl_header.php';

  require($template->get_template_dir($tpl_header,DIR_WS_TEMPLATE, $current_page_base,'common'). '/'.$tpl_header);
  
  
  ?>
  
<div class="mainauto"><?php /*网站主体代码*/require($body_code);?> </div>  
 
<?php
	//网站底部的产品推荐
	if(zen_page_path_check($current_page_base,$p_recommend_content_chk)){
  		require($template->get_template_dir('tpl_modules_products_recommend.php',
                                       DIR_WS_TEMPLATE, 
							   $current_page_base,
							   'templates'). '/tpl_modules_products_recommend.php');
 	}
 	
 	//网站底部
 	require($template->get_template_dir('tpl_footer.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_footer.php');
  
?>


</body>