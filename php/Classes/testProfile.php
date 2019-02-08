<?php
namespace ArtLocale\ArtHaus;

use art-haus\sql\ddl-art-locale{Profile};
use Ramsey\Uuid\Uuid;

// grab the encrypted properties file
require_once("/etc/apache2/capstone-mysql/Secret.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Profile class
 *
 * This is a complete PHPUnit test of the Profile class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Profile
 * @author William Isengard william.isengard@gmail.com>
 **/
