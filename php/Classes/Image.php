<?php
namespace ArtLocale\ArtHaus;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Framework for Image class
 *
 * @author Brandon Huffman <bt_huffman@msn.com>
 * @version 1.0.0
 **/
class Image implements \JsonSerializable {
	use ValidateUuid;
	use ValidateDate;
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
	 * @var \DateTime $imageDate;
	 **/
	private $imageDate;
	/**
	 * Title of image
	 * @var string $imageTitle;
	 **/
	private $imageTitle;
	/**
	 * Url of image
	 * @var string $imageUrl;
	 **/
	private $imageUrl;
//**************************************************************************************************START OF CONSTRUCTOR
	/**
	 * constructor for each new image object/ instance/ record
	 *
	 * @param Uuid|string $newImageId new id of this image or null if a new image
	 * @param Uuid|string $newImageGalleryId id of the gallery that has this image
	 * @param Uuid|string $newImageProfileId id of the profile that created this image
	 * @param \DateTime|string|null $newImageDate date image was activated
	 * @param string $newImageTitle title of image
	 * @param string $newImageUrl image's url
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newImageId, $newImageGalleryId, $newImageProfileId, $newImageDate = null, string $newImageTitle, string $newImageUrl) {
		try {
			$this->setImageId($newImageId);
			$this->setImageGalleryId($newImageGalleryId);
			$this->setImageProfileId($newImageProfileId);
			$this->setImageDate($newImageDate);
			$this->setImageTitle($newImageTitle);
			$this->setImageUrl($newImageUrl);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	//	END OF CONSTRUCTOR
//***********************************************************************************START OF ACCESSOR & MUTATOR imageId
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
		// convert and store the image id
		$this->imageId = $uuid;
	}
//	END OF ACCESSOR & MUTATOR imageId
//****************************************************************************START OF ACCESSOR & MUTATOR imageGalleryId
	/**
	 * @return Uuid value of the gallery Id
	 **/
	public function getImageGalleryId() : Uuid {
		return($this->imageGalleryId);
	}
	/**
	 * mutator method for image gallery id
	 *
	 * @param Uuid|string $newImageGalleryId new value of image gallery id
	 * @throws \RangeException if $newImageGalleryId is not positive
	 * @throws \TypeError if $newImageGalleryId is not a uuid or string
	 **/

