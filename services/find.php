<?php
header("Access-Control-Allow-Origin: *");

session_start();

include 'acn.php';

$t = $_GET["t"];
$lat = $_GET["lat"];
$long = $_GET["long"];

$query = "SELECT Class_ID, MaxHP, Avatar_ID
				FROM Avatar AS A
				INNER JOIN Player AS P ON A.Player_ID = P.Player_ID
				WHERE TeamName != $t
				LIMIT 10;";

//echo $query;
				
$rs=mysqli_query($cxn,$query) or die(mysqli_error($cxn));

$rows = array();

while($row = mysqli_fetch_assoc($rs)) {
	$rows[] = $row;
}

print json_encode($rows);

?>