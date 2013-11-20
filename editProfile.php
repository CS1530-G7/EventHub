<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");

$user = getActiveUser();

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
		setUserLocation($user, $loc_name, $loc_address);
	}
	
	//Password
	
	
	
	
}
else
{

}



?>

 <html>
	<body>
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
	</body>
</html>