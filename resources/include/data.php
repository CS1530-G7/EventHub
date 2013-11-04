<?php
require_once("pw.php");

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

function createUser($username, $password, $email)
{
	$sql = getSQL(TRUE);
	
	$user = sanitize($username);
	$pass = salthash($password);
	$email = sanitize($email);
	$act_code = salthash($email);
	
	$query = "INSERT INTO e_users (u_activecode, u_name, u_email, u_pass) VALUES ('$act_code','$user','$email','$pass')";
	
	mysqli_query($sql,$query) or die(mysqli_error($sql) . ": " .  $query);
	
	return getUserID($user);

}

function getUserID($username)
{

	$sql = getSQL(FALSE);
	
	$query = "SELECT u_id FROM e_users WHERE u_name = '$user'";
	
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