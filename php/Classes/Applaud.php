<?php
namespace ArtLocale\ArtHaus;

// use my local autoload I made:
require_once("autoload.php");
// use autoload via composer (PHP's package manager):
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Capstone project for Art-Locale team, Deepdive cohort 23, Spring 2019
 *
 * This assignment creates a class for 'applaud' counts and builds a PHP program
 * that populates and manipulates the corresponding SQL table.
 *
 * @author Will Tredway <jtredway@cnm.edu>
 * @version 1.0.0
 **/
class Applaud {
	use ValidateDate;
	use ValidateUuid;

	/*  The database attributes:
				applaudProfileId BINARY(16) NOT NULL,
				applaudImageId BINARY(16) NOT NULL,
				applaudCount TINYINT(1) NULL,

        simplified attribute names:
            applaudProfileId,
            applaudImageId,
            applaudCount
	*/

	/**
	 * the profile ID of the user that applauded; this is a foreign key
	 * @var string $galleryId
	 **/
	private $applaudProfileId;

	/**
	 * the associated images's ID; this is a foreign key
	 * @var string $applaudImageId
	 **/
	private $applaudImageId;

	/**
	 * number of applauds given by one user
	 * @var int $applaudCount
	 **/
	private $applaudCount;


	/* START CONSTRUCTOR METHOD*/
	/**
	 * constructor for each new applaud object/ instance
	 *
	 * @param Uuid|string $applaudProfileId ID of the user that applauded
	 * @param Uuid|string $applaudImageId id of the associated image
	 * @param int $applaudCount number of claps for one image from one user
	 *
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newApplaudProfileId, $newApplaudImageId, $newApplaudCount) {
		try {
			$this->setApplaudProfileId($newApplaudProfileId);
			$this->setApplaudImageId($newApplaudImageId);
			$this->setApplaudCount($newApplaudCount);

		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \TypeError | \Exception $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	} /* END CONSTRUCTOR METHOD*/


	/* START APPLAUD-PROFILE-ID METHODS*/
	/**
	 * GETTER accessor method for applaud profile id
	 *
	 * @return string value of applaud profile id
	 **/
	public function getApplaudProfileId(): string {
		return ($this->applaudProfileId);
	}

	/**
	 * SETTER mutator method for applaud profile id
	 *
	 * @param Uuid|string $newApplaudProfileId new value of applaud profile Id
	 * @throws \RangeException if $newApplaudProfileId is not positive
	 * @throws \TypeError if $newApplaudProfileId is not a uuid or string
	 **/
	public function setApplaudProfileId($newApplaudProfileId): void {
		try {
			$uuid = self::validateUuid($newApplaudProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the author id
		$this->applaudProfileId = $uuid;
	}
	/* END APPLAUD-PROFILE-ID METHODS*/


	/* START APPLAUD-IMAGE-ID METHODS*/
	/**
	 * GETTER accessor method for image id that received applause
	 *
	 * @return string value of applaud image id
	 **/
	public function getApplaudImageId(): string {
		return ($this->galleryId);
	}

	/**
	 * SETTER mutator method for applaud image id
	 *
	 * @param Uuid|string $newApplaudImageId new value of applaud image id
	 * @throws \RangeException if $newApplaudImageId is not positive
	 * @throws \TypeError if $newApplaudImageId is not a uuid or string
	 **/
	public function setApplaudImageId($newApplaudImageId): void {
		try {
			$uuid = self::validateUuid($newApplaudImageId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the author id
		$this->applaudImageId = $uuid;
	}
	/* END APPLAUD-IMAGE-ID METHODS*/


	/* START APPLAUD-COUNT METHODS*/
	/**
	 * SETTER mutator method for number of applauds
	 *
	 * @param string $newApplaudCount new value of applaud count
	 * @throws \InvalidArgumentException if $newApplaudCount is not a string or insecure
	 * @throws \RangeException if $newApplaudCount is > 140 characters
	 * @throws \TypeError if $newApplaudCount is not a string
	 **/
	public function setApplaudCount(string $newApplaudCount): void {
		// verify the author's username is secure
		$newApplaudCount = trim($newApplaudCount);
		$newApplaudCount = filter_var($newApplaudCount, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newApplaudCount) === true) {
			throw(new \InvalidArgumentException("applaud count is empty or insecure"));
		}

		// verify the author's username will fit in the database
		if(strlen($newApplaudCount) > 255) {
			throw(new \RangeException("applaud count is too large"));
		}

		// store the author's username
		$this->applaudCount = $newApplaudCount;
	}
	/* END APPLAUD-COUNT METHODS*/


	//Applaud class methods:
	//insert method
	//update method
	//delete method

	// Applaud attributes:
	//	applaudProfileId
	//	applaudImageId
	//	applaudCount

	/* START INSERT METHOD */
	/**
	 * inserts an already-made applaud object (instance of Applaud class) into the mySQL database (into the applaud table)
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {

		// create query template with associative array indexes:
		$query = "INSERT INTO applaud(applaudeProfileId, applaudImageId, applaudCount) VALUES(:applaudeProfileId, :applaudImageId, :applaudCount)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["applaudeProfileId" => $this->applaudeProfileId->getBytes(), "applaudImageId" => $this->applaudImageId, "applaudCount" => $this->applaudCount];
		$statement->execute($parameters);
	}
	/* END INSERT METHOD */


	/* START DELETE METHOD */
	/**
	 * deletes an applaud field from the mySQL database
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {

		// create query template
		$query = "DELETE FROM applaud WHERE applaudeProfileId = :applaudeProfileId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["applaudeProfileId" => $this->applaudeProfileId->getBytes()];
		$statement->execute($parameters);
	}
	/* END DELETE METHOD */


	/* START UPDATE METHOD */
	/**
	 * updates this applaud's info in mySQL database
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo): void {

		// create query template
		$query = "UPDATE applaud SET applaudProfileId = :applaudProfileId, applaudImageId = :applaudImageId, applaudCount = :applaudCount";
		$statement = $pdo->prepare($query);

		$parameters = ["applaudProfileId" => $this->applaudProfileId->getBytes(), "applaudImageId" => $this->applaudImageId, "applaudCount" => $this->applaudCount];
		$statement->execute($parameters);
	}
	/* END UPDATE METHOD */
}



