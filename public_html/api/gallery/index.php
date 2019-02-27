<?php
/***********************************************************************
* GALLERY INDEX.PHP FOR API
***********************************************************************/

require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/Classes/autoload.php");
// require_once(dirname(__DIR__, 3) . "/php/lib/jwt.php"); //TODO What is this?//
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
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/ddctwitter.ini");
	//determine which HTTP method is being used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];
	$galleryId = filter_input(INPUT_GET, "galleryId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$galleryProfileId = filter_input(INPUT_GET, "galleryProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$config = readConfig("/etc/apache2/capstone-mysql/ddctwitter.ini");


//	$cloudinary = json_decode($config["cloudinary"]);
//	\Cloudinary::config(["cloud_name" => $cloudinary->cloudName, "api_key" => 	$cloudinary->apiKey, "api_secret" => $cloudinary->apiSecret]);


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

//		//enforce the end user has a JWT token
//		validateJwtHeader();
//		// delete image from cloudinary
//		$cloudinaryResult = \Cloudinary\Uploader::destroy($image->getImageCloudinaryToken());
//		// delete image database
//		$image->delete($pdo);
//		// update reply
//		$reply->message = "Image deleted OK";

	} elseif($method === "POST") {
		//enforce that the end user has a XSRF token.
		verifyXsrf();
		// verify the user is logged in
		if(empty($_SESSION["profile"]) === true) {
			throw (new \InvalidArgumentException("you must be logged in to create a gallery", 401));
			// verify user is logged into the profile creating the gallery before creating the gallery
		} elseif($_SESSION["profile"]->getProfileId() !== Gallery::getGalleryByGalleryId($pdo, $galleryId)->getGalleryProfileId()) {
			throw(new \InvalidArgumentException("You are not allowed to create a gallery on someone elses account", 403));
		}

//		// assigning variable to the user profile, add image extension
//		$tempUserFileName = $_FILES["image"]["tmp_name"];
//		// upload image to cloudinary and get public id
//		$cloudinaryResult = \Cloudinary\Uploader::upload($tempUserFileName, array("width" => 500, "crop" => "scale"));
//		// after sending the image to Cloudinary, create a new image
//		$image = new Image(generateUuidV4(), $tweetId, $cloudinaryResult["signature"], $cloudinaryResult["secure_url"]);
//		$image->update($pdo);
//		// update reply
//		$reply->message = "Image uploaded Ok";

	}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-Type: application/json");
// encode and return reply to front end caller
echo json_encode($reply);
