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
 * This creates a class for galleries and builds a PHP program
 * that populates and manipulates the corresponding SQL table.
 *
 * @author Will Tredway <jtredway@cnm.edu>
 * @version 1.0.0
 **/
class Gallery {
	use ValidateDate;
	use ValidateUuid;

	/*  The database attributes:
            galleryId BINARY(16) NOT NULL,
            galleryProfileId BINARY(16) NOT NULL,
            galleryDate DATETIME(6) NOT NULL,
            galleryName VARCHAR(32) NOT NULL,

        simplified attribute names:
            galleryId,
            galleryProfileId,
            galleryDate,
            galleryName
	*/

	/**
	 * the gallery's ID; this is the primary key
	 * @var string $galleryId
	 **/
	private $galleryId;

	/**
	 * the associated profile's ID; this is a foreign key
	 * @var string $galleryProfileId
	 **/
	private $galleryProfileId;

	/**
	 * date and time this Tweet was created, in a PHP DateTime object
	 * @var \DateTime $galleryDate
	 **/
	private $galleryDate;

	/**
	 * the gallery's name
	 * @var string $galleryName
	 **/
	private $galleryName;


	/* START CONSTRUCTOR METHOD*/
	/**
	 * constructor for each new gallery object/ instance
	 *
	 * @param Uuid|string $newGalleryId ID of this gallery
	 * @param Uuid|string $newGalleryProfileId id of this gallery's associated profile ID
	 * @param \DateTime|string|null $newGalleryDate date and time gallery was created or null
	 * @param string $newGalleryName gallery's name
	 *
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newGalleryId, $newGalleryProfileId, $newGalleryDate, $newGalleryName) {
		try {
			$this->setGalleryId($newGalleryId);
			$this->setGalleryProfileId($newGalleryProfileId);
			$this->setGalleryDate($newGalleryDate);
			$this->setGalleryName($newGalleryName);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \TypeError | \Exception $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	} /* END CONSTRUCTOR METHOD*/


	/* START GALLERY-ID METHODS*/
	/**
	 * GETTER accessor method for gallery id
	 *
	 * @return uuid | string value of gallery id
	 **/
	public function getGalleryId(): uuid  {
		return ($this->galleryId);
	}

