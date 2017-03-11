<?php
header("Access-Control-Allow-Origin: *");

session_start();

include 'acn.php';

$p = $_GET["p"];
$c = $_GET["c"];
$n = $_GET["n"];

$query = "INSERT INTO Avatar (Player_ID, Class_ID, AvatarName, Exp, Level, MaxHP, CurHP)
				SELECT $p, $c, '$n', 0, 0, B.HP, B.HP
				FROM Class AS C
				WHERE Class_ID = $c;";
$rs = mysqli_query($cxn,$query) or die(mysqli_error($cxn));

print json_encode(mysqli_insert_id($cxn));

?>