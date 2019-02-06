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
  * Date profile was created
  * @var string $profileDate;
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
  * Profile owner account password
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
   * @param string $newProfileDate date profile was activated
   * @param string $newProfileEmail email address for new profile
   * @param string $newProfileLocation location for profile owner
   * @param string $newProfileName name of profile owner
   * @param string $newProfilePassword password for profile
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
			// convert and store the author id
			$this->profileId = $uuid;
		}
