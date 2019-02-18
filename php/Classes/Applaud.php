<?php
namespace ArtLocale\ArtHaus;
// use my local autoload I made:
require_once("autoload.php");
// use autoload via composer (PHP's package manager):
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
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
class Applaud implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
	/*  The database attributes:
				applaudProfileId BINARY(16) NOT NULL,
				applaudImageId BINARY(16) NOT NULL,
				applaudCount INT(1) NULL,
        simplified attribute names:
            applaudProfileId,
            applaudImageId,
            applaudCount
	*/
	/**
	 * the profile ID of the user that applauded; this is a foreign key
	 * @var Uuid $applaudProfileId
	 **/
	private $applaudProfileId;
	/**
	 * the associated images's ID; this is a foreign key
	 * @var Uuid $applaudImageId
	 **/
	private $applaudImageId;
	/**
	 * number of applauds given by one user
	 * @var INT $applaudCount
	 **/
	private $applaudCount;
	/* START CONSTRUCTOR METHOD*/
	/**
	 * constructor for each new applaud object/ instance
	 *
	 * @param Uuid|string $newApplaudProfileId ID of the user that applauded
	 * @param Uuid|string $newApplaudImageId id of the associated image
	 * @param INT $newApplaudCount number of claps for one image from one user
	 *
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newApplaudProfileId, $newApplaudImageId, INT $newApplaudCount) {
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
	 * @return Uuid value of applaud profile id
	 **/
	public function getApplaudProfileId(): Uuid {
		return ($this->applaudProfileId);
	}
	/**
	 * SETTER mutator method for applaud profile id
	 *
	 * @param Uuid|string $newApplaudProfileId new value of applaud profile Id
	 * @throws \RangeException if $newApplaudProfileId is not positive
	 * @throws \TypeError if $newApplaudProfileId is not a uuid or string
	 **/
	public function setApplaudProfileId($newApplaudProfileId) {
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
	 * @return Uuid value of applaud image id
	 **/
	public function getApplaudImageId(): Uuid {
		return ($this->applaudImageId);
	}
	/**
	 * SETTER mutator method for applaud image id
	 *
	 * @param Uuid|string $newApplaudImageId new value of applaud image id
	 * @throws \RangeException if $newApplaudImageId is not positive
	 * @throws \TypeError if $newApplaudImageId is not a uuid or string
	 **/
	public function setApplaudImageId($newApplaudImageId) {
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
	 * Accessor method for applaud
	 *
	 * @return INT number of applauds
	 **/
	public function getApplaudCount(): INT {
		return($this->applaudCount);
 }
 /**
 	* mutator method for applaud
	* @param INT $newApplaudCount new value of applaud count
	* @throws \InvalidArgumentException if $newApplaudCount is not a string or insecure
	* @throws \RangeException if $newApplaudCount is > 140 characters
	* @throws \TypeError if $newApplaudCount is not a string
	**/
	public function setApplaudCount(INT $newApplaudCount) {
	if(empty($newApplaudCount) === true) {
			throw(new \InvalidArgumentException("applaud count is empty"));
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
		$query = "INSERT INTO applaud(applaudProfileId, applaudImageId, applaudCount) VALUES(:applaudProfileId, :applaudImageId, :applaudCount)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["applaudProfileId" => $this->applaudProfileId->getBytes(), "applaudImageId" => $this->applaudImageId->getBytes(), "applaudCount" => $this->applaudCount];
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
		$query = "DELETE FROM applaud WHERE applaudProfileId = :applaudProfileId AND applaudImageId = :applaudImageId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["applaudProfileId" => $this->applaudProfileId->getBytes(), "applaudImageId" => $this->applaudImageId->getBytes()];
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
		$parameters = ["applaudProfileId" => $this->applaudProfileId->getBytes(), "applaudImageId" => $this->applaudImageId->getBytes(), "applaudCount" => $this->applaudCount];
		$statement->execute($parameters);
	}
	//END UPDATE METHOD
	/* START SEARCH STATIC METHODS: RETURN OBJECT */
//********************************************************************************************
	/**
	 * gets the applaud object by applaudProfileId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid $applaudProfileId applaud profile id to search for
	 * @return applaud|null Applaud found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getApplaudByApplaudProfileId (\PDO $pdo, Uuid $applaudProfileId) : ?Applaud {

		try {
			$applaudProfileId = self::validateUuid($applaudProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
					throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		$query = "SELECT applaudProfileId, applaudImageId, applaudCount FROM applaud WHERE applaudProfileId = :applaudProfileId";
		$statement = $pdo->prepare($query);

		// bind the applaudProfileId to the place holder in the template
		// $parameters = ["applaudProfileId" => $this->applaudProfileId->getBytes()];
		$parameters = ["applaudProfileId" => $applaudProfileId->getBytes()];
		$statement->execute($parameters);

		// get the profile applauds from mySQL
		try {
			$applaud = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$applaud = new Applaud($row["applaudProfileId"], $row["applaudImageId"], $row["applaudCount"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($applaud);
		}
		// end getApplaudByApplaudProfileId
//****************************************************************************************
	/**
	 * gets the applaud object by applaudImageId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid $applaudImageId applaud image id to search for
	 * @return applaud|null Applaud found or null if not found
	 **/
	 public static function getApplaudByApplaudImageId (\PDO $pdo, Uuid $applaudImageId) : ?Applaud {

 		try {
 			$applaudImageId = self::validateUuid($applaudImageId);
 		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
 					throw(new \PDOException($exception->getMessage(), 0, $exception));
 		}
 		$query = "SELECT applaudProfileId, applaudImageId, applaudCount FROM applaud WHERE applaudImageId = :applaudImageId";
 		$statement = $pdo->prepare($query);

 		// bind the applaudProfileId to the place holder in the template
 		// $parameters = ["applaudProfileId" => $this->applaudProfileId->getBytes()];
 		$parameters = ["applaudImageId" => $applaudImageId->getBytes()];
 		$statement->execute($parameters);

 		// get the profile applauds from mySQL
 		try {
 			$applaud = null;
 			$statement->setFetchMode(\PDO::FETCH_ASSOC);
 			$row = $statement->fetch();
 			if($row !== false) {
 				$applaud = new Applaud($row["applaudProfileId"], $row["applaudImageId"], $row["applaudCount"]);
 			}
 		} catch(\Exception $exception) {
 			// if the row couldn't be converted, rethrow it
 			throw(new \PDOException($exception->getMessage(), 0, $exception));
 		}
 		return ($applaud);
 		}
	//****************************************************************************************

	/**
	 * gets the applaud by profile id and image id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid $applaudProfileId profile id to search for
	 * @param Uuid $applaudImageId image id to search for
	 * @return applaud|null Applaud found or null if not found
	 */
	public static function getApplaudByApplaudImageIdandApplaudProfileId(\PDO $pdo, $applaudProfileId, $applaudImageId) : ?Applaud {
		//
		try {
			$applaudProfileId = self::validateUuid($applaudProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		try {
			$applaudImageId = self::validateUuid($applaudImageId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT applaudProfileId, applaudImageId, applaudCount FROM applaud WHERE applaudProfileId = :applaudProfileId AND applaudImageId = :applaudImageId";
		$statement = $pdo->prepare($query);

		// bind the profile id and image id to the place holder in the template
		$parameters = ["applaudProfileId" => $applaudProfileId->getBytes(), "applaudImageId" => $applaudImageId->getBytes()];
		$statement->execute($parameters);

		// grab the applaud from mySQL
		try {
			$applaud = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$applaud = new Applaud($row["applaudProfileId"], $row["applaudImageId"], $row["applaudCount"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($applaud);
	}

	// end getApplaudByApplaudImageIdandApplaudProfileId
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize(): array {
		$fields = get_object_vars($this);
	//foreign keys
		$fields["applaudImageId"] = $this->applaudImageId->toString();
		$fields["applaudProfileId"] = $this->applaudProfileId->toString();
		return ($fields);
	}
}
