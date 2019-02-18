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

	// $VALID_GALLERYID and $VALID_GALLERYPROFILEID assigned below in testCreateGallery();

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
	 * new valid name for gallery
	 * @var string $VALID_GALLERYNAME2
	 **/
	protected $VALID_GALLERYNAME2 = "My New Gallery";

	/**
	 * valid Art Haus profile; for foreign key relations
	 * @var Profile profile
	 **/
	protected $profile = null;

	/**
	 * hash of profile owner account password
	 * @var string $VALID_PROFILEPASSWORD
	 **/
	protected $VALID_PROFILEPASSWORD;

	/**
	 * placeholder activation token for initial profile creation
	 * @var string $VALID_PROFILEACTIVATIONTOKEN
	 **/
	protected $VALID_PROFILEACTIVATIONTOKEN;

	//the other profile attributes are defined in the setUp() instantiation arguments below


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
		$this->VALID_PROFILEACTIVATIONTOKEN = bin2hex(random_bytes(16));

		// calculate the date (just use the time the unit test was setup)
		$this->VALID_GALLERYDATE = new \DateTime();

		//FIXME: Are we using these sunrise/ sunset variables?
		//format the sunrise date to use for testing //FIXME Necessary?
		$this->VALID_SUNRISEDATE = new \DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

		//format the sunset date to use for testing //FIXME Necessary?
		$this->VALID_SUNSETDATE = new \DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));

		//create and insert a Profile to own the test Image
		$this->profile =
			new Profile(
					generateUuidV4(),
					$this->VALID_PROFILEACTIVATIONTOKEN,
					new \DateTime,
					"bt@handletest.com",
					89.123445,
					35.098109,
					"Bob Doe",
					$this->VALID_PROFILEPASSWORD,
					"someEmail@gmail.com");

			$this->profile->insert($this->getPDO());
	}
	//	END OF setUp() method

/*************************************************
 * build dummy object for Gallery and compare to
 * the PDO Gallery:
 *************************************************/
	public function testCreateGallery(): void {
		// count the number of rows and save it for later:
		$numRows = $this->getConnection()->getRowCount("gallery");

		// create a new gallery and insert into database:
		$galleryId = generateUuidV4();
		$gallery = new Gallery($galleryId, $this->profile->getProfileId(), $this->VALID_GALLERYDATE, $this->VALID_GALLERYNAME);
		$gallery->insert($this->getPDO());

		// get the data from SQL table and check that the fields match expectations:
		$pdoGallery = Gallery::getGalleryByGalleryId($this->getPDO(), $gallery->getGalleryId());

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("gallery"));
		$this->assertEquals($pdoGallery->getGalleryId(), $galleryId);
		$this->assertEquals($pdoGallery->getGalleryProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoGallery->getGalleryDate()->getTimestamp(), $this->VALID_GALLERYDATE->getTimeStamp());
		$this->assertEquals($pdoGallery->getGalleryName(), $this->VALID_GALLERYNAME);
	}
	// END OF testCreateGallery() function

/*************************************************
 * test inserting a gallery and updating it
 *************************************************/
	public function testUpdateGallery(): void {
		//local function variables:
		$galleryId = generateUuidV4();
//		$galleryProfileId = $this->profile->getProfileId();
//		$this->VALID_GALLERYDATE = new \DateTime();
		//VALID_GALLERYDATE assigned globally in state variables

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("gallery");

		// create a new gallery and insert into database:
		$gallery = new Gallery($galleryId, $this->profile->getProfileId(), $this->VALID_GALLERYDATE, $this->VALID_GALLERYNAME);
		$gallery->insert($this->getPDO());

		// edit the gallery and update it in database
		$gallery->setGalleryName($this->VALID_GALLERYNAME2);

		$gallery->update($this->getPDO());

		// access the data from database and confirm the data matches expectations:
		$pdoGallery = Gallery::getGalleryByGalleryId($this->getPDO(), $gallery->getGalleryId());

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("gallery"));

		//FIXME: not sure if this is worded correctly:
		$this->assertEquals($pdoGallery->getGalleryId(), $galleryId);
		$this->assertEquals($pdoGallery->getGalleryProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoGallery->getGalleryDate()->getTimestamp(), $this->VALID_GALLERYDATE->getTimestamp());
		$this->assertEquals($pdoGallery->getGalleryName(), $this->VALID_GALLERYNAME2);
	}
	// END OF testUpdateGallery() function

