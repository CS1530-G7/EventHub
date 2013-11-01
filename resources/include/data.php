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
		$text = $salt + $text + $salt;
		return sha1($text);
	
}
?>