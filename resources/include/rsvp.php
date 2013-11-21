<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");

function doRSVP {

	$message = "";

	if(isset($_POST['rsvp_submit'])) {

		$rsvp = $_POST['decision'];

		echo $rsvp;
	}

}


?>