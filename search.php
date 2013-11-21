<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/login.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/search.php");

$login_msg = doLogin();


?>

<html>
<body>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/topbar.php");?>
<div id="search_results">
	<?php doEventSearch(); ?>
</div>
</body>
</html>