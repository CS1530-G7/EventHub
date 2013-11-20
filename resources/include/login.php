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

function login_div($msg = "")
{
	print '<div id="login">';
	$UID = getActiveUser();
	if($UID >= 0) {
		$user = getUsername($UID);
		$link = "profile.php?u={$UID}";
		print "<p><a href='$link'>{$user}</a></p>";
		print"</div>"; //End div login
		print  "<div id=\"logout\">";
		print "<p><a href=\"logout.php\">Logout</a></p>";
		print "</div>";
	} else {

$str = <<<END
 
<div id="login-form">

<form name="login" id="login" action="index.php" method="POST">
	<input type="text" name="username" value="Username">
	<input type="password" name="password" value="Password">
	<input class= "btn" name="submit" type="submit" value="Login">
</form>

<div id="login-errors">
	$msg
</div>

</div>
<div id="sign-up">
Not registered? <a href="signup.php">Sign up!</a>	
</div>

END;

print $str;
	}
}



?>