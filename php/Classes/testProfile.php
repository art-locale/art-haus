<?php
namespace ArtLocale\ArtHaus;

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\DataSet\QueryDataSet;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\Operation\{Composite, Factory, Operation};

// grab the encrypted properties file
require_once("/etc/apache2/capstone-mysql/Secret.php");

require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");


/**
 * Full PHPUnit test for the Profile class
 *
 * This is a complete PHPUnit test of the Profile class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Profile
 * @author William Isengard william.isengard@gmail.com>
 **/

 abstract class DataDesignTest extends TestCase {
 	use TestCaseTrait;
 
 	/**
 	 * PHPUnit database connection interface
 	 * @var Connection $connection
 	 **/
 	protected $connection = null;

 	/**
 	 * assembles the table from the schema and provides it to PHPUnit
 	 *
 	 * @return QueryDataSet assembled schema for PHPUnit
 	 **/
 	public final function getDataSet() : QueryDataSet {
 		$dataset = new QueryDataSet($this->getConnection());

 		// add all the tables for the project here
 		// THESE TABLES *MUST* BE LISTED IN THE SAME ORDER THEY WERE CREATED!!!!
 		$dataset->addTable("profile");
 		$dataset->addTable("gallery");
    $dataset->addTable("image");
    $dataset->addTable("applaud");
 		return($dataset);
 	}
