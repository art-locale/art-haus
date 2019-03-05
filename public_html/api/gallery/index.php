<?php
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
	//grab the mySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort23/arthaus.ini");
  $pdo = $secrets->getPdoObject();
	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];
	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$galleryProfileId = filter_input(INPUT_GET, "galleryProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$galleryName = filter_input(INPUT_GET, "galleryName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//gets a post by content
		if(empty($id) === false) {
			$reply->data = Gallery::getGalleryByGalleryId($pdo, $id);
    } else if(empty($galleryProfileId) === false) {
      $reply->data = Gallery::getGalleryByGalleryProfileId($pdo, $galleryProfileId);
		} else if(empty($galleryName) === false) {
			$reply->data = Gallery::getGalleryByGalleryName($pdo, $galleryName)->toArray();
		}
		// else {
		// 	$reply->data = Tweet::getAllTweets($pdo)->toArray();
		// } TODO: Do we need this?
	} elseif($method === "PUT" || $method === "POST") {
		// enforce the user has a XSRF token
		verifyXsrf();
		// enforce the user is signed in
		if(empty($_SESSION["profile"]) === true) {
			throw(new \InvalidArgumentException("you must be logged in to create galleries", 401));
		}
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		//make sure the gallery is available (required field)
		if(empty($requestObject->galleryName) === true) {
			throw(new \InvalidArgumentException ("Gallery name is required.", 405));
		}
		// make sure tweet date is accurate (optional field)
		if(empty($requestObject->galleryDate) === true) {
			$requestObject->galleryDate = null;
		}
		//perform the actual put or post
		if($method === "PUT") {
			// retrieve the gallery to update
			$gallery = Gallery::getGalleryByGalleryId($pdo, $id);
			if($gallery === null) {
				throw(new RuntimeException("Gallery does not exist", 404));
			}
			//enforce the end user has a JWT token
			//enforce the user is signed in and only trying to edit their own gallery
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $gallery->getGalleryProfileId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this gallery", 403));
			}
			validateJwtHeader();
			// update all attributes
			//$gallery->setGalleryDate($requestObject->galleryDate);
			$gallery->setGalleryName($requestObject->galleryName);
			$gallery->update($pdo);
			// update reply
			$reply->message = "Gallery updated OK";
		} else if($method === "POST") {
			// enforce the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to create a gallery", 403));
			}
			//enforce the end user has a JWT token
			validateJwtHeader();
			// create new tweet and insert into the database
			$gallery = new Gallery(generateUuidV4(), $_SESSION["profile"]->getProfileId(), null, $requestObject->galleryName);
			$gallery->insert($pdo);
			// update reply
			$reply->message = "Gallery created OK";
		}
	} else if($method === "DELETE") {
		//enforce that the end user has a XSRF token.
		verifyXsrf();
		// retrieve the Gallery to be deleted
		$gallery = Gallery::getGalleryByGalleryId($pdo, $id);
		if($gallery === null) {
			throw(new RuntimeException("Gallery does not exist", 404));
		}
		//enforce the user is signed in and only trying to edit their own tweet
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $gallery->getGalleryProfileId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this gallery", 403));
		}
		//enforce the end user has a JWT token
		validateJwtHeader();
		// delete gallery
		$gallery->delete($pdo);
		// update reply
		$reply->message = "Gallery deleted OK";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request", 418));
	}
	// update the $reply->status $reply->message
	} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	}
	// encode and return reply to front end caller
	header("Content-type: application/json");
	echo json_encode($reply);
