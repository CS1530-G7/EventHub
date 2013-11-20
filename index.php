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
	 	<div id="main-center">
			<div id="header">
				<?php login_div($msg); ?>
			</div>
			<div id="content">
				<!-- Simple login logic here:
							If not logged in, show the login form
							If logged in, then welcome user and show profile link
				-->
				<h1>EventHub</h1>

				<?php searchBar(); ?>
			</div>
			<div id="footer">EventHub</div>
		</div>
	</body>
</html>

<?php



?>