<?php
    // build to generate a random charcode
  function zen_random_charcode($length) {
	    $arraysize = 34; 
	    $chars = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9');
	
	    $code = '';
		for ($i = 1; $i <= $length; $i++) {
		$j = floor(zen_rand(0,$arraysize));
		$code .= $chars[$j];
		}
		return  $code;
 }
 
 function zen_display_vvcodes(){
   $visual_verify_code = zen_random_charcode(6);
   $_SESSION['vvcode'] = $visual_verify_code;
   return $visual_verify_code;
 }
 function zen_page_path_check($page,$pages_check){
     return in_array($page,$pages_check);
 }
 ////
  function zen_get_top_categories($categories_array = '', $parent_id = '0', $indent = '', $status_setting = '') {
    global $db;

    if (!is_array($categories_array)) $categories_array = array();

    // show based on status
    if ($status_setting != '') {
      $zc_status = " c.categories_status='" . (int)$status_setting . "' and ";
    } else {
      $zc_status = '';
    }

    $categories_query = "select c.categories_id, cd.categories_name, c.categories_status
                         from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                         where " . $zc_status . "
                         parent_id = '" . (int)$parent_id . "'
                         and c.categories_id = cd.categories_id
                         and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                         order by sort_order, cd.categories_name";

    $categories = $db->Execute($categories_query);

    while (!$categories->EOF) {
      $categories_array[] = array('id' => $categories->fields['categories_id'],
                                  'text' => $indent . $categories->fields['categories_name']);
      #############Begin:just limit for top category########
	  //modified by john 2010-08-18
      /*if ($categories->fields['categories_id'] != $parent_id) {
        $categories_array = zen_get_categories($categories_array, $categories->fields['categories_id'], $indent . '&nbsp;&nbsp;', '1');
      }*/
	  #############End:just limit for top category #########
      $categories->MoveNext();
    }

    return $categories_array;
  }
////
?>