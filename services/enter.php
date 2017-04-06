<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

session_start();

include 'acn.php';

$data = json_decode(file_get_contents("php://input"), true);

$p = $data["p"]; //player
$a = $data["a"]; //avatar

$query = "UPDATE Avatar
				SET IsActive = CASE WHEN Avatar_ID = $a THEN 1 ELSE 0 END
				WHERE Player_ID = $p;";

mysqli_query($cxn,$query) or die(mysqli_error($cxn));

print "0";

?>