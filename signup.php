<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");

// get variables
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];

echo "{$username}, {$email}, {$password}, {$password_confirm}\n";

$error = FALSE;

// submit button pressed
if(isset($_POST['submit'])) {

	// checks for empty form fields
 if(empty($username) || empty($email) || empty($password) || empty($password_confirm)) {

 	echo "empty form field(s)\n";
 	$error = TRUE;

 }

 // check username length
 if(strlen($username) < 6 || strlen($username) > 20) {

 	echo "username must be between 6 and 20 characters";
 	$error = TRUE;

 }

 // check password length
 if(strlen($password) < 6 || strlen($password) > 20 ) {

 	echo "password must be between 6 and 20 characters";
 	$error = TRUE;

 }

 //checks for incorrect confirm password
 if ($password != $password_confirm) {

 	echo "confirm password does not match\n";
 	$error = TRUE;

 }

 // checks email format
 if(!filter_var($email, FILTER_VALIDATE_EMAIL)){

    echo "invalid email\n";
    $error = TRUE;

	}

	//submit to DB if no error
	if (!$error) {

		echo "submit user to DB\n";


	}


}


?>
 
 <html>
	<body>
		<h1>Sign up!</h1>
		
		<!-- <img src="./resources/img/Homepage.jpg" /> -->
		<div id="signup-form">

			<form name="signup" id="user-signup" action="signup.php" method="POST">
				<label for="username"/>Username:</label>
				<input type="text" name="username">
				<label for="email"/>Email:</label>
				<input type="text" name="email">
				<label for="password"/>Password:</label>
				<input type="password" name="password">
				<label for="confirm_password"/>Confirm Password: </label>
				<input type="password" name="password_confirm">
				<input class= "btn" name="submit" type="submit" value="Submit">
			</form>

		</div>
			
		
	</body>
</html>
