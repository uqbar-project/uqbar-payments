<?php
function infoBotonesDonaciones(){	
	$valores = array(50,100,150,200);
	$ret = array();

//	if(!isLogged()){
		foreach($valores as $valor){
			$ret[$valor] = array();
			$ret[$valor]["url"] = "login.php";
			$ret[$valor]["texto"] = "Log in con Usuario de Google";
		}
		
		return $ret;
//	}
	
	$mp = new MP(MP_CLIENT, MP_SECRET);
	
	
	$datetime = new DateTime('tomorrow');
	$today = $datetime->format("Y-m-d\TH:i:s.000P");
	
	
	foreach($valores as $valor){
		$preapproval_data= array(
				"back_url" => BACK_URL,
				"reason" => "Donación Mensual $ $valor a Uqbar Project",
				"external_reference" => "MEN-$valor",
				"payer_email" => "ptesone@uno.edu.ar",
				"auto_recurring" => array(
						"frequency" => 1,
						"frequency_type" => "months",
						"transaction_amount" => $valor,
						"currency_id" => "ARS",
						"start_date" => $today
				)
		);
	
		$ret[$valor] = array();
		$ret[$valor]["obj"] = $mp->create_preapproval_payment ($preapproval_data);
		$ret[$valor]["url"] = $ret[$valor]["obj"]['response']['init_point'];
		$ret[$valor]["texto"] = "Donar";
	}
	
	return $ret;
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