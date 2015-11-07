<?php
	function ssu_add_input(){
		global $db;
		$oResponse = new xajaxResponse();
		
		$sql_query = "INSERT IGNORE INTO ".TABLE_LINKS_ALIASES." (link_url, link_alias) VALUES('/default_link/','/default_alias/')";
		$db->Execute($sql_query);
		$id = $db->insert_ID();
		if($id !== 0){
			$oResponse->prepend('linkBox', 'innerHTML' , "
				<div id='link_$id' name='$id' class='editable links'>default_link</div>
				<div id='alias_$id' name='$id' class='editable aliases'>default_alias</div>
				<br class='clearBoth'/>");
			$oResponse->script('location.reload(true)');
			$oResponse->assign('message', 'innerHTML', "New record added");
		}
		else
			$oResponse->assign('message', 'innerHTML', "No new record added!");
		return $oResponse;
	}
	
	function ssu_update_input($id, $value, $action){
		global $db;
		$error = "";
		$oResponse = new xajaxResponse();
		if($action == "links"){
			$field = "link_url";
			$prefix = "link_";
		}
		elseif($action == "aliases"){
			$field = "link_alias";
			$prefix = "alias_";
		}
		else
			$error .= "Wrong action selected: $action";
		
		if(!is_numeric($id))
			$error .= "ID is not int: $id";
		
		$value = ssu_parse_name($value);
		if(empty($value))
			$error .= "New value is empty";

		if(empty($error)){
			if((int)$id > 0){
				$sql_query = "UPDATE ".TABLE_LINKS_ALIASES." SET $field='$value' WHERE id='$id'";
				$db->Execute($sql_query);
				if(mysql_affected_rows($db->link) <= 0)
					$error .= "Failed to update database";
			}
		}
		if(!empty($error))
			$oResponse->assign('message', 'innerHTML', $error);
		else {
			$oResponse->assign('message', 'innerHTML', 'Record updated');
			$oResponse->assign($prefix.$id, 'innerHTML', $value);
		}
		return $oResponse;
	}
	
	function ssu_delete($id){
		$oResponse = new xajaxResponse();
		global $db;
		$db->Execute('DELETE FROM '.TABLE_LINKS_ALIASES.' WHERE id=\''.$id.'\' LIMIT 1');
		if(mysql_affected_rows() != 1)
			$oResponse->assign('message', 'innerHTML', "Failed to remove alias id $id");
		else {
			$oResponse->assign('message', 'innerHTML', 'Record removed');
			$oResponse->assign($id, 'innerHTML', '');
		}
		return $oResponse;
	}
	
	function ssu_update_status($id){
		$oResponse = new xajaxResponse();
		global $db;
		$db->Execute('UPDATE '.TABLE_LINKS_ALIASES.' SET status=-status+1 WHERE id=\''.$id.'\' LIMIT 1');
		if(mysql_affected_rows() != 1)
			$oResponse->assign('message', 'innerHTML', "Failed to update alias id $id");
		else {
			$oResponse->script('location.reload(true)');
			$oResponse->assign('message', 'innerHTML', 'Record status update');
			$oResponse->assign($id, 'innerHTML', '');
		}
		return $oResponse;
	}
	
	function ssu_parse_name($name){
		$name = trim($name, ' /');
		$name = "/$name/";
		return $name;
	}
	
	function retrieve_aliases(){
		global $db;
		$aliases = $db->Execute('SELECT * FROM '.TABLE_LINKS_ALIASES);	
		$result = array();
		while(!$aliases->EOF){
			$temp_array = array();
			foreach($aliases->fields as $key => $value)
				$temp_array[$key] = $value;
			$result[] = $temp_array;
			$aliases->MoveNext();
		}
		return $result;				
	}