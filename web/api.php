<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/core/includes.php");

if(isset($_REQUEST["comando"])){
	$comando = $_REQUEST["comando"];
	$file = getRuta($comando);
	if(file_exists($file)){
		$_SERVER['REQUEST_URI'] = "/" . $_REQUEST["pagina"];
		require_once($file);
		die();
	}else{
		error(500,"No se encuentra el archivo '$file' del comando '$comando'");
	}
	
	
}else{
	error(400,"No se ha especificado el comando");
}

function getRuta($comando){
	$ruta = dbQuery("SELECT ruta FROM api.apis WHERE nombre=?;", array($comando));
	if(isset($ruta) && isset($ruta[0]) && isset($ruta[0]["ruta"]) && $ruta[0]["ruta"] != null){
		return $ruta[0]["ruta"];
	}else{
		error(404,"No se encuentra el comando '$comando'");
	}
}
?>