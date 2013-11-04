<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php";

print "<pre>";
print "Testing add user";

$uname = "Test";
$pass = "Test123";
$email = "Test@test.com";

print "Result: " . createUser($uname,$pass,$email);

print "</pre>";


?>