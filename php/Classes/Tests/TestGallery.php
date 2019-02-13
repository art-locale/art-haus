<?php
namespace ArtLocale\ArtHaus\Tests;

use ArtLocale\ArtHaus\Profile;

// access the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// access the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Gallery class
 *
 * This is a complete PHPUnit test of the Gallery class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Profile
 * @author Jaeren William Tredway <jwilliamtredway@gmail.com>
 **/

//	galleryId BINARY(16) NOT NULL,
//	galleryProfileId BINARY(16) NOT NULL,
//	galleryDate DATETIME(6) NOT NULL,
//	galleryName VARCHAR(32) NOT NULL

class TestGallery extends ArtHausTest {
	/**
	 * valid Art Haus gallery
	 * @var Gallery gallery
	 **/
	protected $gallery = null;

	/**
	 * id for this gallery
	 * @var Uuid $VALID_GALLERYID
	 */
	protected $VALID_GALLERYID;

	/**
	 * id for this gallery
	 * @var Uuid $VALID_GALLERYID
	 */
	protected $VALID_GALLERYID;

	/**
	 * Date and time profile was created- this starts as null and is assigned later
	 * @var \DateTime $VALID_PROFILEDATE
	 **/
	protected $VALID_PROFILEDATE;

	/**
	 * Valid timestamp to use as sunriseProfileDate
	 */
	protected $VALID_SUNRISEDATE = null;

	/**
	 * Valid timestamp to use as sunsetProfileDate
	 */
	protected $VALID_SUNSETDATE = null;

	/**
	 * valid email address for profile owner
	 * @var string $VALID_PROFILEEMAIL
	 **/
	protected $VALID_PROFILEEMAIL = "test@test.com";

	/**
	 * updated email address
	 * @var string $VALID_PROFILEEMAIL2
	 **/
	protected $VALID_PROFILEEMAIL2 = "newtest@test.com";

	/**
	 * Latitude of profile owner- Temp set to city
	 * @var float $VALID_PROFILELATITUDE
	 **/
	protected $VALID_PROFILELATITUDE = "75";

	/**
	 * New latitude of profile owner- Temp set to city
	 * @var float $VALID_PROFILELATITUDE2
	 **/
	protected $VALID_PROFILELATITUDE2 = "35";

	/**
	 * longitude of profile owner- Temp set to city
	 * @var float $VALID_PROFILELONGITUDE
	 **/
	protected $VALID_PROFILELONGITUDE = "50";

	/**
	 * New logitude of profile owner- Temp set to city
	 * @var float $VALID_PROFILELONGITUDE2
	 **/
	protected $VALID_PROFILELONGITUDE2 = "30";

	/**
	 * valid name of profile owner
	 * @var string $VALID_PROFILENAME
	 **/
	protected $VALID_PROFILENAME = "Jane Doe";

	/**
	 * updated profile name
	 * @var string $VALID_PROFILENAME2
	 **/
	protected $VALID_PROFILENAME2 = "John Doe";

	/**
	 * hash of profile owner account password
	 * @var string $VALID_PROFILEPASSWORD
	 **/
	protected $VALID_PROFILEPASSWORD;

	/**
	 * updated hash of profile owner account password
	 * @var string $VALID_PROFILEPASSWORD2
	 **/
	protected $VALID_PROFILEPASSWORD2;

	/**
	 * website of profile owner
	 * @var string $VALID_PROFILEWEBSITE
	 **/
	protected $VALID_PROFILEWEBSITE = "www.etsy.com";

	/**
	 * updated website of profile owner
	 * @var string $VALID_PROFILEWEBSITE2
	 **/
	protected $VALID_PROFILEWEBSITE2 = "www.linkedin.com";

	/**
	 * setup operation to create hash and salt.
	 */
	public final function setUp(): void {
		parent::setUp();
		//
		$password = "password1234";
		$this->VALID_PROFILEPASSWORD = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_PROFILEACTIVATIONTOKEN = bin2hex(random_bytes(16));
		$this->VALID_PROFILEDATE = new \DateTime();
	}

	//     // calculate the date (just use the time the unit test was setup...)
	//   $this->VALID_PROFILEDATE = new \DateTime();

	/**
	 * test creating a valid profile
	 **/
	public function testCreateProfile(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		// create a new Profile and insert into database
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILEACTIVATIONTOKEN, $this->VALID_PROFILEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILELATITUDE, $this->VALID_PROFILELONGITUDE, $this->VALID_PROFILENAME, $this->VALID_PROFILEPASSWORD, $this->VALID_PROFILEWEBSITE);
		$profile->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILEACTIVATIONTOKEN);
		$this->assertEquals($pdoProfile->getProfileDate()->getTimestamp(), $this->VALID_PROFILEDATE->getTimeStamp());
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILEEMAIL);
		$this->assertEquals($pdoProfile->getProfileLatitude(), $this->VALID_PROFILELATITUDE);
		$this->assertEquals($pdoProfile->getProfileLongitude(), $this->VALID_PROFILELONGITUDE);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILENAME);
		$this->assertEquals($pdoProfile->getProfilePassword(), $this->VALID_PROFILEPASSWORD);
		$this->assertEquals($pdoProfile->getProfileWebsite(), $this->VALID_PROFILEWEBSITE);
	}
}