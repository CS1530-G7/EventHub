<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");

$EID = $_POST['u'];

$e_name = getEventField($EID, 'e_name');
$e_date = getEventField($EID, 'e_date');
$e_descrip = getEventField($EID, 'e_descrip');
$e_private = getEventField($EID, 'e_private');

echo $e_name . $e_date . $e_descrip . $e_private;


?>