<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/login.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/search.php");

$login_msg = doLogin();


?>

<html>
    <head>
        <title>EventHub</title>
         <link rel="stylesheet" type="text/css" href="/resources/css/style.css">
     </head>

    <body>
        <div id="main-center">
            <!-- Header -->
            <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/topbar.php");?>
            
            <!-- Content -->
            <div id="content">
                <div id="search_results">
                    <h3>Search Results</h3>
                	<?php doEventSearch(); ?>
                </div>
            </div>
        </div>
    </body>
</html>