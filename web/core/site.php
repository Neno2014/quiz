<?php

function mostrarPagina($contenido, $datos = array()){
	
	$datosJSON = json_encode($datos);
	if(isset($GLOBALS["sesion"]) && isset($GLOBALS["sesion"]["usuario"])){
		$usuarioJSON = json_encode($GLOBALS["sesion"]["usuario"]);
	}else{
		$usuarioJSON = json_encode(null);
	}
	
	$navbar = loadPagina("/front/html/comun/navbar/");
	$estilo = loadPagina("/front/html/comun/estilo/");
	
	echo "<!DOCTYPE html>
<html>
	<head>
		<link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
		<link type='text/css' rel='stylesheet' href='/materialize/css/materialize.min.css'  media='screen,projection'/>
		<meta name='viewport' content='width=device-width, initial-scale=1.0'/>
		<script type='text/javascript' src='/js/jquery-3.2.1.min.js'></script>
	</head>

	<body>
		<script type='text/javascript'>var Quiz = new Object();Quiz.datos=$datosJSON;Quiz.usuario=$usuarioJSON;</script>
		$estilo
		$navbar
		$contenido
		
		<script type='text/javascript' src='/materialize/js/materialize.min.js'></script>
	</body>
</html>";
}
?>