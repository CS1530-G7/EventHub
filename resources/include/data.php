<?php
startSession();
require_once("pw.php");

//Generic functions

function startSession()
{
	if (session_id() === "") 
	{
		session_start();
	}
}

function endSession()
{
	if (session_id() !== "") 
	{
		 session_write_close ();
	}

}


function sanitize($input)
{
	$sql = getSQL(FALSE);
	//Remove semicolons
	$input = str_replace(";","",$input);
	//Escapes harmful characters
	$input = mysqli_real_escape_string($sql, $input);

	
	return $input;
}

function salthash($text)
{
		$salt = "thecaptain";
		$text = $salt . $text . $salt;
		return sha1($text);
	
}

function sqlQuery($sql, $query)
{
	$res = mysqli_query($sql,$query);
	if($res === FALSE)
	{
		$_SESSION["sql_error"] = mysqli_error($sql);
		addLog("SQLError",$query . ": " . mysqli_error($sql));
		return -2;
	}
	else
	{
		unset($_SESSION["sql_error"]);
	}

	return $res;
}

function sqlError()
{
	if(!empty($_SESSION["sql_error"]))
	{
		return $_SESSION["sql_error"];
	}
	else
	{
		return FALSE;
	}

}

function addLog($type, $msg)
{
	
	$sql = getSQL(TRUE);
	$type = sanitize($type);
	$msg = sanitize($msg);
	$query = "INSERT INTO log (type, details) VALUES ('$type','$msg')";
	mysqli_query($sql,$query); //Don't call sqlQuery for fear of infinite logging loop
}


//User SQL wrappers

function getUserID($username)
{

	$sql = getSQL(FALSE);
	
	$user = sanitize($username);
	
	$query = "SELECT u_id FROM e_users WHERE u_name = '$user'";
	
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
			
	$row = $res->fetch_assoc();
	
	if($row)
	{
		return $row["u_id"];
	}
	else
	{
		return -1;
	}
}



function checkEmail($email)
{

	$sql = getSQL(FALSE);
	
	$query = "SELECT u_id FROM e_users WHERE u_email = '$email'";
	
		$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
			
	$row = $res->fetch_assoc();
	
	if($row)
	{
		return $row["u_id"];
	}
	else
	{
		return -1;
	}
}

function getUserField($UID, $field)
{
	$sql = getSQL(FALSE);
	$UID = sanitize($UID);
	$query = "SELECT $field FROM e_users WHERE u_id = '$UID'";
	
	//print $query;
	
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
	$row = $res->fetch_assoc();
	
	if($row)
	{
		return $row[$field];
	}
	else
	{
		return -1;
	}

}
function getUserLField($UID, $field)
{
	$sql = getSQL(FALSE);
	
	$query = "SELECT l.$field AS $field FROM e_users AS u LEFT JOIN e_location AS l ON (u.l_id = l.l_id) WHERE u.u_id = '$UID'";
	
	//print $query;
	
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
	$row = $res->fetch_assoc();
	
	if($row)
	{
		return $row[$field];
	}
	else
	{
		return -1;
	}

}
function setUserField($UID, $field, $data)
{
	$sql = getSQL(TRUE);
	$data = sanitize($data);
	$UID = sanitize($UID);
	$query = "UPDATE e_users SET $field='$data' WHERE u_id = '$UID'";
	
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
}
//Getters
function getUsername($UID)
{
	return getUserField($UID, "u_name");
}

function getUserStatus($UID)
{
	return getUserField($UID, "u_status");
}

function getActivationCode($UID)
{
	return getUserField($UID, "u_activecode");
}

function getEmail($UID)
{
	return getUserField($UID, "u_email");
}
function getLocID($UID)
{
	return getUserField($UID, "l_id");
}
function getUserLocationName($UID)
{
	return getUserLField($UID, "l_name");
}
function getUserAddress($UID)
{
	return getUserLField($UID,"l_address");
}
//Setters
function setUsername($UID, $data)
{
	setUserField($UID, "u_name", $data);
}

function setUserStatus($UID, $data)
{
	setUserField($UID, "u_status", $data);
}

function setActivationCode($UID, $data)
{
	setUserField($UID, "u_activecode", $data);
}

