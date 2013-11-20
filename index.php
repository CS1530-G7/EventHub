<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/login.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/search.php");

$msg = doLogin();
?>
 
<html>
	<head>
 		<title>EventHub</title>
 		<!-- Time stamp on css to stop caching so I can actually get work done when making changes -->
        <link rel="stylesheet" type="text/css" href="css/style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" media="screen" />
	 	<script>
	 		function RemoveText(obj) {   obj.value = ''; } 
	 	</script>
    </head>

	<body>
		<header>
			<form name="login" id="login" action="index.php" method="POST">
				<label for="username"/></label>
				<input type="text" name="search_query" value="" onclick="RemoveText(this);">
				<input class= "btn" name="search_submit" type="submit" value="Search Events">
			</form>
		</header>
	 	<div id="main_center">
			<!-- Simple login logic here:
						If not logged in, show the login form
						If logged in, then welcome user and show profile link
			-->
			<?php login_div($msg); ?>

			<h1>EventHub</h1>

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