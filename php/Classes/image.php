*<?php
namespace BHuffman1\ArtLocale;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Framework for Image class
 *
 * @author William Isengard <wisengard@cnm.edu>
 * @version 1.0.0
 **/

class Image implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for this image; this is the primary key
	 * @var Uuid $imageId
	 **/
	private $imageId;
	/**
	 * id for this image's gallery; this is a foreign key
	 * @var Uuid $imageGalleryId
	 **/
	private $imageGalleryId;
	/**
	 * id for this image's profile; this is a foreign key
	 * @var Uuid $imageProfileId
	 **/
	private $imageProfileId;
	/**
	 * Date image was created
	 * @var string $imageDate;
	 **/
	private $imageDate;
	/**
	 * Title of image
	 * @var string $imageTitle;
	 **/
	private $imageTitle;
	/**
	 * Url of image owner
	 * @var string $imageUrl;
	 **/
	private $imageUrl;
	/**
	 * constructor for this
	 * @param Uuid|string $newImageId new id of this image or null if a new image
	 * @param string $newImageActivationToken activation token for a new image
	 * @param string $newImageDate date image was activated
	 * @param string $newImageEmail email address for new image
	 * @param string $newImageLocation location for image owner
	 * @param string $newImageTitle title of image owner
	 * @param string $newImagePassword password for image
	 * @param string $newImageWebsite image owner's website
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newImageId, string $newImageActivationToken, string $newImageDate, string $newImageEmail, string $newImageLocation, string $newImageTitle, string $newImagePassword, string $newImageWebsite) {
		try {
			$this->setImageId($newImageId);
			$this->setImageActivationToken($newImageActivationToken);
			$this->setImageDate($newImageDate);
			$this->setImageEmail($newImageEmail);
			$this->setImageLocation($newImageLocation);
			$this->setImageTitle($newImageTitle);
			$this->setImagePassword($newImagePassword);
			$this->setImageWebsite($newImageWebsite);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for image id
	 *
	 * @return Uuid value of image id
	 **/
	public function getImageId() : Uuid {
		return($this->imageId);
	}
	/**
	 * mutator method for image id
	 *
	 * @param Uuid|string $newImageId new value of image id
	 * @throws \RangeException if $newImageId is not positive
	 * @throws \TypeError if $newImageId is not a uuid or string
	 **/
	public function setImageId( $newImageId) : void {
		try {
			$uuid = self::validateUuid($newImageId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the author id
		$this->imageId = $uuid;
	}
