<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");

$error_message = "";

if(isset($_POST['submit'])) {

	//get variables
	$event_name = $_POST['event_name'];
	$event_location = $_POST['event_location'];
	$event_addr = $_POST['event_addr'];
	$event_date = $_POST['event_date'];
	$event_time = $_POST['event_time'];
	$event_description = $_POST['event_description'];
	$event_private = $_POST['private_event'];

	// put date/time in right format for DB entry
	$event_date_time = $event_date . " " . $event_time . ":00";
	$event_date_time = strtotime($event_date_time);

	// get the date for error checking purposes
	$current_date = date("m-d-y");


	// make radio button boolean
	if($event_private == "True") {
		$event_private = TRUE;
	} else {
		$event_prviate = FALSE;
	}

	// get active user ID
	// makes sure someone's logged in
	$userID = getActiveUser();

	if($userID == -1){

		$error_message .= "<p>You must be logged in to create an event.</p>";

	}

	// checks for empty form fields
 	if(empty($event_name) || empty($event_location) || empty($event_date) || empty($event_time) 
 			|| empty($event_description) || empty($event_addr) ){

 		$error_message .= "<p>There are empty form fields.</p>";

 	}

 	// checks event name length
 	if(strlen($event_location) < 6 || strlen($event_location) > 50 ) {

 		$error_message .= "<p>Please enter a valid location.</p>";

 	}

 	// check event description length
 	if(strlen($event_description) < 10 || strlen($event_description) > 1000 ) {

 		$error_message .= "<p>Please describe the event a bit.</p>";

 	}

 	if($error_message == '') {
 		addEvent($userID, $event_name, $event_location, $event_addr, $event_date_time, $event_description, $event_private);
 		$event_success = "<p>Successfully created this event. <a href=\"#\">Click here</a> to view.</p>";
 	}




 }

?>