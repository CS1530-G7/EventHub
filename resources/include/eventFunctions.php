<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");



function displayEventCard($EID, $Distance=-1, $rsvp=-1)
{

	$event = getEventCard($EID);

	$ename = $event["Name"];
	$edate = date("F j, Y g:i a",strtotime($event["Date"]));
	$eloc = $event["Location"];
	$edist = number_format($Distance,2);
	$hname = $event["Host"];
	$hid = $event["HostID"];
	
	print "<div id='event-$EID' class='event-card'>
			<p id='name'><a href='event.php?e=$EID'>$ename</a></p>
			<p id='host'>Host <a href='profile.php?u=$hid'>$hname</a></p>
			<p id='date'>$edate</p>
			<p id='loc'>$eloc</p>";
			if($Distance >= 0)
			{
				print "<p id='dist'>$edist</p>";
			}
			if($rsvp >= 0)
			{
				$ersvp = rsvpText($rsvp);
				print "<p id='rsvp'>$ersvp</p>";  
			}
			
			
			
			print "</div>";
}
function rsvpText($rsvp)
{
	$RSVPText = array("Not Going","Maybe", "Going");
	
	return $RSVPText[$rsvp];
}

?>