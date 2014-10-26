<?php

function matchPersentage($set1,$seet2)
{
	$srr1 = explode(",", $set1);
	$srr2 = explode("," ,$seet2);

	$score=0;
	$totalScore = (count($srr1)+count($srr2))/2;

	foreach ($srr1 as $key ) {
		foreach ($srr2 as $key1) {
			if($key1 == $key)
			{
				$score+=1;
			}
		}
	}

	return ($score/$totalScore)*100;
}




	$con=mysqli_connect("localhost","root","","markslist");
	
	if (mysqli_connect_errno()) {
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}



function getCityOfUser($username)
{
	global $con ;

	$theCityNames = mysqli_query($con,"SELECT destination FROM events where username = '".$username."'");

	$row = mysqli_fetch_array($theCityNames);

	return($row['destination']);

}


function getDateOfUser($username)
{
	global $con ;

	$theCityNames = mysqli_query($con,"SELECT date FROM events where username = '".$username."'");

	$row = mysqli_fetch_array($theCityNames);

	return($row['date']);

}


function computeGroups()
{
	global $arrayOfPeople;
	global $arrayOfGroups;

	$tmpArrayOfPeople=[];
	
	$tempGroup=[];
	while (count($arrayOfPeople)>0) {
		for($i=1;$i<count($arrayOfPeople);$i++)
		{

			if(matchPersentage($arrayOfPeople[0][1],$arrayOfPeople[$i][1])>50 && 
				getCityOfUser($arrayOfPeople[0][0])== getCityOfUser($arrayOfPeople[$i][0]) &&
				getDateOfUser($arrayOfPeople[0][0])== getDateOfUser($arrayOfPeople[$i][0])
				  )
			{
				array_push($tempGroup,$arrayOfPeople[$i]);
				 

			}
			else
			{
				array_push($tmpArrayOfPeople,$arrayOfPeople[$i]);
			}
		}
		array_push($tempGroup,$arrayOfPeople[0]);

		$arrayOfPeople = $tmpArrayOfPeople;
		$tmpArrayOfPeople = [];
		//print_r($arrayOfPeople);

		array_push($arrayOfGroups,$tempGroup);
		$tempGroup=[];
	} 

		// foreach ($arrayOfGroups as $xx ) {
		 	
		// 		print_r($xx);
		// 		echo "<br><br>";
		// }
}

// echo getCityOfUser("divamgupta");
 

?>