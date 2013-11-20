<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/eventFunctions.php");


// transforms multi word search into an OR regex
function fixSearchQuery ($query){

	$words = explode(" ", $query);

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

	if(isset($_GET['q'])) {

		$input = $_GET['q'];

		// transforms multi word search into regex
		fixSearchQuery($input);
		$doDistance = FALSE;
		//Check if distance search can be done
		$user = getActiveUser();
		if($user >= 0)
		{
				$loc = getUserLocation($user);
				if($loc == -1 || $loc["Lat"] == NULL)
				{	
				}
				else if($loc == -2)
				{
				}
				else
				{
					$doDistance = TRUE;
				}
		}
		
		//Eventually we should do an advance search to change all of these fixed vars in to variables set by user.
		if($doDistance)
		{
			$search_results = eventSearch($input, 50, $loc["Lat"], $loc["Lng"], TRUE, TRUE);
		}
		else
		{
			$search_results = eventSearch($input, -1, 0, 0, TRUE, TRUE);
		}

		// print results
		foreach ($search_results as $result)
		{
			$e_id = $result['id'];
			$e_dist = $result['distance'];
			if($doDistance)
			{
				displayEventCard($e_id, $e_dist);
			}
			else
			{
				displayEventCard($e_id);
			}
			
		}
	}

}

function searchBar()
{

$search = <<<SEARCH

<div id="search-area">
		<form name="login" id="login" action="search.php" method="GET">
			<label for="username"/></label>
			<input type="text" width="400" name="q" value="Search for event"><br>
			<input class= "btn" type="submit" value="Search Events">
		</form>
</div>
SEARCH;

print $search;
}
?>