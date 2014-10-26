<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');    // DB username
define('DB_PASSWORD', '');    // DB password
define('DB_DATABASE', 'planerr');      // DB name
$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die( "Unable to connect");
$database = mysql_select_db(DB_DATABASE) or die( "Unable to select database");

$firstlogin = 1;
function checkuser($fuid,$funame,$ffname,$femail){
		$check = mysql_query("select * from Users where Fuid='$fuid'");
		$check = mysql_num_rows($check);

		if (empty($check)) { // if new user . Insert a new record		
			$query = "INSERT INTO Users (Fuid,Funame,Ffname,Femail) VALUES ('$fuid','$funame','$ffname','$femail')";
			mysql_query($query) or die(mysql_error());	
			global $firstlogin;
			$firstlogin = 0;
		} else {   // If Returned user . update the user record		
			$query = "UPDATE Users SET Funame='$funame', Ffname='$ffname', Femail='$femail' where Fuid='$fuid'";
			mysql_query($query) or die(mysql_error());
		}
	}
?>