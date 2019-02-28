<?php
/***********************************************************************
* GALLERY INDEX.PHP FOR API
***********************************************************************/

require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/Classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/jwt.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");
use ArtLocale\ArtHaus\ {
	Profile, Gallery
};
/**
 * API for Gallery
 *
 * @author Jaeren William Tredway <jtredway@cnm.edu>
 * @version 1.0
 */
//verify the session, if it is not active start it
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// Grab the MySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort23/arthaus.ini");
	$pdo = $secrets->getPdoObject();
	//determine which HTTP method is being used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$galleryProfileId = filter_input(INPUT_GET, "galleryProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	// process GET requests
	if($method === "GET") {
		// set XSRF token
		setXsrfCookie();
		//get a specific gallery by id and update reply
		if(empty($id) === false) {
			$gallery = Gallery::getGalleryByGalleryId($pdo, $id);
		} elseif(empty($galleryId) === false) {
			$reply->data = Gallery::getGalleryByGalleryProfileId($pdo, $galleryProfileId)->toArray();
		}

		else if($method === "PUT" || $method === "POST") {
		// enforce the user has a XSRF token
		verifyXsrf();
		//enforce the end user has a JWT token
		validateJwtHeader();
		// enforce the user is signed in
		if(empty($_SESSION["profile"]) === true) {
			throw(new \InvalidArgumentException("you must be logged in to add or update galleries", 401));
		}
		$requestContent = file_get_contents("php://input");
		// Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestObject = json_decode($requestContent);
		// This Line Then decodes the JSON package and stores that result in $requestObject
		//make sure gallery name is available (required field)
		if(empty($requestObject->galleryName) === true) {
			throw(new \InvalidArgumentException ("No gallery name.", 405));
		}

		//perform the actual put or post
		if($method === "PUT") {
			// retrieve the gallery to update
			$gallery = Gallery::getGalleryByGalleryId($pdo, $id);
			if($galleryId === null) {
				throw(new RuntimeException("gallery does not exist", 404));
			}
			//enforce the end user has a JWT token
			//enforce the user is signed in and only trying to edit their own gallery
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $gallery->getGalleryProfileId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this gallery", 403));
			}
			validateJwtHeader();
			// update all attributes
			$gallery->setGalleryName($requestObject->galleryName);
			$gallery->update($pdo);
			// update reply
			$reply->message = "gallery updated successfully";
		} else if($method === "POST") {
			// enforce the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to edit galleries", 403));
			}
			//enforce the end user has a JWT token
			validateJwtHeader();
			// create new gallery and insert into the database
			$gallery = new Gallery(generateUuidV4(), $_SESSION["profile"]->getProfileId(), null, $requestObject->galleryName);
			$gallery->insert($pdo);
			// update reply
			$reply->message = "Gallery created OK";
		}

	} elseif($method === "DELETE") {
		//enforce that the end user has a XSRF token.
		verifyXsrf();
		// retrieve the Gallery to be deleted
		$gallery = Gallery::getGalleryByGalleryId($pdo, $id);
		if($gallery === null) {
			throw(new RuntimeException("Gallery does not exist", 404));
		}
		//enforce the user is signed in and only trying to edit their own gallery
		// use the gallery id to get the profile id to get the profile id to compare it to the session profile id
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== Gallery::getGalleryByGalleryId($pdo, $gallery->getGalleryId())->getGalleryProfileId()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this gallery", 403));
		}
		// }catch
		// (\Exception | \TypeError $exception) {
		// 	$reply->status = $exception->getCode();
		// 	$reply->message = $exception->getMessage();
		// }
		header("Content-type: application/json");
		if($reply->data === null) {
			unset($reply->data);
		}
		// encode and return reply to front end caller
		echo json_encode($reply);
