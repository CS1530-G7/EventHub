<?php

require_once("pw.php");

//Generic functions

function startSession()
{
	if (session_status() !== PHP_SESSION_ACTIVE) 
	{
		session_start();
	}
}

function endSession()
{
	if (session_status() === PHP_SESSION_ACTIVE) 
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
	
	$query = "SELECT u_id FROM e_users WHERE u_name LIKE '%$user%' AND u_pass = '$pass'";
	
	mysqli_query($sql,$query) or die(mysqli_error($sql) . ": " .  $query);
	
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

function getLocationName($UID)
{
	$sql = getSQL(FALSE);
	
	$query = "SELECT u_loc_name FROM e_users WHERE u_id = '$UID'";
	
	$res = mysqli_query($sql,$query) or die(mysqli_error($sql) . ": " .  $query);
	
	$row = $res->fetch_assoc();
	
	if($row)
	{
		return $row["u_loc_name"];
	}
	else
	{
		return -1;
	}
}

function getLocationLatlong($UID)
{
	$sql = getSQL(FALSE);
	
	$query = "SELECT u_loc_latlon FROM e_users WHERE u_id = '$UID'";
	
	$res = mysqli_query($sql,$query) or die(mysqli_error($sql) . ": " .  $query);
	
	$row = $res->fetch_assoc();
	
	if($row)
	{
		return $row["u_loc_latlon"];
	}
	else
	{
		return -1;
	}
}

//Event functions

function addEvent($UID, $evName, $evLocation, $evDateTime, $evDescrip, $evPrivate)
{
	$pf = 0;  //Privacy flag
	if($evPrivate)
	{
		$pf = 1;
	}
	$sql = getSQL(TRUE);
	
	$sqldate = date( 'Y-m-d H:i:s', $evDateTime );
	$evName = sanitize($evName);
	$evLocation = sanitize($evLocation);
	$evDescrip = sanitize($evDescrip);
	
	//TODO: Get location co-ords via google maps API
	
	$query = "INSERT INTO e_events (e_name, e_date, e_loc_name, e_descrip, e_private, u_id) VALUES ('$evName','$sqldate','$evLocation','$evDescrip',$pf,$UID)";
	
	$res = mysqli_query($sql,$query) or die(mysqli_error($sql) . ": " .  $query);
	
	$id = mysqli_insert_id($sql);
	
	return $id;
	
	
}
?>