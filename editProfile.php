<?php
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


?>

 <html>
	<body>
		<form id='edit-profile' submit='profile.php?u=$user' method='post'>
			<div id='public'>
				<p>Public Profile</p>
				<p>Area where you live <input type="text" name="loc_name" value='$locname'></p>
			</div>
			<div id='private'>
				<p>Private Profile</p>
				<p>Email address <input type="text" name="email" value='$email'></p>
				<p>House address <input type="text" name="address" value='$address'></p>
				<p>Note: House address is only used for location based searching and will never be displayed</p>
			</div>
			<input type="submit" name="submit" value="Submit Changes">
		</form>
	</body>
</html>