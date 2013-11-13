<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");

?>
 
 <html>

 	<header>

 	<script>
 		function RemoveText(obj) {   obj.value = ''; } 
 	</script>

 	</header>
	<body>
	
		<h1>Welcome [Name Here]</h1>
		
		<!--<img src="./resources/img/Homepage.jpg" />-->
		<div id="search-area">
			<form name="login" id="login" action="login.php" method="POST">
				<label for="username"/></label>
				<input type="text" name="search_query" value="Type your location" onclick="RemoveText(this);">
				<input class= "btn" name="submit" type="submit" value="Search Events">
			</form>
		</div>
		
	</body>
</html>
