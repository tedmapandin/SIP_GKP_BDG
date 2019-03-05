<?
error_reporting(E_ALL); 
ini_set('display_errors', TRUE); 
ini_set('display_startup_errors', TRUE); 


function insert($a,$b)
{
	$query ="INSERT INTO data(a,b)VALUES('$a','$b')";
	return "data berhasil disimpan";
}

function msg($text)
{
	return $text;
}
?>