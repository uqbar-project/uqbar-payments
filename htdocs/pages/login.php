<?php 
	global $client; 
	$redirect = 'http://' . $_SERVER['HTTP_HOST'];
	if(isset($_SESSION['login_backUrl'])){
		$redirect .= "/" . $_SESSION['login_backUrl'];
	}
	
	
	if(isset($_REQUEST['salir'])){
		logout();
		header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
		exit();
	}
	
	if (isset($_GET['code'])) {
		authenticate();
		header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
	}
	
	if(!isLogged()){
		$authUrl = $client->createAuthUrl();
		header('Location: ' . $authUrl);
	}
?>