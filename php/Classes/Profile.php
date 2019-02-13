<?php
namespace ArtLocale\ArtHaus;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Framework for Profile class
 *
 * @author William Isengard <wisengard@cnm.edu>
 * @version 1.0.0
 **/

class Profile implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
	/**
	 * id for this profile; this is the primary key
	 * @var Uuid $profileId
	 **/
	private $profileId;
  /**
  * Activation token for initial profile creation
  * @var string $profileActivationToken
  **/
  Private $profileActivationToken;
  /**
  * Date and time profile was created, in a PHP DateTime object
  * @var \DateTime $profileDate;
  **/
  private $profileDate;
  /**
  * Email address for profile owner
  * @var string $profileEmail;
  **/
  private $profileEmail;
  /**
  * Latitude location of profile owner
  * @var float $profileLatitude;
  **/
  private $profileLatitude;
  /**
  * Longitude location of profile owner
  * @var float $profileLongitude;
  **/
	private $profileLongitude;
	/**
	 * Name of profile owner
	 * @var string $profileName;
	 **/
  private $profileName;
  /**
  * Hash of profile owner account password
  * @var string $profilePassword;
  **/
  private $profilePassword;
  /**
  * Website of profile owner
  * @var string $profileWebsite;
  **/
  private $profileWebsite;
  /**
   * constructor for this
   * @param Uuid|string $newProfileId new id of this profile or null if a new profile
   * @param string $newProfileActivationToken activation token for a new profile
   * @param \DateTime|string|null $newProfileDate date and time profile was activated
   * @param string $newProfileEmail email address for new profile
   * @param float $newProfileLatitude latitude of this profile owner's location
	 * @param float $newProfileLongitude longitude of this profile owner's location
   * @param string $newProfileName name of profile owner
   * @param string $newProfilePassword hashed password for profile
   * @param string $newProfileWebsite profile owner's website
   * @throws \InvalidArgumentException if data types are not valid
   * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
   * @throws \TypeError if data types violate type hints
   * @throws \Exception if some other exception occurs
   * @Documentation https://php.net/manual/en/language.oop5.decon.php
   **/
	 public function __construct($newProfileId, ?string $newProfileActivationToken, $newProfileDate = null, string $newProfileEmail, float $newProfileLatitude, float $newProfileLongitude, string $newProfileName, string $newProfilePassword, string $newProfileWebsite) {
		 try {
			 	$this->setProfileId($newProfileId);
			 	$this->setProfileActivationToken($newProfileActivationToken);
				$this->setProfileDate($newProfileDate);
				$this->setProfileEmail($newProfileEmail);
				$this->setProfileLatitude($newProfileLatitude);
				$this->setProfileLongitude($newProfileLongitude);
				$this->setProfileName($newProfileName);
				$this->setProfilePassword($newProfilePassword);
				$this->setProfileWebsite($newProfileWebsite);
		 }
			 //determine what exception type was thrown
		 catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			 $exceptionType = get_class($exception);
			 throw(new $exceptionType($exception->getMessage(), 0, $exception));
		 }
	 }

/** profileId **/

	 /**
		* accessor method for profile id
		*
		* @return Uuid value of profile id
		**/
	 public function getProfileId() : Uuid {
		 return($this->profileId);
	 }
	 /**
		* mutator method for profile id
		*
		* @param Uuid|string $newProfileId new value of profile id
		* @throws \RangeException if $newProfileId is not positive
		* @throws \TypeError if $newProfileId is not a uuid or string
		**/
		public function setProfileId($newProfileId) : void {
			try {
				$uuid = self::validateUuid($newProfileId);
			} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
				$exceptionType = get_class($exception);
				throw(new $exceptionType($exception->getMessage(), 0, $exception));
			}
			// convert and store the profile id
			$this->profileId = $uuid;
		}

