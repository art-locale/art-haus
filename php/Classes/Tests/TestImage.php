<?php
namespace ArtLocale\ArtHaus\Tests;

use ArtLocale\ArtHaus\{Image, Gallery, Profile};

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
	 * Profile that create image; for foreign key relations
	 * @var Profile profile
	 **/
	protected $profile = null;

	/**
	 * Gallery that houses image; for foreign key relations
	 * @var Gallery gallery
	 **/
	protected $gallery = null;

	/**
	 * id for this image
	 * @var Uuid $VALID_IMAGEID
	 **/
	protected $VALID_IMAGEID;

	/**
	 * Date image was created- this starts as null and is assigned later
	 * @var \DateTime $VALID_IMAGEDATE
	 **/
	protected $VALID_IMAGEDATE = null;

	/**
	 * Date image was created- this starts as null and is assigned later
	 * @var \DateTime $VALID_PROFILEDATE
	 **/
	protected $VALID_PROFILEDATE = null;

	/**
	 * Date image was created- this starts as null and is assigned later
	 * @var \DateTime $VALID_GALLERYDATE
	 **/
	protected $VALID_GALLERYDATE = null;

	/**
	 * Valid timestamp to use as sunriseImageDate
	 */
	protected $VALID_SUNRISEDATE = null; //FIXME Necessary?

	/**
	 * Valid timestamp to use as sunsetImageDate
	 */
	protected $VALID_SUNSETDATE = null; //FIXME Necessary?

	/**
	 * valid title for image title
	 * @var string $VALID_IMAGETITLE
	 **/
	protected $VALID_IMAGETITLE = "test test 123";

	/**
	 * updated image title
	 * @var string $VALID_IMAGETITLE
	 **/
	protected $VALID_IMAGETITLE2 = "John Doe";

	/**
	 * valid url of image url
	 * @var string $VALID_IMAGEURL
	 **/
	protected $VALID_IMAGEURL = "https://www.nps.gov/common/uploads/grid_builder/stli/crop16_9/89721987-1DD8-B71B-0BE77EEAE39E0520.jpg?width=950&quality=90&mode=crop";

	/**
	 * valid url of image url
	 * @var string $VALID_IMAGEURL2
	 **/
	protected $VALID_IMAGEURL2 = "www.google.com";

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

	/***********************************************************************************************************************
	 * START OF OPERATIONS
	 *****************************************************************************************************************/

	/**
	 * setup operation to create hash and salt.
	 */
	public final function setUp(): void {
		parent::setUp();
		//
		$password = "password1234";
		$this->VALID_PROFILEPASSWORD = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_PROFILEACTIVATIONTOKEN = bin2hex(random_bytes(16));

		// calculate the date (just use the time the unit test was setup)
		$this->VALID_IMAGEDATE = new \DateTime();

		//format the sunrise date to use for testing //FIXME Necessary?
		$this->VALID_SUNRISEDATE = new \DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

		//format the sunset date to use for testing //FIXME Necessary?
		$this->VALID_SUNSETDATE = new \DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));

		//create and insert a Profile to own the test Image
		$this->profile = new Profile(generateUuidV4(), $this->VALID_PROFILEACTIVATIONTOKEN, new \DateTime, "bt@handletest.com", 89.123445, 35.098109, "this title", $this->VALID_PROFILEPASSWORD, "www.msn.com");
		$this->profile->insert($this->getPDO());

		//create and insert a Gallery to own the test Image
		$this->gallery = new Gallery(generateUuidV4(), $this->profile->getProfileId(), new \DateTime, "handle");
		$this->gallery->insert($this->getPDO());
	}
	/****************************************************************************************************************
	 * TEST CREATING A VALID IMAGE
	 **************************************************************************************************************/

	public function testCreateImage() : void {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");

		// create a new Image and insert into database
		$imageId = generateUuidV4();

		$image = new Image($imageId,
			$this->gallery->getGalleryId(),
			$this->profile->getProfileId(),
			$this->VALID_IMAGEDATE,
			$this->VALID_IMAGETITLE,
			$this->VALID_IMAGEURL
		);
		$image->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match expectations
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getImageId(), $imageId);
		$this->assertEquals($pdoImage->getImageGalleryId(), $this->gallery->getGalleryId());
		$this->assertEquals($pdoImage->getImageProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoImage->getImageDate()->getTimestamp(), $this->VALID_IMAGEDATE->getTimestamp());
		$this->assertEquals($pdoImage->getImageTitle(), $this->VALID_IMAGETITLE);
		$this->assertEquals($pdoImage->getImageUrl(), $this->VALID_IMAGEURL);
		}

	/****************************************************************************************************************
	 * TEST INSERTING AN IMAGE AND UPDATING IT
	 **************************************************************************************************************/

	 public function testUpdateImage() : void {

	 	// count the number of rows and save it for later
	 	$numRows = $this->getConnection()->getRowCount("image");

	 	// create a new Image and insert into database
	 	$imageId = generateUuidV4();

			$image = new Image ($imageId,
				$this->gallery->getGalleryId(),
				$this->profile->getProfileId(),
				$this->VALID_IMAGEDATE,
				$this->VALID_IMAGETITLE,
				$this->VALID_IMAGEURL
			);
			$image->insert($this->getPDO());

	 	// edit the Image and update it in mySQL
		 $image->setImageTitle($this->VALID_IMAGETITLE2);
		 $image->setImageUrl($this->VALID_IMAGEURL2);
	 	$image->update($this->getPDO());

	 	//grab the data from mySQL and enforce the fields match expectations
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getImageId(), $imageId);
		$this->assertEquals($pdoImage->getImageGalleryId(), $this->gallery->getGalleryId());
		$this->assertEquals($pdoImage->getImageProfileId(), $this->profile->getProfileId());
		 $this->assertEquals($pdoImage->getImageDate()->getTimestamp(), $this->VALID_IMAGEDATE->getTimestamp());
		$this->assertEquals($pdoImage->getImageTitle(), $this->VALID_IMAGETITLE2);
		$this->assertEquals($pdoImage->getImageUrl(), $this->VALID_IMAGEURL2);
	 }


	/****************************************************************************************************************
	 * TEST INSERTING AN IMAGE AND DELETING IT
	 **************************************************************************************************************/
	 public function testDeleteImage() : void {
	   // count the number of rows and save it for later
	   $numRows = $this->getConnection()->getRowCount("image");
	   // create a new image and insert into database
		 $imageId = generateUuidV4();

		 $image = new Image ($imageId,
			 $this->gallery->getGalleryId(),
			 $this->profile->getProfileId(),
			 $this->VALID_IMAGEDATE,
			 $this->VALID_IMAGETITLE,
			 $this->VALID_IMAGEURL
		 );
		 $image->insert($this->getPDO());
	   // delete the image from database
	   $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
	   $image->delete($this->getPDO());
	   // access database and confirm image deleted
	   $pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
	   $this->assertNull($pdoImage);
	   $this->assertEquals($numRows, $this->getConnection()->getRowCount("image"));
	 }
}
/****************************************************************************************************************
 * TEST SELECTING A NON-EXISTANT IMAGE BY IMAGE ID
 **************************************************************************************************************/
