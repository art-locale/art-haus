<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
use ArtLocale\ArtHaus\ {Image, Gallery, Profile};
/**
 * Cloudinary API for Images
 *
 * @author Brandon Huffman
 * @version 1.0
 */
// start session
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
// prepare an empty reply
$reply = new StdClass();
$reply->status = 200;
$reply->data = null;
try {
	// Grab the MySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cohort23/arthaus.ini");
	//determine which HTTP method is being used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];
	// sanitize input
	$galleryId = filter_input(INPUT_GET, "galleryId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileId = filter_input(INPUT_GET, "ProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$config = readConfig("/etc/apache2/capstone-mysql/cohort23/arthaus.ini");
	$cloudinary = json_decode($config["cloudinary"]); /*TODO*/
	\Cloudinary::config(["cloud_name" => $cloudinary->cloudName, "api_key" => $cloudinary->apiKey, "api_secret" => $cloudinary->apiSecret]);
	// process GET requests
	if($method === "GET") {
		// set XSRF token
		setXsrfCookie();
		//get a specific image by id and update reply
		if(empty($id) === false) {
			$image = Image::getImageByImageId($pdo, $id);
		} elseif(empty($tweetId) === false) {
			$reply->data = Image::getImageByImageGalleryId($pdo, $tweetId)->toArray();
		} elseif(empty($profileId) === false) {
			$reply->data = Image::getImageByImageProfileId($pdo, $profileId)->toArray();
		}
	} elseif($method === "DELETE") {
		//enforce that the end user has a XSRF token.
		verifyXsrf();
		// retrieve the Image to be deleted
		$image = Image::getImageByImageId($pdo, $id);
		if($image === null) {
			throw(new RuntimeException("Image does not exist", 404));
		}
		//enforce the user is signed in and only trying to edit their own image
		// use the image id to get the tweet id to get the profile id to compare it to the session profile id
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== Tweet::getGalleryByGalleryId($pdo, $image->getImageGalleryId())->getGallerybyProfileId()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this image", 403));
		}
		//enforce the end user has a JWT token
		validateJwtHeader();
		// delete image from cloudinary
		$cloudinaryResult = \Cloudinary\Uploader::destroy($image->getImageCloudinaryToken()); /*TODO*/
		// delete image database
		$image->delete($pdo);
		// update reply
		$reply->message = "Image deleted OK";
	} elseif($method === "POST") {
		//enforce that the end user has a XSRF token.
		verifyXsrf();
		// verify the user is logged in
		if(empty($_SESSION["profile"]) === true) {
			throw (new \InvalidArgumentException("you must be logged in to post images", 401));
			// verify user is logged into the profile posting the tweet before uploading an image
		} elseif($_SESSION["profile"]->getProfileId() !== Tweet::getGalleryByGalleryId($pdo, $galleryId)->getGalleryProfileId()) {
			throw(new \InvalidArgumentException("You are not allowed to post an image to someone else's tweet", 403));
		}
		// assigning variable to the user profile, add image extension
		$tempUserFileName = $_FILES["image"]["tmp_name"];
		// upload image to cloudinary and get public id
		$cloudinaryResult = \Cloudinary\Uploader::upload($tempUserFileName, array("width" => 500, "crop" => "scale"));
		// after sending the image to Cloudinary, create a new image
		$image = new Image(generateUuidV4(), $galleryId, $cloudinaryResult["signature"], $cloudinaryResult["secure_url"]);
		$image->update($pdo);
		// update reply
		$reply->message = "Image uploaded Ok";
	}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-Type: application/json");
// encode and return reply to front end caller
echo json_encode($reply);