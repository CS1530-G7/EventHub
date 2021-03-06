<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "resources/include/data.php");

print "<pre>";
print "Testing add user\n";

$uname = "Test";
$pass = "Test123";
$email = "Test@test.com";
$uid = createUser($uname,$pass,$email);
print "Result: " . $uid . "\n";
print "Testing add same user (should not work)\n";
$duid = createUser($uname,$pass,$email);
print "Result: " . $duid . "\n";
print "Error: " . sqlError() . "\n";
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
logout();

print "Testing addEvent\n";
$eid = addEvent($uid, "Some Event", "Home", "Pittsburgh, PA",strtotime("November 17, 2013 7:15pm"),"Some event",FALSE);
print "Result: $eid\n";
addEvent($uid, "Some Other Event", "CS Building", "Sennot Square Pittsburgh, PA",strtotime("November 15, 2013 7:15pm"),"Some event 2: the redux",FALSE);
addEvent($uid, "Some Other Event", "CS Building", "Sennot Square Pittsburgh, PA",strtotime("November 16, 2013 7:15pm"),"Some event 3: the private redux",TRUE);
addEvent($uid, "Some Other Event", "CS Building", "Washington, PA",strtotime("November 19, 2013 7:15pm"),"Some event 4",FALSE);
addEvent($uid, "Some Other Event", "CS Building", "Washington, PA",strtotime("November 1, 2013 7:15pm"),"Some event -1",FALSE);
$evs = getEventsByUser($uid);
print "Listing events by user $uid \n";
var_dump($evs);
print "Delete User\n";
deleteUser($uid2);
$uidDel = getUserID($uname);
Print "Result (Should be -1) = $uidDel\n";

print "Testing search\n";
var_dump(eventSearch("Pittsburgh"));

print"\nTesting RSVPs\n";
var_dump(getUserRSVPs($uid));

print "</pre>";


?>