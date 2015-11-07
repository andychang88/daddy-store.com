<input type="button" name="Add New Alias" value="Add New Alias" onclick="xajax_ssu_add_input();"/>
<div id="message"></div>

<div id="linkBox">
<div id="message"></div>
<?php if(is_array($link_aliases)) { ?>
	<div class="links" style="font-weight:bold;">Links</div><div class="aliases" style="font-weight:bold;">Aliases</div><div class="clearBoth"></div>
		<?php foreach ($link_aliases as $link_alias) {?>
		<div id="<?php echo $link_alias['id']; ?>">
			<div id="link_<?php echo $link_alias['id']; ?>" class="editable links" title="<?php echo $link_alias['id']; ?>"><?php echo $link_alias['link_url']; ?></div>
			<div id="alias_<?php echo $link_alias['id']; ?>" class="editable aliases" title="<?php echo $link_alias['id']; ?>"><?php echo $link_alias['link_alias']; ?></div>
			<div class="actions"><a href="#" onclick="xajax_ssu_update_status(<?php echo $link_alias['id']; ?>);"><?php echo zen_image(DIR_WS_ICONS . "ssu_status_{$link_alias['status']}.gif", 'Update Status') ;?></a><a href="#" onclick="xajax_ssu_delete(<?php echo $link_alias['id']; ?>);"><?php echo zen_image(DIR_WS_ICONS . 'ssu_delete.gif', 'delete') ;?></a></div>
			<div class="clearBoth"></div>
		</div>
	<?php } ?>
<?php } ?>
</div>