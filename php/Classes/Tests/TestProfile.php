<?php
namespace ArtLocale\ArtHaus\Tests;

use ArtLocale\ArtHaus\Profile;

// access the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// access the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Profile class
 *
 * This is a complete PHPUnit test of the Profile class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Profile
 * @author William Isengard <william.isengard@gmail.com>
 **/

 class TestProfile extends ArtHausTest {
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
   * Latitude of profile owner- Temp set to city
   * @var float $VALID_PROFILELATITUDE
   **/
  protected $VALID_PROFILELATITUDE= "75.555555";

  /**
   * New latitude of profile owner- Temp set to city
   * @var float $VALID_PROFILELATITUDE2
   **/
  protected $VALID_PROFILELATITUDE2 = "35.555555";

	 /**
	  * longitude of profile owner- Temp set to city
	  * @var float $VALID_PROFILELONGITUDE
	  **/
	 protected $VALID_PROFILELONGITUDE= "50.555555";

	 /**
	  * New logitude of profile owner- Temp set to city
	  * @var float $VALID_PROFILELONGITUDE2
	  **/
	 protected $VALID_PROFILELONGITUDE2 = "30.555555";

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
    //
		$password = "password1234";
		$this->VALID_PROFILEPASSWORD = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
    $password2 = "newPassword4321";
		$this->VALID_PROFILEPASSWORD2 = password_hash($password2, PASSWORD_ARGON2I, ["time_cost" => 384]);

		$this->VALID_PROFILEACTIVATIONTOKEN = bin2hex(random_bytes(16));
    $this->VALID_PROFILEDATE = new \DateTime();

    //format the sunrise date to use for testing
    $this->VALID_SUNRISEDATE = new \DateTime();
    $this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

    //format the sunset date to use for testing
    $this->VALID_SUNSETDATE = new \DateTime();
    $this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));
	}



  /**
	 * test creating a valid profile
	 **/
	public function testCreateProfile() : void {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

    // create a new profile and insert into database
		$profileId = generateUuidV4();

		$profile = new Profile($profileId, $this->VALID_PROFILEACTIVATIONTOKEN, $this->VALID_PROFILEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILELATITUDE, $this->VALID_PROFILELONGITUDE, $this->VALID_PROFILENAME, $this->VALID_PROFILEPASSWORD, $this->VALID_PROFILEWEBSITE);
		$profile->insert($this->getPDO());

		// grab the data from database and enforce the fields match expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILEACTIVATIONTOKEN);
		$this->assertEquals($pdoProfile->getProfileDate()->getTimestamp(), $this->VALID_PROFILEDATE->getTimestamp());
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILEEMAIL);
		$this->assertEquals($pdoProfile->getProfileLatitude(), $this->VALID_PROFILELATITUDE);
		$this->assertEquals($pdoProfile->getProfileLongitude(), $this->VALID_PROFILELONGITUDE);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILENAME);
		$this->assertEquals($pdoProfile->getProfilePassword(), $this->VALID_PROFILEPASSWORD);
    $this->assertEquals($pdoProfile->getProfileWebsite(), $this->VALID_PROFILEWEBSITE);
	}

  /**
	 * test inserting a profile and updating it
	 **/
	public function testUpdateProfile() {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new profile and insert into database
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILEACTIVATIONTOKEN, $this->VALID_PROFILEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILELATITUDE, $this->VALID_PROFILELONGITUDE, $this->VALID_PROFILENAME, $this->VALID_PROFILEPASSWORD, $this->VALID_PROFILEWEBSITE);
		$profile->insert($this->getPDO());

		// edit the profile and update it in database
		$profile->setProfileLatitude($this->VALID_PROFILELATITUDE2);
		$profile->setProfileLongitude($this->VALID_PROFILELONGITUDE2);
		$profile->setProfileEmail($this->VALID_PROFILEEMAIL2);
    $profile->setProfileName($this->VALID_PROFILENAME2);
		$profile->setProfilePassword($this->VALID_PROFILEPASSWORD2);
		$profile->setProfileWebsite($this->VALID_PROFILEWEBSITE2);
    $profile->update($this->getPDO());

		// access the data from database and confirm the data matches expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());

    $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));

		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILEACTIVATIONTOKEN);
		$this->assertEquals($pdoProfile->getProfileDate()->getTimestamp(), $this->VALID_PROFILEDATE->getTimestamp());
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILEEMAIL2);
		$this->assertEquals($pdoProfile->getProfileLatitude(), $this->VALID_PROFILELATITUDE2);
	 	$this->assertEquals($pdoProfile->getProfileLongitude(), $this->VALID_PROFILELONGITUDE2);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILENAME2);
		$this->assertEquals($pdoProfile->getProfilePassword(), $this->VALID_PROFILEPASSWORD2);
		$this->assertEquals($pdoProfile->getProfileWebsite(), $this->VALID_PROFILEWEBSITE2);
	}

  /**
   * test to create a profile and delete it
   **/
  public function testDeleteProfile() : void {

    // count the number of rows and save it for later
    $numRows = $this->getConnection()->getRowCount("profile");

    // create a new profile and insert into database
    $profileId = generateUuidV4();

    $profile = new Profile($profileId, $this->VALID_PROFILEACTIVATIONTOKEN, $this->VALID_PROFILEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILELATITUDE, $this->VALID_PROFILELONGITUDE, $this->VALID_PROFILENAME, $this->VALID_PROFILEPASSWORD, $this->VALID_PROFILEWEBSITE);
    $profile->insert($this->getPDO());

    // delete the profile from database
    $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
    $profile->delete($this->getPDO());

    // access database and confirm profile deleted
    $pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
    $this->assertNull($pdoProfile);
    $this->assertEquals($numRows, $this->getConnection()->getRowCount("profile"));
  }

   /**
	 * test accessing a profile that does not exist
	 **/
   public function testGetInvalidProfileByProfileId() : void {

 		// access a profileId that does not exist
 		$unknownProfileId = generateUuidV4();
 		$profile = Profile::getProfileByProfileId($this->getPDO(), $unknownProfileId );
 		$this->assertNull($profile);
 	}

   /**
	 * test accessing a profile by profile name
	 **/

   public function testAccessProfileByName() : void {

     // count the number of rows and save it for later
     $numRows = $this->getConnection()->getRowCount("profile");

      // create a new profile and insert into database
     $profileId = generateUuidV4();

     $profile = new Profile($profileId, $this->VALID_PROFILEACTIVATIONTOKEN, $this->VALID_PROFILEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILELATITUDE, $this->VALID_PROFILELONGITUDE, $this->VALID_PROFILENAME, $this->VALID_PROFILEPASSWORD, $this->VALID_PROFILEWEBSITE);
     $profile->insert($this->getPDO());

     // access the data from database and confirm the data matches expectations
     $pdoProfile = Profile::getProfileByName($this->getPDO(), $profile->getProfileName());
     $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
     $this->assertEquals($pdoProfile->getProfileId(), $profileId);
     $this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILEACTIVATIONTOKEN);
     $this->assertEquals($pdoProfile->getProfileDate()->getTimestamp(), $this->VALID_PROFILEDATE->getTimestamp());
     $this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILEEMAIL);
     $this->assertEquals($pdoProfile->getProfileLatitude(), $this->VALID_PROFILELATITUDE);
     $this->assertEquals($pdoProfile->getProfileLongitude(), $this->VALID_PROFILELONGITUDE);
     $this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILENAME);
     $this->assertEquals($pdoProfile->getProfilePassword(), $this->VALID_PROFILEPASSWORD);
     $this->assertEquals($pdoProfile->getProfileWebsite(), $this->VALID_PROFILEWEBSITE);
   }

   /**
  * test accessing a profile by profile name that does not exist
  **/
  public function testGetProfileByInvalidName() : void {

    // Access profile name that does not exists
    $profile = Profile::getProfileByName($this->getPDO(), "Fake Name");
    $this->assertNull($profile);
  }

   /**
	 * test accessing a profile by profile email
	 **/

   public function testAccessProfileByEmail() : void {

     // count the number of rows and save it for later
     $numRows = $this->getConnection()->getRowCount("profile");

      // create a new profile and insert into database
     $profileId = generateUuidV4();

     $profile = new Profile($profileId, $this->VALID_PROFILEACTIVATIONTOKEN, $this->VALID_PROFILEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILELATITUDE, $this->VALID_PROFILELONGITUDE, $this->VALID_PROFILENAME, $this->VALID_PROFILEPASSWORD, $this->VALID_PROFILEWEBSITE);
     $profile->insert($this->getPDO());

     // access the data from database and confirm the data matches expectations
     $pdoProfile = Profile::getProfileByEmail($this->getPDO(), $profile->getProfileEmail());
     $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
     $this->assertEquals($pdoProfile->getProfileId(), $profileId);
     $this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILEACTIVATIONTOKEN);
     $this->assertEquals($pdoProfile->getProfileDate()->getTimestamp(), $this->VALID_PROFILEDATE->getTimestamp());
     $this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILEEMAIL);
     $this->assertEquals($pdoProfile->getProfileLatitude(), $this->VALID_PROFILELATITUDE);
     $this->assertEquals($pdoProfile->getProfileLongitude(), $this->VALID_PROFILELONGITUDE);
     $this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILENAME);
     $this->assertEquals($pdoProfile->getProfilePassword(), $this->VALID_PROFILEPASSWORD);
     $this->assertEquals($pdoProfile->getProfileWebsite(), $this->VALID_PROFILEWEBSITE);
   }
   /**
  * test accessing a profile by profile email that does not exist
  **/

  public function testGetProfileByInvalidEmail() : void {

    // Access profile name that does not exists
    $profile = Profile::getProfileByEmail($this->getPDO(), "doesnotexist@gmail.com");
    $this->assertNull($profile);
  }

   /**
	 * test accessing a profile by latitude
	 **/

   public function testAccessProfileByLatitude() : void {

     // count the number of rows and save it for later
     $numRows = $this->getConnection()->getRowCount("profile");

      // create a new profile and insert into database
     $profileId = generateUuidV4();

     $profile = new Profile($profileId, $this->VALID_PROFILEACTIVATIONTOKEN, $this->VALID_PROFILEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILELATITUDE, $this->VALID_PROFILELONGITUDE, $this->VALID_PROFILENAME, $this->VALID_PROFILEPASSWORD, $this->VALID_PROFILEWEBSITE);
     $profile->insert($this->getPDO());

     // access the data from database and confirm the data matches expectations
     $pdoProfile = Profile::getProfileByLatitude($this->getPDO(), $profile->getProfileLatitude());
     $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
     $this->assertEquals($pdoProfile->getProfileId(), $profileId);
     $this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILEACTIVATIONTOKEN);
     $this->assertEquals($pdoProfile->getProfileDate()->getTimestamp(), $this->VALID_PROFILEDATE->getTimestamp());
     $this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILEEMAIL);
     $this->assertEquals($pdoProfile->getProfileLatitude(), $this->VALID_PROFILELATITUDE);
     $this->assertEquals($pdoProfile->getProfileLongitude(), $this->VALID_PROFILELONGITUDE);
     $this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILENAME);
     $this->assertEquals($pdoProfile->getProfilePassword(), $this->VALID_PROFILEPASSWORD);
     $this->assertEquals($pdoProfile->getProfileWebsite(), $this->VALID_PROFILEWEBSITE);
   }

   /**
  * test accessing a profile by profile latitude and longitude that does not exist TODO Ask George For Help w/ Lat/Long
  **/

  /**
  * test accessing a profile by logitude
  **/

  public function testAccessProfileByLongitude() : void {

    // count the number of rows and save it for later
    $numRows = $this->getConnection()->getRowCount("profile");

     // create a new profile and insert into database
    $profileId = generateUuidV4();

    $profile = new Profile($profileId, $this->VALID_PROFILEACTIVATIONTOKEN, $this->VALID_PROFILEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILELATITUDE, $this->VALID_PROFILELONGITUDE, $this->VALID_PROFILENAME, $this->VALID_PROFILEPASSWORD, $this->VALID_PROFILEWEBSITE);
    $profile->insert($this->getPDO());

    // access the data from database and confirm the data matches expectations
    $pdoProfile = Profile::getProfileByLongitude($this->getPDO(), $profile->getProfileLongitude());
    $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
    $this->assertEquals($pdoProfile->getProfileId(), $profileId);
    $this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILEACTIVATIONTOKEN);
    $this->assertEquals($pdoProfile->getProfileDate()->getTimestamp(), $this->VALID_PROFILEDATE->getTimestamp());
    $this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILEEMAIL);
    $this->assertEquals($pdoProfile->getProfileLatitude(), $this->VALID_PROFILELATITUDE);
    $this->assertEquals($pdoProfile->getProfileLongitude(), $this->VALID_PROFILELONGITUDE);
    $this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILENAME);
    $this->assertEquals($pdoProfile->getProfilePassword(), $this->VALID_PROFILEPASSWORD);
    $this->assertEquals($pdoProfile->getProfileWebsite(), $this->VALID_PROFILEWEBSITE);
  }

   /**
	 * test accessing a profile by activation token
	 **/

   public function testAccessProfileByActivationToken() : void {

     // count the number of rows and save it for later
     $numRows = $this->getConnection()->getRowCount("profile");

      // create a new profile and insert into database
     $profileId = generateUuidV4();

     $profile = new Profile($profileId, $this->VALID_PROFILEACTIVATIONTOKEN, $this->VALID_PROFILEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILELATITUDE, $this->VALID_PROFILELONGITUDE, $this->VALID_PROFILENAME, $this->VALID_PROFILEPASSWORD, $this->VALID_PROFILEWEBSITE);
     $profile->insert($this->getPDO());

     // access the data from database and confirm the data matches expectations
     $pdoProfile = Profile::getProfileByProfileActivationToken($this->getPDO(), $profile->getProfileActivationToken());
     $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
     $this->assertEquals($pdoProfile->getProfileId(), $profileId);
     $this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILEACTIVATIONTOKEN);
     $this->assertEquals($pdoProfile->getProfileDate()->getTimestamp(), $this->VALID_PROFILEDATE->getTimestamp());
     $this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILEEMAIL);
     $this->assertEquals($pdoProfile->getProfileLatitude(), $this->VALID_PROFILELATITUDE);
     $this->assertEquals($pdoProfile->getProfileLongitude(), $this->VALID_PROFILELONGITUDE);
     $this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILENAME);
     $this->assertEquals($pdoProfile->getProfilePassword(), $this->VALID_PROFILEPASSWORD);
     $this->assertEquals($pdoProfile->getProfileWebsite(), $this->VALID_PROFILEWEBSITE);
   }

   /**
  * test accessing a profile by activation token that does not exist
  **/

  public function testGetProfileByInvaliActivationToken() : void {

    // Access profile name that does not exists
    $profile = Profile::getProfileByProfileActivationToken($this->getPDO(), "9dc8ec939f2191519ebfc91434c2590f");
    $this->assertNull($profile);
  }

   /**
	 * test accessing all profiles
	 **/

   public function testAccessAllProfiles() : void {

     // count the number of rows and save it for later
     $numRows = $this->getConnection()->getRowCount("profile");

      // create a new profile and insert into database
     $profileId = generateUuidV4();

     $profile = new Profile($profileId, $this->VALID_PROFILEACTIVATIONTOKEN, $this->VALID_PROFILEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILELATITUDE, $this->VALID_PROFILELONGITUDE, $this->VALID_PROFILENAME, $this->VALID_PROFILEPASSWORD, $this->VALID_PROFILEWEBSITE);
     $profile->insert($this->getPDO());

     // access the data from database and confirm the data matches expectations
     $results = Profile::getAllProfiles($this->getPDO());
     $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
     $this->assertCount(1, $results);
     // $this->assertContainsOnlyInstancesOf("ArtLocale\\ArtHaus\\Profile", $results);

     // Access the results and validate
     $pdoProfile = $results[0];
     $this->assertEquals($pdoProfile->getProfileId(), $profileId);
     $this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILEACTIVATIONTOKEN);
     $this->assertEquals($pdoProfile->getProfileDate()->getTimestamp(), $this->VALID_PROFILEDATE->getTimestamp());
     $this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILEEMAIL);
     $this->assertEquals($pdoProfile->getProfileLatitude(), $this->VALID_PROFILELATITUDE);
     $this->assertEquals($pdoProfile->getProfileLongitude(), $this->VALID_PROFILELONGITUDE);
     $this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILENAME);
     $this->assertEquals($pdoProfile->getProfilePassword(), $this->VALID_PROFILEPASSWORD);
     $this->assertEquals($pdoProfile->getProfileWebsite(), $this->VALID_PROFILEWEBSITE);
   }

   /**
	 * test accessing all profiles that have not been activated yet
	 **/

   public function testAccessAllNotActivatedProfiles() : void {

     // count the number of rows and save it for later
     $numRows = $this->getConnection()->getRowCount("profile");

      // create a new profile and insert into database
     $profileId = generateUuidV4();

     $profile = new Profile($profileId, $this->VALID_PROFILEACTIVATIONTOKEN, $this->VALID_PROFILEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILELATITUDE, $this->VALID_PROFILELONGITUDE, $this->VALID_PROFILENAME, $this->VALID_PROFILEPASSWORD, $this->VALID_PROFILEWEBSITE);
     $profile->insert($this->getPDO());

     // access the data from database and confirm the data matches expectations
     $results = Profile::getAllNonActivatedProfiles($this->getPDO());
     $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
     $this->assertCount(1, $results);
     $this->assertContainsOnlyInstancesOf("ArtLocale\\ArtHaus\\Profile", $results);

     // Access the results and validate
     $pdoProfile = $results[0];
     $this->assertEquals($pdoProfile->getProfileId(), $profileId);
     $this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILEACTIVATIONTOKEN);
     $this->assertEquals($pdoProfile->getProfileDate()->getTimestamp(), $this->VALID_PROFILEDATE->getTimestamp());
     $this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILEEMAIL);
     $this->assertEquals($pdoProfile->getProfileLatitude(), $this->VALID_PROFILELATITUDE);
     $this->assertEquals($pdoProfile->getProfileLongitude(), $this->VALID_PROFILELONGITUDE);
     $this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILENAME);
     $this->assertEquals($pdoProfile->getProfilePassword(), $this->VALID_PROFILEPASSWORD);
     $this->assertEquals($pdoProfile->getProfileWebsite(), $this->VALID_PROFILEWEBSITE);
   }

}
?>
