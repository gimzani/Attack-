<?php
header("Access-Control-Allow-Origin: *");

session_start();

include 'acn.php';

$pn = $_GET["pn"];
$n = $_GET["n"];
$e = $_GET["e"];
$lt = $_GET["lt"];
$lg = $_GET["lg"];

$rgb = rand_color();

$query = "INSERT INTO Player (email, PlayerName, Team, Nick, Latitude, Longitude)
				SELECT '$e'
				, '$pn'
				, '$rgb'
				, '$n'
				, $lt
				, $lg;";
				
$rs = mysqli_query($cxn,$query) or die(mysqli_error($cxn));

$id = mysqli_insert_id($cxn);

$query = "SELECT Player_ID, Team FROM Player
				WHERE Player_ID = $id;";

$rs=mysqli_query($cxn,$query) or die(mysqli_error($cxn));

$rows = array();

if(mysqli_num_rows($rs) == 0)
{
	print json_encode("-1");
	die;
}
while($row = mysqli_fetch_assoc($rs)) {
		$rows[] = $row;		
}
print json_encode($rows);

function rand_color() {
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}

?>