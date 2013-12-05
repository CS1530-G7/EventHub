<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/login.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/search.php");

$login_msg = doLogin();
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

			
				<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/topbar.php");?>
			

			<div id="content">
				<h1>EventHub: Hi CS 1530</h1>

				<?php searchBar(); ?>
			</div>
		</div>
	</body>
</html>

<?php



?>