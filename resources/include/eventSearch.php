<?

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");



if(isset($_POST['search_submit'])) {

	$input = $_POST['search_query'];

	//$search_results = eventSearch($input, $dist, $user_lat, $user_lon, $dateorder, $futureEventsOnly);
	$search_results = eventSearch($input);

	#echo $search_results;

	#var_dump($search_results);

}

	
?>