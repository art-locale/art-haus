<?php
namespace ArtLocale\ArtHaus\Tests;

use ArtLocale\ArtHaus\{Gallery, Profile};

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
	 * valid Art Haus profile
	 * @var Profile profile
	 **/
	protected $profile = null;

	/**
	 * id for this gallery
	 * @var Uuid $VALID_GALLERYID
	 */
	protected $VALID_GALLERYID;

	/**
	 * associated profile id for this gallery
	 * @var Uuid $VALID_GALLERYPROFILEID
	 */
	protected $VALID_GALLERYPROFILEID;

	/**
	 * Date and time gallery was created- this starts as null and is assigned later
	 * @var \DateTime $VALID_GALLERYDATE
	 **/
	protected $VALID_GALLERYDATE = null;

	/**
	 * Valid timestamp to use as sunriseGalleryDate
	 */
	protected $VALID_SUNRISEDATE = null;

	/**
	 * Valid timestamp to use as sunsetGalleryDate
	 */
	protected $VALID_SUNSETDATE = null;

	/**
	 * valid name for gallery
	 * @var string $VALID_GALLERYNAME
	 **/
	protected $VALID_GALLERYNAME = "My Gallery";

	/*
	 * test for valid hash
	 */
	protected $VALID_PASSWORD;

	/*
	 * test for valid activation token
	 */
	protected $VALID_ACTIVATION;


	/*
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
	 * test creating a valid gallery
	 **/
	public function testCreateGallery(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("gallery");
		// create a new gallery and insert into database
		$galleryId = generateUuidV4();
		$gallery = new Gallery($galleryId, $this->VALID_GALLERYPROFILEID, $this->VALID_GALLERYDATE, $this->VALID_GALLERYNAME);
		$gallery->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match expectations
		$pdoGallery = Gallery::getGalleryByProfileId($this->getPDO(), $gallery->getGalleryId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("gallery"));
		$this->assertEquals($pdoGallery->getGalleryId(), $galleryId);
		$this->assertEquals($pdoGallery->getGalleryProfileId(), $this->VALID_GALLERYPROFILEID);
		$this->assertEquals($pdoGallery->getGalleryDate()->getTimestamp(), $this->VALID_GALLERYDATE->getTimeStamp());
		$this->assertEquals($pdoGallery->getGalleryName(), $this->VALID_GALLERYNAME);
	}
}