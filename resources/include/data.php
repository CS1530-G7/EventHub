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
	$r = mysqli_query($sql,$query);
	if($r)
	{
		return $r;
	}
	else
	{
		$_SESSION["sql_error"] = mysqli_error($sql);
		return FALSE;
	}
}

function sqlError()
{
	if(isset($_SESSION["sql_error"]))
	{
		return $_SESSION["sql_error"];
	}
	else
	{
		return 0;
	}

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
	if($res == -1) return -1;
	
	
	$id = mysqli_insert_id($sql);
	
	return $id;

}

function getActiveUser()
{

	
	if(isset($_SESSION["auth_userid"]))
	{
		return $_SESSION["auth_userid"];
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
	if($res == -1) return -1;
	
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

function deleteUser($uid)
{
	$sql = getSQL(TRUE);
	$query = "DELETE FROM e_users WHERE u_id='$uid'";
	$res = sqlQuery($sql,$query);
	if($res == -1) return -1;
}

//User SQL wrappers

function getUserID($username)
{

	$sql = getSQL(FALSE);
	
	$query = "SELECT u_id FROM e_users WHERE u_name LIKE '%$username%'";
	
		$res = sqlQuery($sql,$query);
	if($res == -1) return -1;
	
			
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

function getUserField($uid, $field)
{
	$sql = getSQL(FALSE);
	
	$query = "SELECT '$field' FROM e_users WHERE u_id = '$UID'";
	
	$res = sqlQuery($sql,$query);
	if($res == -1) return -1;
	
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
function setUserField($uid, $field, $data)
{
	$sql = getSQL(TRUE);
	$data = sanitize($data);
	$query = "UPDATE e_users SET '$field'='$data' WHERE u_id = '$UID'";
	
	$res = sqlQuery($sql,$query);
	if($res == -1) return -1;
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
function setLocID($UID, $data)
{
	setUserField($UID, "l_id", $data);
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
	$evName = sanitize($evName);
	$evLocation = sanitize($evLocName);
	$evAddr = sanitize($evLocArrd);
	$evDescrip = sanitize($evDescrip);
	
	$lid = newLocation($evLocation, $evLocAddr);
	
	$query = "INSERT INTO e_events (e_name, e_date, e_descrip, e_private, u_id, l_id) VALUES ('$evName','$sqldate','$evDescrip',$pf,$UID,$lid)";
	
		$res = sqlQuery($sql,$query);
	if($res == -1) return -1;
	
	$id = mysqli_insert_id($sql);
	
	return $id;
	
	
}

//Location function
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
	if($res == -1) return -1;
	
	$id = mysqli_insert_id($sql);
	
	return $id;
   
}
?>