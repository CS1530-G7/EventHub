<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");

function doRSVP() {



	if(isset($_POST['rsvp_submit'])) {

		$rsvp = $_POST['decision'];
		$message = "";
		$UID = getActiveUser();
		$EID = $_GET['e'];


		//echo getUserRSVP($UID, $EID);

	
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

 			$userRSVPs = getUserRSVPs($UID, FALSE, FALSE);

 			foreach($userRSVPs as $r){
 				if($r == $EID) {
 					$userCurrentRSVP = getUserRSVP($UID, $EID);
 				}
 			}


 			// if a user is not already chosen an RSVP option for this event, then do these
 			if($userCurrentRSVP == -1) {


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
 			// if the user has already picked something, then do the change function
 			else {

 				if($rsvp == "Yes") {
 					$message = "<p>RSVP'd! Glad you decided to go!</p>";
 					$rsvp = 2;
 					changeRSVP($UID, $EID, $rsvp);
 				} else if ($rsvp == "Maybe") {
 				 		$message = "<p>Oh, you're maybe going now?</p>";
 						$rsvp = 1;
 						changeRSVP($UID, $EID, $rsvp);
 				} else if ($rsvp == 0) {
 				 		$message = "<p>Make up your mind and go!</p>";
 						$rsvp = 0;
 						changeRSVP($UID, $EID, $rsvp);
 				}



 			}
 	}

	return $message;
}

function rsvpStatus() {

	$message = "";
	$UID = getActiveUser();
	$EID = $_GET['e'];

	$status = -1;
	$status = getUserRSVP($UID, $EID);

	if ($status -1 || $status == -2) {
		$message = "<p>You haven't made your mind up about this event, yet.</p>";
	}

	if($status == 0) {

		$message = "<p>You are currently not going to this event.</p>";

	} elseif ($status == 1) {

		$message = "<p>You might be going.</p>";

	} elseif ($status == 2) {

		$message = "<p>You are going to this event.</p>";

	}

	return $message;
}


?>