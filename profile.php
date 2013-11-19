<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/profile.php");


?>
 
 <html>

 	<header>

 	<script>
 		function RemoveText(obj) {   obj.value = ''; } 
 	</script>

 	</header>
	<body>
		
		<!-- what's displayed depends upon who's looking at this page-->
		<?php echo $HTML; ?>

	</body>
</html>


<?php


?>