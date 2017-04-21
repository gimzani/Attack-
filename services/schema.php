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

$query = "SELECT TABLE_NAME, ORDINAL_POSITION, COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, IS_NULLABLE 
			FROM INFORMATION_SCHEMA.COLUMNS
			WHERE 1=1 
			and TABLE_SCHEMA = 'attack' 
			ORDER BY TABLE_NAME, ORDINAL_POSITION;";
$rs=mysqli_query($cxn,$query) or die(mysqli_error($cxn));
while ($row = mysqli_fetch_assoc($rs)) {
		$rows['Schema'][] = $row;		
}

print json_encode($rows);

?>