<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

session_start();

include 'acn.php';

$data = json_decode(file_get_contents("php://input"), true);

$t = $data["t"]; //Team
$lat = $data["lat"]; //latitude
$lng = $data["lng"]; //longitude

$query = "SELECT Class_ID, MaxHP, Avatar_ID
				FROM Avatar AS A
				INNER JOIN Player AS P ON A.Player_ID = P.Player_ID
				WHERE TeamName != '$t' AND IsActive = 1
				LIMIT 10;";

//echo $query;
				
$rs=mysqli_query($cxn,$query) or die(mysqli_error($cxn));

$rows = array();

while($row = mysqli_fetch_assoc($rs)) {
	$rows[] = $row;
}

print json_encode($rows);

?>