<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/login.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/search.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/eventFunctions.php");

$msg = doLogin();


$user = $_GET["u"];
$loggedin = getActiveUser();





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
		//echo '<h1>Welcome ' . $username .'!</h1>';
		$username = getUsername($user);
				
		if($user === $loggedin)
			{
				//Display your profile
				print "<div id='profile-name'><p>Your page (<a href='editProfile.php'>Edit</a>)</p>";
				
				$events = getEventsByUser($user);
				print "<div id='hosted'><p>Hosted Events</p>";
				foreach ($events as $e)
				{

					displayEventCard($e);
				}
				print "</div>";
				
				print "<div id='schedule'><p>Schedule</p>";
				$events = getUserRSVPs($user);

				foreach ($events as $f)
				{

					displayEventCard($f["id"],-1, $f["rsvp"]);
				}
				
				print "</div>";
				
				print "<div id='feed'>Event Feed</div>";
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

					$events = eventSearch("", 50, $loc["Lat"], $loc["Lng"], TRUE, FALSE);
					
					foreach ($events as $s)
					{

						displayEventCard($s["id"],$s["distance"]);
					}
				}
				
			}
			else
			{
				//Public Profile
				print "<div id='profile-name'><p>$username's page</p>";
				$followed = FALSE; //TODO create 'is followed' SQL
				if($followed)
				{
					print "<div id='follow'>
						<form name='unfollow' id='unfollow' action='profile.php?u=$user' method='POST'>
							<input class='btn-unfollow' name='follow' type='submit' value='Un-Follow'>
						</form>
					</div>";
				}
				else
				{
					print "<div id='follow'>
						<form name='follow' id='follow' action='profile.php?u=$user' method='POST'>
							<input class='btn-follow' name='follow' type='submit' value='Follow'>
						</form>
					</div>";
				}
			}

		?>

		
		<!--<img src="./resources/img/Homepage.jpg" />-->
		<div id="search-area">
			<form name="login" id="login" action="profile.php" method="POST">
				<label for="username"/></label>
				<input type="text" name="search_query" value="" onclick="RemoveText(this);">
				<input class= "btn" name="search_submit" type="submit" value="Search Events">
			</form>


			<div id="search_results">
				<?php doEventSearch(); ?>
			</div>

		</div>
		

		<div id="event-create">
			<p><a href="createEvent.php">Click here</a> to create an event</p>
		</div>


	</body>
</html>


<?php


?>