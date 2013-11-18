<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/functions.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");


$error_message = "";

if(isset($_POST['submit'])) {

	// get variables
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$password_confirm = $_POST['password_confirm'];


 if(empty($username) || empty($email) || empty($password) || empty($password_confirm)) {

 	//echo "empty form field(s)</br>";
 	$error_message .= "<p>There are empty form fields.</p>";

 }

 // check username length
 if(strlen($username) < 6 || strlen($username) > 20) {

 	//echo "username must be between 6 and 20 characters</br>";
 	$error_message .= "<p>Username must be between 6 and 20 characters.</p>";

 }


 // check password length
 if(strlen($password) < 6 || strlen($password) > 20 ) {

 	//echo "password must be between 6 and 20 characters</br>";
 	$error_message .= "<p>Password must be between 6 and 20 characters.</p>";

 }

 //checks for incorrect confirm password
 if ($password != $password_confirm) {

 	//echo "confirm password does not match</br>";
 	$error_message .= "<p>Your passwords do not match.</p>";

 }

 // checks email format
 if(!filter_var($email, FILTER_VALIDATE_EMAIL)){

    //echo "invalid email</br>";
    $error_message .= "<p>Please enter a valid email.</p>";

	}

	//checks for duplciate usernames
	if(getUserID($username) != -1) {
		$error_message .= "<p>A user with that username already exists.</p>";
	}


	//checks for duplciate emails
	if(checkEmail($email) != -1) {
		$error_message .= "<p>Someone already signed up with that email.</p>";
	}

}


?>