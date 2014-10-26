<?php

error_reporting(0);
session_start();

require_once('Facebook/FacebookSession.php');
require_once('Facebook/FacebookRedirectLoginHelper.php');
require_once('Facebook/FacebookRequest.php');
require_once('Facebook/FacebookResponse.php');
require_once('Facebook/FacebookSDKException.php');
require_once('Facebook/FacebookRequestException.php');
require_once('Facebook/FacebookAuthorizationException.php');
require_once('Facebook/GraphObject.php');
require_once('Facebook/GraphUser.php');
require_once('Facebook/GraphSessionInfo.php');
require_once('Facebook/FacebookJavaScriptLoginHelper.php');

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphUser;
use Facebook\GraphSessionInfo;
use Facebook\FacebookJavaScriptLoginHelper;


$id = '680714418681220';
$secret = '2a1ef7a3bcb3993a495ae912df5ee6ff';



FacebookSession::setDefaultApplication($id, $secret);

// $helper = new FacebookRedirectLoginHelper('http://localhost/proj');
$helper = new FacebookJavaScriptLoginHelper();

try {
    $session = $helper->getSession();    
}
catch (Exception $e) {
    
}

if (isset($_SESSION['token'])) {
    
    $session = new FacebookSession($_SESSION['token']);
    
    try {
        
        $session->Validate($id, $secret);
        
    }
    catch (FacebookAuthorizationException $e) {
        
        $session = '';
        
    }
    
}

//under this if condition lies the success login wala code

if (isset($session)) {
    
    $_SESSION['token'] = $session->getToken();
    require('db_config.php');
    // $logouturl = $helper->getLogoutUrl();    
    $request = new FacebookRequest($session, 'GET', '/me');
    
    $response = $request->execute();
    
    $graph = $response->getGraphObject(GraphUser::className());

    $userDetail = $graph->asArray();
    $fbid = $userDetail['id'];
    $_SESSION['fbid'] = $fbid;
    $fbfullname = $userDetail['name'];
    $fbfname = $userDetail['first_name'];
    $femail = $userDetail['email'];

?>
<!DOCTYPE html>
<html>
<head>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/jqueryui.js"></script>
<script src="js/script.js"></script>
<link rel="stylesheet" href="css/date.css"/>

<link rel="stylesheet" href="CSS/bootstrap.css">


<script src="js/bootstrap.js"></script>
<link rel="stylesheet" href="CSS/morris.css">
<link rel="stylesheet" href="CSS/jquery-ui.css">

<script>

</script>
</head>
<body>
    
    <div class="navbar navbar-inverse navbar-fixed-top" style="max-height:50px;" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Hola <?php echo $fbfullname; ?>!</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a  id="interestbutton" href="#">Intrests</a></li>
                    <li class="active"><a href="index.htm">Sign Out </a></li>
                </ul>
            </div>  
        </div>
    </div>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Enter Interest</h4>
              </div>
              <div class="modal-body">
                  <div class="bootbox-body">
                    <form class="bootbox-form">
                        <input id="interesttext" class="bootbox-input bootbox-input-text form-control" autocomplete="on" type="text">
                    </form>
                  </div>

              </div>
              <div class="modal-footer">
                <button type="button" id="appendbutton" class="btn btn-primary">Save!</button>
                <br>
              </div>
            </div>
          </div>
        </div>
    <?php

    checkuser($fbid, $fbfullname, $fbfname, $femail); // To update local DB
    echo $fbid;
    ?>
  
  <div id="asdasd">
  <div class="row" style=" margin:0px;margin-top:100px;">
  <div class="col-lg-6">
          <p>Enter Date of Journey: <input type="text" id="datepicker"></p>
  </div>

  </div>
  <div id="mapCanvas" style="margin:0px;width:100%; height:400px;"></div>
  <div class="row" style="background: rgba(0,0,0,0.5);width: 100%; margin:0; padding:10px;">
    <div class="col-lg-6">
        <h3>Current position:</h3>
        <div id="info"></div>
    </div>
    <div class="col-lg-6">
        <h3>State:</h3>
        <div id="address"></div>
    </div>
  </div>
  <div class="row" style="margin:0px;">
            <center><button class="btn btn-default" type="button" id = "gobutton" style="font-weight: 300;
width: 200px;
height: 70px;
font-size: 31px;
text-transform: uppercase;
margin-top: 20px;">Go!</button></center>
  </div>
</div>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
var geocoder = new google.maps.Geocoder();

function geocodePosition(pos) {
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
      // console.log(responses[0].address_components);
      var temp = responses[0].address_components;
      for(var i=0;i<temp.length;i++)
      {
        if(responses[0].address_components[i].types[0]=='administrative_area_level_1')
        {
          // updateMarkerAddress
          updateMarkerAddress(responses[0].address_components[i].long_name);
          break;
        }
      }
      // updateMarkerAddress(responses[0].formatted_address);
    } else {
      updateMarkerAddress('Cannot determine address at this location.');
    }
  });
}


function updateMarkerPosition(latLng) {
  document.getElementById('info').innerHTML = [
    latLng.lat(),
    latLng.lng()
  ].join(', ');
}

function updateMarkerAddress(str) {
  document.getElementById('address').innerHTML = str;
}

function initialize() {
  var latLng = new google.maps.LatLng(28.61432, 77.23233);
  var map = new google.maps.Map(document.getElementById('mapCanvas'), {
    zoom: 8,
    center: latLng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  var marker = new google.maps.Marker({
    position: latLng,
    title: 'Choose your point',
    map: map,
    draggable: true
  });
  
  // Update current position info.
  updateMarkerPosition(latLng);
  geocodePosition(latLng);
  
  // Add dragging event listeners.
  google.maps.event.addListener(marker, 'dragstart', function() {
    updateMarkerAddress('Dragging...');
  });
  
  google.maps.event.addListener(marker, 'drag', function() {
    updateMarkerPosition(marker.getPosition());
  });
  
  google.maps.event.addListener(marker, 'dragend', function() {
    geocodePosition(marker.getPosition());
  });
}

// Onload handler to fire off the app.
google.maps.event.addDomListener(window, 'load', initialize);
</script>

    <?php

  if($firslogin==0)
  {
    $request2 = new FacebookRequest($session, 'GET', '/me/likes?limit=50 ');
      $response2 = $request2->execute();
      $graphObject = $response2->getGraphObject();

      $userLikes = $graphObject->asArray();
      $userLikes = $userLikes['data'];
      foreach ($userLikes as $key => $object) {
        $fblist = $fblist. $object->name . ",";
    }
    // echo $fblist;
    // echo $fbid;
    $db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_DATABASE.';charset=utf8', DB_USERNAME, DB_PASSWORD);
    $stmt = $db->prepare("INSERT INTO interests (Fuid,Fblikes) VALUES(:field1,:field2)");
    $stmt->execute(array(':field1' => $fbid, ':field2' => $fblist));

  }
    // print_r($userLikes);
    
}

else {
    header("Location: index.html");
}
?>