/** profileActivationToken **/

		/**
		 * accessor method for activation token
		 *
		 * @return string value of activation token
		 **/
		public function getProfileActivationToken() : ?string {
			return($this->profileActivationToken);
		}
		/**
		 * mutator method for activation token
		 *
		 * @param string $newProfileActivationToken new value of activation token
		 * @throws \InvalidArgumentException if $newProfileActivationToken is not a string or insecure
		 * @throws \RangeException if $newProfileActivationToken is > 32 characters
		 * @throws \TypeError if $newProfileActivationToken is not a string
		 **/
		public function setProfileActivationToken(?string $newProfileActivationToken) : void {
			if($newProfileActivationToken === null) {
				$this->profileActivationToken = null;
				return;
			}
			$newProfileActivationToken = strtolower(trim($newProfileActivationToken));
			if(ctype_xdigit($newProfileActivationToken) === false) {
				throw(new\RangeException("user activation is not valid"));
			}
			//make sure user activation token is 32 characters
			if(strlen($newProfileActivationToken) !== 32) {
				throw(new\RangeException("user activation token has to be 32"));
			}
			// store the activation token
			$this->profileActivationToken = $newProfileActivationToken;
		}

/** profileDate **/

		/**
		 * accessor method for profile date
		 *
		 * @return \DateTime value of profile date
		 **/
		public function getProfileDate() : \DateTime {
			return($this->profileDate);
		}
		/**
		 * mutator method for profile date
		 *
		 * @param \DateTime|string|null $newProfileDate new value of profile date as a DateTime object
		 * @throws \InvalidArgumentException if $newProfileDate is not a string or insecure
		 * @throws \RangeException if $newProfileDate is a date that does not exist
		 * @throws \TypeError if $newProfileDate is not a string
		 * @throws \Exception if $newProfileDate throws a generic exception
		 **/
		public function setProfileDate($newProfileDate = null) : void {
			// base case: if the date is null, use the current date and time
			if($newProfileDate === null) {
					$this->profileDate = new \DateTime();
					return;
			}
			// store the profile date using the ValidateDate trait.
			try {
			$newProfileDate = self::validateDate($newProfileDate);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->profileDate = $newProfileDate;
	}

/** profileEmail **/

		/**
		 * accessor method for profile email
		 *
		 * @return string value of profile email
		 **/
		public function getProfileEmail() : string {
			return($this->profileEmail);
		}
		/**
		 * mutator method for profile email
		 *
		 * @param string $newProfileEmail new value of profile email
		 * @throws \InvalidArgumentException if $newProfileEmail is not a valid email or insecure
		 * @throws \RangeException if $newProfileEmail is > 128 characters
		 * @throws \TypeError if $newProfileEmail is not a string
		 **/
		public function setProfileEmail(string $newProfileEmail) : void {
			// verify the profile email content is secure
			$newProfileEmail = trim($newProfileEmail);
			$newProfileEmail = filter_var($newProfileEmail, FILTER_VALIDATE_EMAIL);
			if(empty($newProfileEmail) === true) {
				throw(new \InvalidArgumentException("profile email is empty or insecure"));
			}
			// verify the profile email will fit in the database
			if(strlen($newProfileEmail) > 128) {
				throw(new \RangeException("profile email too large"));
			}
			// store the activation token
			$this->profileEmail = $newProfileEmail;
		}

/** profileLatitude**/

	/** accessor method for profile latitude
	 *
	 * @return float value of profile latitude
	 **/
	public function getProfileLatitude() : float {
		return($this->profileLatitude);
	}
	/** mutator method for profile latitude
	 *
	 * @param float $newProfileLatitude new value of profile latitude
	 * @throws \InvalidArgumentException if $newProfileLatitude is not a float or insecure
	 * @throws \RangeException if $newProfileLatitude is not within -90 to 90
	 * @throws \TypeError if $newProfileLatitude is not a float
	 **/
	public function setProfileLatitude(float $newProfileLatitude) : void {
		// verify if the latitude exists
		if(($newProfileLatitude) > 90) {
			throw(new \RangeException("profile latitude is not between -90 and 90"));
		}
		if (($newProfileLatitude) < -90) {
			throw(new \RangeException("profile latitude is not between -90 and 90"));
		}
		// store the latitude
		$this->profileLatitude = $newProfileLatitude;
	}

	/** profileLongitude**/

	/** accessor method for profile longitude
	 *
	 *
	 * @return float value of profile longitude
	 **/
	public function getProfileLongitude() : float {
		return($this->profileLongitude);
	}
	/** mutator method for profile longitude
	 *
	 * @param float $newProfileLongitude new value of profile longitude
	 * @throws \InvalidArgumentException if $newProfileLongitude is not a float or insecure
	 * @throws \RangeException if $newProfileLongitude is not within -180 to 180
	 * @throws \TypeError if $newProfileLongitude is not a float
	 **/
	public function setProfileLongitude(float $newProfileLongitude) : void {
		// verify the longitude exists
		if(($newProfileLongitude) > 180) {
			throw(new \RangeException("profile longitude is not between -180 and 180"));
		}
		if (($newProfileLongitude) < -180) {
			throw(new \RangeException("profile longitude is not between -180 and 180"));
		}
		// store the longitude
		$this->profileLongitude = $newProfileLongitude;
	}

/** profileName**/

		/**
		 * accessor method for profile name
		 *
		 * @return string value of profile name
		 **/
		public function getProfileName() : string {
			return($this->profileName);
		}
		/**
		 * mutator method for profile name
		 *
		 * @param string $newProfileName new value of profile name
		 * @throws \InvalidArgumentException if $newProfileName is not a string or insecure
		 * @throws \RangeException if $newProfileName is > 32 characters
		 * @throws \TypeError if $newProfileName is not a string
		 **/
		public function setProfileName(string $newProfileName) : void {
			// verify the profile name content is secure
			$newProfileName = trim($newProfileName);
			$newProfileName = filter_var($newProfileName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newProfileName) === true) {
				throw(new \InvalidArgumentException("profile name is empty or insecure"));
			}
			// verify the profile name will fit in the database
			if(strlen($newProfileName) > 32) {
				throw(new \RangeException("profile name too large"));
			}
			// store the profile name
			$this->profileName = $newProfileName;
		}

