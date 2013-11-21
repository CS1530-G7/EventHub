<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/include/data.php");




function doInvite() {
	$message = "";

	if(isset($_POST['invite_submit'])) {

		echo "invite submit presed";

		$username = $_POST['username'];
		$invitee_UID = getUserID($username);
		$inviter_UID = getActiveUser();

		$EID = $_GET['e'];

		echo $EID . " " . $username . " " . $invitee_UID . " " . $inviter_UID;

		if ($inviter_UID == -1) {
			$error_message .= "<p>You must be logged in to invite others.</p>";
		}

		if ($invitee_UID == -1) {
			$error_message .= "<p>Please check that the user you want to invite exists.</p>";
		}

		// if no errors, then send the invite
		if ($error_message == "") {
			sendInvite($inviter_UID, $invitee_UI, $EID, $msg="");
			$message = "<p>You successfully invited {$username}!</p>";
		}

	}

	return $message;

}

?>