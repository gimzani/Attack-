<?php
header("Access-Control-Allow-Origin: *");

session_start();

include 'acn.php';

$c = $_GET["c"];
$r = $_GET["r"];
$a = $_GET["a"];
$t = $_GET["t"];

$query = "SELECT MA.*
				, M.meleeRnd 
				, (SELECT COUNT(1) FROM MeleeAvatars AS xMA WHERE xMA.Melee_ID = M.Melee_ID AND xMA.IsChosen IS NULL) AS RndComplete
				FROM MeleeAvatars AS MA
				INNER JOIN Melee AS M ON MA.Melee_ID = M.Melee_ID
				WHERE MA.Attacker = $c AND MA.avatarRnd = $r";

//echo $query;
				
$attacker=mysqli_query($cxn,$query) or die(mysqli_error($cxn));
while($row = mysqli_fetch_assoc($attacker)) {
	
	if($r==$row["meleeRnd"] && $a != $row["atkVal"])
	{	
		echo "set atk";
		$query = "UPDATE MeleeAvatars SET atkVal = $a, target = $t, IsChosen = 1 WHERE Attacker =$c;";
		mysqli_query($cxn,$query);
		$query = "UPDATE MeleeAvatars SET targetVal = $a WHERE target =$c;";
		mysqli_query($cxn,$query);
	}
	else if($r==$row["meleeRnd"] && $row["RndComplete"]==0)
	{	
		$query = "UPDATE Melee SET meleeRnd = meleeRnd+1 WHERE Melee_ID = " . $row["Melee_ID"] . ";";
		mysqli_query($cxn,$query);
		$query = "INSERT INTO MeleeAvatars (Melee_ID, Attacker, avatarRnd) SELECT MA.Melee_ID, MA.Attacker, M.meleeRnd
						FROM MeleeAvatars AS MA
						INNER JOIN Melee AS M ON MA.Melee_ID = M.Melee_ID
						INNER JOIN Avatar AS A ON MA.Attacker = A.Avatar_ID
						WHERE avatarRnd = $r;";

		mysqli_query($cxn,$query) or die(mysqli_error($cxn));
		
		returnResults($cxn, $r);
	}
	else if($r!=$row["meleeRnd"])
	{	
		returnResults($cxn, $r);
	}
}

function returnResults($cxn, $r) {
		$query = "SELECT MA.*, M.meleeRnd FROM MeleeAvatars AS MA
						INNER JOIN Melee AS M ON MA.Melee_ID = M.Melee_ID
						WHERE avatarRnd = $r;";
		$out = mysqli_query($cxn,$query) or die(mysqli_error($cxn));
		
		$rows = array();
		
		while($row = mysqli_fetch_assoc($out)) {
			$rows[] = $row;
		}
		print json_encode($rows);
}

?>