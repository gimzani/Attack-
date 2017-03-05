<?php
header("Access-Control-Allow-Origin: *");

session_start();

include 'acn.php';

$p = $_GET["p"];
$lat = $_GET["lat"];
$long = $_GET["long"];

$query = "SELECT Book_ID, MaxHP, Avatar_ID
				FROM Avatar
				WHERE Player_ID != $p
				LIMIT 10;";

//echo $query;
				
$rs=mysqli_query($cxn,$query) or die(mysqli_error($cxn));

$rows = array();

while($row = mysqli_fetch_assoc($rs)) {
	$rows[] = $row;
}

print json_encode($rows);

?>