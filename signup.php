<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");


if(isset($_POST['submit'])) {

 if(empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password_confirm'])) {
 	echo "empty form fields";
 } else {


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