/** profilePassword**/

		/**
		 * accessor method for profile password
		 *
		 * @return string value of profile password
		 **/
		public function getProfilePassword() : string {
			return($this->profilePassword);
		}
		/**
		 * mutator method for profile password
		 *
		 * @param string $newProfilePassword new value of profile password
		 * @throws \InvalidArgumentException if $newProfilePassword is insecure
		 * @throws \RangeException if $newProfilePassword is > 97 characters
		 * @throws \TypeError if $newProfilePassword is not a string
		 **/
		public function setProfilePassword(string $newProfilePassword) : void {
			// verify the profile password is formatted correctly
			$newProfilePassword = trim($newProfilePassword);
			if(empty($newProfilePassword) === true) {
				throw(new \InvalidArgumentException("profile password is empty or insecure"));
			}
			//enforce the password is really an argon hash
			$profilePasswordInfo = password_get_info($newProfilePassword);
			if($profilePasswordInfo["algoName"] !== "argon2i") {
				throw(new \InvalidArgumentException("profile password is not a valid hash"));
			}

			// verify the profile password will fit in the database
			if(strlen($newProfilePassword) > 97) {
				throw(new \RangeException("profile password too large"));
			}
			// store the profile password
			$this->profilePassword = $newProfilePassword;
		}

/** profileWebsite*/

		/**
		 * accessor method for profile website url
		 *
		 * @return string value of profile website url
		 **/
		public function getProfileWebsite() : string {
			return($this->ProfileWebsite);
		}
		/**
		 * mutator method for profile website url
		 *
		 * @param string $newProfileWebsite new value of profile website url
		 * @throws \InvalidArgumentException if $newProfileWebsite is not a string or insecure
		 * @throws \RangeException if $newProfileWebsite is > 255 characters
		 * @throws \TypeError if $newProfileWebsite is not a string
		 **/
		public function setProfileWebsite(string $newProfileWebsite) : void {
			// verify the profile website url content is secure
			$newProfileWebsite = trim($newProfileWebsite);
			$newProfileWebsite = filter_var($newProfileWebsite, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newProfileWebsite) === true) {
				throw(new \InvalidArgumentException("profile website url is empty or insecure"));
			}
			// verify the profile website url will fit in the database
			if(strlen($newProfileWebsite) > 255) {
				throw(new \RangeException("profile website url too large"));
			}
			// store the profile website url
			$this->profileWebsite = $newProfileWebsite;
		}

