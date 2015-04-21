<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);
session_start();

require_once ('lib/mercadopago.php');
require_once ('lib/Google/autoload.php');

require_once ('domain/config.php');
require_once ('domain/user.php');
require_once ('domain/donaciones.php');


function renderPage($page){
	ob_start();
	include "includes/encabezado.php";
	include $page;
	include "includes/pie.php";
	
	ob_get_flush();
}

function loguear($content, $array = array(), $nombreDelArchivoDeLog = 'uqbar-payments.log'){
	$path = dirname(__FILE__);
	if($log = fopen("$path/../$nombreDelArchivoDeLog", "a")){

		$info = date("Y-m-d H:i:s");
		$info .= "\nIP:\t" . $_SERVER['REMOTE_ADDR'];
		$info .= "\nURL:\t" . $_SERVER['REDIRECT_URL'];
		$info .= "\nURL_QUERY:\t" . $_SERVER['REDIRECT_QUERY_STRING'];

		foreach($array as $line){
			$content .= "\n\t$line";
		}

		fwrite($log, "$info\n$content\n\n");
		fclose($log);
	}
}

function mostrarError(){
	ob_clean();
	renderPage("pages/error.php");
}