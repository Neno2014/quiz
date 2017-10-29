<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/core/includes.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/core/site.php");


if(isset($_REQUEST["pagina"])){
	$pagina = $_REQUEST["pagina"];
	$file = getRuta($_REQUEST["pagina"]);
	if(file_exists($file)){
		$_SERVER['REQUEST_URI'] = "/" . $_REQUEST["pagina"];
		require_once($file);
		//$contenido = contenido();
		//mostrarPagina($contenido);
		die();
	}else{
		error(500,"No se encuentra el archivo '$file' de la pagina '$pagina'");
	}
}


function getRuta($pagina){
	$ruta = dbQuery("SELECT ruta FROM api.paginas WHERE url=?;", array($pagina));
	if(isset($ruta) && isset($ruta[0]) && isset($ruta[0]["ruta"]) && $ruta[0]["ruta"] != null){
		return $ruta[0]["ruta"];
	}else{
		error(404,"No se encuentra la página '$pagina'");
	}
}
?>