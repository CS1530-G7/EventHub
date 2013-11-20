<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "resources/include/data.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "resources/include/createEventValidation.php");


?>
 
 <html>
	<body>
		<h1>Create a new event</h1>
		
		<!-- <img src="./resources/img/Homepage.jpg" /> -->
		<div id="event_create_form">

			<div id="event_create_errors">
				<?php echo $error_message; ?>
			</div>

			<div id="create_event_sucess">
				<?php
					echo $event_success;
				?>
			</div>

			<form id="event_create" name="create_event" action="createEvent.php" method="POST">
				<label for="username"/>Event Name:</label>
				<input type="text" name="event_name">
				<label for="event_location"/>Event Location:</label>
				<input type="text" name="event_location">
				<label for="event_addr"/>Event Address:</label>
				<input type="text" name="event_addr">
				<label for="event_date"/>Event Date:</label>
				<input type="date" name="event_date" min="<?php echo date('Y-m-d'); ?>">
				<label for="event_time"/>Event Time:</label>
				<input type="time" name="event_time">
				<label for="description"/>Event Description:</label>
			 	<textarea name="event_description" form="event_create"></textarea>
			 	<label for="private_event"/>Private Event?:</label>
			 	<input type="checkbox" name="private_event" value="TRUE">
				<input type="submit" name="submit" value="Submit">
			</form>

		</div>
			
		
	</body>
</html>