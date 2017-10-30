<?php

$preguntas = dbQuery("SELECT * FROM api.mis_preguntas;", array());
$asignaturas = dbQuery("SELECT * FROM api.asignaturas;", array());
$respuestas = dbQuery("SELECT * FROM api.mis_respuestas;", array());

mostrarPagina(
	contenido(),
	array(
		"preguntas" => $preguntas,
		"asignaturas" => $asignaturas,
		"respuestas" => $respuestas
	)
);

function contenido(){
	return loadPagina("/front/html/paginas/mis_preguntas/");
}
?>