<?php
require_once dirname(__DIR__, 3) . "/php/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php"; //Todo not existent
require_once ("/etc/apache2/capstone-mysql/Secrets.php");
use ArtLocale\ArtHaus\Profile;
/**
 * api for handling sign-in
 *
 * @author Brandon Huffman
 **/
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//start session
	if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	//grab mySQL statement
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort23/arthaus.ini");
  $pdo = $secrets->getPdoObject();
	//determine which HTTP method is being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//If method is post handle the sign in logic
	if($method === "POST") {
		//make sure the XSRF Token is valid
		verifyXsrf();
		//process the request content and decode the json object into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		//check to make sure the password and email field is not empty.
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException("Please enter your email address.", 401));
		} else {
			$profileEmail = filter_var($requestObject->profileEmail, FILTER_SANITIZE_EMAIL);
		}
		if(empty($requestObject->profilePassword) === true) {
			throw(new \InvalidArgumentException("Please enter your password.", 401));
		} else {
			$profilePassword = $requestObject->profilePassword;
		}
		//grab the profile from the database by the email provided
		$profile = Profile::getProfileByEmail($pdo, $profileEmail);
		if(empty($profile) === true) {
			throw(new \InvalidArgumentException("Email in incorrect", 401));
		}
		//if the profile activation is not null throw an error
		if($profile->getProfileActivationToken() !== null){
			throw (new \InvalidArgumentException ("You are not allowed to sign in unless you have activated your account", 403));
		}
		//verify hash is correct
		if(password_verify($requestObject->profilePassword, $profile->getProfilePassword()) === false) {
			throw(new \InvalidArgumentException("Password or email is incorrect.", 401));
		}
		//grab profile from database and put into a session
		$profile = Profile::getProfileByProfileId($pdo, $profile->getProfileId());
		$_SESSION["profile"] = $profile;
		//create the Auth payload
		$authObject = (object) [
			"profileId" =>$profile->getProfileId(),
			"profileName" => $profile->getProfileName()
		];
		// create and set th JWT TOKEN
		setJwtAndAuthHeader("auth",$authObject);
		$reply->message = "Sign in was successful!";
	} else {
		throw(new \InvalidArgumentException("Invalid HTTP method request", 418));
	}
	// if an exception is thrown update the
} catch(Exception | TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
echo json_encode($reply);
