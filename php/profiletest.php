<?php
// load the profile class
require_once("profileclass.php");

require_once("/etc/apache2/data-design/encrypted-config.php");
$config = readConfig("/etc/apache2/data-design/twiegand.ini");

// utilize profile class constructor to create a profile
$profile = new Profile(1, "Owner",1);
echo $profile;
?>