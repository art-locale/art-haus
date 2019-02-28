<?php
<!--applaudProfileId-->
<!--applaudImageId-->
<!--applaudCount-->

require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/Classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use ArtLocale\ArtHaus\ {
	Profile, Image
};

/*
 * API for Applaud class
 * @author Will Tredway <jwilliamtredway@gmail.com>
 * @version 1.0
 */

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
	// sanitize input: not needed, no strings

	// make sure the id is valid for methods that require it
	if(($method === "GET" || $method === "POST") && (empty($id) === true)) {
		throw(new InvalidArgumentException("ID cannot be empty or negative", 405));
	}

//GET*********************************************
	if($method === "GET") {
		// set XSRF token
		setXsrfCookie();
		//get a specific applaud by id and update reply
		if(empty($id) === false) {
			$applaud = Applaud::getApplaudByApplaudImageId($pdo, $id);
		} elseif(empty($applaudImageId) === false) {
			$reply->data = Applaud::getApplaudByApplaudImageId($pdo, $tweetId)->toArray();
		} elseif(empty($applaudProfileId) === false) {
			$reply->data = Applaud::getApplaudByApplaudImageIdandApplaudProfileId($pdo, $profileId)->toArray();
		} //POST********************************************
		elseif($method === "POST") {
			//enforce that the end user has a XSRF token.
			verifyXsrf();
			// verify the user is logged in
			if(empty($_SESSION["profile"]) === true) {
				throw (new \InvalidArgumentException("you must be logged in to applaud", 401));
				// update reply
				$reply->message = "Applaud uploaded Ok";
			}
		} catch
		(Exception $exception) {
			$reply->status = $exception->getCode();
			$reply->message = $exception->getMessage();
		}
	header("Content-Type: application/json");
	// encode and return reply to front end caller
	echo json_encode($reply);
	}
}

//PUT*****************NO***DON'T******************


//DELETE**************NO***DON't******************

