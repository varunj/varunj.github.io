<?php

// include 'foresquareapi.php';

// $foursquare = new FoursquareAPI("TOTFFFUHNPRKODY4DSVF2G0HKOIUQACNTJZN44DLBRLPXS01", "DEHP3XKIWNRZ3AM4AFEDMBMFIBK0NUXOVYROBA1EOVUGF5AF");

// // Searching for venues nearby Montreal, Quebec
// $endpoint = "bar";

// // Prepare parameters
// $params = array("near"=>"new delhi");

// // Perform a request to a public resource
// $response = $foursquare->GetPublic($endpoint,$params);

// // Returns a list of Venues
// // $POST defaults to false
// $venues = $foursquare->GetPublic($endpoint ,$params, $POST=false);

// print_r ($venues);

include 'matchtags.php';

$arrOfRes = ["restaurant","pizza","donut","burger","cafe"];
session_start();
$username = $_SESSION['fbid'];
for($j=0;$j<5;$j++)
{


$i=0;
$serachQuery = $arrOfRes[$j];

$locationCity = getCityOfUser($username);

// echo $serachQuery;
 
$toBeDecoded = file_get_contents("https://api.foursquare.com/v2/venues/search?limit=5&v=20130815&client_id=TOTFFFUHNPRKODY4DSVF2G0HKOIUQACNTJZN44DLBRLPXS01&client_secret=DEHP3XKIWNRZ3AM4AFEDMBMFIBK0NUXOVYROBA1EOVUGF5AF&near=" .$locationCity."&query=".$serachQuery );
$toBeDecoded = json_decode($toBeDecoded);


		
		$id = $toBeDecoded->response->venues[$i]->id;
		$ven_name   = $toBeDecoded->response->venues[$i]->name;

		// $ven_phono  = $toBeDecoded->response->venues[0]->contact->phone;


		$long =  $toBeDecoded->response->venues[$i]->location->lng;
		$lat =  $toBeDecoded->response->venues[$i]->location->lat;

		$ven_address = "";

		foreach ( ($toBeDecoded->response->venues[$i]->location->formattedAddress) as $key) {
			$ven_address .= $key." ";
		}


		echo "<div style='background:rgba(0,0,0,0.5); width:400px; height:300px; border-radius:15px;'>";
		echo "<h2 style='text-transform:uppercase; color:#CFDDEB;'>".$ven_name."</h2><hr>";
		echo "<h4>".$ven_address."</h4>";
		// echo "<h3>".$toBeDecoded->response->venues[0]->location->postalCode."</h3>";

		if(isset($toBeDecoded->response->venues[$i]->contact->phone))
		{
			$n = $toBeDecoded->response->venues[$i]->contact->phone;
			echo "<h3>".$n."</h3>";
		}
		echo "</echo>";
}


 // print_r($toBeDecoded);


?>