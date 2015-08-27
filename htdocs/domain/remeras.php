<?php

function procesarCompraRemeras(){
	$cant = filter_input(INPUT_POST, "cant", FILTER_VALIDATE_INT);
	$valor = filter_input(INPUT_POST, "valor", FILTER_VALIDATE_INT);
	$talle = filter_input(INPUT_POST, "talle", FILTER_SANITIZE_STRING);
	
	$validos = array('S','M','L','XL','XXL');
	
	if(!in_array($talle, $validos) || $cant == 0 || $valor < 80 ){
		print("<br/><br/><br/><br/><br/><br/>");
		print("Valores inválidos!!!");
		var_dump($cant);
		var_dump($valor);
		var_dump($talle);
		exit;
	}
	
	$mp = new MP(MP_CLIENT, MP_SECRET);

	$data = array();
	$data["email"] = email();
	$data["cantidad"] = $cant;
	$data["talle"] = $talle;
	$data["valor"] = $valor;
	$data["estado"] = "NUEVO";
	
	Conexion::conexion()->guardarArray("remeras", $data, "idRemera");
	$refId = Conexion::conexion()->ultimoIDInsertado();
	
	$preapproval_data= array(
			"back_url" => BACK_URL,
			"reason" => "Compra de la Remera de Uqbar WISIT por $ $valor",
			"external_reference" => $refId,
			"payer" => array(
						"email"=> email()
					),
			"items" => array(
					array(
							"title" => "Remera de Uqbar WISIT por $ $valor",
							"currency_id" => "ARS",
							"category_id" => "Remeras Uqbar",
							"quantity" => $cant,
							"unit_price" => $valor
					)
				)			
	);
	
	$resp = $mp->create_preference($preapproval_data);
	$resp2 = $resp['response'];
	$redirect = $resp2['init_point'];
	header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}