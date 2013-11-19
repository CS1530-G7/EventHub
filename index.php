<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/login.php");

?>
 
 <html>

 	<header>

 	<script>
 		function RemoveText(obj) {   obj.value = ''; } 
 	</script>

 	</header>
	<body>


		<!-- Simple login logic here:
					If not logged in, show the login form
					If logged in, then welcome user and show profile link
		-->
		<div id="login">
			<?php
				$UID = getActiveUser();
					if($UID >= 0) {
						$user = getUsername($UID);
						$link = "profile.php?u={$UID}";
						echo "<p>Welcome {$user}!</p>";
						echo "<p><a href=\"{$link}\">Click here</a> to view your profile.</p>";
					} else {
						echo '
						
						<div id="login-form">
						'; ?>

							<div id="login-errors">
								<?php echo $error_message; ?>
							</div>

							<?php
							echo'
							<form name="login" id="login" action="index.php" method="POST">
								<label for="username"/>Username:</label>
								<input type="text" name="username">
								<label for="password"/>Password:</label>
								<input type="password" name="password">
								<input class= "btn" name="submit" type="submit" value="Submit">
							</form>

						</div>

						<div id="sign-up">
							<a href="signup.php">Sign up</a>
						</div>';
						

					}

				?>			
		</div>
		
		<h1>Welcome to EventHub!!</h1>
		
		<!--<img src="./resources/img/Homepage.jpg" />-->
		<div id="search-area">
			<form name="login" id="login" action="index.php" method="POST">
				<label for="username"/></label>
				<input type="text" name="search_query" value="Type your location" onclick="RemoveText(this);">
				<input class= "btn" name="search_submit" type="submit" value="Search Events">
			</form>
		</div>
		
	</body>
</html>

<?php



?>