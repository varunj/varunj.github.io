<?php

include 'dbconnect.php';
include 'trips.php';
session_start();
if(isset($_SESSION['fbid']))
{
	$username = $_SESSION['fbid'];
	if(isset($_GET['v']))
	{
		 addTags($username,$_GET['v']);
	 	 getSameDesUsers();

	}

}
else
{
	echo "unauthorised access";
}


?>