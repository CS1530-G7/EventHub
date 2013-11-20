<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/login.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/search.php");

$msg = doLogin();
?>
 
<html>
	<head>
 		<title>EventHub</title>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
	 	<script>
	 		function RemoveText(obj) {   obj.value = ''; } 
	 	</script>
    </head>

	<body>
		<div id="header">
			<?php login_div($msg); ?>
		</div>
	 	<div id="main-center">
			<!-- Simple login logic here:
						If not logged in, show the login form
						If logged in, then welcome user and show profile link
			-->

			<h1>EventHub</h1>

			<form name="login" id="login" action="index.php" method="POST">
				<label for="username"/></label>
				<input type="text" name="search_query" value="" onclick="RemoveText(this);">
				<input class= "btn" name="search_submit" type="submit" value="Search Events">
			</form>
			<div id="search-area">
				<div id="search_results">
					<?php doEventSearch(); ?>
				</div>
			</div>

		</div>
		
	</body>
</html>

<?php



?>