<?php

	include 'matchtags.php';



	$con=mysqli_connect("localhost","superadmin","VG9fDzy2B4JwKNbT","markslist");
	
	if (mysqli_connect_errno()) {
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}


	// global varibles
		$arrayOfPeople=[["divam","arduino,coding,hello"],
		["param","aaaa,aaa,hello"],
		["praa","aaaa,aaa,gggg"],
		["varr","aaaa,aaa,hello"],
		["helloooo","bbbb,bb,gggg"],
		["hahahahha","bbbb,bb,hello"]];

		$arrayOfGroups = [];

	 

	function runSQLQuery($query)
	{
		global $con;
		if (mysqli_query($con,$query)) {
		   
		} else {
		  echo "<- Error: " . mysqli_error($con)."->";
		}
	}



	function setUpDB()
	{
		//runSQLQuery("create database markslist");
		runSQLQuery("
			create table if not exists events(
					username char(30),
					tags blob,
					destination char(50),
					date date

				)

			");

		runSQLQuery("
			create table if not exists venues(
					username char(30),					 
					foresquareQuery char(50)

				)

			");
	}


	function getSameDesUsers()
	{
		global $con ;

		$arrOfusers = [];

		$result = mysqli_query($con,"SELECT * FROM intrests");

		

		// $arrCitynames = [];

		// while($row = mysqli_fetch_array($theCityNames)) {
		//   array_push($arrCitynames,  $row['destination']   );
		  
		// }

		while($row = mysqli_fetch_array($result)) {
		  array_push($arrOfusers,  [ $row['username'] ,  $row['tags'] ]  );
		  
		}

		global $arrayOfPeople;
		global $arrayOfGroups;
		$arrayOfPeople = $arrOfusers;

		computeGroups();

		// print_r($arrayOfGroups);
		
		runSQLQuery(" TRUNCATE TABLE venues; "); 

		foreach ($arrayOfGroups as $key) {
			$sq = rand(1,190);
			foreach ($key as $k) {
				$user = $k[0];
				
				runSQLQuery("insert into venues values  ('"  .$user."' , '".$sq.  "'  ) ");
			}
		}

	}
	// setUpDB();
?>