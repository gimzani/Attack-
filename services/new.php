<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

session_start();

include 'acn.php';

$data = json_decode(file_get_contents("php://input"), true);

$p = $data["p"]; //player
$c = $data["c"]; //class
$n = $data["n"]; //avatar name

$query = "INSERT INTO Avatar (Player_ID, Class_ID, AvatarName, Exp, Level, MaxHP, CurHP)
				SELECT $p, $c, '$n', 0, 0, C.HP, C.HP
				FROM Class AS C
				WHERE Class_ID = $c;";
$rs = mysqli_query($cxn,$query) or die(mysqli_error($cxn));

print json_encode(mysqli_insert_id($cxn));

?>