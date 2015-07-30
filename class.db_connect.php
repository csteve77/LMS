<?php


function dbconnect(){//a function that is used to create a database connection by creating a PDO object
	try{
		$dbcon = new PDO("mysql:host=localhost;dbname=lms","root","");
		$dbcon -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
	} catch(Exception $e){
		echo"Could not connect";
		echo $e;
	}
	return $dbcon;
}


function dbout($connection){
	$connection=null;
}
