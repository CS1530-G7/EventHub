<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");



function eventHTML() {

$EID = $_GET['u'];

$e_name = getEventField($EID, 'e_name');
$e_date = getEventField($EID, 'e_date');
$e_descrip = getEventField($EID, 'e_descrip');
$e_private = getEventField($EID, 'e_private');

$LID = getEventLocation($EID);



$HTML = <<<END
 
 <h1>$e_name</h1>

 <h2>$e_date</h2>

 <p>$e_descrip</p>


END;

print $HTML;

}

?>