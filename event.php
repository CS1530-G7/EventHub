<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/login.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/search.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/event.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/invite.php");
$msg = doLogin();

$invite_message = doInvite();

$EID = $_GET['e'];
$url = "event.php?e={$EID}";
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
			eventHTML();
		?>

		<div id="invite">
			<h2>Send invites to this event...</h2>
			<form name="invite" id="invite" action=<?php echo $url; ?> method="GET">
				<label for="username"/></label>
				<input type="text" name="username" value="" size="50">
				<input class= "btn" type="submit" name="invite_submit" value="Invite user">
			</form>

			<div id="invite_message">
				<?php echo $invite_message; ?>
			</div>
		</div>
		
	</body>
</html>
