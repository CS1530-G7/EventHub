<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");


//event search functions here
function doEventSearch () {

	if(isset($_POST['search_submit'])) {

		$input = $_POST['search_query'];

		$search_results = eventSearch($input, -1, 0, 0, TRUE, FALSE);

		// print results
		foreach ($search_results as $result){
			$e_id = $result['id'];
			$event_name = getEventName($e_id);
			$event_link = "<a href=\"event.php?u={$e_id}\"></a>";

			print "<p>{$event_name} - {$event_link}</p>";
		}
	}

}


?>