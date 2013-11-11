<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");

print "<pre>";
print "Testing add user\n";

$uname = "Test";
$pass = "Test123";
$email = "Test@test.com";
$uid = createUser($uname,$pass,$email);
print "Result: " . $uid . "\n";
print "Testing add same user (should not work)\n";
$uid = createUser($uname,$pass,$email);
print "Result: " . $uid . "\n";
print "Error: " . sqlError();
print "Login\n";
$uidLogin = login($uname, $pass);
print "Result: " . $uidLogin . "\n";
$un = getUsername($uidLogin);
print "Username = " .  $un . "\n";
$active = getActiveUser();
print "Auth=$active\n";
$time = getLoginTime();
 print "AuthTime=$time\n";
$uid2 = getUserID($un);
print "UserID = " . $uid2 . "\n";

$loc = "Sennot Square Pittsburgh PA";
print "Testing geocode with: " . $loc . "\n";
$name = "Sennot Sq.";
$lid = newLocation($name, $loc);
print "Loc ID = " . $lid . "\n";

print "Testing addEvent\n";
$eid = addEvent($uid, "Some Event", "Home", "Pittsburgh, PA",strtotime("November 7, 2013 7:15pm"),"Some event",FALSE);
print "Result: $eid\n";
print "Delete User\n";
deleteUser($uid2);
$uidDel = getUserID($uname);
Print "Result (Should be -1) = $uidDel\n";
print "</pre>";


?>