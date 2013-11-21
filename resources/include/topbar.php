<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");



$Home = FALSE;

if($_SERVER["PHP_SELF"] === '/index.php')
{
	$Home = TRUE;
} 


?>

		<div id='header'>
			<? if(!$Home){?>
			<div id="search-area">
				<form name="search" id="search" action="search.php" method="GET">
					<input type="text" name="q" value="" size="50"><br><br>
					<input class= "btn" type="submit" value="Search Events">
				</form>
			</div>
			
			<div id='Home'>
				<a href='/'>Home</a>
			</div>
			<? 
			} 			
			?>
			<div id="login">
			<?
			$UID = getActiveUser();
			if($UID >= 0) 
			{
				$user = getUsername($UID);
				$link = "profile.php?u=$UID";
			?>
			<a href='<?print $link; ?>'><? print $user; ?></a> | <a href=\"logout.php\">Logout</a>
			<?
			}else{
			?>
			<div id="login-form">
				<form name="login" id="login" action="index.php" method="POST">
					<input type="text" name="username" value="Username">
					<input type="password" name="password" value="Password">
					<input class= "btn" name="submit" type="submit" value="Login">
				</form>
				<div id="login-errors">
					<? print $login_msg; ?>
				</div>
			</div>
			<div id="sign-up">
				<p>Not registered? <a href="signup.php">Sign up!</a></p>	
			</div>
			<? } ?>
		</div>
	</div>