	public function setImageGalleryId($newImageGalleryId) : void {
		try {
			$uuid = self::validateUuid($newImageGalleryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the image gallery id
		$this->imageGalleryId = $uuid;
	}
//	//	END OF ACCESSOR & MUTATOR imageGalleryId
//	**************************************************************************START OF ACCESSOR & MUTATOR imageProfileId
	/**
	 * @return Uuid value of the image profile Id
	 **/
	public function getImageProfileId() : Uuid {
		return($this->imageProfileId);
	}
	/**
	 * mutator method for image profile id
	 *
	 * @param Uuid|string $newImageProfileId new value of image profile id
	 * @throws \RangeException if $newImageProfileId is not positive
	 * @throws \TypeError if $newImageProfileId is not a uuid or string
	 **/
	public function setImageProfileId( $newImageProfileId) : void {
		try {
			$uuid = self::validateUuid($newImageProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the image profile id
		$this->imageProfileId = $uuid;
	}
//	//	END OF ACCESSOR & MUTATOR imageProfileId
//*********************************************************************************START OF ACCESSOR & MUTATOR imageDate
	/**
	 * accessor method for image date
	 *
	 * @return \DateTime value of image date
	 **/
	public function getImageDate() : \DateTime {
		return($this->imageDate);
	}
	/**
	 * mutator method for image creation date
	 *
	 * @param \DateTime|string|null $newImageDate image date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newImageDate is not a valid object or string
	 * @throws \RangeException if $newImageDate is a date that does not exist
	 **/
	public function setImageDate($newImageDate = null) : void {
		// base case: if the date is null, use the current date and time
		if($newImageDate === null) {
			$this->imageDate = new \DateTime();
			return;
		}
		// store the image date using the ValidateDate trait
		try {
			$newImageDate = self::validateDateTime($newImageDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->imageDate = $newImageDate;
	}
//	//	END OF ACCESSOR & MUTATOR imageDate
//********************************************************************************START OF ACCESSOR & MUTATOR imageTitle
	/**
	 * accessor method for image title
	 *
	 * @return string value of image title
	 **/
	public function getimageTitle() : string {
		return($this->imageTitle);
	}
	/**
	 * mutator method for image title
	 *
	 * @param string $newImageTitle new value of image title
	 * @throws \InvalidArgumentException if $newImageTitle is not a string or insecure
	 * @throws \RangeException if $newImageTitle is > 32 characters
	 * @throws \TypeError if $newImageTitle is not a string
	 **/
	public function setImageTitle(string $newImageTitle) : void {
		// verify the image title is secure
		$newImageTitle = trim($newImageTitle);
		$newImageTitle = filter_var($newImageTitle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newImageTitle) === true) {
			throw(new \InvalidArgumentException("image title is empty or insecure"));
		}
		// verify the image title will fit in the database
		if(strlen($newImageTitle) > 32) {
			throw(new \RangeException("image title too large"));
		}

		// store the image title
		$this->imageTitle = $newImageTitle;
	}
	//	//	END OF ACCESSOR & MUTATOR imageTitle

//**********************************************************************************START OF ACCESSOR & MUTATOR imageUrl
/**
 * accessor method for image Url
 *
 * @return string value of image Url
 **/
public function getImageUrl() : string {
	return($this->imageUrl);
}
/**
 * mutator method for image Url
 *
 * @param string $newImageUrl new value of image Url
 * @throws \InvalidArgumentException if $newImageUrl is not a string or insecure
 * @throws \RangeException if $newImageUrl is > 255 characters
 * @throws \TypeError if $newImageUrl is not a string
 **/
public function setImageUrl(string $newImageUrl) : void {
	// verify the image Url is secure
	$newImageUrl = trim($newImageUrl);
	$newImageUrl = filter_var($newImageUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($newImageUrl) === true) {
		throw(new \InvalidArgumentException("image Url is empty or insecure"));
	}
	// verify the image Url will fit in the database
	if(strlen($newImageUrl) > 255) {
		throw(new \RangeException("image Url too large"));
	}
	// store the image Url
	$this->imageUrl = $newImageUrl;
}
//	END OF ACCESSOR & MUTATOR imageUrl

/***********************************************************************************************************************
 * START OF INSERT METHOD
 *****************************************************************************************************************/
/**
 * inserts this image into mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function insert(\PDO $pdo) : void {

	// create query template

	$query = "INSERT INTO image (imageId, imageGalleryId, imageProfileId, imageDate, imageTitle, imageUrl) VALUES(:imageId, :imageGalleryId, :imageProfileId, :imageDate, :imageTitle, :imageUrl)";
	$statement = $pdo->prepare($query);

	// bind the member variables to the place holder in the template

	$formattedDate = $this->imageDate->format("Y-m-d H:i:s.u");

	$parameters = ["imageId" => $this->imageId->getBytes(), "imageGalleryId" => $this->imageGalleryId->getBytes(), "imageProfileId" => $this->imageProfileId->getBytes(),"imageDate" => $formattedDate, "imageTitle" => $this->imageTitle, "imageUrl" => $this->imageUrl];
	$statement->execute($parameters);
}

/***********************************************************************************************************************
 * START OF DELETE METHOD
 *****************************************************************************************************************/
/**
 * deletes this image from mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function delete(\PDO $pdo) : void {

	// create query template
	$query = "DELETE FROM image WHERE imageId = :imageId";
	$statement = $pdo->prepare($query);

	// bind the member variables to the place holder in the template
	$parameters = ["imageId" => $this->imageId->getBytes()];
	$statement->execute($parameters);
}

/***********************************************************************************************************************
 * START OF UPDATE METHOD
 *****************************************************************************************************************/
/**
 * updates this image in mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
	public function update(\PDO $pdo) : void {

		// create query template
		$query = "UPDATE image SET imageId = :imageId, imageGalleryId = :imageGalleryId, imageProfileId = :imageProfileId, imageDate = :imageDate, imageTitle = :imageTitle, imageUrl = :imageUrl";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template

		$formattedDate = $this->imageDate->format("Y-m-d H:i:s.u");

		$parameters = ["imageId" => $this->imageId->getBytes(), "imageGalleryId" => $this->imageGalleryId->getBytes(), "imageProfileId" => $this->imageProfileId->getBytes(),"imageDate" => $formattedDate, "imageTitle" => $this->imageTitle, "imageUrl" => $this->imageUrl];
		$statement->execute($parameters);
	}


/***********************************************************************************************************************
 * START OF GET IMAGE BY IMAGEID METHOD
 *****************************************************************************************************************/
/**
 * gets the image by imageId
 *
 * @param \PDO $pdo PDO connection object
 * @param Uuid|string $imageId image id to search for
 * @return image|null image found or null if not found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when a variable are not the correct data type
 **/
public static function getImageByImageId(\PDO $pdo, $imageId) : ?image {
	// sanitize the imageId before searching
	try {
		$imageId = self::validateUuid($imageId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}

	// create query template
	$query = "SELECT imageId, imageGalleryId, imageProfileId, imageDate, imageTitle, imageUrl FROM image WHERE imageId = :imageId";
	$statement = $pdo->prepare($query);

	// bind the image id to the place holder in the template
	$parameters = ["imageId" => $imageId->getBytes()];
	$statement->execute($parameters);

	// grab the image from mySQL
	try {
		$image = null;
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		if($row !== false) {
			$image = new Image($row["imageId"], $row["imageGalleryId"], $row["imageProfileId"], $row["imageDate"], $row["imageTitle"], $row["imageUrl"]);
		}
	} catch(\Exception $exception) {
		// if the row couldn't be converted, rethrow it
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}
	return($image);
}


	/***********************************************************************************************************************
	 * START OF GET IMAGE BY GALLERY ID
	 *****************************************************************************************************************/
	/**
	 * gets image by gallery id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of images found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getImageByGalleryId(\PDO $pdo, Uuid $imageGalleryId) : ?Image {
		// sanitize the imageGalleryId before searching
		try {
			$imageGalleryId = self::validateUuid($imageGalleryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT imageId, imageGalleryId, imageProfileId, imageDate, imageTitle, imageUrl FROM image WHERE imageGalleryId = :imageGalleryId";
		$statement = $pdo->prepare($query);

		//bind the galleryId to the place holder in the template
		$parameters = ["imageGalleryId" => $imageGalleryId->getBytes()];
		$statement->execute($parameters);

		// grab the image from mySQL
		try {
			$image = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$image = new Image($row["imageId"], $row["imageGalleryId"], $row["imageProfileId"], $row["imageDate"], $row["imageTitle"], $row["imageUrl"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($image);
	}

	/***********************************************************************************************************************
	 * START OF GET IMAGE BY PROFILE ID
	 *****************************************************************************************************************/
	/**
	 * gets image by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of images found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getImageByProfileId(\PDO $pdo, Uuid $imageProfileId) : ?Image {
		// sanitize the imageProfileId before searching
		try {
			$imageProfileId = self::validateUuid($imageProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT imageId, imageGalleryId, imageProfileId, imageDate, imageTitle, imageUrl FROM image WHERE imageProfileId = :imageProfileId";
		$statement = $pdo->prepare($query);

		//bind the profileId to the place holder in the template
		$parameters = ["imageProfileId" => $imageProfileId->getBytes()];
		$statement->execute($parameters);

		// grab the image from mySQL
		try {
			$image = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$image = new Image($row["imageId"], $row["imageGalleryId"], $row["imageProfileId"], $row["imageDate"], $row["imageTitle"], $row["imageUrl"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($image);
	}


//TODO getImageByProfileDistance get unit testing done before this last

/***********************************************************************************************************************
 * START OF GET ALL IMAGES METHOD
 *****************************************************************************************************************/
/**
 * gets all images
 *
 * @param \PDO $pdo PDO connection object
 * @return \SplFixedArray SplFixedArray of images found or null if not found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getAllImages(\PDO $pdo) : \SplFixedArray {
		// create query template
		$query = "SELECT imageId, imageGalleryId, imageProfileId, imageDate, imageTitle, imageUrl FROM image";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of images
		$images = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$image = new Image($row ["imageId"], $row["imageGalleryId"], $row["imageProfileId"], $row["imageDate"], $row["imageTitle"], $row["imageUrl"]);
				$images[$images->key()] = $image;
				$images->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($images);
	}
/**
 * formats the state variables for JSON serialization
 *
 * @return array resulting state variables to serialize
 **/
public function jsonSerialize() {
	$fields = get_object_vars($this);
	//primary key
	$fields["imageId"] = $this->imageId->toString();
//foreign keys
	$fields["imageGalleryId"] = $this->imageGalleryId->toString();
	$fields["imageProfileId"] = $this->imageProfileId->toString();

//	Fixme I think george said not to use this date thing
	//format the date so that the front end can consume it
	$fields["imageDate"] = round(floatval($this->imageDate->format("U.u")) * 1000);
	return ($fields);
}
}
?>

//
