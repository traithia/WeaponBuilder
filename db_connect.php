<?PHP
	
	$db_conn = new mysqli('localhost','username','password','phatWeapons') 
		or die ('There was a problem connecting to the database. the following error was returned: '.mysqli_connect_error());

?>