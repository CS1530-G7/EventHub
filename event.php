<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/login.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/search.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/event.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/invite.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/rsvp.php");
$login_msg = doLogin();

$invite_message = doInvite();
$rsvp_message = doRSVP();
$rsvp_status = rsvpStatus();

$EID = $_GET['e'];
$url = "event.php?e={$EID}";
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
			<!-- Header -->
			<?php
				require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/topbar.php");
			?>

			<!-- Content -->
			<div id="content">
				<?php
					eventHTML();
					showEventDelete();
				?>

				<div id="invite">
					<h2>Send invites to this event...</h2>
					<form name="invite" id="invite" action=<?php echo $url; ?> method="POST">
						<label for="username"/></label>
						<input type="text" name="username" value="" size="50">
						<input class= "btn" type="submit" name="invite_submit" value="Invite user">
					</form>

					<div id="invite_message">
						<?php echo $invite_message; ?>
					</div>
				</div>

				<div id="rsvp">
					<h2>RSVP to this event!</h2>
					<?php 

					//print rsvp status
					echo $rsvp_status;
					
					?>

					<form name="rsvp" id="rsvp" action=<?php echo $url; ?> method="POST">
						<label for=""/>Are you going?</label><br>
						<input type="radio" name="decision" value="Yes">Yes<br>
						<input type="radio" name="decision" value="No">No<br>
						<input type="radio" name="decision" value="Maybe">Maybe<br>
						<input class= "btn" type="submit" name="rsvp_submit" value="RSVP">
					</form>

					<div id="rsvp_message">
						<?php echo $rsvp_message; ?>
					</div>			
				</div>
			<div>
		</div>
	</body>
</html>
