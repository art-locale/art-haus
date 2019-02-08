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

