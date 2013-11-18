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
	//Escapes % and _
	$input = addcslashes($input, '%_');
	
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
	if(isset($_SESSION["sql_error"]))
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
function setUserField($UID, $field, $data)
{
	$sql = getSQL(TRUE);
	$data = sanitize($data);
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
	setUserField($UID, "l_id", $data);
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
			logout();
			return -2;
		
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
	$_SESSION['auth_time'] = date("Y-m-d H:i:s");
	
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


//Event functions

function addEvent($UID, $evName, $evLocName, $evLocAddr, $evDateTime, $evDescrip, $evPrivate)
{
	$pf = 0;  //Privacy flag
	if($evPrivate)
	{
		$pf = 1;
	}
	$sql = getSQL(TRUE);
	
	//$sqldate = date( 'Y-m-d H:i:s', $evDateTime );
	$sqldate = $evDateTime;
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

function getEventsByUser($UID)
{
	$sql = getSQL(FALSE);
	$UID = sanitize($UID);
	$query = "SELECT e_id FROM e_events WHERE u_id='$UID'";
	$res = sqlQuery($sql, $query);
	if($res === -2) return -2;
	
	$events = array();
	while($row = mysqli_fetch_assoc($res))
	{
		$events[] = $row["e_id"];
	}
	
	return $events;
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
		//Default for testing.  Change to error.
		$lat = 123.4;
		$lng = 567.8;
   }
   else
   {
		$location = $response['results'][0]['geometry']['location'];
		$lat = $location['lat'];
		$lng = $location['lng'];
   }
   
   $sql = getSQL(TRUE);
   
   $query = "INSERT INTO e_location (l_name, l_address, l_lat, l_lng) VALUES ('$lname','$laddr','$lat','$lng')";
   
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

function getUserRSVPs($UID, $ignoreNotGoing=TRUE)
{
	$UID = sanitize($UID);
	
	$sql = getSQL(FALSE);
	$query = "SELECT e_id, rsvp FROM e_rsvp WHERE u_id='$UID'";
	if($ignoreNotGoing)
	{
		$query .= " AND rsvp>0";
	}
	
	$res = sqlQuery($sql,$query);
	if($res === -2) return -2;
	
	$rsvps = array();
	while($row = mysqli_fetch_assoc($res))
	{
		$new = array();
		$new["id"] = $row["e_id"];
		$new["rsvp"] = $row["rsvp"];
		/*
		if($row["rsvp"] == 0)
		{
			$new["rsvp"]
		}
		else if($row["rsvp"] == 1)
		{
		
		}
		else
		{
		
		}
		*/
		$rsvps[] = $new; 
	}
	
	return $rsvps;
	
}

?>