<?php

$error_message = "";

if(isset($_POST['submit'])) {

	// get variables
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$password_confirm = $_POST['password_confirm'];


 // check username length
 if(strlen($username) < 6 || strlen($username) > 20) {

 	//echo "username must be between 6 and 20 characters</br>";
 	$error_message .= "Username must be between 6 and 20 characters.";

 }

}


?>