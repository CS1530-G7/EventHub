<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");



function displayEventCard($EID, $Distance=-1, $rsvp=-1)
{

	$event = getEventCard($EID);
	if($event >= 0)
	{
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
				print "<p id='dist'>$edist mi</p>";
			}
			if($rsvp >= 0)
			{
				$ersvp = rsvpText($rsvp);
				print "<p id='rsvp'>$ersvp</p>";  
			}
			
			
			
			print "</div>";
	}
}
function displayInviteCard($IID)
{
	$inv = getInviteCard($IID);
	if($inv >= 0)
	{
		$guID = $inv["GuestID"];
		$invr = $inv["Inviter"];
		$invrID = $inv["InviterID"];
		$ename = $inv["Event"];
		$eid = $inv["EventID"];
		$msg = $inv["Message"];
		
		print "<div id='invite-$IID' class='invite-card'>
				<p id='EName'><a href='event.php>e=$eid'>$ename</a></p>
				<p id='Invite'>Invited by <a href='profile.php?u=$invrID'>$invr</a></p>
				<p id='Msg' class='quote'>$msg</p>
				<form name='Invite' action='profile.php?u=$guID' method='POST'>
					<input class='btn-invite' name='invite-submit' type='submit' value='Accept'>
					<input class='btn-invite' name='invite-submit' type='submit' value='Reject'>
				</form></div>";
	
	}
}
function rsvpText($rsvp)
{
	$RSVPText = array("Not Going","Maybe", "Going");
	
	return $RSVPText[$rsvp];
}

?>