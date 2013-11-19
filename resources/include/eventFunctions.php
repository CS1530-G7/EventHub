<?

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");

$eventName = '';
$eventDate = '';
$eventDescription = '';
$eventPrivate = 0;

if ( isset($_POST['u']) ) {

	$eventID = $_POST['u'];

	$eventName = getEventField($EID, 'e_name');
	$eventDate = getEventField($EID, 'e_date');
	$eventDescription = getEventField($EID, 'e_descrip');
	$eventPrivate = getEventField($EID, 'e_private');;

} else {

	$eventID = -1;	

}
	

 



?>