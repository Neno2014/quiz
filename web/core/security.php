<?php

if (isset($_COOKIE["quiz_session"])){
	iniciarSesion($_COOKIE["quiz_session"]);
}

function iniciarSesion($idSesion){
	$resultado = dbQuery("select api.session_start(?);", array($idSesion));
	if(isset($resultado[0])){
		$datos = json_decode($resultado[0]["session_start"],true);
		if(isset($datos["id"])){
			$GLOBALS["sesion"] = array(
				"usuario" => $datos
			);
			return $datos;
		}else{
			return false;
		}
	}
}

function cerrarSesion(){
	dbQuery("select api.session_close();", array());
	unset($GLOBALS["sesion"]);
	unset($_COOKIE['quiz_session']);
	setcookie('quiz_session', null, -1, '/');
}

function login($email, $password){
	cerrarSesion();
	$resultado = dbQuery("select api.login(?,?);", array($email, $password));
	if(isset($resultado[0])){
		$datos = json_decode($resultado[0]["login"],true);
		if(isset($datos["id_sesion"])){
			setcookie("quiz_session", $datos["id_sesion"], time() + (10 * 365 * 24 * 60 * 60), "/");
			return iniciarSesion($datos["id_sesion"]);
		}else{
			return $datos;
		}
	}
	return false;
}


?>