<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");


function formatDate($e_date) {

	$formattted_date = "";


	return $formattted_date;

}


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
$num_attendees = count($attendee_list);


foreach ($attendees as $uid) {
	if($username > 0) {
			$username = getUsername($uid);
			$attendee_list .= "<p>{$username}</p>";
		} else {
			$attendee_list = "<p>No one's going... Be the first and <a href=\"#\">RSVP!</a></p>";
		}
}





$HTML = <<<END

<div id="event_info">
 
 <h1>$e_name</h1>

 <p><b>Date</b>: $e_date</p>
 <p><b>Location</b>: $e_location</p>
 <p><b>Address</b>: $e_address</p>
 <p><b>Description</b>: $e_descrip</p>

 <h2>Who's going</h2>
 $attendee_list

</div>


END;

print $HTML;

}


?>