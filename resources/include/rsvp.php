<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");

function doRSVP() {



	if(isset($_POST['rsvp_submit'])) {

		$rsvp = $_POST['decision'];
		$message = "";
		$UID = getActiveUser();
		$EID = $_GET['e'];


		echo getUserRSVP($UID, $EID);

	
		// check for input errors
		if (empty($rsvp)){
			$message .= "<p>Please select an RSVP option.</p>";
		}

		if ($UID == -1){
			$message .= "<p>Please log in to RSVP.</p>";
		}

		// no input errors
 		if ($message == "") {

 			// check to see if user already RSVP'd
 			$userCurrentRSVP = -1;

 			$userRSVPs = getUsersRSVPs($UID, FALSE, FALSE);

 			foreach($userRSVPs as $r){
 				if($r == $EID) {
 					$userCurrentRSVP = getUserRSVP($UID, $EID);
 				}
 			}
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