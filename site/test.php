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

$uid2 = getUserID($un);
print "UserID = " . $uid2 . "\n";
print "Testing addEvent\n";
$eid = addEvent($uid, "Some Event", "Pittsburgh, PA",strtotime("November 7, 2013 7:15pm"),"Some event",FALSE);
print "Result: $eid\n";
print "</pre>";


?>