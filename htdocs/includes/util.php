<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);
session_start();

class ConexionException extends Exception{}

class SinResultadosException extends ConexionException {}


define ('MYSQL_NULL', 'NULL@MySQL');

require_once ("db/Conexion.class.php");

require_once ('lib/mercadopago.php');
require_once ('lib/Google/autoload.php');

require_once ('domain/config.php');
require_once ('domain/user.php');
require_once ('domain/donaciones.php');
require_once ('domain/remeras.php');

$render = true;

function turnNotRender(){
	global $render;
	$render = false;
}


function renderPage($page){
	global $render;
	
	ob_start();
	include "includes/encabezado.php";
	include $page;
	include "includes/pie.php";
	
	$content = ob_get_clean();
	
	if($render)
		echo $content;
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
	global $render;
	
	$render = true;
	ob_clean();
	renderPage("pages/error.php");
}