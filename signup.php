<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "resources/include/data.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "resources/include/signupValidate.php");

?>


 
 <html>
	<body>
		<h1>Sign up!</h1>
		
		<!-- <img src="./resources/img/Homepage.jpg" /> -->
		<div id="signup-form">

			<!--form validation error messages displayed in this div-->
			<div id="error-message">
				<?php echo $error_message; ?>
			</div>

			<div id="success">
				<?php 
				if(isset($_POST['submit']) && $error_message == '') {
					echo "<p>Success! Thanks for signing up <b>{$username}</b>! <a href=\"index.php\">Click here </a>to log in.</p>"; 
				}
				?>
			</div>

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

<?php

// submit button pressed and no errors
// create the user
if(isset($_POST['submit']) && $error_message == '') {

	createUser($username, $password, $email);


}


?>