<?php




function login_div($msg = "")
{
	print '';

		print "<a href='$link'>$user</a> | ";
		print "<a href=\"logout.php\">Logout</a>";
		print"</div>"; //End div login
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