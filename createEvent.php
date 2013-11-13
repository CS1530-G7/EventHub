<?php

/*
	TODO: 

		- Fix date input
		- Prevent multiple submits to DB



*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");

//get variables
$event_name = $_POST['event_name'];
$event_location = $_POST['event_location'];
$event_date = $_POST['event_date'];
$event_description = $_POST['event_description'];
$event_private = $_POST['private_event'];

$error = FALSE;

// make radio button boolean
if($event_private == "True") {
	$event_private = TRUE;
} else {
	$event_prviate = FALSE;
}

echo "{$event_name}, {$event_location}, {$event_date}, {$event_description}, {$event_private} <br><br>";

//submit button clicked
if(isset($_POST['submit'])) {

	// check for active user
	// only logged in users can create events
	// change this for form testing
	$userID = getActiveUser();

	//$userID = 123456789;
	if($userID != -1){


		$user = getUsername($userID);
		echo "user <b>{$user}</b> is logged in and ready to create an EVENT!<br><br>";


		// checks for empty form fields
 		if(empty($event_name) || empty($event_location) || empty($event_date) || empty($event_description)) {

 			echo "empty form field(s)</br>";
 			$error = TRUE;

 		}

 		// check event name length
 		if(strlen($event_name) < 6 || strlen($event_name) > 50 ) {

 			echo "event name must be between 6 and 50 characters</br>";
 			$error = TRUE;

 		}

 		// check event location length
 		// TODO: figure out how to do locations
 		if(strlen($event_location) < 6 || strlen($event_location) > 50 ) {

 			echo "event location must be between 6 and 50 characters</br>";
 			$error = TRUE;

 		}

 		// check event description length
 		if(strlen($event_description) < 10 || strlen($event_description) > 1000 ) {

 			echo "event description must be between 10 and 1000 characters</br>";
 			$error = TRUE;

 		}

 		// no errors, submit to DB
 		// date needs corrected
 		if(!$error) {

 			echo "event created!<br>";
 			addEvent($userID, $event_name, $event_location, $event_date, $event_description, $event_private);

 		}


	} else {

		echo "no active user out and about<br>";

	}


}

?>
 
 <html>
	<body>
		<h1>Create a new event</h1>
		
		<!-- <img src="./resources/img/Homepage.jpg" /> -->
		<div id="event_create_form">

			<form id="event_create" name="create_event" action="createEvent.php" method="POST">
				<label for="username"/>Event Name:</label>
				<input type="text" name="event_name">
				<label for="event_location"/>Event Location:</label>
				<input type="text" name="event_location">
				<label for="event_date"/>Event Date:</label>
				<input type="date" name="event_date">
				<label for="description"/>Event Description:</label>
			 	<textarea name="event_description" form="event_create"></textarea>
			 	<label for="private_event"/>Private:</label>
			 	<input type="checkbox" name="private_event" value="TRUE">
				<input type="submit" name="submit" value="Submit">
			</form>

		</div>
			
		
	</body>
</html>
