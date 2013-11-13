<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Champion Select</title>
<link href="Admin.css" rel="stylesheet" type="text/css" />

<?php

$GameIDPostError = false;
$ChampionPostError = false;

if (isset($_POST['GameID'])) $GameID = $_POST['GameID'];
else $GameIDPostError = true;
if (isset($_POST['Champion'])) $Champion = $_POST['Champion'];
else $ChampionPostError = true;


require_once 'login.php';
mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($dbname);

$result = mysql_query("
(SELECT PlayerInfo.PlayerID
FROM Player
JOIN PlayerInfo ON Player.PlayerId = PlayerInfo.PlayerId
JOIN Game ON Game.GameID = Player.GameID
WHERE Game.GameID = $GameID AND Game.TeamAID = Player.TeamID
ORDER BY Player.Lane)
UNION ALL
(SELECT PlayerInfo.PlayerID
FROM Player
JOIN PlayerInfo ON Player.PlayerId = PlayerInfo.PlayerId
JOIN Game ON Game.GameID = Player.GameID
WHERE Game.GameID = $GameID AND Game.TeamBID = Player.TeamID
ORDER BY Player.Lane)
");
while ($row = mysql_fetch_array($result)) {
	$PlayerID[] = $row['PlayerID'];
}

if(!$ChampionPostError) {
	//SQL UPDATES
	for ($val = 0; $val < 10; $val++){
		//use secret formula obtained from Wolfram Alpha to reorder player list to compensate for champions being enetered out of order due to page layout
		$i = ((1/4)*(2*($val+1) + 9 * pow(-1,($val+1)) + 7));
		mysql_query("UPDATE `LoLStatsTest2`.`Player` SET `ChampionID`=$Champion[$val] WHERE `GameID`='$GameID' and`PlayerID`='$PlayerID[$i]';");
		$iq1[$val] = "UPDATE `LoLStatsTest2`.`Player` SET `ChampionID`=$Champion[$val] WHERE `GameID`='$GameID' and`PlayerID`='$PlayerID[$i]';";
	}
}

//Get Current Picks
$result = mysql_query("
SELECT Champion.ChampionID,
Champion.ChampionName
FROM Champion
JOIN PickOrder ON PickOrder.ChampionID = Champion.ChampionID
WHERE PickOrder.GameID = $GameID AND PickOrder.PickID > 6;
");
while ($row = mysql_fetch_array($result)) {
	$Pick[] = $row['ChampionID'];
	$PickName[] = $row['ChampionName'];
}
//Get current Champions
$result = mysql_query("
(SELECT Champion.ChampionID, PlayerInfo.ScreenName
FROM Player
JOIN PlayerInfo ON Player.PlayerId = PlayerInfo.PlayerId
JOIN Game ON Game.GameID = Player.GameID
JOIN Champion ON Player.ChampionID = Champion.ChampionID
WHERE Game.GameID = $GameID AND Game.TeamAID = Player.TeamID
ORDER BY Player.Lane)
UNION ALL
(SELECT Champion.ChampionID, PlayerInfo.ScreenName
FROM Player
JOIN PlayerInfo ON Player.PlayerId = PlayerInfo.PlayerId
JOIN Game ON Game.GameID = Player.GameID
JOIN Champion ON Player.ChampionID = Champion.ChampionID
WHERE Game.GameID = $GameID AND Game.TeamBID = Player.TeamID
ORDER BY Player.Lane)
");
while ($row = mysql_fetch_array($result)) {
	$PlayerChamp[] = $row['ChampionID'];
	$PlayerName[] = $row['ScreenName'];
}

$max = sizeof($Pick);

function EchoOptions($pid){

	global $max, $PickName, $Pick, $PlayerChamp;
	for ($num = 0; $num < $max; $num++){
		echo "<option ";
		if ($Pick[$num] == $PlayerChamp[$pid]){
			echo "selected=\"selected\"";
		}
		echo "value = '$Pick[$num]'> $PickName[$num]</option>\n";
	}	
}


?>
</head>
<body>
<div id="whitebox">
  <div class="caption">
    Champion Select
  </div>
  <form method="post" action="ChampionSelect.php">
  
  	<table>
    
    <tr>
    <td><?php echo $PlayerName[0]; ?></td>
    <td><select name="Champion[]"><?php EchoOptions(0);?></select></td>
    <td><select name="Champion[]"><?php EchoOptions(5);?></select></td>
    <td><?php echo $PlayerName[5]; ?></td>
    </tr>
    
    <tr>
    <td><?php echo $PlayerName[1]; ?></td>
    <td><select name="Champion[]"><?php EchoOptions(1);?></select></td>
    <td><select name="Champion[]"><?php EchoOptions(6);?></select></td>
    <td><?php echo $PlayerName[6]; ?></td>
    </tr>
    
    <tr>
    <td><?php echo $PlayerName[2]; ?></td>
    <td><select name="Champion[]"><?php EchoOptions(2);?></select></td>
    <td><select name="Champion[]"><?php EchoOptions(7);?></select></td>
    <td><?php echo $PlayerName[7]; ?></td>
    </tr>
    
    <tr>
    <td><?php echo $PlayerName[3]; ?></td>
    <td><select name="Champion[]"><?php EchoOptions(3);?></select></td>
    <td><select name="Champion[]"><?php EchoOptions(8);?></select></td>
    <td><?php echo $PlayerName[8]; ?></td>
    </tr>
    
    <tr>
    <td><?php echo $PlayerName[4]; ?></td>
    <td><select name="Champion[]"><?php EchoOptions(4);?></select></td>
    <td><select name="Champion[]"><?php EchoOptions(9);?></select></td>
    <td><?php echo $PlayerName[9]; ?></td>
    </tr>
    
    </table>
  
    <input type="hidden" name="GameID" value="<?php echo $GameID ?>" />
      
    <input type="submit" value="Update Champions" style="width:160px"/>
      
  </form>
  
  <form method="post" action="AdminPanel.php">
      <input type="submit" value="Admin Panel" style="width:160px"/>
  </form>
  	<div class="sql">
			<?php
      foreach ($iq1 as $out){
        echo $out."</br>\n";
      }
		?>
</div>
</body>
</html>