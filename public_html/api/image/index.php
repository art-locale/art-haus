<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
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
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort23/arthaus.ini");
  $pdo = $secrets->getPdoObject();
	$cloudinary = $secrets->getSecret("cloudinary");

	//determine which HTTP method is being used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$galleryId = filter_input(INPUT_GET, "galleryId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileId = filter_input(INPUT_GET, "ProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	\Cloudinary::config(["cloud_name" => $cloudinary->cloudName, "api_key" => $cloudinary->apiKey, "api_secret" => $cloudinary->apiSecret]);

	// process GET requests
	if($method === "GET") {

		// set XSRF token
		setXsrfCookie();

		$reply->data = Image::getAllImages($pdo)->toArray();
	}  elseif($method === "POST") {

			verifyXsrf();

			$imageId = filter_input(INPUT_POST, "imageId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			$tempUserFileName = $_FILES["image"]["temp_name"];
			$cloudinaryResult = \Cloudinary\Uploader::upload($tempUserFileName, array("width" => 200, "crop" => "scale"));
			$image = new Image(generateUuidV4(), $imageId, $imageGalleryId, $imageProfileId, $imageDate, $imageTitle, $cloudinaryResult["secure_url"]);
			$image->insert($pdo);
			var_dump($image);
			$reply->message = "Image uploaded!";
		}
	} catch(Exception $exception) {
		$reply->status = $exception->getCode();
		$reply->message = $exception->getMessage();
	}

header("Content-Type: application/json");

echo json_encode($reply);