function setEmail($UID, $data)
{
	setUserField($UID, "u_email", $data);
}
function setUserLocation($UID, $loc_name, $loc_address)
{
	$data = newLocation($loc_name, $loc_address);
	//Delete old user location?
	setUserField($UID, "l_id", $data);
}
function changePassword($UID, $password)
{
	$pass = salthash($password);
	setUserField($UID, "u_pass", $pass);
}
//Event SQL wrappers
function getEventField($EID, $field)
{
	$sql = getSQL(FALSE);
	
	$query = "SELECT $field FROM e_events WHERE e_id = '$EID'";
	
	//print $query;
	
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
	$row = $res->fetch_assoc();
	
	if($row)
	{
		return $row[$field];
	}
	else
	{
		return -1;
	}

}

function getEventLField($EID, $field)
{
$sql = getSQL(FALSE);
	
	$query = "SELECT l.$field AS $field FROM e_events AS e LEFT JOIN e_location AS l ON (e.l_id = l.l_id) WHERE e.e_id = '$EID'";
	
	//print $query;
	
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
	$row = $res->fetch_assoc();
	
	if($row)
	{
		return $row[$field];
	}
	else
	{
		return -1;
	}

}

function setEventField($EID, $field, $data)
{
	$sql = getSQL(TRUE);
	$data = sanitize($data);
	$query = "UPDATE e_events SET $field='$data' WHERE u_id = '$EID'";
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
}
//Event SQL Wrappers
function getEventName($EID)
{
	return getEventField($EID,"e_name");
}
function getEventDate($EID)
{
return getEventField($EID,"e_date");
}
function getEventDescription($EID)
{
return getEventField($EID,"e_descrip");
}
function isEventPrivate($EID)
{
	$p = getEventField($EID,"e_private");
	if($p == 0)
	{
		return FALSE;
	}
	else if($p == 1)
	{
		return TRUE;
	}
	else
	{
		return $p;
	}

}
function getEventHost($EID)
{
	return getEventField($EID,"u_id");
}
function getEventLocation($EID)
{
	return getEventField($EID,"l_id");
}
function getEventLocationName($EID)
{
	return getEventLField($EID,"l_name");
}
function getEventLocationAddress($EID)
{
	return getEventLField($EID,"l_address");
}

function setEventName($EID, $data)
{
	return setEventField($EID,"e_name", $data);
}
function setEventDate($EID, $data)
{
	return setEventField($EID,"e_date", $data);
}
function setEventDescription($EID, $data)
{
	return setEventField($EID,"e_descrip", $data);
}
function makeEventPrivate($EID)
{
	return setEventField($EID,e_private,1);
}
function makeEventPublic($EID)
{
	return setEventField($EID,e_private,0);
}
function setEventLocation($EID, $loc_name, $loc_address)
{
	$data = newLocation($loc_name, $loc_address);
	//Delete old event location?
	setEventField($EID, "l_id", $data);
}




//User functions


function createUser($username, $password, $email)
{
	$sql = getSQL(TRUE);
	
	$user = sanitize($username);
	$pass = salthash($password);
	$email = sanitize($email);
	$act_code = salthash($email);
	
	$query = "INSERT INTO e_users (u_activecode, u_name, u_email, u_pass) VALUES ('$act_code','$user','$email','$pass')";
	
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
	
	$id = mysqli_insert_id($sql);
	
	return $id;

}

function getActiveUser($timeout = 30)
{

	$tos = $timeout*60;
	if(isset($_SESSION["auth_userid"]))
	{
		$lt = getLoginTime();
		$now = time();
		if($now - $lt >= $tos)
		{
			//Login Expired
			print 
			logout();
			return -3;
		
		}
		else
		{
			return $_SESSION["auth_userid"];
		}
	}
	else
	{
		return -1;
	}
	
}

function getLoginTime()
{

	
	if(isset($_SESSION["auth_userid"]))
	{
		return $_SESSION["auth_time"];
	}
	else
	{
		return -1;
	}
}

function login($username, $password)
{

	
	$sql = getSQL(FALSE);
	
	$user = sanitize($username);
	$pass = salthash($password);
	
	$query = "SELECT u_id FROM e_users WHERE u_name='$user' AND u_pass='$pass'";
	
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
	$row = $res->fetch_assoc();
	
	if($row)
	{
		$uid =  $row["u_id"];
	}
	else
	{
		return -1;
	}
	
	$_SESSION["auth_userid"] = $uid;
	$_SESSION['auth_time'] = time();
	
	return $uid;
	
}
function logout()
{
	 unset ($_SESSION["auth_userid"]);
}

function deleteUser($uid)
{
	$sql = getSQL(TRUE);
	$query = "DELETE FROM e_users WHERE u_id='$uid'";
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
}

