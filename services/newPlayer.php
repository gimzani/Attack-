<?php
header("Access-Control-Allow-Origin: *");

session_start();

include 'acn.php';

$pn = $_GET["pn"];
$n = $_GET["n"];
$e = $_GET["e"];
$lt = $_GET["lt"];
$lg = $_GET["lg"];

$tn = rand_color($cxn);

$query = "INSERT INTO Player (email, PlayerName, TeamName, Nick, Latitude, Longitude)
				SELECT '$e'
				, '$pn'
				, '$tn'
				, '$n'
				, $lt
				, $lg;";
				
$rs = mysqli_query($cxn,$query) or die(mysqli_error($cxn));

$id = mysqli_insert_id($cxn);

$query = "SELECT Player_ID, TeamName FROM Player
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

function rand_color($cxn) {
	$query = "SELECT TeamName FROM Team WHERE IsActive = 1 ORDER BY RAND() LIMIT 1;";
	$rs=mysqli_query($cxn,$query) or die(mysqli_error($cxn));
	while($row = mysqli_fetch_assoc($rs)) {
		return $row["TeamName"];
	}
	
    //return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}

?>