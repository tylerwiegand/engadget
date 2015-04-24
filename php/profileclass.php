<?php
/**
 * this is the Profile class
 *
 * the profile class will contain profileId (primary key),
 * profileName (varchar(30))
 * profilePermissions (char(1)) set manually for article posting
 * privileges.
 * profileAvatar will link to an avatar image
 *
 * @author Tyler Wiegand <tyler dot wiegand at me dot com>
 **/

class Profile {
	/**
	 * unique ID for this profile; primary key
	 */
	private $profileId;

	/**
	 * user name of profile
	 */
	private $profileName;

	/**
	 * permissions of user. 1 for article writer, 0 (default) for reader
	 */
	private $profilePermissions;

	/**
	 * link to avatar image (gravatar)
	 */
	private $profileAvatar;
	/**
	 * default image variable for profileAvatar
	 */

	/**
	 * the is the constructor for the Profile class.
	 * @param int $newProfileId new profileId
	 * @param string $newProfileName new profileName
	 * @param int $newProfilePermissions new profilePermissions
	 * @param string $newProfileAvatar new profileAvatar
	 * @throws UnexpectedValueException if any parameters don't meet expectation (see mutator methods)
	 */
	public function __construct($newProfileId, $newProfileName, $newProfilePermissions = 0, $newProfileAvatar = "http://www.gravatar.com/avatar/00000000000000000000000000000000") {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileName($newProfileName);
			$this->setProfilePermissions($newProfilePermissions);
			$this->setProfileAvatar($newProfileAvatar);
		} catch(UnexpectedValueException $exception) {
			// RE-Throw to the construct requester
			throw(new UnexpectedValueException("Unable to create profile.", 0, $exception));
		}
	}

	/**
	 * toString() magic method
	 *
	 * @return string formatted in HTML for Profile class constructor
	 */

	// this allows the class to be Echo'd as a string in HTML format
	public function __toString() {
		//create an HTML formatted Profile
		$html = 		"<p>Profile Id: " .	$this->profileId			. "<br />"
			. "Profile Name: ".	$this->profileName				. "<br />"
			. "Profile Perm: ".	$this->profilePermissions		. "<br />"
			. "Avatar:<br />	<img src=" . $this->profileAvatar . " />"
			. "</p>";
		return($html);
	}

	/**
	 * accessor method to profileId
	 *
	 * @return int value of profileId
	 */
	public function getProfileId() {
		return($this->profileId);
	}

	/**
	 * mutator method for profileId
	 *
	 * @param int $newProfileId - new value of profileId
	 * @throws UnexpectedValueException if $profileId is NOT INT
	 */
	public function setProfileId($newProfileId) {
		// verify the value of profileId is a valid int
		$newProfileId = filter_var($newProfileId, FILTER_VALIDATE_INT);
		if($newProfileId === false) {
			throw(new UnexpectedValueException("Profile ID is not a valid integer."));
		}
		//convert profileId into an int (just for safesies)
		//THEN store it into THIS object's profileId
		$this->profileId = intval($newProfileId);
	}


	/**
	 * accessor method to profileName
	 *
	 * @return string value of profileName
	 */
	public function getProfileName() {
		return($this->profileName);
	}

	/**
	 * mutator method for profileName
	 *
	 * @param string $newProfileName new value of profileName
	 * @throws UnexpectedValueException if $profileId is not a string
	 */
	public function setProfileName($newProfileName) {
		// verify the value of profileId is a valid int
		$newProfileId = filter_var($newProfileName, FILTER_SANITIZE_STRING);
		if($newProfileId === false) {
			throw(new UnexpectedValueException("Profile Name is not a valid string."));
		}
		//store the $newProfileName string
		$this->profileName = $newProfileName;
	}

	/**
	 * accessor method to profilePermissions
	 *
	 * @return int value of profilePermissions
	 */
	public function getProfilePermissions() {
		return($this->profilePermissions);
	}

	/**
	 * mutator method for profilePermissions
	 *
	 * @param int $newProfilePermissions - new value of profilePermissions
	 * @throws UnexpectedValueException if $profileId is NOT INT
	 */
		// declare a function accessible to any requester inside profile class
		// that you can ask me to put a value into profilePermissions, a variable
		// that references (or IS the value in) an SQL database.
	public function setProfilePermissions($newProfilePermissions) {
		// verify the value of profileId is a valid int, or if it is greater than 1
		$newProfilePermissions = filter_var($newProfilePermissions, FILTER_VALIDATE_INT);
		if ($newProfilePermissions === false || $newProfilePermissions > 1) {
			throw(new UnexpectedValueException("Profile ID is not a valid integer OR value."));
		}
		//convert profileId into an int (just for safesies)
		//THEN store it into THIS object's profileId
		$this->profilePermissions = intval($newProfilePermissions);
	}

	/**
	 * accessor method to profileAvatar
	 *
	 * @return string value of profileAvatar
	 */
	public function getProfileAvatar() {
		return($this->profileAvatar);
	}

	/**
	 * mutator method for profileAvatar
	 *
	 * @param string $newProfileAvatar new value of profileAvatar
	 * @throws UnexpectedValueException if $profileId is not a string
	 */
	public function setProfileAvatar($newProfileAvatar) {
		// sanitize the value of profileAvatar so that it can be nothing other than a URL
		// it also checks to see if the sanitization changed the entry
		$newProfileAvatar = filter_var($newProfileAvatar, FILTER_SANITIZE_URL);
		if($newProfileAvatar === false) {
			throw(new UnexpectedValueException("Profile Avatar is not a valid URL."));
		}
		//store the $newProfileName string
		$this->profileAvatar = $newProfileAvatar;
	}


	//////////////////////PDO SECTION/////////////////////////
	/**
	 * This function allows the profile class to insert values
	 * into the mySQL database table "profile." It utilizes the PDO
	 * class built into PHP. @see php.net PDO class.
	 *
	 * @param PDO $insertParameters pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function insert(PDO &$insertParameters) {
		// ensure that you don't attempt to pass a profile ID directly to database
		// profile ID is an auto_incremental value!
		if($this->profileId !== null) {
			throw(new PDOException("This profile ID has already been created!"));
		}

		// First step in the process to send an SQL command from PHP
		$query = "INSERT INTO profile(profileId, profileName, profilePermissions, profileAvatar)
					 				 VALUES(:profileId, :profileName, :profilePermissions, :profileAvatar)";

		// turn $unpreparedStatement into $preparedStatement with the contents of $query and the prepare PDO method
		$preparedStatement = $insertParameters->prepare($query);

		// create an array filled with
		$parameters = 	array("profileId" => $this->profileId,
									"profileName" => $this->profileName,
									"profilePermissions" => $this->profilePermissions,
									"profileAvatar" => $this->profileAvatar);

		// take the parameters given and stick them into the :denoted places in $query
		// the prepared statement now executes with inserted parameters
		$preparedStatement->execute($parameters);

		// FINALLY, we can catch up to a full object with the profileId that
		// we just generated automagically within mySQL
		// "please tell me what box i just stuck all my junk into, please mySQL??"
		$this->profileId = intval($insertParameters->lastInsertId());
		}

	/**
	 * deletes this profile NAME and AVATAR from mySQL
	 *
	 * @param PDO $deleteParameters pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function delete(PDO &$deleteParameters) {
		if($this->profileId === null) {
			throw(new PDOException("How you gonna delete somethin' that ain't THERE?"));
		}
		$query	 = "DELETE FROM profileName, profileAvatar WHERE profileId = :profileId";
		$preparedStatement = $deleteParameters->prepare($query);
		$parameters = array("profileId" => $this->profileId);
		$preparedStatement->execute($parameters);
	}

	/**
	 * updates this Tweet in mySQL
	 *
	 * @param PDO $updateParameters pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function update(PDO &$updateParameters) {
		// enforce the profileId is not null...don't modify things that aren't as they should be
		if($this->profileId === null) {
			throw(new PDOException("That Profile ID does not exist...yet!"));
		}
		// update the profile table by the value of the profileId
		$query		= "UPDATE profile SET 	profileId = :profileId,
														profileName = :profileName,
														profilePermissions = :profilePermissions,
														profileAvatar = :profileAvatar
							WHERE						profileId = :profileId";

		$preparedStatement	= $updateParameters->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters =  array("profileId" => $this->profileId,
									"profileName" => $this->profileName,
									"profilePermissions" => $this->profilePermissions,
									"profileAvatar" => $this->profileAvatar);
		$preparedStatement->execute($parameters);
	}

	/**
	 * gets the profile by profileId
	 *
	 * @param PDO $getProfileParameters pointer to PDO connection, by reference
	 * @param int $profileId tweet id to search for
	 * @return mixed Profile found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProfileByProfileId(PDO &$getProfileParameters, $profileId) {
		$profileId = filter_var($profileId, FILTER_VALIDATE_INT);
		if($profileId === false) {
			throw(new PDOException("Profile ID given is not valid."));
		}
		if($profileId <= 0) {
			throw(new PDOException("Profile ID's must be above 0."));
		}

		// template for our mySQL statement. we put the :profileId in from the $profileId arg later on...
		$query		= "SELECT profileId, profileName, profilePermissions, profileAvatar FROM profile WHERE profileId = :profileId";
		// prepare the statement. PDO does it!
		$preparedStatement	= $getProfileParameters->prepare($query);
		// lets give some parameters for our statement. or arguments. ARGUE WITH STATEMENT!
		$parameters = array("profileId" => $profileId);
		// so we've just given $parameters something to chew on, and it's profileId, which came from our array
		// that contains a relational array. this is so we can match it up to :profileId. It's a PDO thing!
		// now we can tell PDO through the execute method to send our preparedStatement with parameters as the argument!
		// MAGIC!
		$preparedStatement->execute($parameters);
		// now our preparedStatement has the same stuff it had it in before, we just used it in combination
		// with parameters to do the execute. it's still there!


		try {

			// declare returnProfile so we can return it after we find what we're looking for (IF we do!)
			// but we cant return NOTHING...well, we CAN return NULL but not nothing...ironic...
			$returnProfile = null;
			// within our preparedStatement variable, change the fetchmode in PDO so it gets it as an
			// associative array
			$preparedStatement->setFetchMode(PDO::FETCH_ASSOC);
			// now our preparedStatement isn't what we care about. we want our results (as an array)
			$results   = $preparedStatement->fetch();
			// now if we actually got something, we want to be able to assign it to returnProfile. Remember
			// results are from the PDO statement, returnProfile is what we want the METHOD to output.
			if($results !== false) {
				$returnProfile = new Profile($results["profileId"], $results["profileName"], $results["profilePermissions"], $results["profileAvatar"]);
			}
		} catch(Exception $exception) {
			// exception? NO PROBLEM! Throw it ...away...to someone else.
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		// alright if everything went well we have our profile results returned to us. Nice!
		return($returnProfile);
	}

	/**
	 * gets the profile by profileName
	 *
	 * @param PDO $getProfileParameters pointer to PDO connection, by reference
	 * @param int $profileName tweet id to search for
	 * @return mixed Profile found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProfileByProfileName(PDO &$getProfileParameters, $profileName) {
		$profileName = trim($profileName);
		$profileName = filter_var($profileName, FILTER_SANITIZE_STRING);
		if(empty($profileName === true)) {
			throw(new PDOException("Profile Name must be entered to search by it."));
		}
		// template for our mySQL statement. we put the :profileName in from the $profileName arg later on...
		$query = "SELECT profileId, profileName, profilePermissions, profileAvatar FROM profile WHERE profileName = :profileName";

		// prepare the statement. PDO does it!
		$preparedStatement = $getProfileParameters->prepare($query);

		// lets give some parameters for our statement. or arguments. ARGUE WITH STATEMENT!
		$parameters = array("profileName" => "%$profileName%");

		// so we've just given $parameters something to chew on, and it's profileName (with WILDCARD strings around
		// it, which came from our array that contains a relational array. this is so we can match it up to
		// :profileName. It's a PDO thing! now we can tell PDO through the execute method to send our
		//  preparedStatement with parameters as the argument!

		$preparedStatement->execute($parameters);
		// now our preparedStatement has the same stuff it had it in before, we just used it in combination
		// with parameters to do the execute. it's still there!

		$returnProfileArray = new SplFixedArray($preparedStatement->rowCount());

		$preparedStatement->setFetchMode(PDO::FETCH_ASSOC);
			// declare returnProfile so we can return it after we find what we're looking for (IF we do!)
			// but we cant return NOTHING...well, we CAN return NULL but not nothing...ironic...
			$returnProfile = null;
			// within our preparedStatement variable, change the fetchmode in PDO so it gets it as an
			// associative array
			$preparedStatement->setFetchMode(PDO::FETCH_ASSOC);
			// so, if the mySQL search results from the prepared statement came back empty, null, etc,
			// we will stop this process. otherwise, repeat!
			while(($results = $preparedStatement->fetch()) !== false) {
				try {
					// return profile now is assigned the output from the Profile constructor as it relates to the
					// current results from our mySQL statement. associative arrays fo LIFE
					$returnProfile = new Profile($results["tweetId"], $results["profileId"], $results["tweetContent"], $results["tweetDate"]);
					// so now that we have a profiles info (built from the Profile constructor), we need to
					// store it somewhere else than where we already have it so we can keep adding to it (loopy!)
					$returnProfileArray[$returnProfileArray->key()] = $returnProfile;
					// and we store the info ^ up there so that later we can re-use ^ ($returnProfile) next time!
					$returnProfileArray->next();
					// now we increase the key() number so it doesnt just keep putting the entries
					// into the same stupid array...stupid array...
					// and of course, if something goes wrong...THROW IT AWAY!
				} catch(Exception $exception) {
					throw(new PDOException($exception->getMessage(), 0, $exception));
				}
			}
			$numberOfProfiles = count($returnProfileArray);
			if($numberOfProfiles === 0) {
				return (null);
			} else {
				// alright if everything went well we have our profiles in a neat array.
				return ($returnProfileArray);
			}
		}
}

?>