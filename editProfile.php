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


?>

 <html>
	<body>
		<form id='edit-profile' action='profile.php?u='<?php print $user?>' method='post'>
			<div id='public'>
				<p>Public Profile</p>
				<p>Area where you live <input type="text" name="loc_name" value='<?php print $locname?>'></p>
			</div>
			<div id='private'>
				<p>Private Profile</p>
				<p>Email address <input type="text" name="email" value='<?php print $email?>'></p>
				<p>House address <input type="text" name="address" value='<?php print $address?>'></p>
				<p>Note: House address is only used for location based searching and will never be displayed</p>
			</div>
			<input type="submit" name="submit" value="Submit Changes">
		</form>
	</body>
</html>