/*************************************************
 * test inserting a gallery and then deleting it
 *************************************************/
	public function testDeleteGallery(): void {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("gallery");

		// create a new gallery and insert into database:
		$galleryId = generateUuidV4();
		$gallery = new Gallery($galleryId, $this->profile->getProfileId(), $this->VALID_GALLERYDATE, $this->VALID_GALLERYNAME);
		$gallery->insert($this->getPDO());

		// delete the gallery from database
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("gallery"));
		$gallery->delete($this->getPDO());

		// access database and confirm gallery is deleted
		$pdoImage = Gallery::getGalleryByGalleryId($this->getPDO(), $gallery->getGalleryId());
		$this->assertNull($pdoImage);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("gallery"));
	}
	// END OF testDeleteGallery() function

	/**********************************************
	 * test selecting a gallery by galleryId
	 *********************************************/
	public function testGetGalleryByGalleryId(): void {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("gallery");

		// create a new gallery and insert into database:
		$galleryId = generateUuidV4();
		$gallery = new Gallery($galleryId, $this->profile->getProfileId(), $this->VALID_GALLERYDATE, $this->VALID_GALLERYNAME);
		$gallery->insert($this->getPDO());

		// get the data from SQL table and check that the fields match expectations:
		$pdoGallery = Gallery::getGalleryByGalleryId($this->getPDO(), $gallery->getGalleryId());

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("gallery"));
		$this->assertEquals($pdoGallery->getGalleryId(), $galleryId);
		$this->assertEquals($pdoGallery->getGalleryProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoGallery->getGalleryDate()->getTimestamp(), $this->VALID_GALLERYDATE->getTimeStamp());
		$this->assertEquals($pdoGallery->getGalleryName(), $this->VALID_GALLERYNAME);
	}
// END OF testGetGalleryByGalleryId() function

/*************************************************
 * test selecting a non-existent gallery by galleryId
 *************************************************/
	public function testGetInvalidGalleryByGalleryId(): void {

		// access a galleryId that does not exist
		$unknownGalleryId = generateUuidV4();
		$gallery = Gallery::getGalleryByGalleryId($this->getPDO(), $unknownGalleryId);
		$this->assertNull($gallery);
	}
	// END OF testGetInvalidGalleryByGalleryId()

/*************************************************
 * test selecting a gallery by profileId
 *************************************************/
	public function testGetGalleryByProfileId(): void {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("gallery");

		// create a new gallery and insert into database:
		$galleryId = generateUuidV4();
		$gallery = new Gallery($galleryId, $this->profile->getProfileId(), $this->VALID_GALLERYDATE, $this->VALID_GALLERYNAME);
		$gallery->insert($this->getPDO());

		// get the data from SQL table and check that the fields match expectations:
		$pdoGallery = Gallery::getGalleryByGalleryId($this->getPDO(), $gallery->getGalleryId());

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("gallery"));
		$this->assertEquals($pdoGallery->getGalleryId(), $galleryId);
		$this->assertEquals($pdoGallery->getGalleryProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoGallery->getGalleryDate()->getTimestamp(), $this->VALID_GALLERYDATE->getTimeStamp());
		$this->assertEquals($pdoGallery->getGalleryName(), $this->VALID_GALLERYNAME);
	}

/*************************************************
 * test selecting a non-existent gallery by profileId
 *************************************************/
	public function testGetInvalidGalleryByProfileId(): void {

		// access a profileId that does not exist
		$unknownProfileId = generateUuidV4();
		$image = Image::getImageByProfileId($this->getPDO(), $unknownProfileId);
		$this->assertNull($image);
	}



} // END OF TestGallery Class