function getUserLocation($UID)
{
	$sql = getSQL(FALSE);
	$query = "SELECT l.l_lat As Lat, l.l_lng AS Lng FROM e_users AS u LEFT JOIN e_location AS l ON (u.l_id = l.l_id) WHERE u.u_id = '$UID'";
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
	$row = $res->fetch_assoc();
	
	if($row)
	{
		return $row;
	}
	else
	{
		return -1;
	}
}


//Event functions

function addEvent($UID, $evName, $evLocName, $evLocAddr, $evDateTime, $evDescrip, $evPrivate)
{
	$pf = 0;  //Privacy flag
	if($evPrivate)
	{
		$pf = 1;
	}
	$sql = getSQL(TRUE);
	
	$sqldate = date( 'Y-m-d H:i:s', $evDateTime );
	//$sqldate = $evDateTime;
	$evName = sanitize($evName);
	$evLocation = sanitize($evLocName);
	$evAddr = sanitize($evLocAddr);
	$evDescrip = sanitize($evDescrip);
	
	$lid = newLocation($evLocation, $evAddr);
	
	$query = "INSERT INTO e_events (e_name, e_date, e_descrip, e_private, u_id, l_id) VALUES ('$evName','$sqldate','$evDescrip',$pf,$UID,$lid)";
	
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
	$id = mysqli_insert_id($sql);
	
	addRSVP($UID, $id, 2);  //Add the host to the "going" list
	
	
	return $id;
	
}

function getEventsByUser($UID, $futureEventsOnly = TRUE)
{
	$sql = getSQL(FALSE);
	$UID = sanitize($UID);
	$query = "SELECT e_id FROM e_events WHERE u_id='$UID' ";
	if($futureEventsOnly)
	{
		$query .= "AND (e_date >= CURDATE()) ";
	}
	$query .= "ORDER BY e_date";
	$res = sqlQuery($sql, $query);
	if($res === -2) return -2;
	
	$events = array();
	while($row = mysqli_fetch_assoc($res))
	{
		$events[] = $row["e_id"];
	}
	
	return $events;
}
function getEventCard($EID)
{
	$sql = getSQL(FALSE);
	$EID = sanitize($EID);
	$query = "SELECT e.e_name AS Name, e.e_date AS Date, l.l_name AS Location, u.u_name AS Host, u.u_id AS HostID
	FROM (e_events AS e) LEFT JOIN (e_location AS l) ON (e.l_id = l.l_id) LEFT JOIN (e_users AS u) ON (e.u_id = u.u_id)
	WHERE e.e_id = '$EID'";
	$res = sqlQuery($sql, $query);

	if($res === -2) return -2;
	
	$row = $res->fetch_assoc();
	
	if($row)
	{
		return $row;
	}
	else
	{
		return -1;
	}
	
}

//Location functions
function newLocation($loc_name, $loc_address)
{

	$lname = sanitize($loc_name);
	$laddr = sanitize($loc_address);
	$addr_url = urlencode($laddr);
	
	$geocode_url = "https://maps.googleapis.com/maps/api/geocode/" . "json" . "?" . "address=" . $addr_url . "&sensor=" . "false";
	
	//print $geocode_url;
	
	$ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $geocode_url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $response = json_decode(curl_exec($ch), true);
 
   // If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
   if ($response['status'] != 'OK') 
   {
		
		$lat = 'NULL';
		$lng = 'NULL';
		addLog("GeocodeError",$response['status'] . ": " . $geocode_url);
   }
   else
   {
		$location = $response['results'][0]['geometry']['location'];
		$lat = $location['lat'];
		$lng = $location['lng'];
   }
   
   $sql = getSQL(TRUE);
   
   $query = "INSERT INTO e_location (l_name, l_address, l_lat, l_lng) VALUES ('$lname','$laddr',$lat,$lng)";
   
   	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
	$id = mysqli_insert_id($sql);
	
	return $id;
   
}

function getLocationLatLon($LID)
{
$sql = getSQL(FALSE);
	$LID = sanitize($LID);
	$query = "SELECT l_lat AS lat, l_lng AS lon FROM e_location WHERE l_id='$LID'";
	
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
	$row = $res->fetch_assoc();
	
	if($row)
	{
		return $row;
	}
	else
	{
		return -2;
	}
}



//Search Functions

