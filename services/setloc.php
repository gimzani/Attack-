<?php
header("Access-Control-Allow-Origin: *");

session_start();

include 'acn.php';

$p = $_GET["p"];
$lat = $_GET["lat"];
$lng = $_GET["lng"];

$query = "UPDATE Player
				SET Latitude = $lat, Longitude = $lng
				WHERE Player_ID = $p;";

mysqli_query($cxn,$query) or die(mysqli_error($cxn));

print "0";

?>