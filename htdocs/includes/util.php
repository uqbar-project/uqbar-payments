<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);
session_start();

require_once ('lib/mercadopago.php');
require_once ('lib/Google/autoload.php');

require_once ('domain/config.php');
require_once ('domain/user.php');
require_once ('domain/donaciones.php');
