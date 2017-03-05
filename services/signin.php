<?php
header("Access-Control-Allow-Origin: *");

session_start();

include 'acn.php';

$e = $_GET["e"];

$query = "SELECT Player_ID, Team
				FROM Player
				WHERE email = '$e';";
				
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

?>