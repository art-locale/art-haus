<?php
namespace Edu\Cnm\ArtHaus\ArtHausTest;

use Edu\Cnm\ArtHaus\Profile;

// access the class under scrutiny
require_once(dirname(__DIR__, 1) . "/autoload.php");

// access the uuid generator
require_once(dirname(__DIR__, 1) . "lib/uuid.php");

/**
 * Full PHPUnit test for the Profile class
 *
 * This is a complete PHPUnit test of the Profile class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Profile
 * @author William Isengard <william.isengard@gmail.com>
 **/

 class ProfileTest extends ArtHausTest {
 	/**
 	 * valid Art Haus user profile
 	 * @var Profile profile
 	 **/
 	protected $profile = null;

 	/**
 	 * id for this profile
 	 * @var Uuid $VALID_PROFILEID
 	 */
 	protected $VALID_PROFILEID;

 	/**
 	 * placeholder activation token for initial profile creation
 	 * @var string $VALID_PROFILEACTIVATIONTOKEN
 	 **/
 	protected $VALID_PROFILEACTIVATIONTOKEN;

 	/**
 	 * Date and time profile was created- this starts as null and is assigned later
 	 * @var \DateTime $VALID_PROFILEDATE
 	 **/
 	protected $VALID_PROFILEDATE = null;

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
   * Location of profile owner- Temp set to city
   * @var string $VALID_PROFILELOCATION
   **/
  protected $VALID_PROFILELOCATION = "Albuquerque";

  /**
   * New location of profile owner- Temp set to city
   * @var string $VALID_PROFILELOCATION2
   **/
  protected $VALID_PROFILELOCATION2 = "Denver";

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
	public final function setUp() : void {
		parent::setUp();
		$password = "password1234";
		$this->VALID_PROFILEPASSWORD = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_PROFILEACTIVATIONTOKEN = bin2hex(random_bytes(16));
	}

  /**
	 * test creating a valid profile
	 **/
	public function testCreateProfile() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
    // create a new Profile and insert into database
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILEACTIVATIONTOKEN, $this->VALID_PROFILEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILELOCATION, $this->VALID_PROFILENAME, $this->VALID_PROFILEPASSWORD, $this->VALID_PROFILEWEBSITE);
		$profile->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILEACTIVATIONTOKEN);
		$this->assertEquals($pdoProfile->getProfileDate(), $this->VALID_PROFILEDATE);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILEEMAIL);
		$this->assertEquals($pdoProfile->getProfileLocation(), $this->VALID_PROFILELOCATION);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILENAME);
		$this->assertEquals($pdoProfile->getProfilePassword(), $this->VALID_PROFILEPASSWORD);
		$this->assertEquals($pdoProfile->getProfileWebsite(), $this->VALID_PROFILEWEBSITE);
	}

  // /**
	//  * test inserting a profile and updating it
	//  **/
	// public function testUpdateProfile() {
	// 	// count the number of rows and save it for later
	// 	$numRows = $this->getConnection()->getRowCount("profile");
	// 	// create a new Profile and insert into database
	// 	$profileId = generateUuidV4();
	// 	$profile = new Profile($profileId, $this->VALID_PROFILEACTIVATIONTOKEN, $this->VALID_PROFILEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILELOCATION, $this->VALID_PROFILENAME, $this->VALID_PROFILEPASSWORD, $this->VALID_PROFILEWEBSITE);
	// 	$profile->insert($this->getPDO());
	// 	// edit the Profile and update it in mySQL
	// 	$profile->setProfileEmail($this->$VALID_PROFILEEMAIL2);
	// 	$profile->setProfileLocation($this->$VALID_PROFILELOCATION2);
	// 	$profile->setProfileName($this->$VALID_PROFILENAME2);
	// 	$profile->setProfilePassword($this->VALID_PROFILEPASSWORD2);
	// 	$profile->setProfileWebsite($this->$VALID_PROFILEEMAIL2);
	// 	$profile->update($this->getPDO());
	// 	// access the data from database and confirm the data matches expectations
	// 	$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
  //   $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
	// 	$this->assertEquals($pdoProfile->getProfileId(), $profileId);
	// 	$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILEACTIVATIONTOKEN);
	// 	$this->assertEquals($pdoProfile->getProfileDate(), $this->VALID_PROFILEDATE);
	// 	$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILEEMAIL2);
	// 	$this->assertEquals($pdoProfile->getProfileLocation(), $this->VALID_PROFILELOCATION2);
	// 	$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILENAME2);
	// 	$this->assertEquals($pdoProfile->getProfilePassword(), $this->VALID_PROFILEPASSWORD2);
	// 	$this->assertEquals($pdoProfile->getProfileWebsite(), $this->VALID_PROFILEWEBSITE2);
	// }
  //
  // /**
  //  * test to create a profile and delete it
  //  **/
  // public function testDeleteProfile() : void {
  //   // count the number of rows and save it for later
  //   $numRows = $this->getConnection()->getRowCount("profile");
  //   // create a new profile and insert into database
  //   $profileId = generateUuidV4();
  //   $profile = new Profile($profileId, $this->VALID_PROFILEACTIVATIONTOKEN, $this->VALID_PROFILEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILELOCATION, $this->VALID_PROFILENAME, $this->VALID_PROFILEPASSWORD, $this->VALID_PROFILEWEBSITE);
  //   $profile->insert($this->getPDO());
  //   // delete the profile from database
  //   $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
  //   $profile->delete($this->getPDO());
  //   // access database and confirm profile deleted
  //   $pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
  //   $this->assertNull($pdoProfile);
  //   $this->assertEquals($numRows, $this->getConnection()->getRowCount("profile"));
  // }
  //
  //     // calculate the date (just use the time the unit test was setup...)
  //   $this->VALID_PROFILEDATE = new \DateTime();
  //
  //   //format the sunrise date to use for testing
  //   $this->VALID_SUNRISEDATE = new \DateTime();
  //   $this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));
  //
  //   //format the sunset date to use for testing
  //   $this->VALID_SUNSETDATE = new\DateTime();
  //   $this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));
}
