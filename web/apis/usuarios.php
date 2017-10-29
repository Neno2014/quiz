<?php

if ($comando == "iniciar_sesion"){
	if(isset($_REQUEST["email"]) && isset($_REQUEST["password"])){
		$resultado = login($_REQUEST["email"],$_REQUEST["password"]);
		echo json_encode($resultado);
	}
}

if ($comando == "crear_cuenta"){
	if(isset($_REQUEST["email"]) && isset($_REQUEST["nombre"]) && isset($_REQUEST["password"])){
		$email = $_REQUEST["email"];
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			echo '{"error":"La direccion de correo \''.$email.'\' no es valida.","tipo":"5"}';
			die();
		}
		
		$resultado = dbQuery("SELECT api.crear_cuenta(?,?,?);",array($email, $_REQUEST["nombre"],$_REQUEST["password"]));
		
		if(isset($resultado[0])){
			$datos = json_decode($resultado[0]["crear_cuenta"], true);
			if(isset($datos["id_validacion"])){
				
				$validacion = dbQuery("SELECT api.validar_cuenta(?);", array($datos["id_validacion"]));
				
				$sesion = dbQuery("SELECT api.session();", array());
				$idSesion = $sesion[0]["session"];
				setcookie("quiz_session", $idSesion, time() + (10 * 365 * 24 * 60 * 60), "/");
				/*
				$enlace = $datos["id_validacion"];
				$to = $datos["email"];
				$nombre = $datos["nombre"];
				
				$subject = "Bienvenido a galaxyvictor";
				$mensaje = "
				Hola $nombre
				Su cuenta de galaxyvictor.com se ha creado correctamente. 
				
				Haga click en el siguiente enlace para verificar su cuenta
				
				$enlace
				";

				echo mail($to,$subject,$mensaje,"From: no-reply@platypoox.com");
				*/
				
			}
			
			echo $resultado[0]["crear_cuenta"];
		}else{
			echo '{"error":"Error desconocido","tipo":"6"}';
		}
		
	}
}

?>