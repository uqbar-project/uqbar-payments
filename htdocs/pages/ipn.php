<?php
turnNotRender();

try{
	$mp = new MP(MP_CLIENT, MP_SECRET);
	
	$params = array("access_token" => $mp->get_access_token());
	$topic = $_REQUEST['topic'];
	$idOp = $_REQUEST['id'];

	if($topic == "payment"){
		$url = "/collections/notifications/$idOp";
	}else{
		$url = "/$topic/$idOp";
	}
	
	
	$resp = $mp->get($url, $params);
	
	$data = array();
	$data["topic"] = $topic;
	$data["idOperation"] = $idOp;
	$data["responseCode"] = $resp['status'];
	$data["responseJSON"] = json_encode($resp['response']);

	$r2 = $resp['response'];
	$col = $r2['collection'];
	$ref = $col['external_reference'];
	$estado = $col['status'];

	
	Conexion::conexion()->guardarArray("ipn_notifications", $data, "idIPNNotification");
	Conexion::conexion()->newTransaction();
	Conexion::conexion()->ejecutar("UPDATE remeras SET estado = '$estado', modificado = CURRENT_TIMESTAMP WHERE idRemera = '$ref'");
}catch(Exception $e){
	echo $e->getMessage();
	loguear(E_WARNING, $e->getMessage() . ":" . $e->getTraceAsString());
	header("HTTP/1.0 500 Internal server error");
}