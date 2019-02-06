<?php
namespace jtredway\ArtLocale;

// use my local autoload I made:
require_once("autoload.php");
// use autoload via composer (PHP's package manager):
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Capstone project for Art-Locale team, Deepdive cohort 23, Spring 2019
 *
 * This assignment creates a class for galleries and builds a PHP program
 * that populates and manipulates the corresponding SQL table.
 *
 * @author Will Tredway <jtredway@cnm.edu>
 * @version 1.0.0
 **/
class Gallery {
	use ValidateDate;
	use ValidateUuid;

	/*  The database attributes:
            galleryId BINARY(16) NOT NULL, -- FIXME any consideration here for Auto incrementing?
            galleryProfileId BINARY(16) NOT NULL,
            galleryDate DATETIME(6) NOT NULL, -- FIXME look into other options
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
	 * date and time this Tweet was sent, in a PHP DateTime object
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
	 * constructor for each new author object/ instance/ record
	 *
	 * @param Uuid|string $newGalleryId ID of this gallery
	 * @param Uuid|string $newGalleryProfileId id of this gallery's associated profile ID
	 * @param \DateTime|string|null $newTweetDate date and time gallery was created or null FIXME for some reason
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
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	} /* END CONSTRUCTOR METHOD*/


	/* START GALLERY-ID METHODS*/
	/**
	 * GETTER accessor method for gallery id
	 *
	 * @return string value of gallery id
	 **/
	public function getGalleryId(): string {
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

		// convert and store the author id
		$this->galleryId = $uuid;
	}
	/* END GALLERY-ID METHODS*/


	/* START GALLERY-PROFILE-ID METHODS*/
	/**
	 * GETTER accessor method for gallery id
	 *
	 * @return string value of gallery id
	 **/
	public function getGalleryProfileId(): string {
		return ($this->galleryId);
	}

