<?php

if(isset($GLOBALS["sesion"]) && isset($GLOBALS["sesion"]["usuario"])){
	$usuario = $GLOBALS["sesion"]["usuario"]["nombre"];
}else{
	$usuario = null;
}

cerrarSesion();

mostrarPagina(
	contenido(),
	array(
		"usuario_anterior" => $usuario
	)
);

function contenido(){
	return loadPagina("/front/html/paginas/logout/");
}

?>