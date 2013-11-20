<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");


//event search functions here
function doEventSearch () {

	if(isset($_POST['search_submit'])) {

		$input = $_POST['search_query'];

		$search_results = eventSearch($input, -1, 0, 0, TRUE, FALSE);

		foreach ($search_results as $result){
			$e_id = $result['id'];
			print "<p>{$result}</p>";
		}
	}

}


?>