<?php
date_default_timezone_set ("Europe/Madrid");
require_once("db_data.php");


$db = new PDO("pgsql:host=$host_name;
		dbname=$database;", $user_name, $pass);

function beginTransaction(){
	global $db;
	$db->beginTransaction();
}

function rollback(){
	global $db;
	$db->rollback();
}

function commit(){
	global $db;
	$db->commit();
}

function dbQuery($query, $parameters){
	global $db;
	$stmt = $db->prepare($query);
	if(!isset($parameters)){
		throw new Exception();
	}
	$result = $stmt->execute($parameters);
	if(!$result){
		$errorCode = $stmt->errorCode();
		$errorInfo = $stmt->errorInfo();
		if(substr($errorCode,0,2) == "GV"){
			error(substr($errorCode,2,3), explode("CONTEXT",$errorInfo[2])[0]);
		}
		header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error", true, 500);
		$explicacion = str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br>", $errorInfo[2]);
		
		$e = new Exception;
		$stackTrace = str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br>", $e->getTraceAsString());
		echo "Error SQL(" . $errorCode . "): <hr>" . $explicacion . "<hr>" . $stackTrace;
		die();
	}
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $result; 
}

function loged(){
	return isset($_SESSION['registered']) && userId()!=0 && $_SESSION['HTTP_USER_AGENT'] == $_SERVER['HTTP_USER_AGENT'];
}

function userId(){
	if(isset($_SESSION['sim_userid'])){
		return $_SESSION['sim_userid'];
	}
	if(isset($_SESSION['userid'])){
		return $_SESSION['userid'];
	}
	return 0;
}

?>