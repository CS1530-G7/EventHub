<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");

print "<pre>";
print "Testing add user\n";

$uname = "Test";
$pass = "Test123";
$email = "Test@test.com";
$uid = createUser($uname,$pass,$email);
print "Result: " . $uid . "\n";

$un = getUsername($uid);
print "Username = " .  $un . "\n";

print "</pre>";


?>