//From Google:
//SELECT id, ( 3959 * acos( cos( radians(37) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(-122) ) + sin( radians(37) ) * sin( radians( lat ) ) ) ) AS distance FROM markers HAVING distance < 25 ORDER BY distance
//From Me;
//SELECT e.e_id, CONCAT( e.e_name, ' ', e.e_descrip, ' ', l.l_name ) AS s FROM (e_events AS e) LEFT JOIN (e_location AS l) ON ( e.l_id = l.l_id ) HAVING s RLIKE '$regex_search'
function eventSearch($regex_search = "", $dist = -1, $user_lat = 0, $user_lon = 0, $dateorder = TRUE, $futureEventsOnly = TRUE)
{

	$sql = getSQL(FALSE);
	$query = "SELECT e.e_id, CONCAT( e.e_name, ' ', e.e_descrip, ' ', l.l_name, ' ', l.l_address) AS search, 
	( 3959 * acos( cos( radians($user_lat) ) * cos( radians( l.l_lat ) ) * cos( radians( l.l_lng ) - radians($user_lon) ) + sin( radians($user_lat) ) * sin( radians( l.l_lat ) ) ) ) AS distance
	FROM (e_events AS e) LEFT JOIN (e_location AS l) ON ( e.l_id = l.l_id )
	WHERE (e_private=0)";
	if($futureEventsOnly)
	{
		$query .= " AND (e.e_date >= CURDATE())";
	}
	if(!empty($regex_search))
	{
		$query .= " HAVING (search RLIKE '$regex_search')";
	}
	
	if($dist >= 0)
	{
		if(empty($regex_search))
		{
			$query .= " HAVING";
		}
		else
		{
			$query .= " AND";
		}
		$query .= " (distance < $dist)";
	}
	
	if($dateorder)
	{
		$query .= " ORDER BY e.e_date";
	}
	else
	{
		$query .= " ORDER BY distance";
	}
	
	
	//print $query . "\n";
	
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
	$results = array();
	while($row = mysqli_fetch_assoc($res))
	{
		$r = array('id' => $row["e_id"], 'distance' => $row["distance"]);
		$results[] = $r;
	}
	
	return $results;

}


//RSVP functions

/*
RSVP:
0 = Not Going
1 = Maybe
2 = Going
*/
function addRSVP($UID, $EID, $rsvp)
{
	$UID = sanitize($UID);
	$EID = sanitize($EID);
	$rsvp = sanitize($rsvp);

	$sql = getSQL(TRUE);
	$query = "INSERT INTO e_rsvp (u_id, e_id, rsvp) VALUES ('$UID','$EID','$rsvp')";

	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;

	$id = mysqli_insert_id($sql);

	return $id;
}

function getUserRSVP($UID, $EID){
	$UID = sanitize($UID);
	$EID = sanitize($EID);

	$sql = getSQL(TRUE);

	$query = "SELECT rsvp FROM e_rsvp WHERE (u_id='$UID' AND e_id='$EID')";

	$res = sqlQuery($sql,$query);

	if($res === -2) 
		return -2;

	$rsvp = $res->fetch_assoc();

	if($rsvp)
	{
		return $rsvp['rsvp'];
	}
	else
	{
		return -2;
	}

}

function changeRSVP($UID, $EID, $rsvp)
{
	$UID = sanitize($UID);
	$EID = sanitize($EID);
	$rsvp = sanitize($rsvp);

	$sql = getSQL(TRUE);
	$query = "UPDATE e_rsvp SET rsvp='$rsvp' WHERE (u_id='$UID' AND e_id='$EID')";

	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
}

function getUsersByRSVP($EID, $rsvp)
{
	$EID = sanitize($EID);
	$rsvp = sanitize($rsvp);

	$sql = getSQL(FALSE);
	$query = "SELECT u_id FROM e_rsvp WHERE (e_id='$EID' AND rsvp='$rsvp')";
	
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
	$users = array();
	while($row = mysqli_fetch_assoc($res))
	{
		$users[] = $row["u_id"];
	}
	
	return $users;
}

function getUserRSVPs($UID, $ignoreNotGoing=TRUE, $futureEventsOnly = TRUE)
{
	$UID = sanitize($UID);
	
	$sql = getSQL(FALSE);
	$query = "SELECT r.e_id AS id, r.rsvp AS rsvp FROM e_rsvp AS r LEFT JOIN e_events AS e ON (r.e_id = e.e_id)  WHERE r.u_id='$UID'";
	if($ignoreNotGoing)
	{
		$query .= " AND rsvp>0";
	}
		if($futureEventsOnly)
	{
		$query .= " AND (e.e_date >= CURDATE())";
	}
	$query .= " ORDER BY e.e_date";
	
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
	$rsvps = array();
	while($row = mysqli_fetch_assoc($res))
	{
		
		$rsvps[] = $row;
		
	}
	
	return $rsvps;
	
}

