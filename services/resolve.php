<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

session_start();

include 'acn.php';

$data = json_decode(file_get_contents("php://input"), true);

$p = $data["p"]; //Player ID
$a = $data["a"]; //avatar
$t = $data["t"]; //team
$exp = $data["exp"]; //experience
$hp = $data["hp"]; //current Hit Points
$wl = $data["wl"]; //W/L/T

$win = ($wl != 'l' ? 1 : 0);
$loss = ($wl != 'w' ? 1 : 0);

$query = "UPDATE Player
			SET TeamName = '$t'
			, Win = Win + $win
			, Loss = Loss + $loss
		WHERE Player_ID = $p;";
				
mysqli_query($cxn,$query) or die(mysqli_error($cxn));

$query = "UPDATE Avatar
			SET Exp = Exp + $exp
			, CurHP = $hp
		WHERE Avatar_ID = $a;";

mysqli_query($cxn,$query) or die(mysqli_error($cxn));

print 0;

?>