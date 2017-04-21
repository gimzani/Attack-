<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

session_start();

include 'acn.php';

$data = json_decode(file_get_contents("php://input"), true);

$a = $data["a"]; //avatar
$atk = $data["atk"]; //Attack
$hp =  $data["hp"]; //New MaxHP

$query = "UPDATE Avatar
			SET Level = Level +1
			, Exp = Exp - MaxHP
		WHERE Avatar_ID = $a;";
				
mysqli_query($cxn,$query) or die(mysqli_error($cxn));

$query = "UPDATE Avatar
			SET MaxHP = $hp
		WHERE Avatar_ID = $a;";
				
mysqli_query($cxn,$query) or die(mysqli_error($cxn));

$query = "INSERT INTO AvatarMod (Avatar_ID, ActionNumber_ID, DmgMod)
			VALUES ($a, $atk, 1)
			ON DUPLICATE KEY UPDATE
			DmgMod = DmgMod + 1;";

mysqli_query($cxn,$query) or die(mysqli_error($cxn));

print 0;

?>