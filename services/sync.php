<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

session_start();

include 'acn.php';

$data = json_decode(file_get_contents("php://input"), true);

$v = $data["v"]; // version

$rows = array();

$query = "SELECT ver FROM Version;";
$rs=mysqli_query($cxn,$query) or die(mysqli_error($cxn));
while($row = mysqli_fetch_assoc($rs)) {
	if($row['ver']==$v) {
		print 0;
		die;
	}
}
$query = "SELECT * FROM Version;";
$rs=mysqli_query($cxn,$query) or die(mysqli_error($cxn));
while($row = mysqli_fetch_assoc($rs)) {
		$rows['Version'][] = $row;		
}

$query = "SELECT * FROM Action;";
$rs=mysqli_query($cxn,$query) or die(mysqli_error($cxn));
while($row = mysqli_fetch_assoc($rs)) {
		$rows['Action'][] = $row;		
}

$query = "SELECT * FROM ActionNumber;";
$rs=mysqli_query($cxn,$query) or die(mysqli_error($cxn));
while ($row = mysqli_fetch_assoc($rs)) {
		$rows['ActionNumber'][] = $row;		
}

$query = "SELECT * FROM Class;";
$rs=mysqli_query($cxn,$query) or die(mysqli_error($cxn));
while ($row = mysqli_fetch_assoc($rs)) {
		$rows['Class'][] = $row;		
}

$query = "SELECT * FROM InterAction;";
$rs=mysqli_query($cxn,$query) or die(mysqli_error($cxn));
while ($row = mysqli_fetch_assoc($rs)) {
		$rows['InterAction'][] = $row;		
}

$query = "SELECT * FROM Page;";
$rs=mysqli_query($cxn,$query) or die(mysqli_error($cxn));
while ($row = mysqli_fetch_assoc($rs)) {
		$rows['Page'][] = $row;		
}

$query = "SELECT * FROM Restriction;";
$rs=mysqli_query($cxn,$query) or die(mysqli_error($cxn));
while ($row = mysqli_fetch_assoc($rs)) {
		$rows['Restriction'][] = $row;		
}

$query = "SELECT * FROM Result;";
$rs=mysqli_query($cxn,$query) or die(mysqli_error($cxn));
while ($row = mysqli_fetch_assoc($rs)) {
		$rows['Result'][] = $row;		
}

$query = "SELECT * FROM Team;";
$rs=mysqli_query($cxn,$query) or die(mysqli_error($cxn));
while ($row = mysqli_fetch_assoc($rs)) {
		$rows['Team'][] = $row;		
}

print json_encode($rows);

?>