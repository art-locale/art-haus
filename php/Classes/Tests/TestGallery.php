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
 * @see Gallery
 * @author Jaeren William Tredway <jwilliamtredway@gmail.com>
 **/
class TestGallery extends ArtHausTest {
	/**
	 * valid Art Haus gallery
	 * @var Gallery gallery
	 **/
	protected $gallery = null;

	/**
	 * valid Art Haus profile; for foreign key relations
	 * @var Profile profile
	 **/
	protected $profile = null;

	/**
	 * id for this gallery
	 * @var Uuid $VALID_GALLERYID
	 */
	protected $VALID_GALLERYID;


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

	/**
	 * placeholder activation token for initial profile creation
	 * @var string $VALID_PROFILEACTIVATIONTOKEN
	 **/
	protected $VALID_PROFILEACTIVATIONTOKEN;

	/**
	 * hash of profile owner account password
	 * @var string $VALID_PROFILEPASSWORD
	 **/
	protected $VALID_PROFILEPASSWORD;


	/*
	 * @throws \Exception
	 */
	public final function setUp(): void {
		parent::setUp();
		/*************************************************
		 * build dummy object for Profile:
		 *************************************************/
		$password = "test123";
		$this->VALID_PROFILEPASSWORD = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_PROFILEACTIVATION = bin2hex(random_bytes(16));

		// calculate the date (just use the time the unit test was setup)
		$this->VALID_GALLERYDATE = new \DateTime();

		//format the sunrise date to use for testing //FIXME Necessary?
		$this->VALID_SUNRISEDATE = new \DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

		//format the sunset date to use for testing //FIXME Necessary?
		$this->VALID_SUNSETDATE = new \DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));

		//create and insert a Profile to own the test Image
		$this->profile = new Profile(generateUuidV4(), $this->VALID_PROFILEACTIVATIONTOKEN, new \DateTime, "bt@handletest.com", 89.123445, 35.098109, "this title", $this->VALID_PROFILEPASSWORD, "www.msn.com");
		$this->profile->insert($this->getPDO());

	}
	//	end setUp() method

	/*************************************************
	 * build dummy object for Gallery:
	 *************************************************/
	public function testCreateGallery(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("gallery");
		// create a new gallery and insert into database
		$galleryId = generateUuidV4();
		$gallery = new Gallery($galleryId, $this->profile->getProfileId(), $this->VALID_GALLERYDATE, $this->VALID_GALLERYNAME);
		$gallery->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match expectations
		$pdoGallery = Gallery::getGalleryByGalleryId($this->getPDO(), $gallery->getGalleryId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("gallery"));
		$this->assertEquals($pdoGallery->getGalleryId(), $galleryId);
		$this->assertEquals($pdoGallery->getGalleryProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoGallery->getGalleryDate()->getTimestamp(), $this->VALID_GALLERYDATE->getTimeStamp());
		$this->assertEquals($pdoGallery->getGalleryName(), $this->VALID_GALLERYNAME);
	}
}