//Invite
function sendInvite($UIDSender, $UIDRecieve, $EID, $msg="")
{
	$m = sanitize($msg);
	$UIDs = sanitize($UIDSender);
	$UIDr = sanitize($UIDRecieve);
	$EID = sanitize($EID);
	
	$sql = getSQL(TRUE);
	
	$query = "INSERT INTO e_inv (e_id, u_inv_id, u_gu_id, i_cmt) VALUES ('$EID', '$UIDs', '$UIDr', '$m')";
	
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
}
function getInvites($UID)
{
	$sql = getSQL(FALSE);
	$UID = sanitize($UID);
	
	$query = "SELECT i_id FROM e_inv WHERE u_gu_id = '$UID'";
	
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
	$invis = array();
	while($row = mysqli_fetch_assoc($res))
	{
		$invis[] = $row["i_id"];
	}
	return $invis;
}
function getInviteCard($IID)
{
	$sql = getSQL(FALSE);
	$IID = sanitize($IID);
	
	$query = "SELECT i.u_gu_id AS GuestID, u.u_name AS Inviter, i.u_inv_id AS InviterID, e.e_name AS Event, e.e_id AS EventID, i.i_cmt AS Message 
			FROM e_inv AS i
			LEFT JOIN e_users AS u ON (i.u_inv_id = u.u_id)
			LEFT JOIN e_events AS e ON (i.e_id = e.e_id)
			WHERE i.i_id = '$IID'";
			
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
	$row = $res->fetch_assoc();
	
	if($row)
	{
		return $row;
	}
	else
	{
		return -1;
	}
	
	
} 

function acceptInvite($IID)
{

	return 	processInvite($IID,TRUE);
}

function rejectInvite($IID)
{
	return 	processInvite($IID,FALSE);	
}

function processInvite($IID, $accept)
{
	$sql = getSQL(TRUE);
	$IID = sanitize($IID);
	//Get info from invite
	$query = "SELECT u_gu_id AS uid, e_id AS eid FROM e_inv WHERE i_id = '$IID'";
	
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
	$row = $res->fetch_assoc();
	
	if($row)
	{
		$EID = $row["eid"];
		$UID = $row["uid"];
	}
	else
	{
		return -1;
	}
	//Add info to RSVP
	$query = "INSERT INTO e_rsvp (e_id, u_id, rsvp) VALUES ('$EID', '$UID',";
	if($accept)
	{
		$query .= "2)";
	}
	else
	{
		$query .= "0)";
	}
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
	//Delete that invite
	$query = "DELETE FROM e_inv WHERE i_id='$IID'";
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
}
//Following

function followUser($UID, $UIDtoFollow)
{
	$UID = sanitize($UID);
	$UID2 = sanitize($UIDtoFollow);
	$sql = getSQL(TRUE);
	$query = "INSERT INTO e_follow (u_head_id, u_tail_id) VALUES ('$UID','$UID2')";
	
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
}
function unfollowUser($UID, $UIDtoUnfollow)
{
	$UID = sanitize($UID);
	$UID2 = sanitize($UIDtoUnfollow);
	$sql = getSQL(TRUE);
	$query = "DELETE FROM e_follow WHERE u_head_id = '$UID' AND u_tail_id = '$UID2'";
	
		$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
}
function isFollowed($UID, $UIDtoCheck)
{
	$UID = sanitize($UID);
	$UID2 = sanitize($UIDtoCheck);
	$sql = getSQL(FALSE);
	$query = "SELECT * FROM e_follow WHERE u_head_id = '$UID' AND u_tail_id = '$UID2'";
	
		$res = sqlQuery($sql,$query);
	if($res === -2) return FALSE;
	
	$row = $res->fetch_assoc();
	
	if($row)
	{
		return TRUE;
	}
	return FALSE;
	
}
function getFollows($UID)
{
	$sql = getSQL(FALSE);
	$UID = sanitize($UID);
	$query = "SELECT u_tail_id AS id FROM e_follow WHERE u_head_id = '$UID'";
	
		$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
	$users = array();
	while($row = mysqli_fetch_assoc($res))
	{
		$users[] = $row["id"];
	}
	
	return $users;	
	
}

?>