<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

session_start();

include 'acn.php';

$data = json_decode(file_get_contents("php://input"), true);

$c = $data["c"];
$r = $data["r"];
$a = $data["a"];
$t = $data["t"];

$query = "UPDATE MeleeAvatars SET target = 0;";
$run=mysqli_query($cxn,$query) or die(mysqli_error($cxn));


$query = "DELETE FROM MeleeAvatars WHERE avatarRnd != 1;";
$run=mysqli_query($cxn,$query) or die(mysqli_error($cxn));

$query = "DELETE FROM Avatar WHERE Avatar_ID > 2;";
$run=mysqli_query($cxn,$query) or die(mysqli_error($cxn));

$query = "DELETE FROM MeleeAvatars WHERE Melee_ID > 1;";
$run=mysqli_query($cxn,$query) or die(mysqli_error($cxn));

$query = "UPDATE MeleeAvatars SET AtkVal = null, targetVal = null, IsChosen = null;";
$run=mysqli_query($cxn,$query) or die(mysqli_error($cxn));

$query = "DELETE FROM Melee WHERE Melee_ID > 1;";
$run=mysqli_query($cxn,$query) or die(mysqli_error($cxn));

$query = "UPDATE Melee SET meleeRnd = 1;";
$run=mysqli_query($cxn,$query) or die(mysqli_error($cxn));

$query = "DELETE FROM Player WHERE Player_ID > 2;";
$run=mysqli_query($cxn,$query) or die(mysqli_error($cxn));

print 0;

?>