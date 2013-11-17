<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");

$error_message = "";

if(isset($_POST['submit'])) {

	// get variables
	$username = $_POST['username'];
	$password = $_POST['password'];

	$userID = login($username, $password);

 if(empty($username) || empty($password)) {

 	$error_message .= "<p>Username and/or password field blank.</p>";

 }


 if ($userID == -1) {

 	$error_message .= "<p>Username and/or password incorrect.</p>";

 }

}



?>