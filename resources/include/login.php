<?php

function doLogin()
{
	$error_message = "";

	if(isset($_POST['submit'])) {

			// get variables
			$username = $_POST['username'];
			$password = $_POST['password'];

			$userID = login($username, $password);

		 if(empty($username) || empty($password)) {

			$error_message .= "<p>Username and/or password field blank.</p>";

		 }
		 else if ($userID == -1) {

			$error_message .= "<p>Username and/or password incorrect.</p>";

		 }
		 else
		 {
			 header( "Location:profile.php?u=$userID");
		 }

	}
	else if(getActiveUser() == -3)
	{
		$error_message .= "<p>Your session has expired, please login again.</p>";
	}
	
	return $error_message;
	
}





?>