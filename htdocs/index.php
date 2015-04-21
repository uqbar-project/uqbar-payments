<?php
require_once 'includes/util.php';

//error handler function
function default_error_handler($errno = E_USER_ERROR, $errstr = '', $err_file = '', $err_line = ''){
	loguear("Unexpected Error: $errstr $err_file $err_line ");
	mostrarError();
}
function shutdown_handler(){
	$error = error_get_last();
	
	if($error !== NULL && $error['type'] == E_ERROR){
		loguear('Unexpected Error: ' . $error['message']);
		mostrarError();
	}
}

session_cache_limiter('private, must-revalidate');

//set error handler
set_error_handler("default_error_handler", E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);
register_shutdown_function("shutdown_handler");

try{	
	if(!isset($_SERVER['REDIRECT_URL']) || $_SERVER['REDIRECT_URL'] == ''){
		$redirect = "/index.php";
	} else {
		$redirect = $_SERVER['REDIRECT_URL'];
	}
	preg_match("/^(.*\/.*\.php)$/", $redirect, $parts);
	
	var_dump($redirect);
	
	renderPage("pages$parts[0]");
} catch (Exception $e) {
	default_error_handler(E_WARNING, $e->getMessage());
}

?>