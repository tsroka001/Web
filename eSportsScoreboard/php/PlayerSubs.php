<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Player Subs</title>
<link href="Admin.css" rel="stylesheet" type="text/css" />

<?php

//Get Posted Variables
if (isset($_POST['GameID'])) $GameID = $_POST['GameID'];
else $senderror=1;
if (isset($_POST['NewPlayerID'])) $NewPlayerID = $_POST['NewPlayerID'];
else $senderror=1;
if (isset($_POST['OldPlayerID'])) $OldPlayerID = $_POST['OldPlayerID'];
else $senderror=1;

//Login to Database
require_once 'login.php';
mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($dbname);

//SQL UPdates for all changed fields
for( $i = 0; $i < 10; $i++ ){
	if ( $NewPlayerID[$i] != $OldPlayerID[$i] ){
		$myInsQuery = "UPDATE `LoLStatsTest2`.`Player` SET `PlayerID`=$NewPlayerID[$i] WHERE `GameID`='$GameID' and`PlayerID`='$OldPlayerID[$i]';";
		mysql_query($myInsQuery);
		$myInsQuery = "UPDATE `LoLStatsTest2`.`GPItems` SET `PlayerID`=$NewPlayerID[$i] WHERE `GameID`='$GameID' and`PlayerID`='$OldPlayerID[$i]';";
		mysql_query($myInsQuery);
	}
}

//SQL Queries
$result = mysql_query("SELECT PlayerID, ScreenName FROM PlayerInfo ORDER BY ScreenName");
while ($row = mysql_fetch_array($result)) {
	$PlayerID[] = $row['PlayerID'];
	$ScreenName[] = $row['ScreenName'];	
}

$result = mysql_query("
SELECT Player.PlayerID, PlayerInfo.ScreenName
FROM Player
JOIN PlayerInfo ON Player.PlayerId = PlayerInfo.PlayerId
JOIN Game ON Game.GameID = Player.GameID
WHERE Game.GameID = $GameID AND Game.TeamAID = Player.TeamID
ORDER BY Player.Lane
");
while ($row = mysql_fetch_array($result)) {
	$BlueID[] = $row['PlayerID'];
	$BlueSN[] = $row['ScreenName'];
}

$result = mysql_query("
SELECT Player.PlayerID, PlayerInfo.ScreenName
FROM Player
JOIN PlayerInfo ON Player.PlayerId = PlayerInfo.PlayerId
JOIN Game ON Game.GameID = Player.GameID
WHERE Game.GameID = $GameID AND Game.TeamBID = Player.TeamID
ORDER BY Player.Lane
");
while ($row = mysql_fetch_array($result)) {
	$RedID[] = $row['PlayerID'];
	$RedSN[] = $row['ScreenName'];
}


?>

</head>
<body>
  <div id="whitebox">
    <div class="caption">
      <strong>Update Player Subs Subs</strong>
    </div>
  <form method="post" action="PlayerSubs.php">

  <div class="FloatBox">
  <table>
  <tr><td height="25">Position</td></tr>
  <tr><td height="25">TOP</td></tr>
  <tr><td height="25">JNG</td></tr>
  <tr><td height="25">MID</td></tr>
  <tr><td height="25">ADC</td></tr>
  <tr><td height="25">SUP</td></tr>
  <tr><td height="25"></td></td></tr>
  </table>
  </div>
  <div class="FloatBox">
  <table>
  <tr><td>Blue Team</td></tr>

	<?php echoPlayers($BlueID)	?>

  <tr><td><input type="hidden" name="GameID" value="<?php echo $GameID; ?>" /></td></tr>
  </table>
  </div>
  <div class="FloatBox">
  <table>
  <tr><td>Red Team</td></tr>
  
  <?php echoPlayers($RedID)	?>
  
  <tr><td><input type="submit" /></td></tr>
  </table>
  </div>
    <div id="contClear"></div>
  <?php //pass old names for reference
		for ($i = 0; $i < 5; $i++){
			echo '<input type="hidden" name="OldPlayerID[]" value="'.$BlueID[$i].'">'."\n";
		}
		for ($i = 0; $i < 5; $i++){
			echo '<input type="hidden" name="OldPlayerID[]" value="'.$RedID[$i].'">'."\n";
		}
	?>
  </form>
  <div class="quickEscape">
    <form method="post" action="AdminPanel.php">
      <input type="submit" value="Admin Panel" style="width:193px"/>
    </form>
  </div>
</div>

</body>
</html>

<?php

function echoPlayers($PlaID){
	global $PlayerID, $ScreenName;
	$max = sizeof($PlayerID);
	for ( $pos = 0; $pos < 5; $pos++ ){
		echo "<tr><td height=\"25\">\n<select name=\"NewPlayerID[]\">\n";
		for ( $pla = 0; $pla < $max; $pla++ ){
			echo "<option";
			if ( $PlayerID[$pla] == $PlaID[$pos] ){
				echo " selected = \"selected\" ";
			}
			echo " value = \"$PlayerID[$pla]\">$ScreenName[$pla]</option>\n";
		}
		echo "</tr></td>\n";
	}
}


?>



