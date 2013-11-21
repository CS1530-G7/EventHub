<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/login.php");
$login_msg=doLogin();
$user = getActiveUser();
$showerror = false;

	if($user < 0)
	{
		header( "Location: index.php");
	}
	$email = getEmail($user);
	$locname = getUserLocationName($user);
	if($locname < 0)
	{
		$locname = "";
	}
	$address = getUserAddress($user); 
	if($address < 0)
	{
		$address = "";
	}

//Changes
if(isset($_POST['edit-profile']))
{
	//Email
	$email = $_POST['email'];
	$emailid = checkEmail($email);
	$emailerror = "";
	if(empty($email))
	{
		//No change
	}
	else if ($emailid == $user)
	{
		//No change
	}
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$emailerror = "<p>Please enter a valid email.</p>";
	}
	else if($emailid  >= 0)
	{
		$emailerror = "<p>Someone already signed up with that email.</p>";
	}
	else
	{
		//Change email
		setEmail($user, $email);
	}
	//Location
	$loc_name = $_POST['loc_name'];
	$loc_addr = $_POST['address'];
	$locerror = "";
	if(empty($loc_name) && empty($loc_addr))
	{
		//No change
	}
	else if($loc_name === $locname && $loc_addr === $addres)
	{
		//No change
	}
	else
	{
		setUserLocation($user, $loc_name, $loc_addr);
	}
	
	//Password
	$password = $_POST["pass1"];
	$password_confirm = $_POST["pass2"];
	$passerror = "";
	if(empty($password))
	{
		// No change
	}
		 // check password length
	else if(strlen($password) < 6 || strlen($password) > 20 ) {

		//echo "password must be between 6 and 20 characters</br>";
		$passerror = "<p>Password must be between 6 and 20 characters.</p>";

	 }

	 //checks for incorrect confirm password
	 else if ($password != $password_confirm) {

		//echo "confirm password does not match</br>";
		$passerror = "<p>Your passwords do not match.</p>";

	 }
	 else
	 {
		changePassword($user,$password);
	 }

	if(empty($emailerror) && empty($passerror) && empty($locerror))
	{
		header( "Location: profile.php?u=$user");
	}
	else
	{
		$showerror = true;
	}
	
	
}
else
{

}
	$email = getEmail($user);
	$locname = getUserLocationName($user);
	if($locname < 0)
	{
		$locname = "";
	}
	$address = getUserAddress($user); 
	if($address < 0)
	{
		$address = "";
	}


?>

 <html>
 	<head>
  		<title>EventHub</title>
         <link rel="stylesheet" type="text/css" href="/resources/css/style.css">
     </head>

	<body>
	<?php 
	require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/topbar.php");
	if($showerror)
	{
		print "<div class='error'>$emailerror\n$locerror\n$passerror</div>";
	}
	
	
	?>
		<div id="main-center">
			<!-- Header -->
			<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/topbar.php");?>

			<!-- Content -->
			<div id="content">
				<form id='edit-profile' action='editProfile.php' method='post'>
					<div id='public'>
						<p>Public Profile</p>
						<p>Area where you live <input type="text" name="loc_name" value='<?php print $locname?>'></p>
					</div>
					<div id='private'>
						<p>Private Profile</p>
						<p>Email address <input type="text" name="email" value='<?php print $email?>'></p>
						<p>House address <input type="text" name="address" value='<?php print $address?>'></p>
						<p>Note: House address is only used for location based searching and will never be displayed</p>
						<p>New Password <input type="password" name="pass1" value=''></p>
						<p>New Password Again <input type="password" name="pass2" value=''></p>
					</div>
					<input type="submit" name="edit-profile" value="Submit Changes">
				</form>
			</div>
		</div>
	</body>
</html>