public function testGetInvalidImageByImageId() : void {

	// access a profileId that does not exist
	$unknownImageId = generateUuidV4();
	$image = Image::getImageByImageId($this->getPDO(), $unknownImageId );
	$this->assertNull($image);
}
/****************************************************************************************************************
 * TEST SELECTING AN IMAGE BY GALLERY ID
 **************************************************************************************************************/
/**
 * test accessing a profile by activation token
 **/

public function testSelectImageByGalleryId() : void {

	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("image");

	// create a new Image and insert into database
	$imageId = generateUuidV4();

	$image = new Image ($imageId,
		$this->gallery->getGalleryId(),
		$this->profile->getProfileId(),
		$this->VALID_IMAGEDATE,
		$this->VALID_IMAGETITLE,
		$this->VALID_IMAGEURL
	);
	$image->insert($this->getPDO());

	// grab the data from mySQL and enforce the fields match expectations
	$pdoImage = Image::getImageByGalleryId($this->getPDO(), $image->getImageGalleryId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
	$this->assertEquals($pdoImage->getImageId(), $imageId);
	$this->assertEquals($pdoImage->getImageGalleryId(), $this->gallery->getGalleryId());
	$this->assertEquals($pdoImage->getImageProfileId(), $this->profile->getProfileId());
	$this->assertEquals($pdoImage->getImageDate()->getTimestamp(), $this->VALID_IMAGEDATE->getTimestamp());
	$this->assertEquals($pdoImage->getImageTitle(), $this->VALID_IMAGETITLE);
	$this->assertEquals($pdoImage->getImageUrl(), $this->VALID_IMAGEURL);
}

/****************************************************************************************************************
 * TEST SELECTING ALL IMAGES
 **************************************************************************************************************/
/****************************************************************************************************************
 * TEST SELECTING IMAGES BY PROFILE DISTANCE TODO get unit testing done before this -George
 **************************************************************************************************************/