/**
 * inserts this profile into mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function insert(\PDO $pdo) : void {

	// create query template
	$query = "INSERT INTO Profile(profileId, profileActivationToken, profileDate, profileEmail, profileLatitude, profileLongitude, profileName, profilePassword, profileWebsite) VALUES(:profileId, :profileActivationToken, :profileDate, :profileEmail, :profileLatitude, :profileLongitude, :profileName, :profilePassword, :profileWebsite)";
	$statement = $pdo->prepare($query);

	// bind the member variables to the place holder in the template
	$formattedDate = $this->profileDate->format("Y-m-d H:i:s.u");
	$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken, "profileDate" => $formattedDate, "profileEmail" => $this->profileEmail, "profileLatitude" => $this->profileLatitude, "profileLongitude" => $this->profileLongitude, "profileName" => $this->profileName, "profilePassword" => $this->profilePassword, "profileWebsite" => $this->profileWebsite];
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
	$query = "UPDATE Profile SET profileId = :profileId, profileActivationToken = :profileActivationToken, profileDate = :profileDate, profileEmail = :profileEmail, profileLatitude = :profileLatitude, profileLongitude = :profileLongitude, profileName = :profileName, profilePassword = :profilePassword, profileWebsite = :profileWebsite WHERE profileId = :profileId";
	$statement = $pdo->prepare($query);

	// bind the member variables to the place holder in the template
	$formattedDate = $this->profileDate->format("Y-m-d H:i:s.u");
	$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken, "profileDate" => $formattedDate, "profileEmail" => $this->profileEmail, "profileLatitude" => $this->profileLatitude, "profileLongitude" => $this->profileLongitude, "profileName" => $this->profileName, "profilePassword" => $this->profilePassword, "profileWebsite" => $this->profileWebsite];
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
	$query = "SELECT profileId, profileActivationToken, profileDate, profileEmail, profileLatitude, profileLongitude, profileName, profilePassword, profileWebsite FROM Profile WHERE profileId = :profileId";
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
			$profile = new Profile($row["profileActivationToken"], $row["profileDate"], $row["profileEmail"], $row["profileLatitude"], $row["profileLongitude"], $row["profileName"], $row["profilePassword"], $row["profileWebsite"]);
		}
	} catch(\Exception $exception) {
		// if the row couldn't be converted, rethrow it
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}
	return($profile);
}

/**
 * gets the profile by email
 *
 * @param \PDO $pdo PDO connection object
 * @param string $profileEmail profile email to search for
 * @return Profile|null profile found or null if not found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when a variable are not the correct data type
 **/
public static function getProfileByEmail(\PDO $pdo, string $profileEmail) : ?Profile {
	// sanitize the profileEmail before searching
	$profileEmail = trim($profileEmail);
	$profileEmail = filter_var($profileEmail, FILTER_VALIDATE_EMAIL);
	if(empty($profileEmail) === true) {
		throw(new \PDOException("not a valid email"));
	}

	// create query template
	$query = "SELECT profileId, profileActivationToken, profileDate, profileEmail, profileLatitude, profileLongitude, profileName, profilePassword, profileWebsite FROM Profile WHERE profileEmail = :profileEmail";
	$statement = $pdo->prepare($query);

	// bind the profile email to the placeholder in template
	$parameters = ["profileEmail" => $profileEmail];
	$statement->execute($parameters);

	// grab profile from database
	try {
		$profile = null;
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		if($row !== false) {
			$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileDate"], $row["profileEmail"], $row["profileLatitude"], $row["profileLongitude"], $row["profileName"], $row["profilePassword"], $row["profileWebsite"]);
		}
	} catch(\Exception $exception) {
		// if the row couldn't be converted, rethrow it
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}
	return($profile);
}

/**
 * gets the profile by activation token
 *
 * @param \PDO $pdo PDO connection object
 * @param string $profileActivationToken profile activation token to search for
 * @return Profile|null profile found or null if not found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when a variable are not the correct data type
 **/
