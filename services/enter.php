<?php
header("Access-Control-Allow-Origin: *");

session_start();

include 'acn.php';

$p = $_GET["p"];
$a = $_GET["a"];

$query = "UPDATE Avatar
				SET IsActive = CASE WHEN Avatar_ID = $a THEN 1 ELSE 0 END
				WHERE Player_ID = $p;";

mysqli_query($cxn,$query) or die(mysqli_error($cxn));

print "0";

?>