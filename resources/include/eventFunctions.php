<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");


//event search functions here
function doEventSearch () {

	if(isset($_POST['search_submit'])) {

		$input = $_POST['search_query'];

		$search_results = eventSearch($input, -1, 0, 0, TRUE, FALSE);

		foreach ($search_results as $result){
			print "<p>{$result}</p>";
		}
}

}

function displayEventCard($EID, $Distance=-1)
{
	$event = getEventCard($e);
	$ename = $event["Name"];
	$edate = date("F j, Y g:i a",strtotime($event["Date"]));
	$eloc = $event["Location"];
	
	print "<div id='event-$EID' class='event-card'>
			<p id='name'><a href='event.php?e=$EID'>$ename</a></p><br>
			<p id='date'>$edate</p><br>
			<p id='loc'>$eloc</p>
			</div>";
}


?>