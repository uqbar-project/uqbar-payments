<?php

checkLogin();

function isLogged(){
	return isset($_SESSION['access_token']) && $_SESSION['access_token'];
}

function checkLogin(){
	global $token_data;
	global $client;
	global $plus;

	$client = new Google_Client();
	$client->setClientId(GOOGLE_ID);
	$client->setClientSecret(GOOGLE_SECRET);
	$client->setRedirectUri(GOOGLE_REDIRECT);
	$client->setScopes('email profile');
	
	$plus = new Google_Service_Plus($client);
	
	if(isLogged()){
		$client->setAccessToken($_SESSION['access_token']);
		try{
			$token_data = $client->verifyIdToken()->getAttributes();

			$email = email();
			
			$email = str_replace("@", "@", $email);
			
			$q = "SELECT * from google_user WHERE email = '$email'";
			$result = Conexion::conexion()->consultar($q);
			
			if(!$result->tieneSiguiente()){
				$gUser = array();
			}else{
				$gUser = $result->dameElSiguiente();
				
			}
			$gUser["email"] = $email;
			$gUser["displayName"] = displayName();
			$gUser["userInfo"] = json_encode(userInfo());
			
			Conexion::conexion()->guardarArray("google_user", $gUser, "idGoogleUser");
			$result->liberar();
			
		}catch(Google_Auth_Exception $e){
			logout();
		}
	}
}

function authenticate(){
	global $client;
	$client->authenticate($_GET['code']);
	$_SESSION['access_token'] = $client->getAccessToken();
}

function logout(){
	unset($_SESSION['access_token']);
}

function userInfo(){
	global $plus;
	global $me;
	
	if(!$me)
		$me = $plus->people->get('me');
		
	return $me;
}

function displayName(){
	$u = userInfo();
	return $u['displayName'];
} 

function email(){
	global $token_data;
	return $token_data['payload']['email'];
}