*<?php
namespace Wisengard\ArtLocale;

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
  * Activation token for intial profile creation
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
  * Location of profile owner
  * @var string $profileLocation;
  **/
  private $profileLocation;
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
   * @param string $newProfileLocation location for profile owner
   * @param string $newProfileName name of profile owner
   * @param string $newProfilePassword hashed Locationpassword for profile
   * @param string $newProfileWebsite profile owner's website
   * @throws \InvalidArgumentException if data types are not valid
   * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
   * @throws \TypeError if data types violate type hints
   * @throws \Exception if some other exception occurs
   * @Documentation https://php.net/manual/en/language.oop5.decon.php
   **/
	 public function __construct($newProfileId, string $newProfileActivationToken, string $newProfileDate, string $newProfileEmail, string $newProfileLocation, string $newProfileName, string $newProfilePassword, string $newProfileWebsite) {
		 try {
			 	$this->setProfileId($newProfileId);
			 	$this->setProfileActivationToken($newProfileActivationToken);
				$this->setProfileDate($newProfileDate);
				$this->setProfileEmail($newProfileEmail);
				$this->setProfileLocation($newProfileLocation);
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
		public function setProfileId( $newProfileId) : void {
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
		public function getProfileActivationToken() : string {
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
		public function setProfileActivationToken(string $newProfileActivationToken) : void {
			// verify the activation token content is secure
			$newProfileActivationToken = trim($newProfileActivationToken);
			$newProfileActivationToken = filter_var($newProfileActivationToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newProfileActivationToken) === true) {
				throw(new \InvalidArgumentException("activation token is empty or insecure"));
			}
			// verify the activation token will fit in the database
			if(strlen($newProfileActivationToken) > 32) {
				throw(new \RangeException("activation token too large"));
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
		 * @param \DateTime|string $newProfileDate new value of profile date as a DateTime object
		 * @throws \InvalidArgumentException if $newProfileDate is not a string or insecure
		 * @throws \RangeException if $newProfileDate is a date that does not exist
		 **/
		public function setProfileDate($newProfileDate = null) : void {
			// base case: if the date is null, use the current date and time
			if($newProfileDate === null) {
					$this->profileDate = new \DateTime();
					return;
			}
			// store the profile date using the ValidateDate trait
			try {
			$newProfileDate = self::validateDateTime($newProfileDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
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
		 * @throws \InvalidArgumentException if $newProfileEmail is not a string or insecure
		 * @throws \RangeException if $newProfileEmail is > 128 characters
		 * @throws \TypeError if $newProfileEmail is not a string
		 **/
		public function setProfileEmail(string $newProfileEmail) : void {
			// verify the profile email content is secure
			$newProfileEmail = trim($newProfileEmail);
			$newProfileEmail = filter_var($newProfileEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
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

/** profileLocation**/

		/**
		 * accessor method for profile location
		 *
		 * @return string value of profile location
		 **/
		public function getProfileLocation() : string {
			return($this->profileLocation);
		}
		/**
		 * mutator method for profile location
		 *
		 * @param string $newProfileLocation new value of profile location
		 * @throws \InvalidArgumentException if $newProfileLocation is not a string or insecure
		 * @throws \RangeException if $newProfileLocation is > 128 characters
		 * @throws \TypeError if $newProfileLocation is not a string
		 **/
		public function setProfileLocation(string $newProfileLocation) : void {
			// verify the profile location content is secure
			$newProfileLocation = trim($newProfileLocation);
			$newProfileLocation = filter_var($newProfileLocation, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newProfileLocation) === true) {
				throw(new \InvalidArgumentException("profile location is empty or insecure"));
			}
			// verify the profile location will fit in the database
			if(strlen($newProfileLocation) > 128) {
				throw(new \RangeException("profile location too large"));
			}
			// store the profile location
			$this->profileLocation = $newProfileLocation;
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
		 * @throws \InvalidArgumentException if $newProfilePassword is not a string or insecure
		 * @throws \RangeException if $newProfilePassword is > 140 characters
		 * @throws \TypeError if $newProfilePassword is not a string
		 **/
		public function setProfilePassword(string $newProfilePassword) : void {
			// verify the profile password content is secure
			$newProfileName = trim($newProfilePassword);
			$newProfileName = filter_var($newProfilePassword, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newProfilePassword) === true) {
				throw(new \InvalidArgumentException("profile password is empty or insecure"));
			}
			// verify the profile password will fit in the database
			if(strlen($newProfilePassword) > 140) {
				throw(new \RangeException("profile password too large"));
			}
			// store the profile password
			$this->profileName = $newProfilePassword;
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
		 * @throws \RangeException if $newProfileWebsite is > 128 characters
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
			if(strlen($newProfileWebsite) > 128) {
				throw(new \RangeException("profile website url too large"));
			}
			// store the profile website url
			$this->profileWebsite = $newProfileWebsite;
		}
