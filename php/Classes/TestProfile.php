<?php
namespace ArtLocale\ArtHaus;

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