	/**
	 * SETTER mutator method for gallery id
	 *
	 * @param Uuid|string $newGalleryId new value of gallery id
	 * @throws \RangeException if $newGalleryId is not positive
	 * @throws \TypeError if $newGalleryId is not a uuid or string
	 **/
	public function setGalleryId($newGalleryId): void {
		try {
			$uuid = self::validateUuid($newGalleryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the gallery id
		$this->galleryId = $uuid;
	}
	/* END GALLERY-ID METHODS*/


	/* START GALLERY-PROFILE-ID METHODS*/
	/**
	 * GETTER accessor method for gallery profile id
	 *
	 * @return string value of gallery profile id
	 **/
	public function getGalleryProfileId(): uuid  {
		return ($this->galleryProfileId);
	}

	/**
	 * SETTER mutator method for gallery profile id
	 *
	 * @param Uuid|string $newGalleryProfileId new value of gallery profile id
	 * @throws \RangeException if $newGalleryProfileId is not positive
	 * @throws \TypeError if $newGalleryProfileId is not a uuid or string
	 **/
	public function setGalleryProfileId($newGalleryProfileId): void {
		try {
			$uuid = self::validateUuid($newGalleryProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the author id
		$this->galleryId = $uuid;
	}
	/* END GALLERY-PROFILE-ID METHODS*/


	/* START GALLERY-DATE METHODS*/
	/**
	 * accessor method for gallery date
	 *
	 * @return \DateTime value of gallery date
	 **/
	public function getGalleryDate() : \DateTime {
		return($this->galleryDate);
	}

	/**
	 * mutator method for gallery creation date
	 *
	 * @param \DateTime|string|null $newGalleryDate gallery date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newGalleryDate is not a valid object or string
	 * @throws \RangeException if $newGalleryDate is a date that does not exist
	 **/
	public function setGalleryDate($newGalleryDate = null) : void {
		// base case: if the date is null, use the current date and time
		if($newGalleryDate === null) {
			$this->galleryDate = new \DateTime();
			return;
		}

		// store the like date using the ValidateDate trait
		try {
			$newGalleryDate = self::validateDate($newGalleryDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->galleryDate = $newGalleryDate;
	}
	/* END GALLERY-DATE METHODS*/


	/* START GALLERY-NAME METHODS*/
	/**
	 * GETTER accessor method for gallery's name
	 *
	 * @return string value of gallery's name
	 **/
	public function getGalleryName(): string {
		return ($this->galleryName);
	}

	/**
	 * SETTER mutator method for gallery name
	 *
	 * @param string $newGalleryName new value of gallery's name
	 * @throws \InvalidArgumentException if $newGalleryName is not a string or insecure
	 * @throws \RangeException if $newGalleryName is > 140 characters
	 * @throws \TypeError if $newGalleryName is not a string
	 **/
	public function setGalleryName(string $newGalleryName): void {
		// verify the gallery's name is secure
		$newGalleryName = trim($newGalleryName);
		$newAuthorUsername = filter_var($newGalleryName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newGalleryName) === true) {
			throw(new \InvalidArgumentException("author's username is empty or insecure"));
		}

		// verify the author's username will fit in the database
		if(strlen($newGalleryName) > 255) {
			throw(new \RangeException("author's username too large"));
		}

		// store the gallery's name
		$this->galleryName = $newGalleryName;
	}
	/* END GALLERY-NAME METHODS*/


	/* START INSERT METHOD */
	/**
	 * inserts an already-made gallery object (instance of Gallery class) into the mySQL database (into the gallery table)
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		// create query template with associative array indexes:
		$query = "INSERT INTO gallery(galleryId, galleryProfileId, galleryDate, galleryName) VALUES(:galleryId, :galleryProfileId, :galleryDate, :galleryName)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["galleryId" => $this->galleryId->getBytes(), "galleryProfileId" => $this->galleryProfileId, "galleryDate" => $this->galleryDate, "galleryName" => $this->galleryName];
		$statement->execute($parameters);
	}
	/* END INSERT METHOD */


	/* START DELETE METHOD */
	/**
	 * deletes a gallery from the mySQL database
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		// create query template
		$query = "DELETE FROM author WHERE galleryId = :galleryId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["galleryId" => $this->galleryId->getBytes()];
		$statement->execute($parameters);
	}
	/* END DELETE METHOD */


	/* START UPDATE METHOD */
	/**
	 * updates this gallery's info in mySQL database
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {

		// create query template
		$query = "UPDATE gallery SET galleryId = :galleryId, galleryProfileId = :galleryProfileId, galleryDate = :galleryDate, galleryName = :galleryName";
		$statement = $pdo->prepare($query);

		$parameters = ["galleryId" => $this->galleryId->getBytes(), "galleryProfileId" => $this->galleryProfileId, "galleryDate" => $this->galleryDate, "galleryName" => $this->galleryName];
		$statement->execute($parameters);
	}
	/* END UPDATE METHOD */


	/* START SEARCH STATIC METHODS: RETURN OBJECT */

	/**
	 * gets the gallery name by galleryProfileId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid $galleryProfileId gallery profile id to search for
	 * @return gallery|null author found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getGalleryByGalleryId(\PDO $pdo, $galleryId) : ?gallery {
		// sanitize the galleryId before searching
		try {
			$galleryId = self::validateUuid($galleryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT galleryId, galleryName FROM gallery WHERE galleryId = :galleryId";
		$statement = $pdo->prepare($query);

		// bind the gallery id to the place holder in the template
		$parameters = ["galleryId" => galleryId];
		$statement->execute($parameters);

		// get the gallery from mySQL
		try {
			$gallery = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$author = new Gallery($row["galleryId"], $row["galleryName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($gallery);
	}


	/**
	 * gets the gallery name by GalleryProfileId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid $GalleryProfileId profile id to search for
	 * @return author|null author found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getGalleryByGalleryProfileId(\PDO $pdo, $GalleryProfileId) : ?gallery {
		// sanitize the galleryProfileId before searching
		try {
			$galleryId = self::validateUuid($GalleryProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT galleryId, galleryName FROM gallery WHERE galleryProfileId = :galleryProfileId";
		$statement = $pdo->prepare($query);

		// bind the gallery id to the place holder in the template
		$parameters = ["galleryProfileId" => galleryProfileId];
		$statement->execute($parameters);

		// get the gallery from mySQL
		try {
			$gallery = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$gallery = new Gallery($row["galleryProfileId"], $row["galleryName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($gallery);
	}
	/* END SEARCH STATIC METHODS: RETURN OBJECT */


} /* END OF CLASS AUTHOR */
