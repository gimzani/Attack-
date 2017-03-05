<?php
header("Access-Control-Allow-Origin: *");

session_start();

include 'acn.php';

$a = $_GET["a"]; //avatar
$t = $_GET["t"]; //target
$atk = $_GET["atk"]; //attack choice

$query = "SELECT M.Melee_ID FROM Melee AS M
				INNER JOIN MeleeAvatars AS MA ON M.Melee_ID = MA.Melee_ID
				WHERE Attacker = $a AND M.meleeRnd > 0;";

				//echo $query;
	
$rs = mysqli_query($cxn,$query) or die(mysqli_error($cxn));
$row = mysqli_fetch_assoc($rs);

if($row["Melee_ID"]!=null) {
	$mid = $row["Melee_ID"];
	returnResults($cxn, $mid);
	die;
}

$query = "SELECT M.Melee_ID FROM Melee AS M
				INNER JOIN MeleeAvatars AS MA ON M.Melee_ID = MA.Melee_ID
				WHERE Attacker = $t AND M.meleeRnd > 0;";

$target = mysqli_query($cxn,$query) or die(mysqli_error($cxn));
$row = mysqli_fetch_assoc($target);

$mid = $row["Melee_ID"];

if($mid==null) {

	$query = "INSERT INTO Melee (MeleeRnd)  SELECT 1;";

	$rs = mysqli_query($cxn,$query) or die(mysqli_error($cxn));
	
	$mid = mysqli_insert_id($cxn);

	$query = "INSERT INTO MeleeAvatars (Melee_ID, avatarRnd, Attacker, target, atkVal, IsChosen)
					SELECT $mid, 1, $a, $t, $atk, 1;";

	//echo $query;

	mysqli_query($cxn,$query) or die(mysqli_error($cxn));
	
	returnResults($cxn, $mid);
} else {

	$query = "INSERT INTO MeleeAvatars (Melee_ID, avatarRnd, Attacker, target, atkVal, IsChosen)
				SELECT MA.Melee_ID, MA.avatarRnd, $a, $t, $atk, 1
				FROM MeleeAvatars AS MA
				INNER JOIN Melee AS M ON MA.Melee_ID = M.Melee_ID AND MA.avatarRnd = M.meleeRnd
				WHERE MA.Melee_ID = $mid
				AND MA.Attacker = $t;";

	//echo $query;

	//mysqli_query($cxn,$query) or die(mysqli_error($cxn));
	$rs = mysqli_query($cxn,$query);// or die(mysqli_error($cxn));

	returnResults($cxn, $mid);
}

function returnResults($cxn, $mid) {
		$query = "SELECT MA.*, M.meleeRnd, P.Team
						FROM MeleeAvatars AS MA
						INNER JOIN Avatar AS A ON MA.Avatar_ID = A.Avatar_ID
						INNER JOIN Player AS P ON A.Player_ID = P.Player_ID
						INNER JOIN Melee AS M ON MA.Melee_ID = M.Melee_ID AND MA.avatarRnd = M.meleeRnd
						WHERE M.Melee_ID = $mid;";
							//echo $query;
		$out = mysqli_query($cxn,$query) or die(mysqli_error($cxn));
		
		$rows = array();
		
		while($row = mysqli_fetch_assoc($out)) {
			$rows[] = $row;
		}
		print json_encode($rows);
}

?>