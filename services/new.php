<?php
header("Access-Control-Allow-Origin: *");

session_start();

include 'acn.php';

$p = $_GET["p"];
$b = $_GET["b"];
$n = $_GET["n"];

$query = "INSERT INTO Avatar (Player_ID, Book_ID, AvatarName, Exp, Level, MaxHP, CurHP)
				SELECT $p, $b, '$n', 0, 0, B.HP, B.HP
				FROM Book AS B
				WHERE Book_ID = $b;";
$rs = mysqli_query($cxn,$query) or die(mysqli_error($cxn));

print json_encode(mysqli_insert_id($cxn));

?>