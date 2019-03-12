<?php

require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/Classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/php/lib/jwt.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use ArtLocale\ArtHaus\ {
	Profile, Image, Applaud
};

/**
 * API for Applaud class
 * @author Will Tredway <jwilliamtredway@gmail.com>
 * @version 1.0
 **/

//SET UP*******************************************
//verify the session, if it is not active start it
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//grab the mySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort23/arthaus.ini");
	$pdo = $secrets->getPdoObject();
	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];
	// sanitize input:
	$applaudProfileId = $id = filter_input(INPUT_GET, "applaudProfileId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$applaudImageId = $id = filter_input(INPUT_GET, "applaudImageId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	// make sure the id is valid for methods that require it
	if(($method === "GET" || $method === "POST") && (empty($id) === true)) {
		throw(new InvalidArgumentException("ID cannot be empty or negative", 405));
	}

//GET*********************************************
if($method === "GET") {
	//set XSRF cookie
	setXsrfCookie();
	//gets  a specific like associated based on its composite key
	if ($applaudProfileId !== null && $applaudImageId !== null) {
		$applaud = Applaud::getApplaudByApplaudImageIdandApplaudProfileId($pdo, $applaudProfileId, $applaudImageId);
		if($applaud!== null) {
			$reply->data = $applaud;
		}
		//if none of the search parameters are met throw an exception
	} else if(empty($applaudProfileId) === false) {
		$reply->data = Applaud::getApplaudByApplaudProfileId($pdo, $applaudProfileId)->toArray();
	//get all the likes associated with the applaudId
	} else if(empty($applaudImageId) === false) {
		$reply->data = Applaud::getApplaudByApplaudImageId($pdo, $applaudImageId)->toArray();
	} else {
		throw new InvalidArgumentException("incorrect search parameters ", 404);
	}
}
//POST********************************************
elseif($method === "POST" || $method === "PUT") {
	//decode the response from the front end
	$requestContent = file_get_contents("php://input");
	$requestObject = json_decode($requestContent);
	if(empty($requestObject->applaudProfileId) === true) {
		throw (new \InvalidArgumentException("No profile linked to the applaud", 405));
	}
	if(empty($requestObject->applaudImageId) === true) {
		throw (new \InvalidArgumentException("No image linked to the applaud", 405));
	}
	if(empty($requestObject->applaudCount) === true) {
		throw (new \InvalidArgumentException("No applauds to count", 405));
	}
	if($method === "POST") {
		//enforce that the end user has a XSRF token.
		verifyXsrf();
		//enforce the end user has a JWT token
		validateJwtHeader();
		// enforce the user is signed in
		if(empty($_SESSION["profile"]) === true) {
			throw(new \InvalidArgumentException("you must be logged in to applaud images", 403));
		}
		validateJwtHeader();
		$applaud = new Applaud($_SESSION["profile"]->getProfileId(), $requestObject->applaudImageId);
		$applaud->insert($pdo);
		$reply->message = "applauded image successfully";
	} else if($method === "PUT") {
		//enforce the end user has a XSRF token.
		verifyXsrf();
		//enforce the end user has a JWT token
		validateJwtHeader();
		//grab the like by its composite key
		$applaud = Applaud::getApplaudByApplaudImageIdandApplaudProfileId($pdo, $requestObject->applaudProfileId, $requestObject->applaudImageId);
		if($applaud === null) {
			throw (new RuntimeException("applaud does not exist"));
		}
		//enforce the user is signed in and only trying to edit their own applaud
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $applaud->getApplaudProfileId()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this applaud", 403));
		}
		validateJwtHeader();
		//perform the applaud delete
		$applaud->delete($pdo);
		//update the message
		$reply->message = "Applaud successfully deleted";
	}
	// if any other HTTP request is sent throw an exception
} else {
	throw new \InvalidArgumentException("invalid http request", 400);
 }
//catch any exceptions that is thrown and update the reply status and message
} catch(\Exception | \TypeError $exception) {
$reply->status = $exception->getCode();
$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);
