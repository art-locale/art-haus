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
// verify or start session
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
//	$date =  filter_input(INPUT_GET, "imageDate", self::validateDateTime($imageDate));
//	$title = filter_input(INPUT_GET, "imageTitle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
//	$url = filter_input(INPUT_GET,"imageUrl", FILTER_SANITIZE_URL);
	\Cloudinary::config(["cloud_name" => $cloudinary->cloudName, "api_key" => $cloudinary->apiKey, "api_secret" => $cloudinary->apiSecret]);

	// process GET requests
	if($method === "GET") {

		// set XSRF token
		setXsrfCookie();

		$reply->data = Image::getAllImages($pdo)->toArray();
	}  elseif($method === "POST") {

			verifyXsrf();

			$imageTitle = filter_input(INPUT_POST, "imageTitle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

			$tempUserFileName = $_FILES["image"]["tmp_name"];
			var_dump($tempUserFileName);

			$cloudinaryResult = \Cloudinary\Uploader::upload($tempUserFileName, array("width" => 200, "crop" => "scale"));
			$image = new Image(generateUuidV4(), $_SESSION["gallery"] -> getGalleryId(), $_SESSION["profile"] -> getProfileId(), $imageDate, $imageTitle, $cloudinaryResult["secure_url"]);
			$image->insert($pdo);
			var_dump($image);
			$reply->message = "Image uploaded!";
		}
}

catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
}
//TODO the following four lines of code break sign-in
//catch(TypeError $typeError) {
//	$reply->status = $typeError->getCode();
//	$reply->message = $typeError->getMessage();
//	}

	//the Exceptions are caught and the $reply object is updated with the data from the caught exception. Note that $reply->status will be updated with the correct error code in the case of an Exception.
header("Content-Type: application/json");

// sets up the response header.
if($reply->data === null) {
	unset($reply->data);
}

echo json_encode($reply);
