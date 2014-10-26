<?php
	include 'dbconnect.php';

	session_start();
	$username = $_SESSION['fbid'];
	$destination = $_GET['destination'];
	$date = $_GET['date'];
	// runSQLQuery("
			
	// 	");
	if(mysqli_query($con,"insert into events
			values ( '".$username."', '',  '".$destination ." ','".$date."'  )"))
	{
		echo "success";
	}
	else
	{
		echo "error";
	}


?>