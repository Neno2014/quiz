<?php

if ($comando == "crear_asignatura"){
	if(isset($_REQUEST["nombre"])){
		$resultado = dbQuery("SELECT api.crear_asignatura(?) as id;", array($_REQUEST["nombre"]));
		$tema = dbQuery("SELECT * from api.temas where id=?;", array($resultado[0]["id"]));
		echo json_encode($tema[0]);
	}
}

if ($comando == "editar_asignatura"){
	if(isset($_REQUEST["nombre"]) && isset($_REQUEST["id"])){
		dbQuery("SELECT api.editar_asignatura(?,?);", array($_REQUEST["nombre"], $_REQUEST["id"]));
	}
}

if ($comando == "eliminar_asignatura"){
	if(isset($_REQUEST["id"])){
		dbQuery("SELECT api.eliminar_asignatura(?);", array($_REQUEST["id"]));
	}
}

?>