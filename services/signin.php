<?php
header("Access-Control-Allow-Origin: *");

session_start();

include 'acn.php';

$e = $_GET["e"];

$rows = array();

$query = "SELECT *
				FROM Player
				WHERE email = '$e';";
				
$rs=mysqli_query($cxn,$query) or die(mysqli_error($cxn));

if(mysqli_num_rows($rs) == 0)
{
	print json_encode("-1");
	die;
}
while($row = mysqli_fetch_assoc($rs)) {
		$p = $row["Player_ID"];
		$rows['Player'] = $row;		
}

$query = "SELECT *
				FROM Avatar
				WHERE Player_ID = $p;";

$rs=mysqli_query($cxn,$query) or die(mysqli_error($cxn));

while ($row = mysqli_fetch_assoc($rs)) {
		$rows['Avatar'] = $row;		
}

print json_encode($rows);

?>