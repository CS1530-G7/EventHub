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



		<!-- Simple login logic here:
					If not logged in, show the login form
					If logged in, then welcome user and show profile link
		-->
		<?php login_div($msg); ?>

		

		<h1>Welcome to EventHub!!!</h1>

		<?php searchBar(); ?>
		
		<!--<img src="./resources/img/Homepage.jpg" />-->


		</div>
		
	</body>
</html>

<?php



?>