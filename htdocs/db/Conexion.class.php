<?php

class Conexion {
	static private $instancia;

	public $conn;
	var $usuario;
	var $clave;
	var $servidor;
	var $puerto;
	var $db;
	private $errores = array();

	private function __construct() {
		$this->servidor = SERVIDOR;
		$this->puerto = PUERTO;
		$this->usuario = USUARIO;
		$this->clave = CLAVE;
		$this->db = DB;
	}

	public function abrir() {
		if ($this->estaAbierta()) return;
		if (!$this->conn = @mysql_pconnect($this->servidor.':'.$this->puerto, $this->usuario, $this->clave)){
			throw new ConexionException(mysql_error());
		}
		// Hack para solucionar el problema del Warning:  mysql_pconnect(): MySQL server has gone away
		if (!mysql_ping( $this->conn ) ) {
			if (!$this->conn = mysql_pconnect($this->servidor.':'.$this->puerto, $this->usuario, $this->clave)){
			throw new ConexionException(mysql_error());
			}
		}
		if (!mysql_select_db($this->db)){
			throw new ConexionException(mysql_error());
		}
		if (!mysql_query("BEGIN", $this->conn)){
			throw new ConexionException(mysql_error());
		}
		mysql_set_charset('utf8',$this->conn);
	}

	public function estaAbierta() {
		return isset($this->conn);
	}

	public function newTransaction(){
		if ($this->estaAbierta()){
			$this->endTransaction();
			if (!mysql_query("BEGIN", $this->conn)){
				throw new ConexionException(mysql_error());
			}
		} else {
			$this->abrir();
		}
	}

	public function consultar($sql, $coleccion=true) {
		if (!($this->estaAbierta())) {
			$this->abrir();
		}
		
		if(!$resultado = mysql_query($sql , $this->conn)){
			throw new ConexionException($sql . mysql_error());
		}

		if ($coleccion) return new Coleccion($resultado);
		if (!$coleccion) return $resultado; 

	}

	public function ejecutar($sql) {
		if (!($this->estaAbierta())) {
			$this->abrir();
		}
		
		if (!$resultado = mysql_query(str_replace("NULL@MySQL", "null", $sql), $this->conn)) {
			$error = mysql_error();
			echo $error;
			$this->errores[] = $error . "\n" . $sql;
		 	throw new ConexionException($sql . " " . $error);
		}
		return;
	}


	public function __destruct() {
		$this->endTransaction();
		mysql_close($this->conn);
	}

	public function endTransaction(){
		if(count($this->errores)){
			mysql_query("ROLLBACK", $this->conn);
			loguear("ERRORES DE MYSQL:" , $this->errores);
			$this->errores = array();
		} else {
			mysql_query("COMMIT", $this->conn);
		}
	}

	static public function funcionNow () {
		return ' now() ';
	}
	static public function conexion() {
		if (self :: $instancia == NULL) {
			self :: $instancia = new Conexion();
		}
		return self :: $instancia;
	}

	public function ultimoIDInsertado(){
		return mysql_insert_id($this->conn);
	}

	public function guardarArray ($tabla, $array, $idTag) {
		if(empty($array[$idTag])){
			unset($array[$idTag]);
			$this->insertarArray($tabla,$array);
			$sarasa = $this->ultimoIDInsertado();
			$array[$idTag] = $sarasa;
		}
		else {
			$this->actualizarArray($tabla,$array,$idTag);
		}
		return $array;
	}

	private function insertarArray ($tabla, $array){
		$insert = " INSERT INTO " . $tabla . " ";
		$campos = "(";
		$valores = "(";
		foreach($array as $campo => $valor) {
			if(isset($valor)){
				$campos .= $campo . ",";
					if (((string) $valor) == MYSQL_NULL){
						$valores .= "null,";
					} else {
						$valores .= "\"". str_replace('"', '\'', $valor) ."\",";
					}
			}
		}
		$campos = substr($campos, 0, -1) . ")";
		$valores = substr($valores, 0, -1) . ")";
		$query =  $insert . $campos . " VALUES " . $valores;
		/*echo $query . br();
		exit;*/
		$this->ejecutar($query);
	}

	private function actualizarArray ($tabla, $array, $idTag){
		$sets = "";
		foreach($array as $campo => $valor) {
			/*if ($campo != $idTag && !empty($valor) || $valor == '0') {
				$sets .= $campo . " = '" . $valor ."',";
			}*/
			if(isset($valor)){
				if ($campo != $idTag) {
					if (((string) $valor) == MYSQL_NULL){
						$sets .= $campo . " = null,";
					} else {
						$sets .= $campo . " = \"". str_replace("\"", "'", $valor) ."\",";
					}
				}
			}
		}
		$sets = substr($sets, 0, -1);
		$this->ejecutar (" UPDATE " . $tabla . " SET " . $sets . " WHERE " . $idTag . " = " .$array[$idTag]);
	}

	public function encontrarUnResultado ($sql){
		$resultados = $this->consultar($sql);
		$resultados = $resultados->toArray();
		if(!is_array($resultados)){
			throw new SinResultadosException('');
		}
		if(count($resultados) == 0){
			throw new SinResultadosException('');
		}

		return $resultados[0];
	}
	
	public function escape($unescaped){
		if (!($this->estaAbierta())) {
			$this->abrir();
		}
		
		return mysql_real_escape_string($unescaped, $this->conn);
	} 
}


class Coleccion {
	var $sqlResult;
	var $siguiente;
	var $fila;
	function __construct($resultado) {
		unset ($this->siguiente);
		$this->sqlResult = $resultado;
		$this->siguiente = mysql_fetch_assoc($this->sqlResult);
		$this->fila = 1;
	}

	public function __destruct(){
		$this->liberar();
	}

	function tieneSiguiente() {
		if (!$this->siguiente) return false;
		return true;
	}

	function dameElSiguiente() {
		if (!$this->tieneSiguiente()){
			throw new ConexionException('No tiene más elementos');
		}
		$retorno = $this->siguiente;
		$this->siguiente = mysql_fetch_array($this->sqlResult);
		$this->fila++;
		return $retorno;
	}

	function liberar() {
		if(isset($this->sqlResult)) {
			mysql_free_result($this->sqlResult);
			unset($this->sqlResult);
		}
	}
	function rewind(){
		$this->fila = 1;
		@mysql_data_seek($this->sqlResult,1);
	}
	function goToRow($numero){
		$this->fila = $numero;
		@mysql_data_seek($this->sqlResult,$numero);
	}
	function toArray() {
		$array = array();
		$filaActual = $this->fila;
		$this->rewind();
		while ($this->tieneSiguiente()){
			array_push($array,$this->dameElSiguiente());
		}
		$this->goToRow($filaActual);
		return $array;
	}
	
}
?>
