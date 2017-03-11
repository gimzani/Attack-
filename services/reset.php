<?php
header("Access-Control-Allow-Origin: *");

session_start();

include 'acn.php';

$c = $_GET["c"];
$r = $_GET["r"];
$a = $_GET["a"];
$t = $_GET["t"];

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

?>