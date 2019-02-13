<?php
namespace ArtLocale\ArtHaus\Tests;

use ArtLocale\ArtHaus\Image;

// access the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// access the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Image class
 *
 * This is a complete PHPUnit test of the Image class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Image
 * @author William Isengard <william.isengard@gmail.com>
 **/

class TestImage extends ArtHausTest {
	/**
	 * valid Art Haus user image ]
	 * @var Image image
	 **/
	protected $image = null;

	/**
	 * id for this imageId
	 * @var Uuid $VALID_IMAGEID
	 */
	protected $VALID_IMAGEID;

	/**
	 * placeholder image gallery id for initial image creation
	 * @var string $VALID_IMAGEGALLERYID
	 **/
	protected $VALID_IMAGEGALLERYID;

	/**
	 * placeholder image profile id for initial image creation
	 * @var string $VALID_IMAGEPROFILEID
	 **/
	protected $VALID_IMAGEPROFILEID;
	/**
	 * Date image was created- this starts as null and is assigned later
	 * @var \Date $VALID_IMAGEDATE
	 **/
	protected $VALID_IMAGEDATE;

	/**
	 * Valid timestamp to use as sunriseImageDate
	 */
	protected $VALID_SUNRISEDATE = null;

	/**
	 * Valid timestamp to use as sunsetImageDate
	 */
	protected $VALID_SUNSETDATE = null;

	/**
	 * valid title for image title
	 * @var string $VALID_IMAGETITLE
	 **/
	protected $VALID_IMAGETITLE = "test test 123";

	/**
	 * valid url of image url
	 * @var string $VALID_IMAGEURL
	 **/
	protected $VALID_IMAGEURL = "https://www.nps.gov/common/uploads/grid_builder/stli/crop16_9/89721987-1DD8-B71B-0BE77EEAE39E0520.jpg?width=950&quality=90&mode=crop";

	/**
	 * valid url of image url
	 * @var string $VALID_IMAGEURL2
	 **/
	protected $VALID_IMAGEURL2 = null;

	/**
	 * updated image tite
	 * @var string $VALID_IMAGETITLE2
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
		$this->VALID_PROFILEACTIVATIONTOKEN = bin2hex(random_bytes(16));
		$this->VALID_PROFILEDATE = new \DateTime();
	}

	//     // calculate the date (just use the time the unit test was setup...)
	//   $this->VALID_PROFILEDATE = new \DateTime();

	/**
	 * test creating a valid profile
	 **/
	public function testCreateProfile() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		// create a new Profile and insert into database
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILEACTIVATIONTOKEN, $this->VALID_PROFILEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILELATITUDE, $this->VALID_PROFILELONGITUDE, $this->VALID_PROFILENAME, $this->VALID_PROFILEPASSWORD, $this->VALID_PROFILEWEBSITE);
		$profile->insert($this->getPDO());
		var_dump($newProfileDate);
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

	// /**
	//  * test inserting a profile and updating it
	//  **/
	// public function testUpdateProfile() {
	// 	// count the number of rows and save it for later
	// 	$numRows = $this->getConnection()->getRowCount("profile");
	// 	// create a new Profile and insert into database
	// 	$profileId = generateUuidV4();
	// 	$profile = new Profile($profileId, $this->VALID_PROFILEACTIVATIONTOKEN, $this->VALID_PROFILEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILELATITUDE, $this->VALID_PROFILELONGITUDE, $this->VALID_PROFILENAME, $this->VALID_PROFILEPASSWORD, $this->VALID_PROFILEWEBSITE);
	// 	$profile->insert($this->getPDO());
	// 	// edit the Profile and update it in mySQL
	// 	$profile->setProfileEmail($this->$VALID_PROFILEEMAIL2);
	// 	$profile->setProfileLatitude($this->$VALID_PROFILELatitude);
	// 	$profile->setProfileLongitude($this->$VALID_PROFILELongitude);
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
	// 	$this->assertEquals($pdoProfile->getProfileLatitude(), $this->VALID_PROFILELATITUDE2);
	// 	$this->assertEquals($pdoProfile->getProfileLongitude(), $this->VALID_PROFILELONGITUDE2);
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
	//   $profile = new Profile($profileId, $this->VALID_PROFILEACTIVATIONTOKEN, $this->VALID_PROFILEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILELATITUDE, $this->VALID_PROFILELONGITUDE, $this->VALID_PROFILENAME, $this->VALID_PROFILEPASSWORD, $this->VALID_PROFILEWEBSITE);
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

	//
	//   //format the sunrise date to use for testing
	//   $this->VALID_SUNRISEDATE = new \DateTime();
	//   $this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));
	//
	//   //format the sunset date to use for testing
	//   $this->VALID_SUNSETDATE = new\DateTime();
	//   $this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));
}
