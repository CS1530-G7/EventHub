<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/login.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/search.php");
$msg = doLogin();


?>

<html>
<body>
<?php login_div($msg); searchBar(); ?>
<div id="search_results">
	<?php doEventSearch(); ?>
</div>
</body>
</html>