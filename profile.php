<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/login.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/search.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/eventFunctions.php");

$msg = doLogin();


$user = $_GET["u"];
$loggedin = getActiveUser();


if(isset($_POST["follow-submit"]))
{
	if($loggedin >= 0)
	{
		if($_POST["follow-submit"] === "Follow")
		{
			followUser($loggedin, $user);
		}
		else
		{
			unfollowUser($loggedin, $user);
		}
	}
	else
	{
		$msg = "You must be logged in to follow a user";
	}
}



?>
 
 <html>

 	<header>

 	<script>
 		function RemoveText(obj) {   obj.value = ''; } 
 	</script>

 	</header>
	<body>
	
		<?php
		login_div($msg);
		searchBar();
		//echo '<h1>Welcome ' . $username .'!</h1>';
		$username = getUsername($user);
				
		if($user === $loggedin)
			{
				//Display your profile
				print "<div id='profile-name'><h3>Your page</h3><p>(<a href='editProfile.php'>Edit</a>)</p>";
				
				$events = getEventsByUser($user);
				print "<div id='hosted'><h3>Hosted Events</h3>";
				foreach ($events as $e)
				{

					displayEventCard($e);
				}
				print "</div>";
				
				print "<div id='schedule'><h3>Schedule</h3>";
				$events = getUserRSVPs($user);

				foreach ($events as $f)
				{

					displayEventCard($f["id"],-1, $f["rsvp"]);
				}
				
				print "</div>";
				
				print "<div id='feed'><h3>Event Feed</h3></div>";
				//Get user location
				$loc = getUserLocation($user);
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
				print "<div id='followedUsers'><h3>Following</h3>";
				$users = getFollows($user);
				
				foreach($users as $u)
				{
					$name = getUsername($u);
					if($name >= 0)
					{
						print "<a href='profile.php?u=$u'>$name</a>";
					}
				
				}
				print "</div>";
				print "<div id='invites'><h3>Invites</h3>";
				$inv = getInvites($user);
				foreach($inv as $i)
				{
					displayInviteCard($i);
				}
				print "</div>";
			}
			else if($username < 0)
			{
			
			}
			else
			{
				//Public Profile
				$loc = getUserLocationName($user);
				print "<div id='profile-name'><p>$username's page</p></div>";
				if(!empty($loc) && $loc >= 0)
				{
					print "<div id='location'><p>Location $loc</p></div>";
				}
				
				if(isFollowed($loggedin, $user))
				{
					print "<div id='follow'>
						<form name='unfollow' id='unfollow' action='profile.php?u=$user' method='POST'>
							<input class='btn-unfollow' name='follow-submit' type='submit' value='Un-Follow'>
						</form>
					</div>";
				}
				else
				{
					print "<div id='follow'>
						<form name='follow' id='follow' action='profile.php?u=$user' method='POST'>
							<input class='btn-follow' name='follow-submit' type='submit' value='Follow'>
						</form>
					</div>";
				}
				
				print "<div id='followedUsers'><p>Following</p>";
				$users = getFollows($user);
				
				foreach($users as $u)
				{
					$name = getUsername($u);
					if($name >= 0)
					{
						print "<a href='profile.php?u=$u'>$name</a>";
					}
				
				}
				print "</div>";
			}

		?>

		
		<!--<img src="./resources/img/Homepage.jpg" />-->
		




		</div>
		

		<div id="event-create">
			<p><a href="createEvent.php">Click here</a> to create an event</p>
		</div>


	</body>
</html>


<?php


?>