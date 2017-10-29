<?php

$preguntas = dbQuery("SELECT * FROM api.mis_preguntas;", array());
$respuestas = dbQuery("SELECT * FROM api.mis_respuestas;", array());

mostrarPagina(
	contenido(),
	array(
		"preguntas" => $preguntas,
		"respuestas" => $respuestas
	)
);

function contenido(){
	return loadPagina("/front/html/paginas/mis_preguntas/");
}
?>