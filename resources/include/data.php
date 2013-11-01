<?php
require_once("pw.php");



function sanitize($input)
{
	//Remove semicolons
	$input = str_replace(";","",$input);
	//Escapes harmful characters
	$input = mysqli_real_escape_string($input);
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
	$act_code = satlhash($email);
	
	$query = "INSERT INTO e_users (u_activecode, u_name, u_email, u_pass) VALUES ('$act_code','$user','$email','$pass')";
	
	mysqli_query($sql,$query) or die(mysqli_error($sql) . ": " .  $query);
	
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
?>