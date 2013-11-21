<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/login.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/search.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/eventFunctions.php");

$login_msg = doLogin();


$userID = $_GET["u"];
$loggedin = getActiveuserID();


if(isset($_POST["follow-submit"]))
{
	if($loggedin >= 0)
	{
		if($_POST["follow-submit"] === "Follow")
		{
			followuserID($loggedin, $userID);
		}
		else
		{
			unfollowuserID($loggedin, $userID);
		}
	}
	else
	{
		$msg = "You must be logged in to follow a userID";
	}
}

if(isset($_POST["invite-submit"]))
{
	$guest = $_POST["InvuserID"];
	if($loggedin == $guest)
	{
		$IID = $_POST["IID"];
		
		if($_POST["invite-submit"] === "Accept")
		{
			acceptInvite($IID);
		}
		else
		{
			rejectInvite($IID);
		}
	}
}


?>
 
 <html>
 	<head>
  		<title>EventHub</title>
         <link rel="stylesheet" type="text/css" href="/resources/css/style.css">

 		<script>
 			function RemoveText(obj) {   obj.value = ''; } 
 		</script>
    </head>

	<body>
		<div id="main-center">

				<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/topbar.php");?>

			
			<div id="content">
				<?php
				$userIDname = getuserIDname($userID);

				if($userID === $loggedin)
					{
						//Display your profile
						print "<div id='profile-name'><h3>Your page</h3><p>(<a href='editProfile.php'>Edit</a>)</p>";
						
						$events = getEventsByuserID($userID);
						print "<div id='hosted'><h3>Hosted Events</h3>";
						foreach ($events as $e)
						{

							displayEventCard($e);
						}
						print "</div>";
						
						print "<div id='schedule'><h3>Schedule</h3>";
						$events = getuserIDRSVPs($userID);

						foreach ($events as $f)
						{

							displayEventCard($f["id"],-1, $f["rsvp"]);
						}
						
						print "</div>";
						
						print "<div id='feed'><h3>Event Feed</h3></div>";
						//Get userID location
						$loc = getuserIDLocation($userID);
						if($loc == -1 || $loc["Lat"] == NULL)
						{
							print "<p class='error'>You have not set a location for yourself.  <a href='editProfile.php'>Edit your profile</a> to get events near you</p>";
						}
						else if($loc == -2)
						{
						}
						else
						{

							$events = eventSearch("", 50, $loc["Lat"], $loc["Lng"], TRUE, TRUE);
							
							foreach ($events as $s)
							{

								displayEventCard($s["id"],$s["distance"]);
							}
						}
						print "<div id='followeduserIDs'><h3>Following</h3>";
						$userIDs = getFollows($userID);
						
						foreach($userIDs as $u)
						{
							$name = getuserIDname($u);
							if($name >= 0)
							{
								print "<a href='profile.php?u=$u'>$name</a>";
							}
						
						}
						print "</div>";
						print "<div id='invites'><h3>Invites</h3>";
						$inv = getInvites($userID);
						foreach($inv as $i)
						{
							displayInviteCard($i);
						}
					}
					else if($userIDname < 0)
					{
						print "<h1>This userID does not exist.</h1>";
					}
					else
					{
						//Public Profile
						$loc = getuserIDLocationName($userID);
						print "<div id='profile-name'><p>$userIDname's page</p></div>";
						if(!empty($loc) && $loc >= 0)
						{
							print "<div id='location'><p>Location $loc</p></div>";
						}
						
						if(isFollowed($loggedin, $userID))
						{
							print "<div id='follow'>
								<form name='unfollow' id='unfollow' action='profile.php?u=$userID' method='POST'>
									<input class='btn-unfollow' name='follow-submit' type='submit' value='Un-Follow'>
								</form>
							</div>";
						}
						else
						{
							print "<div id='follow'>
								<form name='follow' id='follow' action='profile.php?u=$userID' method='POST'>
									<input class='btn-follow' name='follow-submit' type='submit' value='Follow'>
								</form>
							</div>";
						}
						
						print "<div id='followeduserIDs'><p>Following</p>";
						$userIDs = getFollows($userID);
						
						foreach($userIDs as $u)
						{
							$name = getuserIDname($u);
							if($name >= 0)
							{
								print "<a href='profile.php?u=$u'>$name</a>";
							}
						
						}
						print "</div>";
					}

				?>
		
				<div id="event-create">
					<p><a href="createEvent.php">Click here</a> to create an event</p>
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


?>