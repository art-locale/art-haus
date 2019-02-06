*<?php
namespace ArtLocale/ArtHaus;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Framework for Image class
 *
 * @author William Isengard <wisengard@cnm.edu>
 * @version 1.0.0
 **/
//Note FIXME do we want to have these states as protected or public instead?
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
	 * Url of image
	 * @var string $imageUrl;
	 **/
	private $imageUrl;
//	START OF CONSTRUCTOR
	/**
	 * constructor for each new image object/ instance/ record
	 *
	 * @param Uuid|string $newImageId new id of this image or null if a new image FIXME would it really be null?
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
	public function __construct($newImageId, $newImageGalleryId, $newImageProfileId, string $newImageDate, string $newImageTitle, string $newImageUrl) {
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
//	START OF ACCESSOR & MUTATOR imageId
	/**
	 * accessor method for image id
	 *
	 * @return Uuid value of image id
	 **/
//	FIXME noticed that Will's mutator method for gallery Id targets a string not a Uuid. Which is correct?
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
//	END OF ACCESSOR & MUTATOR imageGalleryId
//	START OF ACCESSOR & MUTATOR imageGalleryId
	/**
	 * @return Uuid value of the gallery Id
	 **/
	public function getImageGalleryId() : Uuid {
		return($this->imageGalleryId);
	}
	/**
	 * mutator method for image gallery id
	 *
	 * @param Uuid|string $newImageGalleryId new value of image gallrey id
	 * @throws \RangeException if $newImageGalleryId is not positive
	 * @throws \TypeError if $newImageGalleryId is not a uuid or string
	 **/
//	FIXME noticed that Will's mutator may have an error, the "public function setGalleryProfileId ($newGalleryId)" s.b. "($newGalleryProfileId)
	public function setImageGalleryId( $newImageGalleryId) : void {
		try {
			$uuid = self::validateUuid($newImageGalleryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the author id
		$this->imageGalleryId = $uuid;
	}
//	//	END OF ACCESSOR & MUTATOR imageProfileId
//	START OF ACCESSOR & MUTATOR imageProfileId
	/**
	 * @return Uuid value of the profile Id
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
		// convert and store the author id
		$this->imageProfileId = $uuid;
	}
//	//	END OF ACCESSOR & MUTATOR imageProfileId
	//	START OF ACCESSOR & MUTATOR imageDate
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
	//	START OF ACCESSOR & MUTATOR imageTitle
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
}
//	START OF ACCESSOR & MUTATOR imageUrl
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
 * @throws \RangeException if $newImageUrl is > 128 characters
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
	if(strlen($newImageUrl) > 128) {
		throw(new \RangeException("image Url too large"));
	}
	// store the image Url
	$this->imageUrl = $newImageUrl;
}
//	END OF ACCESSOR & MUTATOR imageUrl

/***********************************************************************************************************************
 * START OF THE UNIT TESTING
 *****************************************************************************************************************/
/**
 * inserts this profile into mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function insert(\PDO $pdo) : void {

	// create query template
	$query = "INSERT INTO Profile(profileId, profileActivationToken, profileDate, profileEmail, profileLocation, profileName, profilePassword, profileWebsite) VALUES(:profileId, :profileActivationToken, :profileDate, :profileEmail, :profileLocation, :profileName, :profilePassword, :profileWebsite)";
	$statement = $pdo->prepare($query);

	// bind the member variables to the place holder in the template
	$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken, "profileDate" => $this->profileDate, "profileEmail" => $this->profileEmail, "profileLocation" => $this->profileLocation, "profileName" => $this->profileName, "profilePassword" => $this->profilePassword, "profileWebsite" => $this->profileWebsite];
	$statement->execute($parameters);
}

/**
 * deletes this profile from mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function delete(\PDO $pdo) : void {

	// create query template
	$query = "DELETE FROM Profile WHERE profileId = :profileId";
	$statement = $pdo->prepare($query);

	// bind the member variables to the place holder in the template
	$parameters = ["profileId" => $this->profileId->getBytes()];
	$statement->execute($parameters);
}

/**
 * updates this profile in mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function update(\PDO $pdo) : void {

	// create query template
	$query = "UPDATE Profile SET profileId = :profileId, profileActivationToken = :profileActivationToken, profileDate = :profileDate, profileEmail = :profileEmail, profileLocation = :profileLocation, profileName = :profileName, profilePassword = :profilePassword, profileWebsite = :profileWebsite WHERE profileId = :profileId";
	$statement = $pdo->prepare($query);

	// bind the member variables to the place holder in the template
	$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken, "profileDate" => $this->profileDate, "profileEmail" => $this->profileEmail, "profileLocation" => $this->profileLocation, "profileName" => $this->profileName, "profilePassword" => $this->profilePassword, "profileWebsite" => $this->profileWebsite];
	$statement->execute($parameters);
}

/**
 * gets the profile by profileId
 *
 * @param \PDO $pdo PDO connection object
 * @param Uuid|string $profileId profile id to search for
 * @return profile|null profile found or null if not found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when a variable are not the correct data type
 **/
public static function getProfileByProfileId(\PDO $pdo, $profileId) : ?Profile {
	// sanitize the profileId before searching
	try {
		$profileId = self::validateUuid($profileId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}

	// create query template
	$query = "SELECT profileId, profileActivationToken, profileDate, profileEmail, profileLocation, profileName, profilePassword, profileWebsite FROM Profile WHERE profileId = :profileId";
	$statement = $pdo->prepare($query);

	// bind the profile id to the place holder in the template
	$parameters = ["profileId" => $profileId->getBytes()];
	$statement->execute($parameters);

	// grab the profile from mySQL
	try {
		$profile = null;
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		if($row !== false) {
			$profile = new Profile($row["profileActivationToken"], $row["profileDate"], $row["profileEmail"], $row["profileLocation"], $row["profileName"], $row["profilePassword"], $row["profileWebsite"]);
		}
	} catch(\Exception $exception) {
		// if the row couldn't be converted, rethrow it
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}
	return($profile);
}

/**
 * gets all profiles
 *
 * @param \PDO $pdo PDO connection object
 * @return \SplFixedArray SplFixedArray of profiles found or null if not found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getAllProfiles\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT profileId, profileActivationToken, profileDate, profileEmail, profileLocation, profileName, profilePassword, profileWebsite FROM Profile";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of profiles
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileActivationToken"], $row["profileDate"], $row["profileEmail"], $row["profileLocation"], $row["profileName"], $row["profilePassword"], $row["profileWebsite"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profiles);
	}
/**
 * formats the state variables for JSON serialization
 *
 * @return array resulting state variables to serialize
 **/
public function jsonSerialize() {
	$fields = get_object_vars($this);
	$fields["profileId"] = $this->profileId->toString();

	//format the date so that the front end can consume it
	$fields["profileDate"] = round(floatval($this->profileDate->format("U.u")) * 1000);
	return ($fields);

}
}}
