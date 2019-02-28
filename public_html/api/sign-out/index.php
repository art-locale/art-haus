<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/Secrets.php");
/**
 * api for signing out
 *
 * @author Brandon Huffman
 * @version 1.0
 **/
//verify the xsrf challenge
if(session_status() !== PHP_SESSION_ACTIVE){
	session_start();
}
//prepare default error message
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//grab the mySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort23/arthaus.ini");
	$pdo = $secrets->getPdoObject();
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	if($method === "GET") {
		$_SESSION = [];
		$reply->message = "You are now signed out.";
	}
	else {
		throw (new \InvalidArgumentException("Invalid HTTP method request"));
	}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
//encode and return reply to front end caller
echo json_encode($reply);