public static function getProfileByProfileActivationToken(\PDO $pdo, string $profileActivationToken) : ?Profile {
	//verify activation token is in correct format and a string representation of hexidecimal
	$profileActivationToken = trim($profileActivationToken);
	if(ctype_xdigit($profileActivationToken) === false) {
		throw(new \InvalidArgumentException("activation token is empty or incorrect format"));
	}

 // create query template
 $query = "SELECT profileId, profileActivationToken, profileDate, profileEmail, profileLatitude, profileLongitude, profileName, profilePassword, profileWebsite FROM Profile WHERE profileActivationToken = :profileActivationToken";
 $statement = $pdo->prepare($query);

 // bind activation token to placeholder in template
 $parameters = ["profileActivationToken" => $profileActivationToken];
 $statement->execute($parameters);

 // grab profile from database
 try {
	 $profile = null;
	 $statement->setFetchMode(\PDO::FETCH_ASSOC);
	 $row = $statement->fetch();
	 if($row !== false) {
		 $profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileDate"], $row["profileEmail"], $row["profileLatitude"], $row["profileLongitude"], $row["profileName"], $row["profilePassword"], $row["profileWebsite"]);
	 }
 } catch(\Exception $exception) {
	 // if the row couldn't be converted, rethrow it
	 throw(new \PDOException($exception->getMessage(), 0, $exception));
 }
 return($profile);
}

/**
 * gets the profile by profile name
 *
 * @param \PDO $pdo PDO connection object
 * @param string $profileName profile name to search for
 * @return Profile|null profile found or null if not found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when a variable are not the correct data type
 **/
public static function getProfileByName(\PDO $pdo, string $profileName) : ?Profile {
	// sanitize the profileName before searching
	$profileName = trim($profileName);
	$profileName = filter_var($profileName, FILTER_VALIDATE_NAME);
	if(empty($profileName) === true) {
		throw(new \PDOException("not a valid name"));
	}

	// create query template
	$query = "SELECT profileId, profileActivationToken, profileDate, profileEmail, profileLatitude, profileLongitude, profileName, profilePassword, profileWebsite FROM Profile WHERE profileName = :profileName";
	$statement = $pdo->prepare($query);

	// bind the profile name to the placeholder in template
	$parameters = ["profileName" => $profileName];
	$statement->execute($parameters);

	// grab profile from database
	try {
		$profile = null;
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		if($row !== false) {
			$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileDate"], $row["profileEmail"], $row["profileLatitude"], $row["profileLongitude"], $row["profileName"], $row["profilePassword"], $row["profileWebsite"]);
		}
	} catch(\Exception $exception) {
		// if the row couldn't be converted, rethrow it
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}
	return($profile);
}

/**
 * TODO- Add get profile by Profile Distance getProfileByProfileDistance
 **/

/**
 * gets all profiles
 *
 * @param \PDO $pdo PDO connection object
 * @return \SplFixedArray SplFixedArray of profiles found or null if not found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getAllProfiles(\PDO $pdo) : \SPLFixedArray {
	// create query template
	$query = "SELECT profileId, profileActivationToken, profileDate, profileEmail, profileLatitude, profileLongitude, profileName, profilePassword, profileWebsite FROM Profile";
	$statement = $pdo->prepare($query);
	$statement->execute();

	// build an array of profiles
	$profiles = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while(($row = $statement->fetch()) !== false) {
		try {
			$profile = new Profile($row["profileActivationToken"], $row["profileDate"], $row["profileEmail"], $row["profileLatitude"], $row["profileLongitude"], $row["profileName"], $row["profilePassword"], $row["profileWebsite"]);
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
	unset($fields["profilePassword"]);
	$fields["profileDate"] = round(floatval($this->profileDate->format("U.u")) * 1000);
	return ($fields);

}
}

//---------------------------------------------------------------//

<?php
namespace Edu\Cnm\DataDesign;
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;
/**
 * Cross Section of a Twitter Profile
 *
 * This is a cross section of what is probably stored about a Twitter user. This entity is a top level entity that
 * holds the keys to the other entities in this example (i.e., Favorite and Profile).
 *
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 * @version 4.0.0
 **/
