<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/login.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/search.php");

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

		

		<h1>Welcome to EventHub!!!</h1>

		<?php searchBar(); ?>
		
		<!--<img src="./resources/img/Homepage.jpg" />-->

		</div>
		
	</body>
</html>

<?php



?>