<?php 

 ?>
 
 <html>
	<body>
		<h1>Sign up!</h1>
		
		<!-- <img src="./resources/img/Homepage.jpg" /> -->
		<div id="event_create_form">

			<form id="event_create" name="create_event" action="" method="POST">
				Event Name: <input type="text" name="event_name">
				Event Location: <input type="text" name="event_location">
				Event Date: <input type="date" name="event_date">
				Event Description: <textarea name="description" form="event_create">Give event description</textarea>
				<input type="submit" value="Submit">
			</form>

		</div>
			
		
	</body>
</html>
