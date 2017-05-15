<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

session_start();

include 'acn.php';

$data = json_decode(file_get_contents("php://input"), true);

$rows = array();

$query = "SELECT * FROM Version;";
$rs=mysqli_query($cxn,$query) or die(mysqli_error($cxn));
while($row = mysqli_fetch_assoc($rs)) {
		$rows['Version'][] = $row;		
}

print json_encode($rows);

?>