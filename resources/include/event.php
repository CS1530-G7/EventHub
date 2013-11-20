<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");



function eventHTML() {

$EID = $_GET['e'];

$e_name = getEventField($EID, 'e_name');
$e_date = getEventField($EID, 'e_date');
$e_descrip = getEventField($EID, 'e_descrip');
$e_private = getEventField($EID, 'e_private');

$LID = getEventLocation($EID);

$e_location = getEventLocationAddress($EID);
$e_address = getEventLocationName($EID);

// get people who are going
$attendees = getUsersByRSVP($EID, 2);
$attendee_list = "";

foreach ($attendees as $going) {
	$username = getUsername($going);
	$attendee_list .= "<p>{$username}</p>";
}




$HTML = <<<END
 
 <h1>$e_name</h1>

 <p>$e_date</p>
 <p>$e_location</p>
 <p>$e_address</p>
 <p>$e_descrip</p>

 <h2>Who's going</h2>
 $attendee_list;

 

END;

print $HTML;

}

?>