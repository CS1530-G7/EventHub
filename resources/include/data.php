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

//User functions


function createUser($username, $password, $email)
{
	$sql = getSQL(TRUE);
	
	$user = sanitize($username);
	$pass = salthash($password);
	$email = sanitize($email);
	$act_code = salthash($email);
	
	$query = "INSERT INTO e_users (u_activecode, u_name, u_email, u_pass) VALUES ('$act_code','$user','$email','$pass')";
	
	mysqli_query($sql,$query) or die(mysqli_error($sql) . ": " .  $query);
	
	
	$id = mysqli_insert_id($sql);
	
	return $id;

}

function getActiveUser()
{
	//There should already be a session but check first
	startSession();
	
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
	//There should already be a session but check first
	startSession();
	
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
	startSession();
	
	$sql = getSQL(FALSE);
	
	$user = sanitize($username);
	$pass = salthash($password);
	
	$query = "SELECT u_id FROM e_users WHERE u_name='$user' AND u_pass='$pass'";
	
	$res = mysqli_query($sql,$query) or die(mysqli_error($sql) . ": " .  $query);
	
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
	mysqli_query($sql,$query) or die(mysqli_error($sql) . ": " .  $query);
}

//User SQL wrappers

function getUserID($username)
{

	$sql = getSQL(FALSE);
	
	$query = "SELECT u_id FROM e_users WHERE u_name LIKE '%$username%'";
	
	$res = mysqli_query($sql,$query) or die(mysqli_error($sql) . ": " .  $query);
	
			
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

function getUsername($UID)
{
	$sql = getSQL(FALSE);
	
	$query = "SELECT u_name FROM e_users WHERE u_id = '$UID'";
	
	$res = mysqli_query($sql,$query) or die(mysqli_error($sql) . ": " .  $query);
	
	$row = $res->fetch_assoc();
	
	if($row)
	{
		return $row["u_name"];
	}
	else
	{
		return -1;
	}
}

function getUserStatus($UID)
{
	$sql = getSQL(FALSE);
	
	$query = "SELECT u_status FROM e_users WHERE u_id = '$UID'";
	
	$res = mysqli_query($sql,$query) or die(mysqli_error($sql) . ": " .  $query);
	
	$row = $res->fetch_assoc();
	
	if($row)
	{
		return $row["u_status"];
	}
	else
	{
		return -1;
	}
}

function getActivationCode($UID)
{
	$sql = getSQL(FALSE);
	
	$query = "SELECT u_activecode FROM e_users WHERE u_id = '$UID'";
	
	$res = mysqli_query($sql,$query) or die(mysqli_error($sql) . ": " .  $query);
	
	$row = $res->fetch_assoc();
	
	if($row)
	{
		return $row["u_activecode"];
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
	$evName = sanitize($evName);
	$evLocation = sanitize($evLocName);
	$evAddr = sanitize($evLocArrd);
	$evDescrip = sanitize($evDescrip);
	
	$lid = newLocation($evLocation, $evLocAddr);
	
	$query = "INSERT INTO e_events (e_name, e_date, e_descrip, e_private, u_id, l_id) VALUES ('$evName','$sqldate','$evDescrip',$pf,$UID,$lid)";
	
	$res = mysqli_query($sql,$query) or die(mysqli_error($sql) . ": " .  $query);
	
	$id = mysqli_insert_id($sql);
	
	return $id;
	
	
}

//Location function
function newLocation($loc_name, $loc_address)
{

	$lname = sanitize($loc_name);
	$laddr = sanitize($loc_address);
	$addr_url = urlencode($laddr);
	
	$geocode_url = "https://maps.googleapis.com/maps/api/geocode/" . "json" . "?" . "?address=" . $addr_url . "&sensor=" . "false";
	
	$ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $geocode_url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $response = json_decode(curl_exec($ch), true);
 
   // If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
   if ($response['status'] != 'OK') 
   {
		//Default to 0, 0 for testing.  Change to error.
		$lat = 0;
		$lng = 0;
   }
   else
   {
		$location = $response['results'][0]['geometry']['location'];
		$lat = $location['lat'];
		$lng = $location['lng'];
   }
   
   $sql = getSQL(TRUE);
   
   $query = "INSERT INTO e_location (l_name, l_address, l_lat, l_lng) VALUES ('$lname','$laddr','$lat','$lng')";
   
   $res = mysqli_query($sql,$query) or die(mysqli_error($sql) . ": " .  $query);
	
	$id = mysqli_insert_id($sql);
	
	return $id;
   
}
?>