	/**
	 * SETTER mutator method for author id
	 *
	 * @param Uuid|string $newGalleryId new value of author id
	 * @throws \RangeException if $newGalleryId is not positive
	 * @throws \TypeError if $newGalleryId is not a uuid or string
	 **/
	public function setGalleryProfileId($newGalleryId): void {
		try {
			$uuid = self::validateUuid($newGalleryId);
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
	 * accessor method for tweet date
	 *
	 * @return \DateTime value of tweet date
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
			$newGalleryDate = self::validateDateTime($newGalleryDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->galleryDate = $newGalleryDate;
	}
	/* END GALLERY-DATE METHODS*/


	/* START GALLERY-NAME METHODS*/
	/**
	 * GETTER accessor method for author's username
	 *
	 * @return string value of author's username
	 **/
	public function getGalleryName(): string {
		return ($this->galleryName);
	}

	/**
	 * SETTER mutator method for author's username
	 *
	 * @param string $newAuthorUsername new value of author's username
	 * @throws \InvalidArgumentException if $newAuthorUsername is not a string or insecure
	 * @throws \RangeException if $newAuthorUsername is > 140 characters
	 * @throws \TypeError if $newAuthorUsername is not a string
	 **/
	public function setGalleryName(string $newAuthorUsername): void {
		// verify the author's username is secure
		$newAuthorUsername = trim($newAuthorUsername);
		$newAuthorUsername = filter_var($newAuthorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorUsername) === true) {
			throw(new \InvalidArgumentException("author's username is empty or insecure"));
		}

		// verify the author's username will fit in the database
		if(strlen($newAuthorUsername) > 255) {
			throw(new \RangeException("author's username too large"));
		}

		// store the author's username
		$this->galleryName = $newAuthorUsername;
	}
	/* END GALLERY-NAME METHODS*/


	//Object Oriented Part 2:
//Write and Document an insert statement method
//Write and Document an update statement method
//Write and Document a delete statement method
//Write and document a getFooByBar method that returns a single object
//Write and document a getFooByBar method that returns a full array

	/* START INSERT METHOD */
	/**
	 * inserts an already-made author object (instance of Author class) into the mySQL database (into the author table)
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		// create query template with associative array indexes:
		$query = "INSERT INTO author(authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername) VALUES(:authorId, :authorAvatarUrl, :authorActivationToken, :authorEmail, :authorHash, :authorUsername)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["authorId" => $this->galleryId->getBytes(), "authorAvatarUrl" => $this->authorAvatarUrl, "authorActivationToken" => $this->authorActivationToken, "authorEmail" => $this->authorEmail, "authorHash" => $this->authorHash, "authorUsername" => $this->galleryName];
		$statement->execute($parameters);
	}
	/* END INSERT METHOD */


	/* START DELETE METHOD */
	/**
	 * deletes an author from the mySQL database
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		// create query template
		$query = "DELETE FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["authorId" => $this->galleryId->getBytes()];
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
		$query = "UPDATE author SET galleryId = :galleryId, galleryProfileId = :galleryProfileId, galleryDate = :galleryDate, galleryName = :galleryName";
		$statement = $pdo->prepare($query);

		$parameters = ["authorId" => $this->galleryId->getBytes(),"authorAvatarUrl" => $this->authorAvatarUrl, "authorActivationToken" => $this->authorActivationToken, "authorEmail" => $this->authorEmail, "authorHash" => $this->authorHash, "authorUsername" => $this->galleryName];
		$statement->execute($parameters);
	}
	/* END UPDATE METHOD */


	/* START SEARCH STATIC METHOD: RETURN OBJECT */
//	/**
//	 * gets the author's username by authorId
//	 *
//	 * @param \PDO $pdo PDO connection object
//	 * @param Uuid|string $authorId author id to search for
//	 * @return author|null author found or null if not found
//	 * @throws \PDOException when mySQL related errors occur
//	 * @throws \TypeError when a variable are not the correct data type
//	 **/
//	public static function getAuthorByAuthorId(\PDO $pdo, $authorId) : ?author {
//		// sanitize the authorId before searching
//		try {
//			$authorId = self::validateUuid($authorId);
//		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
//			throw(new \PDOException($exception->getMessage(), 0, $exception));
//		}
//
//		// create query template
//		$query = "SELECT authorId, authorUsername FROM author WHERE authorId = :authorId";
//		$statement = $pdo->prepare($query);
//
//		// bind the author id to the place holder in the template
//		$parameters = ["authorId" => authorId];
//		$statement->execute($parameters);
//
//		// get the author from mySQL
//		try {
//			$author = null;
//			$statement->setFetchMode(\PDO::FETCH_ASSOC);
//			$row = $statement->fetch();
//			if($row !== false) {
//				$author = new Author($row["authorId"], $row["authorUsername"]);
//			}
//		} catch(\Exception $exception) {
//			// if the row couldn't be converted, rethrow it
//			throw(new \PDOException($exception->getMessage(), 0, $exception));
//		}
//		return($author);
//	}
//	/* END SEARCH STATIC METHOD: RETURN OBJECT */
//
//
//	/* START SEARCH STATIC METHOD: RETURN ARRAY */
//	/**
//	 * gets the author username by email
//	 *
//	 * @param \PDO $pdo PDO connection object
//	 * @param string $authorEmail author email to search for
//	 * @return \SplFixedArray SplFixedArray of authors found
//	 * @throws \PDOException when mySQL related errors occur
//	 * @throws \TypeError when variables are not the correct data type
//	 **/
//	public static function getAuthorByEmail(\PDO $pdo, string $authorEmail) : \SplFixedArray {
//		// sanitize the description before searching
//		$authorEmail = trim($authorEmail);
//		$authorEmail = filter_var($authorEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
//		if(empty($authorEmail) === true) {
//			throw(new \PDOException(" author email is invalid"));
//		}
//
//		// escape any mySQL wild cards
//		$authorEmail = str_replace("_", "\\_", str_replace("%", "\\%", $authorEmail));
//
//		// create query template
//		$query = "SELECT authrId, authorEmail, authorUsername FROM author WHERE authorEmail LIKE :authorEmail";
//		$statement = $pdo->prepare($query);
//
//		// bind the tweet content to the place holder in the template
//		$authorEmail = "%$authorEmail%";
//		$parameters = ["authorEmail" => $authorEmail];
//		$statement->execute($parameters);
//
//		// build an array of tweets
//		$authors = new \SplFixedArray($statement->rowCount());
//		$statement->setFetchMode(\PDO::FETCH_ASSOC);
//		while(($row = $statement->fetch()) !== false) {
//			try {
//				$author = new Author($row["authorId"], $row["authorEmail"], $row["authorUsername"]);
//				$authors[$authors->key()] = $author;
//				$authors->next();
//			} catch(\Exception $exception) {
//				// if the row couldn't be converted, rethrow it
//				throw(new \PDOException($exception->getMessage(), 0, $exception));
//			}
//		}
//		return($authors);
//	}
//	/* END SEARCH STATIC METHOD: RETURN ARRAY */

} /* END OF CLASS AUTHOR */



