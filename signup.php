<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "resources/include/data.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "resources/include/signupValidate.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/login.php");

$login_msg = doLogin();
?>


 
<html>
	<body>
		<head>
 			<title>EventHub</title>
        	<link rel="stylesheet" type="text/css" href="/resources/css/style.css">
			<script>
				function RemoveText(obj) {   obj.value = ''; } 
			</script>
    	</head>
		
		<div id="main-center">

				<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/topbar.php");?>


			<div id="content">
				<h1>Sign up!</h1>
				
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
			</div>

			<div id="footer">
                <a href='./index.php'>Home</a>&nbsp&nbsp
                <a href='./profile.php'>Profile</a>&nbsp&nbsp
                <a href='./logout.php'>Logout</a>
			</div>
		</div>
	</body>
</html>

<?php
// submit button pressed and no errors
// create the user
if(isset($_POST['submit']) && $error_message == '')
{
	createUser($username, $password, $email);
}
?>