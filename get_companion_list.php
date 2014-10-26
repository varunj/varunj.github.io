<?php
	$con=mysqli_connect("localhost","root","","markslist");
	
	if (mysqli_connect_errno()) {
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	session_start();

 
	function getGroupCode($username)
	{
		global $con ;

		$groupCode = mysqli_query($con,"SELECT foresquareQuery FROM venues where username = '".$username."'");

		$row = mysqli_fetch_array($groupCode);

		return($row['foresquareQuery']);

	}
		 
	$username = $_SESSION['fbid'];

	$grpCode = getGroupCode($username);

	$result = mysqli_query($con,"SELECT username FROM venues where foresquareQuery='".$grpCode."'");

	while($row = mysqli_fetch_array($result)) {
		  echo  $row['username'] ;
		  echo "<br>";
		  
		}

?>