<?php
namespace ArtLocale\ArtHaus\ArtHausTest;

use ArtLocale\ArtHaus\{Profile};

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

 class ProfileTest extends ArtHausTest {
 	/**
 	 * Art Haus user profile
 	 * @var Profile profile
 	 **/
 	protected $profile = null;

 	/**
 	 * id for this profile
 	 * @var Uuid $VALID_PROFILEID
 	 */
 	protected $VALID_PROFILEID;

 	/**
 	 * Activation token for initial profile creation
 	 * @var string $VALID_PROFILEACTIVATIONTOKEN
 	 **/
 	protected $VALID_PROFILEACTIVATIONTOKEN = "PHPUnit test passing";

 	/**
 	 * Date and time profile was created; this starts as null and is assigned later
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
   * Email address for profile owner
   * @var string $VALID_PROFILEEMAIL
   **/
  protected $VALID_PROFILEEMAIL = "PHPUnit test still passing";

  /**
   * Location of profile owner
   * @var string $VALID_PROFILELOCATION
   **/
  protected $VALID_PROFILELOCATION = "PHPUnit test still passing";

  /**
   * Name of profile owner
   * @var string $VALID_PROFILENAME
   **/
  protected $VALID_PROFILENAME = "PHPUnit test still passing";

  /**
   * Hash of profile owner account password
   * @var string $VALID_PROFILEPASSWORD
   **/
  protected $VALID_PROFILEPASSWORD = "PHPUnit test still passing";

  /**
   * Website of profile owner
   * @var string $VALID_PROFILEWEBSITE
   **/
  protected $VALID_PROFILEWEBSITE = "PHPUnit test still passing";

  /**
   * create dependent objects before running each test
   **/
  public final function setUp()  : void {
    // run the default setUp() method first
    parent::setUp();
    $password = "abc123";
    $this->VALID_PROFILEPASSWORD = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);

    // create and insert a Profile to own the test Profile
    $this->profile = new Profile(generateUuidV4(), "ActivationTokenActivationTokenAc", null, "test@test.com", "Latitude/Longitude", "Spiderman The Artist", $this->VALID_PROFILEPASSWORD, "www.test.com");
    $this->profile->insert($this->getPDO());

    // calculate the date (just use the time the unit test was setup...)
    $this->VALID_PROFILEDATE = new \DateTime();

    //format the sunrise date to use for testing
    $this->VALID_SUNRISEDATE = new \DateTime();
    $this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

    //format the sunset date to use for testing
    $this->VALID_SUNSETDATE = new\DateTime();
    $this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));
  }

  //   /**
  //  * test inserting a Tweet, editing it, and then updating it
  //  **/
  // public function testUpdateValidTweet() : void {
  //   // count the number of rows and save it for later
  //   $numRows = $this->getConnection()->getRowCount("tweet");
  //
  //   // create a new Tweet and insert to into mySQL
  //   $tweetId = generateUuidV4();
  //   $tweet = new Tweet($tweetId, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
  //   $tweet->insert($this->getPDO());
  //
  //   // edit the Tweet and update it in mySQL
  //   $tweet->setTweetContent($this->VALID_TWEETCONTENT2);
  //   $tweet->update($this->getPDO());
  //
  //   // grab the data from mySQL and enforce the fields match our expectations
  //   $pdoTweet = Tweet::getTweetByTweetId($this->getPDO(), $tweet->getTweetId());
  //   $this->assertEquals($pdoTweet->getTweetId(), $tweetId);
  //   $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
  //   $this->assertEquals($pdoTweet->getTweetProfileId(), $this->profile->getProfileId());
  //   $this->assertEquals($pdoTweet->getTweetContent(), $this->VALID_TWEETCONTENT2);
  //   //format the date too seconds since the beginning of time to avoid round off error
  //   $this->assertEquals($pdoTweet->getTweetDate()->getTimestamp(), $this->VALID_TWEETDATE->getTimestamp());
  // }

  /**
   * test grabbing a Tweet by tweet content
   **/
  public function testGetValidProfileByProfileName() : void {
    // count the number of rows and save it for later
    $numRows = $this->getConnection()->getRowCount("profile");

    // create a new Profile and insert to into mySQL
    $profileId = generateUuidV4();
    $profile = new Profile($profileId, $this->VALID_PROFILEACTIVATIONTOKEN, $this->VALID_PROFILEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILELOCATION, $this->VALID_PROFILENAME, $this->VALID_PROFILEPASSWORD, $this->VALID_PROFILEWEBSITE);
    $profile->insert($this->getPDO());

  //   // grab the data from mySQL and enforce the fields match our expectations
  //   $results = Tweet::getTweetByTweetContent($this->getPDO(), $tweet->getTweetContent());
  //   $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
  //   $this->assertCount(1, $results);
  //
  //   // enforce no other objects are bleeding into the test
  //   $this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Tweet", $results);
  //
  //   // grab the result from the array and validate it
  //   $pdoTweet = $results[0];
  //   $this->assertEquals($pdoTweet->getTweetId(), $tweetId);
  //   $this->assertEquals($pdoTweet->getTweetProfileId(), $this->profile->getProfileId());
  //   $this->assertEquals($pdoTweet->getTweetContent(), $this->VALID_TWEETCONTENT);
  //   //format the date too seconds since the beginning of time to avoid round off error
  //   $this->assertEquals($pdoTweet->getTweetDate()->getTimestamp(), $this->VALID_TWEETDATE->getTimestamp());
  // }


