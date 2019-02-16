<?php
namespace ArtLocale\ArtHaus\Tests;

use ArtLocale\ArtHaus\{Applaud, Image, Profile, Gallery};

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
	 * valid Art Haus image; for foreign key relations
	 * @var Image image
	 **/
	protected $image = null;

	/**
	 * valid Art Haus profile; for foreign key relations
	 * @var Profile profile
	 **/
	protected $profile = null;

//**************************************************
// Applaud class state variables:
//**************************************************
	// /**
	//  * associated image id for this applaud
	//  * @var Uuid $VALID_APPLAUDIMAGEID
	//  */
	// protected $VALID_APPLAUDIMAGEID;
	//
	// /**
	//  * associated profile id for this applaud
	//  * @var Uuid $VALID_APPLAUDPROFILEID
	//  */
	// protected $VALID_APPLAUDPROFILEID;

	/*
	 * a valid applaud count
	 * @var INT $VALID_APPLUADCOUNT
	 */
	protected $VALID_APPLAUDCOUNT = "100";


//**************************************************
// Image class state variables:
//**************************************************
	// /**
	//  * id for the image
	//  * @var Uuid $VALID_IMAGEID
	//  */
	// protected $VALID_IMAGEID;

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
		$this->VALID_PROFILEPASSWORD = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_PROFILEACTIVATIONTOKEN = bin2hex(random_bytes(16));

		$this->profile = new Profile(generateUuidV4(), $this->VALID_PROFILEACTIVATIONTOKEN, new \DateTime, "picard4@starfleetacademy.edu", 87.123445, 33.098109, "this new title", $this->VALID_PROFILEPASSWORD, "www.cartoonnetwork.com");
		$this->profile->insert($this->getPDO());

		$this->gallery = new Gallery(generateUuidV4(), $this->profile->getProfileId(), new \DateTime, "Engage");
		$this->gallery->insert($this->getPDO());

		$this->image = new Image(generateUuidV4(), $this->gallery->getGalleryId(), $this->profile->getProfileId(), new \DateTime, "Purple", "www.happypuppy.com");
		$this->image->insert($this->getPDO());
	}


	/**
	 * test creating a valid applaud record
	 **/
	public function testCreateApplaud(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("applaud");
		// create a new applaud record and insert into database
		// $applaudImageId = generateUuidV4();
		// $applaudProfileId = generateUuidV4();
		$applaud = new Applaud($this->profile->getProfileId(), $this->image->getImageId(), $this->VALID_APPLAUDCOUNT);
		$applaud->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match expectations
		$pdoApplaud = Applaud::getApplaudByApplaudProfileId($this->getPDO(), $this->profile->getProfileId());
		$pdoApplaud = $pdoApplaud[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("applaud"));
		$this->assertEquals($pdoApplaud->getApplaudProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoApplaud->getApplaudImageId(), $this->image->getImageId());
		$this->assertEquals($pdoApplaud->getApplaudCount(), $this->VALID_APPLAUDCOUNT);
	}

}
