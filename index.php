<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/login.php");
$msg = doLogin();
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
		<?php login_div($msg); ?>

		<div id="logout">
			<a href="logout.php">Logout</a>
		</div>
		

		<h1>Welcome to EventHub!!!</h1>

		
		<!--<img src="./resources/img/Homepage.jpg" />-->
		<div id="search-area">
			<form name="login" id="login" action="index.php" method="POST">
				<label for="username"/></label>
				<input type="text" name="search_query" value="" onclick="RemoveText(this);">
				<input class= "btn" name="search_submit" type="submit" value="Search Events">
			</form>
		</div>
		
	</body>
</html>

<?php



?>