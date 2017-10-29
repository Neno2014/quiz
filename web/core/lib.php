<?php

function error($num, $mensaje){
	$msgCorto = "Unknown";
	if($num==404){
		$msgCorto = "Not found";
	}else if($num==401){
		$msgCorto = "Unauthorized";
	}else if($num==400){
		$msgCorto = "Bad request";
	}
	header($_SERVER["SERVER_PROTOCOL"]." $num $msgCorto", true, $num);
	echo $mensaje;
	die();
}

function loadPagina($ruta){
	if(isset($_REQUEST["paginas_cargadas_peticion"])
		&& isset($_REQUEST["paginas_cargadas_peticion"][$ruta]) 
		&& $_REQUEST["paginas_cargadas_peticion"][$ruta]==1){
		//error(500, "Hay un ciclo '".$ruta." '.");
		//return "";
	}
	$_REQUEST["paginas_cargadas_peticion"][$ruta]=1;
	$ruta = $_SERVER["DOCUMENT_ROOT"] . $ruta;
	$contenido = "";
	$config = file_get_contents($ruta."config");
	$archivos = explode(";", $config);
	foreach($archivos as $archivo){
		$rutaArchivo = $ruta . $archivo;
		if(contiene("..",$archivo)){
			error(500, "No permitido '..'");
		}
		if(empiezaCon("/",$archivo)){
			$rutaArchivo = $_SERVER["DOCUMENT_ROOT"] . "/html/front" . $archivo;
		}
		if(empiezaCon("@",$archivo)){
			$a =  "/html/front/componentes" . str_replace("@","/",$archivo) . "/";
			$contenido .= loadPagina($a);
			continue;
		}
		if(!file_exists($rutaArchivo)){
			error(500, "Archivo '$archivo' no encontrado.");
		}
		$contenidoArchivo = file_get_contents($rutaArchivo);
		$partesArchivo = explode(".", $archivo);
		$extension = $partesArchivo[count($partesArchivo)-1];
		if($extension == "css"){
			$contenido .= "<style>$contenidoArchivo</style>";
		}else if($extension == "js"){
			$contenido .= "<script>$contenidoArchivo</script>";
		}else if($extension == "html"){
			$contenido .= $contenidoArchivo;
		}else{
			error(500, "Extension de archivo '$archivo' no reconocida.");
		} 
	}
	return $contenido;
}

function contiene($aguja, $pajar){
	if(strpos($pajar, $aguja) !== false) {
		return true;
	}
	return false;
}

function empiezaCon($aguja, $pajar) {
    return $aguja === "" || strrpos($pajar, $aguja, -strlen($pajar)) !== false;
}
?>