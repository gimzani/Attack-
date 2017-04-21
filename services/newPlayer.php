<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

session_start();

include 'acn.php';

$data = json_decode(file_get_contents("php://input"), true);

$pn = $data["pn"]; //player name
$n = $data["n"]; //nick name
$e = $data["e"]; //email
$lat = $data["lat"]; //latitude
$lng = $data["lng"]; //longitude

$tn = rand_color($cxn);

$baseLat = 39.738026;
$baseLng = -86.031102;

$myLat = $baseLat - 0.05 + mt_rand() / mt_getrandmax() / 10;
$myLng = $baseLng - 0.05 + mt_rand() / mt_getrandmax() / 10;

$query = "INSERT INTO Player (email, PlayerName, TeamName, Nick, Latitude, Longitude)
				SELECT '$e'
				, '$pn'
				, '$tn'
				, '$n'
				, $myLat
				, $myLng;";
				
$rs = mysqli_query($cxn,$query) or die(mysqli_error($cxn));

$id = mysqli_insert_id($cxn);

$query = "SELECT Player_ID, TeamName FROM Player
				WHERE Player_ID = $id;";

$rs=mysqli_query($cxn,$query) or die(mysqli_error($cxn));

$rows = array();

if(mysqli_num_rows($rs) == 0)
{
	print json_encode("-1");
	die;
}
while($row = mysqli_fetch_assoc($rs)) {
		$rows[] = $row;		
}
print json_encode($rows);

function rand_color($cxn) {
	$query = "SELECT TeamName FROM Team WHERE IsActive = 1 ORDER BY RAND() LIMIT 1;";
	$rs=mysqli_query($cxn,$query) or die(mysqli_error($cxn));
	while($row = mysqli_fetch_assoc($rs)) {
		return $row["TeamName"];
	}
	
    //return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}

?>