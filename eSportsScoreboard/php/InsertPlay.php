<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Insert Play</title>
<link href="Admin.css" rel="stylesheet" type="text/css" />

<?php

$senderror = false;

//Get Posts
if (isset($_POST['GameID'])) $GameID = $_POST['GameID'];
  else $senderror=true;
if (isset($_POST['AttackerID'])) $AttackerID = $_POST['AttackerID'];
  else $senderror=true;
if (isset($_POST['DefenderID'])) $DefenderID = $_POST['DefenderID'];
  else $senderror=true;
if (isset($_POST['AssistID'])) $AssistID = $_POST['AssistID'];
  else $senderror=true;
if (isset($_POST['Time'])) $Time = $_POST['Time'];
  else $senderror=true;

require_once 'login.php';
mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($dbname);

if(!($senderror)) {
  //Get KDA's to update
  $result = mysql_query("
  SELECT Kills
  FROM Player
  WHERE GameID = $GameID AND PlayerID = $AttackerID
  ");
  $Kills = mysql_result($result, 0);
  $Kills++;
  
  $result = mysql_query("
  SELECT Deaths
  FROM Player
  WHERE GameID = $GameID AND PlayerID = $DefenderID
  ");
  $Deaths = mysql_result($result, 0);
  $Deaths++;
  
  $result = mysql_query("
  SELECT COUNT(*) 
  FROM Plays 
  WHERE GameID = $GameID
  ");
  $PlayID = mysql_result($result, 0)+1;
  
  $max = sizeof($AssistID);
  for($val = 0; $val< $max; $val++){
	$result = mysql_query("
	SELECT Assists
	FROM Player
	WHERE GameID = $GameID AND PlayerID = $AssistID[$val]
	");
	$Assists[$val] = mysql_result($result, 0);
}
  
  $max = sizeof($AssistID);  
  for($val = 0; $val< $max; $val++){
	$Assists[$val]++;
  }
  
  //Update Kills > Deaths > Assists	  
  mysql_query("UPDATE `LoLStatsTest2`.`Player` SET `Kills`=$Kills WHERE `GameID`='$GameID' and`PlayerID`='$AttackerID';"); 
  mysql_query("UPDATE `LoLStatsTest2`.`Player` SET `Deaths`=$Deaths WHERE `GameID`='$GameID' and`PlayerID`='$DefenderID';"); 
  $max = sizeof($AssistID);
  for($val = 0; $val< $max; $val++){
    mysql_query("UPDATE `LoLStatsTest2`.`Player` SET `Assists`=$Assists[$val] WHERE `GameID`='$GameID' and`PlayerID`='$AssistID[$val]';");
		mysql_query("INSERT INTO `LoLStatsTest2`.`Assits` (`GameID`, `PlayID`, `PlayerID`) VALUES ($GameID, '$PlayID', '$AssistID[$val]');");
  }
  
  //Update Plays Table
  mysql_query("INSERT INTO `LoLStatsTest2`.`Plays` (`GameID`, `PlayID`, `PlayTime`, `AttackerID`, `PlayType`, `DefenderID`) VALUES ($GameID, $PlayID, '$Time', $AttackerID, 'Killed', $DefenderID);");


  
  //Update Assists Table
  
  
  
  echo"Updates Effective";
}//end update if

//Get Player Stats
$result = mysql_query("
  SELECT PlayerInfo.PlayerID, 
  PlayerInfo.ScreenName, 
  Champion.JointChampionName
  FROM PlayerInfo 
  JOIN Player ON Player.PlayerID = PlayerInfo.PlayerID
  JOIN Champion ON Champion.ChampionID = Player.ChampionID
  WHERE Player.GameID = $GameID
  ORDER BY PlayerInfo.TeamID ASC, Player.Lane ASC;
  ");
while ($row = mysql_fetch_array($result)) {
  $ScreenName[] = $row['ScreenName'];
  $PlayerID[] = $row['PlayerID'];
  $JointChampionName[] = $row['JointChampionName'];
}

  

echo <<<END

  </head>  
  <body>  
	<div id="whitebox">
	  <div class="caption">
	    <strong>Insert Plays</strong>
	  </div>		
	  <p>Current Game:$GameID</p>
	  <form method="post" action="InsertPlay.php">
	  <table>
	  
		<tr>
		<td>Time</td>
		<td>Attacker</td>
		<td>Action</td>
		<td>Defender</td>
		<td>Assists</td>
		</tr>	 
		 
		<tr>
		<td><input type="text" name="Time" size="2"/></td>
		<td> <img src="../ChampIcons/36px-$JointChampionName[0]Square.png" width="24" height="24" /><input type="radio" name="AttackerID" value="$PlayerID[0]" />$ScreenName[0]</td>
		<td><select name="Action"><option value="Killed">Killed</option><option value="Destroyed a Tower">Destroyed</option></select></td>
		<td><img src="../ChampIcons/36px-$JointChampionName[0]Square.png" width="24" height="24" /><input type="radio" name="DefenderID" value="$PlayerID[0]" />$ScreenName[0]</td>
		<td><img src="../ChampIcons/36px-$JointChampionName[0]Square.png" width="24" height="24" /><input type="checkbox" name="AssistID[]" value="$PlayerID[0]" />$ScreenName[0]</td>
		</tr>
END;
		//Player Table
		$max = sizeof($PlayerID);
		for($var = 1; $var< $max; $var++){
		echo <<<END
		<tr>
		<td></td>
		<td> <img src="../ChampIcons/36px-$JointChampionName[$var]Square.png" width="24" height="24" /><input type="radio" name="AttackerID" value="$PlayerID[$var]" />$ScreenName[$var]</td>
		<td></td>
		<td><img src="../ChampIcons/36px-$JointChampionName[$var]Square.png" width="24" height="24" /><input type="radio" name="DefenderID" value="$PlayerID[$var]" />$ScreenName[$var]</td>
		<td><img src="../ChampIcons/36px-$JointChampionName[$var]Square.png" width="24" height="24" /><input type="checkbox" name="AssistID[]" value="$PlayerID[$var]" />$ScreenName[$var]</td>
		</tr>
END;
		}
		//Buttons SubTable
		echo <<<END
		<tr>
		<td>
		</td>
		<td>
		</td>
		<td>
		</td>
		<td>
		</td>
		<td>
		<input type="hidden" name="GameID" value="$GameID" />
		<input type="submit" />
		</form>
		</td>
		</tr>
		<tr>
		<td>
		</td>
		<td>
		</td>
		<td>
		</td>
		<td>
		</td>
		<td>
		<form method="post" action="AdminPanel.php">
		  <input type="submit" value="Admin Panel"/>
		</form>
		</td>
		</tr>
	  </table>
	</div>
  </body>
</html>
END;
?>

		  