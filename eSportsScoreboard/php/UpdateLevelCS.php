<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update Level/CS</title>
<link href="Admin.css" rel="stylesheet" type="text/css" />

<?php

require_once 'login.php';
mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($dbname);

$GameIDPostError = false;
$PlayerCSPostError = false;
$PlayerLevelPostError = false;

if (isset($_POST['GameID'])) $GameID = $_POST['GameID'];
else $GameIDPostError = true;
if (isset($_POST['PlayerCS'])) $PlayerCS = $_POST['PlayerCS'];
else $PlayerCSPostError = true;
if (isset($_POST['PlayerLevel'])) $PlayerLevel = $_POST['PlayerLevel'];
else $PlayerLevelPostError = true;
if (isset($_POST['PlayerGold'])) $PlayerGold = $_POST['PlayerGold'];
else $PlayerGoldPostError = true;

//Get Player Id's
$result = mysql_query("
SELECT PlayerInfo.PlayerID
FROM PlayerInfo 
JOIN Player ON Player.PlayerID = PlayerInfo.PlayerID
WHERE Player.GameID = $GameID
ORDER BY PlayerInfo.TeamID ASC, Player.Lane ASC;
");
while ($row = mysql_fetch_array($result)) {
	$PlayerID[] = $row['PlayerID'];
}

//SQL Updates
if(!$PlayerCSPostError && !$PlayerLevelPostError){
	for($i = 0; $i < 10; $i++){
		//Algorithm to compensate for 0 5 1 6 2 7 3 8 4 9 pattern
		$j = (2*($i+1)+9*(pow((-1),($i+1)))+7)/4;
		mysql_query("UPDATE `LoLStatsTest2`.`Player` SET `Level`=$PlayerLevel[$i], `CreepScore`=$PlayerCS[$i], `Gold`=$PlayerGold[$i] WHERE `GameID`='$GameID' and`PlayerID`='$PlayerID[$j]';");
	}
}

//Get Current Stats
$result = mysql_query("
SELECT PlayerInfo.ScreenName,  
Champion.JointChampionName,
Player.Level,
Player.CreepScore,
Player.Lane,
Player.Gold,
PlayerInfo.TeamID
FROM PlayerInfo 
JOIN Player ON Player.PlayerID = PlayerInfo.PlayerID
JOIN Champion ON Champion.ChampionID = Player.ChampionID
WHERE Player.GameID = $GameID
ORDER BY PlayerInfo.TeamID ASC, Player.Lane ASC;
");
while ($row = mysql_fetch_array($result)) {
	$ScreenName[] = $row['ScreenName'];
	$JointChampionName[] = $row['JointChampionName'];
	$Level[] = $row['Level'];
	$CreepScore[] = $row['CreepScore'];
	$Gold[] = $row['Gold'];
	$TeamID[] = $row['TeamID'];
}

?>


</head>

<body>
<div id="whitebox">
<div class="caption">
<strong>Update Levels/CS/Gold</strong>
</div>

<form method="post" action="UpdateLevelCS.php">

<table>
  <tr>
  <td style="width:160px">Player</td>
  <td style="width:50px">CS</td>
  <td style="width:50px">Level</td>
  <td style="width:50px">Gold</td>
  <td style="width:50px"></td>
  <td style="width:160px">Player</td>
  <td style="width:50px">CS</td>
  <td style="width:50px">Level</td>
  <td style="width:50px">Gold</td>
  </tr>

<?php
for($i = 0; $i<5; $i++){
	$j = $i+5;
	echo <<<END
	<tr>
	<td><img src="../ChampIcons/36px-$JointChampionName[$i]Square.png" width="20" height="20" /> $ScreenName[$i] </td>
	<td><input type="number" value="$CreepScore[$i]" name="PlayerCS[]" min="1" max="9999"/></td>
	<td><input type="number" value="$Level[$i]" name="PlayerLevel[]" min="1" max="18"/></td>
	<td><input type="number" value="$Gold[$i]" name="PlayerGold[]" min="0" max="100000"/></td>
	<td></td>
	<td><img src="../ChampIcons/36px-$JointChampionName[$j]Square.png" width="20" height="20" /> $ScreenName[$j] </td>
	<td><input type="number" value="$CreepScore[$j]" name="PlayerCS[]" min="1" max="9999"/></td>
	<td><input type="number" value="$Level[$j]" name="PlayerLevel[]" min="1" max="18"/></td>
	<td><input type="number" value="$Gold[$j]" name="PlayerGold[]" min="0" max="100000"/></td>
	<td></td>
	</tr>	
END;
}

?>

</table>

<input type="hidden" name="GameID" value="<?php echo $GameID;?>" />
<input type="submit" style="width:160px" />
</form>

<form method="post" action="AdminPanel.php">
  <input type="submit" value="Admin Panel" style="width:160px"/>
</form>


</div>
</body>
</html>