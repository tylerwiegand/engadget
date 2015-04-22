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
	public function __construct($newProfileId, $newProfileName, $newProfileAvatar = "http://www.gravatar.com/avatar/00000000000000000000000000000000?d=http%3A%2F%2Fexample.com%2Fimages%2Favatar.jpg", $newProfilePermissions = 0) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileName($newProfileName);
			$this->setProfilePermissions($newProfilePermissions);
			$this->setProfileAvatar($newProfileAvatar);
		} catch(UnexpectedValueException $exception) {
			// RE-Throw to the construct requestor
			throw(new UnexpectedValueException("Unable to create profile.", 0, $exception));
		}
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
		// verify the value of profileAvatar is a valid URL AND if it contains
		// the gravatar img link prelude
		$newProfileAvatar = filter_var($newProfileAvatar, FILTER_SANITIZE_URL);
		if($newProfileAvatar === false || strpos($newProfileAvatar, "http://www.gravatar.com/avatar/") !== false) {
			throw(new UnexpectedValueException("Profile Avatar is not a valid URL."));
		}
		//store the $newProfileName string
		$this->profileAvatar = $newProfileAvatar;
	}

	/**
	 * toString() magic method
	 *
	 * @return string formatted in HTML for Profile class constructor
	 */
	public function __toString() {
		//create an HTML formatted Profile
		$html = 		"<p>Profile Id: " .	$this->profileId			. "<br />"
						. "Profile Name: ".	$this->profileName				. "<br />"
						. "Profile Perm: ".	$this->profilePermissions		. "<br />"
						. "Avatar:<br />	<img src=" . $this->profileAvatar . " />"
						. "</p>";
		return($html);
	}

}
?>