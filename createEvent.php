<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");

//get variables
$event_name = $_POST['event_name'];
$event_location = $_POST['event_location'];
$event_date = $_POST['event_date'];
$event_description = $_POST['event_description'];
$event_private = $_POST['private_event'];

echo "{$event_name}, {$event_location}, {$event_date}, {$event_description}, {$event_private}";

?>
 
 <html>
	<body>
		<h1>Create Event!</h1>
		
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