class Profile implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for this Profile; this is the primary key
	 * @var Uuid $profileId
	 **/
	private $profileId;
	/**
	 * at handle for this Profile; this is a unique index
	 * @var string $profileAtHandle
	 **/
	private $profileAtHandle;
	/**
	 * token handed out to verify that the profile is valid and not malicious.
	 * @var $profileActivationToken
	 **/
	private $profileActivationToken;
	/**
	 * Cloudinary id for this Profile; this is a unique index
	 * @var string $profileAtHandle
	 **/
	private $profileAvatarUrl;
	/**
	 * email for this Profile; this is a unique index
	 * @var string $profileEmail
	 **/
	private $profileEmail;
	/**
	 * hash for profile password
	 * @var $profileHash
	 **/
	private $profileHash;
	/**
	 * phone number for this Profile
	 * @var string $profilePhone
	 **/
	private $profilePhone;
	/**
	 * constructor for this Profile
	 *
	 * @param string|Uuid $newProfileId id of this Profile or null if a new Profile
	 * @param string $newProfileActivationToken activation token to safe guard against malicious accounts
	 * @param string $newProfileAtHandle string containing newAtHandle
	 * @param string $newProfileAvatarUrl string containing newAtHandle can be null
	 * @param string $newProfileEmail string containing email
	 * @param string $newProfileHash string containing password hash
	 * @param string $newProfilePhone string containing phone number
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if a data type violates a data hint
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newProfileId, ?string $newProfileActivationToken, string $newProfileAtHandle, string $newProfileAvatarUrl, string $newProfileEmail, string $newProfileHash, ?string $newProfilePhone) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileAtHandle($newProfileAtHandle);
			$this->setProfileAvatarUrl($newProfileAvatarUrl);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileHash($newProfileHash);
			$this->setProfilePhone($newProfilePhone);
		} catch(\InvalidArgumentException | \RangeException |\TypeError | \Exception $exception) {
			//determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for profile id
	 *
	 * @return Uuid value of profile id (or null if new Profile)
	 **/
	public function getProfileId(): Uuid {
		return ($this->profileId);
	}
	/**
	 * mutator method for profile id
	 *
	 * @param  Uuid| string $newProfileId value of new profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if the profile Id is not
	 **/
	public function setProfileId($newProfileId): void {
		try {
			$uuid = self::validateUuid($newProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->profileId = $uuid;
	}
	/**
	 * accessor method for account activation token
	 *
	 * @return string value of the activation token
	 */
	public function getProfileActivationToken() : ?string {
		return ($this->profileActivationToken);
	}
	/**
	 * mutator method for account activation token
	 *
	 * @param string $newProfileActivationToken
	 * @throws \InvalidArgumentException  if the token is not a string or insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 */
	public function setProfileActivationToken(?string $newProfileActivationToken): void {
		if($newProfileActivationToken === null) {
			$this->profileActivationToken = null;
			return;
		}
		$newProfileActivationToken = strtolower(trim($newProfileActivationToken));
		if(ctype_xdigit($newProfileActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}
		//make sure user activation token is only 32 characters
		if(strlen($newProfileActivationToken) !== 32) {
			throw(new\RangeException("user activation token has to be 32"));
		}
		$this->profileActivationToken = $newProfileActivationToken;
	}
	/**
	 * accessor method for at handle
	 *
	 * @return string value of at handle
	 **/
	public function getProfileAtHandle(): string {
		return ($this->profileAtHandle);
	}
	/**
	 * mutator method for at handle
	 *
	 * @param string $newProfileAtHandle new value of at handle
	 * @throws \InvalidArgumentException if $newAtHandle is not a string or insecure
	 * @throws \RangeException if $newAtHandle is > 32 characters
	 * @throws \TypeError if $newAtHandle is not a string
	 **/
	public function setProfileAtHandle(string $newProfileAtHandle) : void {
		// verify the at handle is secure
		$newProfileAtHandle = trim($newProfileAtHandle);
		$newProfileAtHandle = filter_var($newProfileAtHandle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileAtHandle) === true) {
			throw(new \InvalidArgumentException("profile at handle is empty or insecure"));
		}
		// verify the at handle will fit in the database
		if(strlen($newProfileAtHandle) > 32) {
			throw(new \RangeException("profile at handle is too large"));
		}
		// store the at handle
		$this->profileAtHandle = $newProfileAtHandle;
	}
	/**
	 * accessor method for profile avatar url
	 * @return string value of the activation token
	 */
	public function getProfileAvatarUrl() : string {
		return($this->profileAvatarUrl);
	}
	/**
	 * mutator method for at handle
	 *
	 * @param string $newProfileAvatarUrl new value of profile avatar URL
	 * @throws \InvalidArgumentException if $newProfileAvatarUrl is not a string or insecure
	 * @throws \RangeException if $newProfileAvatarUrl is > 255 characters
	 * @throws \TypeError if $newAtHandle is not a string
	 **/
	public function setProfileAvatarUrl(string $newProfileAvatarUrl) : void {
		$newProfileAvatarUrl = trim($newProfileAvatarUrl);
		$newProfileAvatarUrl = filter_var($newProfileAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		// verify the avatar URL will fit in the database
		if(strlen($newProfileAvatarUrl) > 255) {
			throw(new \RangeException("image cloudinary content too large"));
		}
		// store the image cloudinary content
		$this->profileAvatarUrl = $newProfileAvatarUrl;
	}
	/**
	 * accessor method for email
	 *
	 * @return string value of email
	 **/
	public function getProfileEmail(): string {
		return $this->profileEmail;
	}
	/**
	 * mutator method for email
	 *
	 * @param string $newProfileEmail new value of email
	 * @throws \InvalidArgumentException if $newEmail is not a valid email or insecure
	 * @throws \RangeException if $newEmail is > 128 characters
	 * @throws \TypeError if $newEmail is not a string
	 **/
	public function setProfileEmail(string $newProfileEmail): void {
		// verify the email is secure
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("profile email is empty or insecure"));
		}
		// verify the email will fit in the database
		if(strlen($newProfileEmail) > 128) {
			throw(new \RangeException("profile email is too large"));
		}
		// store the email
		$this->profileEmail = $newProfileEmail;
	}
	/**
	 * accessor method for profileHash
	 *
	 * @return string value of hash
	 */
	public function getProfileHash(): string {
		return $this->profileHash;
	}
	/**
	 * mutator method for profile hash password
	 *
	 * @param string $newProfileHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if profile hash is not a string
	 */
	public function setProfileHash(string $newProfileHash): void {
		//enforce that the hash is properly formatted
		$newProfileHash = trim($newProfileHash);
		if(empty($newProfileHash) === true) {
			throw(new \InvalidArgumentException("profile password hash empty or insecure"));
		}
		//enforce the hash is really an Argon hash
		$profileHashInfo = password_get_info($newProfileHash);
		if($profileHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("profile hash is not a valid hash"));
		}
		//enforce that the hash is exactly 97 characters.
		if(strlen($newProfileHash) !== 97) {
			throw(new \RangeException("profile hash must be 97 characters"));
		}
		//store the hash
		$this->profileHash = $newProfileHash;
	}
	/**
	 * accessor method for phone
	 *
	 * @return string value of phone or null
	 **/
	public function getProfilePhone(): ?string {
		return ($this->profilePhone);
	}
	/**
	 * mutator method for phone
	 *
	 * @param string $newProfilePhone new value of phone
	 * @throws \InvalidArgumentException if $newPhone is not a string or insecure
	 * @throws \RangeException if $newPhone is > 32 characters
	 * @throws \TypeError if $newPhone is not a string
	 **/
	public function setProfilePhone(?string $newProfilePhone): void {
		//if $profilePhone is null return it right away
		if($newProfilePhone === null) {
			$this->profilePhone = null;
			return;
		}
		// verify the phone is secure
		$newProfilePhone = trim($newProfilePhone);
		$newProfilePhone = filter_var($newProfilePhone, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfilePhone) === true) {
			throw(new \InvalidArgumentException("profile phone is empty or insecure"));
		}
		// verify the phone will fit in the database
		if(strlen($newProfilePhone) > 32) {
			throw(new \RangeException("profile phone is too large"));
		}
		// store the phone
		$this->profilePhone = $newProfilePhone;
	}
	/**
	 * inserts this Profile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		// create query template
		$query = "INSERT INTO profile(profileId, profileActivationToken, profileAtHandle, profileAvatarUrl,  profileEmail, profileHash, profilePhone) VALUES (:profileId, :profileActivationToken, :profileAtHandle, :profileAvatarUrl, :profileEmail, :profileHash, :profilePhone)";
		$statement = $pdo->prepare($query);
		$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken, "profileAtHandle" => $this->profileAtHandle, "profileAvatarUrl" => $this->profileAvatarUrl, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash,"profilePhone" => $this->profilePhone];
		$statement->execute($parameters);
	}
	/**
	 * deletes this Profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		// create query template
		$query = "DELETE FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holders in the template
		$parameters = ["profileId" => $this->profileId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * updates this Profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public function update(\PDO $pdo): void {
		// create query template
		$query = "UPDATE profile SET profileActivationToken = :profileActivationToken, profileAtHandle = :profileAtHandle, profileAvatarUrl = :profileAvatarUrl,profileEmail = :profileEmail, profileHash = :profileHash, profilePhone = :profilePhone WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken, "profileAtHandle" => $this->profileAtHandle, "profileAvatarUrl" => $this->profileAvatarUrl, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profilePhone" => $this->profilePhone];
		$statement->execute($parameters);
	}
	/**
	 * gets the Profile by profile id
	 *
	 * @param \PDO $pdo $pdo PDO connection object
	 * @param  $profileId profile Id to search for (the data type should be mixed/not specified)
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getProfileByProfileId(\PDO $pdo, $profileId):?Profile {
		// sanitize the profile id before searching
		try {
			$profileId = self::validateUuid($profileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT profileId, profileActivationToken, profileAtHandle, profileAvatarUrl, profileEmail, profileHash, profilePhone FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		// bind the profile id to the place holder in the template
		$parameters = ["profileId" => $profileId->getBytes()];
		$statement->execute($parameters);
		// grab the Profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"], $row["profileAvatarUrl"],$row["profileEmail"], $row["profileHash"], $row["profilePhone"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}
	/**
	 * gets the Profile by email
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileEmail email to search for
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileEmail(\PDO $pdo, string $profileEmail): ?Profile {
		// sanitize the email before searching
		$profileEmail = trim($profileEmail);
		$profileEmail = filter_var($profileEmail, FILTER_VALIDATE_EMAIL);
		if(empty($profileEmail) === true) {
			throw(new \PDOException("not a valid email"));
		}
		// create query template
		$query = "SELECT profileId, profileActivationToken, profileAtHandle, profileAvatarUrl, profileEmail, profileHash, profilePhone FROM profile WHERE profileEmail = :profileEmail";
		$statement = $pdo->prepare($query);
		// bind the profile id to the place holder in the template
		$parameters = ["profileEmail" => $profileEmail];
		$statement->execute($parameters);
		// grab the Profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"], $row["profileAvatarUrl"], $row["profileEmail"], $row["profileHash"], $row["profilePhone"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}
	/**
	 * gets the Profile by at handle
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileAtHandle at handle to search for
	 * @return \SPLFixedArray of all profiles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileAtHandle(\PDO $pdo, string $profileAtHandle) : \SPLFixedArray {
		// sanitize the at handle before searching
		$profileAtHandle = trim($profileAtHandle);
		$profileAtHandle = filter_var($profileAtHandle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileAtHandle) === true) {
			throw(new \PDOException("not a valid at handle"));
		}
		// create query template
		$query = "SELECT  profileId, profileActivationToken, profileAtHandle, profileAvatarUrl, profileEmail, profileHash, profilePhone FROM profile WHERE profileAtHandle = :profileAtHandle";
		$statement = $pdo->prepare($query);
		// bind the profile at handle to the place holder in the template
		$parameters = ["profileAtHandle" => $profileAtHandle];
		$statement->execute($parameters);
		$profiles = new \SPLFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while (($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"], $row["profileAvatarUrl"], $row["profileEmail"], $row["profileHash"], $row["profilePhone"]);
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
	 * get the profile by profile activation token
	 *
	 * @param string $profileActivationToken
	 * @param \PDO object $pdo
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public
	static function getProfileByProfileActivationToken(\PDO $pdo, string $profileActivationToken) : ?Profile {
		//make sure activation token is in the right format and that it is a string representation of a hexadecimal
		$profileActivationToken = trim($profileActivationToken);
		if(ctype_xdigit($profileActivationToken) === false) {
			throw(new \InvalidArgumentException("profile activation token is empty or in the wrong format"));
		}
		//create the query template
		$query = "SELECT  profileId, profileActivationToken, profileAtHandle, profileAvatarUrl, profileEmail, profileHash, profilePhone FROM profile WHERE profileActivationToken = :profileActivationToken";
		$statement = $pdo->prepare($query);
		// bind the profile activation token to the placeholder in the template
		$parameters = ["profileActivationToken" => $profileActivationToken];
		$statement->execute($parameters);
		// grab the Profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"], $row["profileAvatarUrl"], $row["profileEmail"], $row["profileHash"], $row["profilePhone"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["profileId"] = $this->profileId->toString();
		unset($fields["profileActivationToken"]);
		unset($fields["profileHash"]);
		return ($fields);
	}
}
