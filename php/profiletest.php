<?php
// load the profile class
require_once("profileclass.php");

require_once("/etc/apache2/data-design/encrypted-config.php");
$config = readConfig("/etc/apache2/data-design/twiegand.ini");

try {
		$config = readConfig("/etc/apache2/data-design/database-config.ini");
		$dsn = "mysql:host=" . $config["hostname"] . ";dbname=" . $config["twiegand"];
		$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
		$pdoConnection = new PDO($dsn, $config["username"], $config["password"], $options);
		$pdoConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


		$profile = new Profile(null, "NameGoesHere", null, null);
		$profile->insert($pdoConnection);
		echo $profile;

		$profile->setProfileName("PDUDEO!");
		$profile->update($pdoConnection);
		echo $profile;

		$profile->setProfilePermissions(1);
		$profile->update($pdoConnection);
		echo $profile;

		$pdoProfile = Profile::getProfileByProfileId($pdoConnection, $profile->getProfileId());
		echo $pdoProfile;

		$pdoProfile = profile::getProfileByProfileName($pdoConnection, $profile->getProfileName());
		echo $pdoProfile;

		$profile->delete($pdoConnection);
		$pdoProfile = Profile::getProfileByProfileId($pdoConnection, $profile->getProfileId());
		echo $pdoProfile;

} 	catch(PDOException $pdoException) {
	echo "Exception: " . $pdoException->getMessage();
}

// utilize profile class constructor to create a profile
//$profile = new Profile(1, "Owner",1);
//echo $profile;
?>