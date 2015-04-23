<?php
// this includes @DylanMcdonald's custom mySQL datetime feature
require_once "sqltime.php";
/**
 * this is the Article class
 *
 * the profile class will contain profileId (primary key),
 * profileId (foreign key) id number of user
 * articleId (primary key)
 * articleContents article contents in HTML (BB code?) format
 * articleTime time of article posting
 *
 * @author Tyler Wiegand <tyler dot wiegand at me dot com>
 **/
class Article {
	/**
	 * unique ID for the article in question; primary key
	 */
	private $articleId;

	/**
	 * user name of profile
	 */
	private $articleContents;

	/**
	 * DATETIME of the article, when it was posted
	 */
	private $articleTime;


	/**
	 * the is the constructor for the Profile class.
	 * @param int $newArticleId new article id number
	 * @param string $newArticleContents new article contents
	 * @param int $newArticleTime assign DATETIME to article time
	 * @throws UnexpectedValueException if any parameters don't meet expectation (see mutator methods)
	 */
	public function __construct($newArticleId, $newArticleContents, $newArticleTime) {
		try {
			$this->setArticleId($newArticleIdId);
			$this->setArticleTime($newArticleTime);
			$this->setArticleContents($newArticleContents);
		} catch(UnexpectedValueException $exception) {
			// RE-Throw to the construct requestor
			throw(new UnexpectedValueException("Unable to post article.", 0, $exception));
		}
	}
	/**
	 * toString() magic method
	 *
	 * @return string formatted in HTML for Profile class constructor
	 */
	public function __toString() {
		//create an HTML formatted Profile
		$html = 		"<p>Article Id: " .	$this->articleId			. "<br />"
			. "Article Time: ".	$this->articleContents				. "<br />"
			. "Article Contents: ".	$this->articleTime		. "<br />"
			. "</p>";
		return($html);
	}
	/**
	 * accessor method to articleId
	 *
	 * @return int value of articleId
	 */
	public function getArticleId() {
		return($this->articleId);
	}

	/**
	 * mutator method for articleId
	 *
	 * @param int $newProfileId - new value of articleId
	 * @throws UnexpectedValueException if $articleId is NOT INT
	 */
	public function setArticleId($newArticleId) {
		// verify the value of profileId is a valid int
		$newArticleId = filter_var($newArticleId, FILTER_VALIDATE_INT);
		if($newArticleId === false) {
			throw(new UnexpectedValueException("Article ID is not a valid integer."));
		}
		//convert profileId into an int (just for safesies)
		//THEN store it into THIS object's profileId
		$this->articleId = intval($newArticleId);
	}


	/**
	 * accessor method to articleContents
	 *
	 * @return string value of articleContents
	 */
	public function getArticleContents() {
		return($this->articleContents);
	}

	/**
	 * mutator method for articleContents
	 *
	 * @param int $newArticleContents - new value of articleContents
	 * @throws UnexpectedValueException if $articleContents is NOT a valid string
	 */
	public function setArticleContents($newArticleContents) {
		// verify the value of profileId is a valid string
		$newArticleContents = filter_var($newArticleContents, FILTER_SANITIZE_STRING);
		if($newArticleContents === false) {
			throw(new UnexpectedValueException("Article ID is not a valid integer."));
		}
		// store our $newArticleContents into articleContents
		$this->articleContents = $newArticleContents;
	}
	/**
	 * accessor method to articleTime
	 *
	 * @return int value of articleTime
	 */
	public function getArticleTime() {
		return($this->articleTime);
	}

	/**
	 * mutator method for articleTime
	 *
	 * @param int $newArticleTime - new value of articleTime
	 * @throws UnexpectedValueException if $articleTime is NOT INT
	 */
	public function setArticleTime($newArticleTime) {
		// verify the value of profileId is a valid int
		$newArticleTime = filter_var($newArticleTime, FILTER_VALIDATE_INT);
		if($newArticleTime === false) {
			throw(new UnexpectedValueException("Article ID is not a valid integer."));
		}
		//convert articleTime into an int (just for safesies)
		//THEN store it into THIS object's profileId
		$this->articleTime = intval($newArticleTime);
	}

}
?>