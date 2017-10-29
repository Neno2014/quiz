<?php

if ($comando == "crear_pregunta"){
	if(isset($_REQUEST["pregunta"])){
		$resultado = dbQuery("SELECT api.crear_pregunta(?,null);", array($_REQUEST["pregunta"]));
		echo json_encode($resultado);
	}
}

if ($comando == "crear_respuesta"){
	if(isset($_REQUEST["pregunta"]) && isset($_REQUEST["respuesta"]) && isset($_REQUEST["correcta"])){
		$resultado = dbQuery("SELECT api.crear_respuesta(?,?,?) as id;", array($_REQUEST["pregunta"],$_REQUEST["respuesta"],$_REQUEST["correcta"]));
		$respuestas = dbQuery("SELECT * FROM api.respuestas where id=?;", array($resultado[0]["id"]));
		echo json_encode($respuestas[0]);
	}
}

if ($comando == "get_datos_pregunta"){
	if(isset($_REQUEST["idPregunta"])){
		
		$preg = dbQuery("SELECT * FROM api.preguntas where id=?;", array($_REQUEST["idPregunta"]));
		$respuestas = dbQuery("SELECT * FROM api.respuestas where pregunta=?;", array($_REQUEST["idPregunta"]));
		
		echo json_encode(array(
			"id" => $preg[0]["id"],
			"pregunta" => $preg[0]["pregunta"],
			"respuestas" => $respuestas
		));
	}
}

if ($comando == "editar_pregunta"){
	if(isset($_REQUEST["id"])){
		beginTransaction();
		$edPregunta = dbQuery("SELECT api.editar_pregunta(?,?,null);", array($_REQUEST["id"], $_REQUEST["pregunta"]));
		foreach($_REQUEST["respuestas"] as $respuesta){
			if($respuesta["id"]==-1){
				$edRespuesta = dbQuery("SELECT api.crear_respuesta(?,?,?);", array($_REQUEST["id"], $respuesta["respuesta"], $respuesta["correcta"]));
			}else{
				$edRespuesta = dbQuery("SELECT api.editar_respuesta(?,?,?);", array($respuesta["id"], $respuesta["respuesta"], $respuesta["correcta"]));
			}
		}
		commit();
	}
}

if ($comando == "eliminar_respuesta"){
	if(isset($_REQUEST["id"])){
		dbQuery("SELECT api.eliminar_respuesta(?);", array($_REQUEST["id"]));
	}
}

?>