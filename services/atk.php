<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

session_start();

include 'acn.php';

$data = json_decode(file_get_contents("php://input"), true);

$m = $data["m"]; //Melee_ID
$a = $data["a"]; //Attacker
$r = $data["rnd"]; //avatarRnd
$atk = $data["atk"]; //attackVal
$tgt = $data["tgt"]; //target

$query = "SELECT MA.*
				, M.meleeRnd 
				, (SELECT COUNT(1) FROM MeleeAvatars AS xMA WHERE xMA.Melee_ID = M.Melee_ID AND xMA.IsChosen IS NULL) AS RndComplete
				FROM MeleeAvatars AS MA
				INNER JOIN Melee AS M ON MA.Melee_ID = M.Melee_ID
				WHERE MA.Attacker = $a AND MA.avatarRnd = $r AND M.Melee_ID = $m;";

$attacker=mysqli_query($cxn,$query) or die(mysqli_error($cxn));

while($row = mysqli_fetch_assoc($attacker)) {
	
	if($r==$row["meleeRnd"] && $atk != $row["atkVal"])
	{	
		$query = "UPDATE MeleeAvatars SET atkVal = $atk
										, target = $tgt
										, IsChosen = 1
		WHERE Melee_ID = $m 
		AND Attacker = $a 
		AND avatarRnd = $r;";
	
		mysqli_query($cxn,$query) or die(mysqli_error($cxn));
		//$query = "UPDATE MeleeAvatars SET targetVal = $atk WHERE Melee_ID = $m AND target =$c AND avatarRnd = $r;";
		//mysqli_query($cxn,$query) or die(mysqli_error($cxn));
		echo 0;
	}
	else if($r==$row["meleeRnd"] && $row["RndComplete"]==0)
	{	
		$query = "UPDATE MeleeAvatars AS MA1
						INNER JOIN MeleeAvatars AS MA2 ON MA1.Melee_ID = MA2.Melee_ID
																			AND MA1.avatarRnd = MA2.avatarRnd
																			AND MA1.target = MA2.Attacker
						SET MA1.targetVal = MA2.atkVal
						WHERE MA1.Melee_ID = $m AND MA1.avatarRnd = $r;";
		//echo $query;
		
		$comma="";
		$out="";	
		if($_POST["d"]!=null) {
			$dead = json_decode($_POST["d"], true); //avatars defeated this round

			foreach($dead as $item) {
				$out .= $comma .$item["d"];
				$comma = ",";
			}		
		}
		
		mysqli_query($cxn,$query) or die(mysqli_error($cxn));

		$query = "UPDATE Melee SET meleeRnd = meleeRnd+1 WHERE Melee_ID = $m AND meleeRnd = $r;";
		mysqli_query($cxn,$query) or die(mysqli_error($cxn));
		
		if(mysqli_affected_rows($cxn)>0) {
			$query = "INSERT INTO MeleeAvatars (Melee_ID, Attacker, avatarRnd) SELECT MA.Melee_ID, MA.Attacker, M.meleeRnd
							FROM MeleeAvatars AS MA
							INNER JOIN Melee AS M ON MA.Melee_ID = M.Melee_ID
							INNER JOIN Avatar AS A ON MA.Attacker = A.Avatar_ID
							WHERE M.Melee_ID = $m AND avatarRnd = $r";
			if($out!=""){
				$query .= " AND Attacker NOT IN ($out);";
			}

			mysqli_query($cxn,$query) or die(mysqli_error($cxn));
		}
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