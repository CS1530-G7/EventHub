<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");

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
		 else if(getActiveUser() == -3)
		 {
			$error_message .= "<p>Your session has expired, please login again.</p>";
		 }
		 else
		 {
			 header( "Location:profile.php?u=$userID");
		 }

	}
	
	return $error_message;
	
}

function login_div($msg = "")
{
	print '<div id="login">';
	$UID = getActiveUser();
	if($UID >= 0) {
		$user = getUsername($UID);
		$link = "profile.php?u={$UID}";
		print "<p>Welcome <a href='$link'>{$user}</a>!</p>";
		print"</div>"; //End div login
		print  "<div id=\"logout\">";
		print "<a href=\"logout.php\">Logout</a>";
		print "</div>";
	} else {

$str = <<<END
 
<div id="login-form">

<div id="login-errors">
	$msg
</div>
<form name="login" id="login" action="index.php" method="POST">
	<label for="username"/>Username:</label>
	<input type="text" name="username">
	<label for="password"/>Password:</label>
	<input type="password" name="password">
	<input class= "btn" name="submit" type="submit" value="Submit">
</form>

</div>
<div id="sign-up">
<a href="signup.php">Sign up</a>	
</div>

END;

print $str;
	}
}



?>