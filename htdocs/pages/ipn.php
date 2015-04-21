<?php
turnNotRender();

try{
	$mp = new MP(MP_CLIENT, MP_SECRET);
	
	$params = ["access_token" => $mp->get_access_token()];
	$topic = $_REQUEST['topic'];
	$idOp = $_REQUEST['id'];

	$resp = $mp->get("/$topic/$id", $params);
	
	$data = array();
	$data["topic"] = $topic;
	$data["idOperation"] = $idOp;
	$data["responseCode"] = $resp['status'];
	$data["responseJSON"] = json_encode($resp['response']);

	Conexion::conexion()->guardarArray("ipn_notifications", $data, "idIPNNotification");
}catch(Exception $e){
	echo $e->getMessage();
	loguear(E_WARNING, $e->getMessage() . ":" . $e->getTraceAsString());
	http_response_code(500);
}