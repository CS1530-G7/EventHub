<?php
require_once("pw.php");

function sanitize($input)
{
	//Remove semicolons
	$input = str_replace(";","",$input);
	//Escapes harmful characters
	$input = mysqli_real_escape_string($input);
	
	return $input;
}
?>