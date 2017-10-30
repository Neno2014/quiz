<?php

if ($comando == "crear_tema"){
	if(isset($_REQUEST["nombre"]) && isset($_REQUEST["asignatura"])){
		$resultado = dbQuery("SELECT api.crear_tema(?,?) as id;", array($_REQUEST["nombre"], $_REQUEST["asignatura"]));
		$tema = dbQuery("SELECT * from api.temas where id=?;", array($resultado[0]["id"]));
		echo json_encode($tema[0]);
	}
}

if ($comando == "editar_tema"){
	if(isset($_REQUEST["nombre"]) && isset($_REQUEST["id"])){
		dbQuery("SELECT api.editar_tema(?,?);", array($_REQUEST["nombre"], $_REQUEST["id"]));
	}
}

if ($comando == "eliminar_tema"){
	if(isset($_REQUEST["id"])){
		dbQuery("SELECT api.eliminar_tema(?);", array($_REQUEST["id"]));
	}
}

if ($comando == "get_temas_asignatura"){
	if(isset($_REQUEST["asignatura"])){
		if($_REQUEST["asignatura"]=="null"){
			$temas = array();
		}else{
			$temas = dbQuery("SELECT * from api.temas where asignatura=?;", array($_REQUEST["asignatura"]));
		}
		
		echo json_encode($temas);
	}
}

?>