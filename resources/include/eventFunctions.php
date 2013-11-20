<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");



function displayEventCard($EID, $Distance=-1)
{
	$event = getEventCard($e);
	$ename = $event["Name"];
	$edate = date("F j, Y g:i a",strtotime($event["Date"]));
	$eloc = $event["Location"];
	$edist = number_format($Distance,2);
	
	print "<div id='event-$EID' class='event-card'>
			<p id='name'><a href='event.php?e=$EID'>$ename</a></p><br>
			<p id='date'>$edate</p><br>
			<p id='loc'>$eloc</p>"
			if($Distance >= 0)
			{
				print "<p id='dist'>$edist</p>";
			}
			
			
			print "</div>";
}


?>