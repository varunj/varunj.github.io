<?php
	 
	$con=mysqli_connect("localhost","root","","markslist");
	
	// require("db_config.php")
	if (mysqli_connect_errno()) {
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	 

	function runSQLQuery($query)
	{
		global $con;
		if (mysqli_query($con,$query)) {
		   
		} else {
		  echo "<- Error: " . mysqli_error($con)."->";
		}
	}

	 



	function addTags($username,$tags)
	{
		
	 
 
		runSQLQuery("

				insert into intrests
				values ('".$username."','". $tags  . "'  )

			");

	}

	function updateTags($username,$tags)
	{
		runSQLQuery("
					UPDATE intrests 
					SET 
					 tags='".$tags ."'
					 WHERE username = '" . $username  ."'


			");
	}


	function setUpDB()
	{
		runSQLQuery("create database markslist");
		runSQLQuery("
			create table if not exists intrests(
					username char(30),
					tags blob

				)

			");


	

	}
?>