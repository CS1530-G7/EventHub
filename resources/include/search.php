<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");

function fixSearchQuery ($query){

	$words = explode(" ", $fixed_query);

	$num_words = count($words);

	if($num_words == 0) {
		$fixed_query = '';
	} else if ($num_words == 1){
		$fixed_query = $query;
	} else {
		$i = 0;
		for (; $i < $num_words; $i++){
			if($i == 0){
				$fixed_query .= "(";
			} else if ($i == $num_words) {
				$fixed_query .= ")";
			} else {
				$fixed_query .= $words[$i];
				$fixed_query .= "|";
			}

		}
	}


	return $fixed_query;
}


//event search functions here
function doEventSearch () {

	if(isset($_POST['search_submit'])) {

		$input = $_POST['search_query'];

		fixSearchQuery($input);
		echo $input;

		$search_results = eventSearch($input, -1, 0, 0, TRUE, FALSE);

		// print results
		foreach ($search_results as $result){
			$e_id = $result['id'];
			$event_name = getEventName($e_id);
			$event_link = "<a href=\"event.php?u={$e_id}\">{$event_name}</a>";
			$event_date = getEventDate($e_id);

			print "<p>{$event_link} {$event_date}</p>";
		}
	}

}


?>