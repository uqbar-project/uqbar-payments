<?php
function infoBotonesDonaciones(){	
	$valores = array(50,100,150,200);
	$ret = array();

	if(!isLogged()){
		foreach($valores as $valor){
			$ret[$valor] = array();
			$ret[$valor]["url"] = "login.php";
			$ret[$valor]["texto"] = "Log in con Usuario de Google";
		}
		
		return $ret;
	}else{
		foreach($valores as $valor){
			$ret[$valor] = array();
			$ret[$valor]["url"] = "donar.php?valor=$valor";
			$ret[$valor]["texto"] = "Donar";
		}
		
		return $ret;
	}
}

function doDonar($valor){
	$mp = new MP(MP_CLIENT, MP_SECRET);
	
	$datetime = new DateTime('tomorrow');
	$today = $datetime->format("Y-m-d\TH:i:s.000P");
	
	$preapproval_data= array(
			"back_url" => BACK_URL,
			"reason" => "Donación Mensual $ $valor a Uqbar Project",
			"external_reference" => "MEN-$valor",
			"payer_email" => email(),
			"auto_recurring" => array(
					"frequency" => 1,
					"frequency_type" => "months",
					"transaction_amount" => $valor,
					"currency_id" => "ARS",
					"start_date" => $today
			)
	);
	$resp = $mp->create_preapproval_payment ($preapproval_data);
	$resp2 = $resp['response'];
	$redirect = $resp2['init_point'];
	header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

function renderBotonesDonaciones(){
	$r = "";
	$pagos = infoBotonesDonaciones();
	
	foreach($pagos as $valor => $obj){
		$r .=
				"<div class='col-md-3'>
					<h2>$ $valor</h2>
					<p>
						<a class='btn btn-primary' href='".$obj['url']."'
						 role='button'>".$obj['texto']."</a>
					</p>
				</div>";
	}
	return $r;
}