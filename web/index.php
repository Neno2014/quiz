<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/core/includes.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/core/site.php");


mostrarPagina(
	loadPagina("/front/html/paginas/index/"),
	array(
		"prueba" => true
	)
);

?>