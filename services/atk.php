<?php
header("Access-Control-Allow-Origin: *");

session_start();

include 'acn.php';

$m = $_GET["m"]; //Melee_ID
$c = $_GET["c"]; //Attacker
$r = $_GET["r"]; //avatarRnd
$a = $_GET["a"]; //attackVal
$t = $_GET["t"]; //target

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
		$query = "UPDATE MeleeAvatars SET atkVal = $a, target = $t, IsChosen = 1 WHERE Melee_ID = $m AND Attacker =$c AND avatarRnd = $r;";
	
		mysqli_query($cxn,$query) or die(mysqli_error($cxn));
		$query = "UPDATE MeleeAvatars SET targetVal = $a WHERE Melee_ID = $m AND target =$c AND avatarRnd = $r;";

		mysqli_query($cxn,$query) or die(mysqli_error($cxn));
		print 0;
	}
	else if($r==$row["meleeRnd"] && $row["RndComplete"]==0)
	{	
		$query = "UPDATE MeleeAvatars AS MA1
						INNER JOIN MeleeAvatars AS MA2 ON MA1.Melee_ID = MA2.Melee_ID AND MA1.avatarRnd = MA2.avatarRnd AND MA1.target = MA2.Attacker
						SET MA1.targetVal = MA2.atkVal
						WHERE MA1.Melee_ID = $m AND MA1.avatarRnd = $r;";
		//echo $query;
		
		mysqli_query($cxn,$query) or die(mysqli_error($cxn));
		
		$query = "UPDATE Melee SET meleeRnd = meleeRnd+1 WHERE Melee_ID = $m;";
		mysqli_query($cxn,$query) or die(mysqli_error($cxn));
		$query = "INSERT INTO MeleeAvatars (Melee_ID, Attacker, avatarRnd) SELECT MA.Melee_ID, MA.Attacker, M.meleeRnd
						FROM MeleeAvatars AS MA
						INNER JOIN Melee AS M ON MA.Melee_ID = M.Melee_ID
						INNER JOIN Avatar AS A ON MA.Attacker = A.Avatar_ID
						WHERE M.Melee_ID = $m AND avatarRnd = $r;";

		mysqli_query($cxn,$query) or die(mysqli_error($cxn));
		
		returnResults($cxn, $m, $r);
	}
	else if($r!=$row["meleeRnd"])
	{	
		returnResults($cxn, $m, $r);
	}
}

function returnResults($cxn, $m, $r) {
		$query = "SELECT MA.*, M.meleeRnd FROM MeleeAvatars AS MA
						INNER JOIN Melee AS M ON MA.Melee_ID = M.Melee_ID
						WHERE M.Melee_ID = $m AND avatarRnd = $r;";
						//echo $query;
						
		$out = mysqli_query($cxn,$query) or die(mysqli_error($cxn));
		
		$rows = array();
		
		while($row = mysqli_fetch_assoc($out)) {
			$rows[] = $row;
		}
		print json_encode($rows);
}

?>