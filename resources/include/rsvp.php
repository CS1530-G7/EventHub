<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");

function doRSVP() {



	if(isset($_POST['rsvp_submit'])) {

		$rsvp = $_POST['decision'];
		$message = "";
		$UID = getActiveUser();
		$EID = $_GET['e'];

	

		if (empty($rsvp)){
			$message .= "<p>Please select an RSVP option.</p>";
		}

		if ($UID == -1){
			$message .= "<p>Please log in to RSVP.</p>";
		}

 		if ($message == "") {

 			$test = changeRSVP($UID, $EID, 0);
 			echo $test;


 			if($rsvp == "Yes") {
 				$message = "<p>RSVP'd! See you there!</p>";
 				$rsvp = 2;
 				addRSVP($UID, $EID, $rsvp);
 			} else if ($rsvp == "Maybe") {
 				 	$message = "<p>We hope you make it!</p>";
 					$rsvp = 1;
 					addRSVP($UID, $EID, $rsvp);
 			} else if ($rsvp == 0) {
 				 	$message = "<p>If you change your mind, come back and RSVP anytime!</p>";
 					$rsvp = 0;
 					addRSVP($UID, $EID, $rsvp);
 			}
 }

}

	return $message;
}


?>