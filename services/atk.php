<?php
header("Access-Control-Allow-Origin: *");

session_start();

include 'acn.php';

$m = $_GET["m"];
$c = $_GET["c"];
$r = $_GET["r"];
$a = $_GET["a"];
$t = $_GET["t"];

$query = "SELECT MA.*
				, M.meleeRnd 
				, (SELECT COUNT(1) FROM MeleeAvatars AS xMA WHERE xMA.Melee_ID = M.Melee_ID AND xMA.IsChosen IS NULL) AS RndComplete
				FROM MeleeAvatars AS MA
				INNER JOIN Melee AS M ON MA.Melee_ID = M.Melee_ID
				WHERE MA.Attacker = $c AND MA.avatarRnd = $r AND M.Melee_ID = $m;";

//echo $query;
				
$attacker=mysqli_query($cxn,$query) or die(mysqli_error($cxn));
while($row = mysqli_fetch_assoc($attacker)) {
	
	if($r==$row["meleeRnd"] && $a != $row["atkVal"])
	{	
		echo "set atk";
		$query = "UPDATE MeleeAvatars SET atkVal = $a, target = $t, IsChosen = 1 WHERE M.Melee_ID = $m AND Attacker =$c AND avatarRnd = $r;";
		mysqli_query($cxn,$query);
		$query = "UPDATE MeleeAvatars SET targetVal = $a WHERE M.Melee_ID = $m AND target =$c AND avatarRnd = $r;";
		mysqli_query($cxn,$query);
	}
	else if($r==$row["meleeRnd"] && $row["RndComplete"]==0)
	{	
		$query = "UPDATE Melee SET meleeRnd = meleeRnd+1 WHERE Melee_ID = $m;";
		mysqli_query($cxn,$query);
		$query = "INSERT INTO MeleeAvatars (Melee_ID, Attacker, avatarRnd) SELECT MA.Melee_ID, MA.Attacker, M.meleeRnd
						FROM MeleeAvatars AS MA
						INNER JOIN Melee AS M ON MA.Melee_ID = M.Melee_ID
						INNER JOIN Avatar AS A ON MA.Attacker = A.Avatar_ID
						WHERE M.Melee_ID = $m AND avatarRnd = $r;";

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
						WHERE M.Melee_ID = $m AND avatarRnd = $r;";
		$out = mysqli_query($cxn,$query) or die(mysqli_error($cxn));
		
		$rows = array();
		
		while($row = mysqli_fetch_assoc($out)) {
			$rows[] = $row;
		}
		print json_encode($rows);
}

?>