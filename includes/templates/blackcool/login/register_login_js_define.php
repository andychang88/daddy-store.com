<?php

function yihaochuli($str){
	$str = str_replace("'","\'",$str);
	$str = str_replace('"','\"',$str);
	return $str;
}
    $js_define = "
        var POP_OK_IMG = \"".yihaochuli(POP_OK_IMG)."\";        
        var POP_ERROR_IMG = \"".yihaochuli(POP_ERROR_IMG)."\";
        var POP_LOADING_IMG = \"".yihaochuli(POP_LOADING_IMG)."\";

        var POP_TEXT_JS_TIP_EMAIL_REQUIRED=POP_ERROR_IMG+\"".yihaochuli(POP_TEXT_JS_TIP_EMAIL_REQUIRED)."\";
        var POP_TEXT_JS_TIP_EMAIL_FORMAT =POP_ERROR_IMG+ \"".yihaochuli(POP_TEXT_JS_TIP_EMAIL_FORMAT)."\";
        var POP_TEXT_JS_TIP_EMAIL_ALREADY_EXITS = POP_ERROR_IMG+\"".yihaochuli(POP_TEXT_JS_TIP_EMAIL_ALREADY_EXITS)."\";
        
        var POP_TEXT_JS_TIP_PASSWORD_REQUIRED =POP_ERROR_IMG+ \"".yihaochuli(POP_TEXT_JS_TIP_PASSWORD_REQUIRED)."\";
        var POP_TEXT_JS_TIP_PASSWORD_LENGTH = POP_ERROR_IMG+\"".yihaochuli(POP_TEXT_JS_TIP_PASSWORD_LENGTH)."\";
            
        var POP_TEXT_JS_TIP_PASSWORD2_REQUIRED = POP_ERROR_IMG+\"".yihaochuli(POP_TEXT_JS_TIP_PASSWORD2_REQUIRED)."\";
        var POP_TEXT_JS_TIP_PASSWORD_MATCH = POP_ERROR_IMG+\"".yihaochuli(POP_TEXT_JS_TIP_PASSWORD_MATCH)."\";
            
        	var POP_ENTRY_FIRST_NAME_ERROR = \"".yihaochuli(POP_ENTRY_FIRST_NAME_ERROR)."\";
            
        var POP_ENTRY_LAST_NAME_ERROR = POP_ERROR_IMG+\"".yihaochuli(POP_ENTRY_LAST_NAME_ERROR)."\";
            
        var POP_ENTRY_TELEPHONE_NUMBER_ERROR = POP_ERROR_IMG+\"".yihaochuli(POP_ENTRY_TELEPHONE_NUMBER_ERROR)."\";
        var POP_ENTRY_TELEPHONE_NUMBER_EFFECTIVENESS = POP_ERROR_IMG+\"".yihaochuli(POP_ENTRY_TELEPHONE_NUMBER_EFFECTIVENESS)."\";
            
        var POP_ENTRY_STREET_ADDRESS_ERROR = POP_ERROR_IMG+\"".yihaochuli(POP_ENTRY_STREET_ADDRESS_ERROR)."\";
            
	        var POP_ENTRY_POST_CODE_ERROR = \"".yihaochuli(POP_ENTRY_POST_CODE_ERROR)."\";
	        var POP_ENTRY_POST_CODE_EFFECTIVENESS = \"".yihaochuli(POP_ENTRY_POST_CODE_EFFECTIVENESS)."\";
            
        var POP_ENTRY_CITY_ERROR = POP_ERROR_IMG+\"".yihaochuli(POP_ENTRY_CITY_ERROR)."\";
            
        var POP_ENTRY_COUNTRY_ERROR = POP_ERROR_IMG+\"".yihaochuli(POP_ENTRY_COUNTRY_ERROR)."\";
            
        var POP_RECOGNIZED_AGREEMENT_ERROR = \"<img src=\'includes/templates/blackcool/images/error_img.gif\' style=\'margin-left: 15px;\' />".yihaochuli(POP_RECOGNIZED_AGREEMENT_ERROR)."\";
            
        var POP_ENTRY_DIAHAO_ERROR = \"".yihaochuli(POP_ENTRY_DIAHAO_ERROR)."\";            
        var POP_ENTRY_DIAHAO_NO_NUMBER_ERROR = \"".yihaochuli(POP_ENTRY_DIAHAO_NO_NUMBER_ERROR)."\";
            
        var TEXT_JS_TIP_LOGIN_EMAIL_REQUIRED = \"".yihaochuli(TEXT_JS_TIP_LOGIN_EMAIL_REQUIRED)."\";
        var TEXT_JS_TIP_LOGIN_EMAIL_FORMAT = \"".yihaochuli(TEXT_JS_TIP_LOGIN_EMAIL_FORMAT)."\";
            
        var TEXT_JS_TIP_PASSWORD_REQUIRED = \"".yihaochuli(TEXT_JS_TIP_PASSWORD_REQUIRED)."\";
        var TEXT_JS_TIP_PASSWORD_LENGTH = \"".yihaochuli(TEXT_JS_TIP_PASSWORD_LENGTH)."\";
            
        var POP_TEXT_CHECKOUT_R_TITLE = \"".yihaochuli(POP_TEXT_CHECKOUT_R_TITLE)."\";
        var POP_TEXT_REGISTER_TO_LOGIN = \"".yihaochuli(POP_TEXT_REGISTER_TO_LOGIN)."\";
        var POP_TEXT_CHECKOUT_L_TITLE = \"".yihaochuli(POP_TEXT_CHECKOUT_L_TITLE)."\";
            
    ";
?>