<?php
/**
 * Simple SEO URL
 * $Author: yellow1912 $
 * $Rev: 213 $
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */ 

require('includes/application_top.php');
require_once(DIR_WS_CLASSES.'module_installer.php');
require_once(DIR_WS_CLASSES.'ssu.php');
$module_installer = new module_installer();
$module_installer->set_module('yellow1912_ssu');
$module_installer->upgrade_module();

$yclass = new yclass();
$yclass->init_template();
$yclass->init_validation();

$ytemplate = new ytemplate();
$ytemplate->admin_set_base();
$ytemplate->build_name();
$ytemplate->zen_admin_set_path();

switch($_GET['action']){
	case 'reset_cache':
		$ytemplate->set('file_counter', SSUManager::resetCache($_GET['folder']));
		$ytemplate->set_name('tpl_reset_cache_folder.php');
	break;
	case 'link_aliases':
		SSUAlias::retrieveAliases();
		$ytemplate->set('link_aliases', retrieve_aliases());
	break;	
}
		
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/javascript/inlineeditor.js"></script>
<script type="text/javascript">
InlineEditor.cutomEditor = function( el )
{
return;
    if( el.tagName == 'CAPTION' || el.tagName == 'P' ){
    
        var ta = document.createElement( 'textarea' );
        ta.innerHTML = el.innerHTML;   
        ta.style.width  = "100%";
        ta.style.height = el.offsetHeight + "px";
        return ta;
        
    }   // end if: caption
    
}   // end cutomEditor 


InlineEditor.editorValue = function( editor )
{
return;
    // If it's a textarea we'd created, then there's
    // no 'value' property (on most browsers). Instead,
    // return innerHTML. Otherwise just return, and
    // InlineEditor will use its default behavior for 
    // everything else.
    if( editor.tagName == 'TEXTAREA' )
        return editor.innerHTML;
        
}   // end editorValue

InlineEditor.elementChanged = function( el, oldVal, newVal )
{
    mySavingIndicator( el );

    if (InlineEditor.checkClass( el, 'links' ))
    	action = 'links';
    else if (InlineEditor.checkClass( el, 'aliases' ))
    	action = 'aliases';
    // Perform save 
    
    xajax_ssu_update_input(el.title, newVal, action);
    clearMySavingIndicator( el ); 
    

}   // end elementChanged


/**
 * One way to indicate that the data is being saved.
 */
function mySavingIndicator( el )
{
    // Make some indication of saving the cell
    InlineEditor.addClass( el, 'uneditable' );
    InlineEditor.addClass( el, 'saving' );
    //el.title = "Saving your change...";

}   // end mySavingIndicator

/**
 * One way to clear indication of data being saved.
 */
function clearMySavingIndicator( el )
{
    InlineEditor.removeClass( el, 'uneditable' );
    InlineEditor.removeClass( el, 'saving' );
    //el.title = "";

}   // end clearMySavingIndicator
</script>
<script type="text/javascript">
  <!--
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  }
  // -->
</script>
<style type="text/css">
.linkAliases{border:1px solid;}
</style>
<!-- Styles used by InlineEditor -->

<style type="text/css">

 .editable    { background-color: #EFE; } /* green background  */

 .uneditable  { background-color: #FDD } /* red cell      */

 .editing     { background-color: #AFA } /* active edit   */

 .links, .aliases {float: left; width: 30%}
 
 .actions {float: left}
 
 .evenRow 	{ background-color: #ffaaee; }
 
 #message { color:red; font-weight:bold}
</style>




<!-- Styles you might want to use -->

<style type="text/css">

 .saving      { color: #999; } /* gray text */

</style>

<?php $xajax->printJavascript(); ?>
</head>
<body onLoad="init()">
<!-- header //-->
<div class="header_area">
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
</div>
<!-- header_eof //-->
<fieldset>
	<legend>Instruction</legend>
	SSU caches your categories/products names and links in order to reduce the number of sql queries and minimize the performance penalty on your server. That has its drawback, however. If you change your categories/products names, you will need to reset the cache to force SSU reload and update the names.
</fieldset>
<fieldset>
	<legend>Cache Functions</legend>
	Reset all cache: <a href="<?php echo zen_href_link(FILENAME_SSU,'action=reset_cache&folder=all'); ?>">Click here</a><br />
	Reset alias cache: <a href="<?php echo zen_href_link(FILENAME_SSU,'action=reset_cache&folder=aliases'); ?>">Click here</a><br />
	<?php foreach(SSUConfig::registry('plugins', 'parsers') as $parser) { ?>
	Reset only <?= $parser ?> cache: <a href="<?php echo zen_href_link(FILENAME_SSU,"action=reset_cache&folder=$parser"); ?>">Click here</a><br />
	<?php } ?>
</fieldset>
<fieldset>
	<legend>Alias Functions</legend>
	Manage Aliases: <a href="<?php echo zen_href_link(FILENAME_SSU,'action=link_aliases'); ?>">Click here</a><br />
</fieldset>
<?php $ytemplate->render(); ?>

<!-- footer //-->
<div class="footer-area">
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</div>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>