<?php 
	global $client; 
	
	if(isset($_REQUEST['salir'])){
		logout();
		$redirect = 'http://' . $_SERVER['HTTP_HOST'];
		header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
		exit();
	}
	
	if (isset($_GET['code'])) {
		authenticate();
		$redirect = 'http://' . $_SERVER['HTTP_HOST'];
		header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
	}
	
	if(!isLogged()){
		$authUrl = $client->createAuthUrl();
		header('Location: ' . $authUrl);
	}
?>