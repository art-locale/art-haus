<?php
namespace ArtLocale\ArtHaus\Tests;

use ArtLocale\ArtHaus\{Image, Profile};

// access the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// access the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Applaud class
 *
 * This is a complete PHPUnit test of the Applaud class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Profile
 * @author Jaeren William Tredway <jwilliamtredway@gmail.com>
 **/

//	applaudProfileId BINARY(16) NOT NULL,
//	applaudImageId BINARY(16) NOT NULL,
//	applaudCount TINYINT(1) NULL

class TestApplaud extends ArtHausTest {
	/**
	 * valid Art Haus image
	 * @var Image image
	 **/
	protected $image = null;

	/**
	 * valid Art Haus profile
	 * @var Profile profile
	 **/
	protected $profile = null;

//**************************************************
// Applaud class state variables:
//**************************************************
	/**
	 * associated image id for this applaud
	 * @var Uuid $VALID_APPLAUDIMAGEID
	 */
	protected $VALID_APPLAUDIMAGEID;

	/**
	 * associated profile id for this applaud
	 * @var Uuid $VALID_APPLAUDPROFILEID
	 */
	protected $VALID_APPLAUDPROFILEID;

	/*
	 * a valid applaud count
	 * @var int $VALID_APPLUADCOUNT;
	 */
	protected $VALID_APPLAUDCOUNT;

//**************************************************
// Image class state variables:
//**************************************************
	/**
	 * id for the image
	 * @var Uuid $VALID_IMAGEID
	 */
	protected $VALID_IMAGEID;

//**************************************************
// Profile class state variables:
//**************************************************


	/*
	 * set up a temporary test profile
	 * @throws \Exception
	 */
	public final function setUp(): void {
		parent::setUp();
		$password = "test123";
		$this->VALID_PASSWORD = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));
		$this->profile = new Profile(generateUuidV4(), $this->VALID_ACTIVATION, null, "testUser@gmail.com", 85.12345, 75.12345, "Jack Johnson", $this->VALID_PASSWORD, "www.myWebsite.com");

		$this->profile->insert($this->getPDO());
	}


	/**
	 * test creating a valid applaud record
	 **/
	public function testCreateApplaud(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("applaud");
		// create a new applaud record and insert into database
		$applaudImageId = generateUuidV4();
		$applaudProfileId = generateUuidV4();
		$applaud = new Applaud($this->VALID_APPLAUDIMAGEID, $this->VALID_APPLAUDPROFILEID,$this->VALID_APPLAUDCOUNT);
		$applaud->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match expectations
		$pdoApplaud = Applaud::getApplaudByImageId($this->getPDO(), $applaud->getApplaudByProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("applaud"));
		$this->assertEquals($pdoApplaud->getApplaudCount(), $applaudCount);
	}
}