<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update KDA</title>
<link href="Admin.css" rel="stylesheet" type="text/css" />
<?php

$GameIDerror = false;
$OldKillserror=false;
$OldDeathserror=false;
$OldAssistserror=false;
//Get Posted Variables
if (isset($_POST['GameID'])) $GameID = $_POST['GameID'];
else $GameIDerror=true;
if (isset($_POST['NewKills'])) $Kills = $_POST['NewKills'];
else $Killserror=true;
if (isset($_POST['NewDeaths'])) $Deaths = $_POST['NewDeaths'];
else $Deathserror=true;
if (isset($_POST['NewAssists'])) $Assists = $_POST['NewAssists'];
else $Assistserror=true;
if (isset($_POST['OldKills'])) $OldKills = $_POST['OldKills'];
else $OldKillserror=true;
if (isset($_POST['OldDeaths'])) $OldDeaths = $_POST['OldDeaths'];
else $OldDeathserror=true;
if (isset($_POST['OldAssists'])) $OldAssists = $_POST['OldAssists'];
else $OldAssistserror=true;
if (isset($_POST['OldPlayerID'])) $OldPlayerID = $_POST['OldPlayerID'];
else $OldPlayerIDserror=true;

//Login to Database
require_once 'login.php';
mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
		mysql_select_db($dbname);

//If all values posted successfully execute sql updates for all altered data
if((!$OldKillserror) || (!$OldDeathserror) || (!$OldAssistserror) || (!$OldPlayerIDserror)){
	for ($i = 0; $i < 10; $i++){
		if( ($OldKills[$i] != $Kills[$i]) || ($OldDeaths[$i] != $Deaths[$i]) || ($OldAssists[$i] != $Assists[$i]) ){
			$myInsQuery = "UPDATE `LoLStatsTest2`.`Player` SET `Kills`=$Kills[$i], `Deaths`=$Deaths[$i], `Assists`=$Assists[$i] WHERE `GameID`='$GameID' and`PlayerID`='$OldPlayerID[$i]';";
			mysql_query($myInsQuery);
		}
	}
}

//Query Blue Side Data
$result = mysql_query("
SELECT PlayerInfo.PlayerID, 
PlayerInfo.ScreenName,  
Champion.JointChampionName,
Player.Kills, 
Player.Deaths, 
Player.Assists,
Player.Lane,
Team.TeamName
FROM Player
JOIN PlayerInfo ON Player.PlayerId = PlayerInfo.PlayerId
JOIN Game ON Game.GameID = Player.GameID
JOIN Champion ON Champion.ChampionID = Player.ChampionID
JOIN Team ON Player.TeamID = Team.TeamID
WHERE Game.GameID = $GameID AND Game.TeamAID = Player.TeamID
ORDER BY Player.Lane ASC
");
while ($row = mysql_fetch_array($result)) {
	$b_PlayerID[] = $row['PlayerID'];
	$b_ScreenName[] = $row['ScreenName'];
	$b_JointChampionName[] = $row['JointChampionName'];
	$b_Kills[] = $row['Kills'];
	$b_Deaths[] = $row['Deaths'];
	$b_Assists[] = $row['Assists'];
	$b_Lane[] = $row['Lane'];
	$b_TeamName[] = $row['TeamName'];
}

//Query Red Side Data
$result = mysql_query("
SELECT PlayerInfo.PlayerID, 
PlayerInfo.ScreenName,  
Champion.JointChampionName,
Player.Kills, 
Player.Deaths, 
Player.Assists,
Player.Lane,
Team.TeamName
FROM Player
JOIN PlayerInfo ON Player.PlayerId = PlayerInfo.PlayerId
JOIN Game ON Game.GameID = Player.GameID
JOIN Champion ON Champion.ChampionID = Player.ChampionID
JOIN Team ON Player.TeamID = Team.TeamID
WHERE Game.GameID = $GameID AND Game.TeamBID = Player.TeamID
ORDER BY Player.Lane ASC
");
while ($row = mysql_fetch_array($result)) {
	$r_PlayerID[] = $row['PlayerID'];
	$r_ScreenName[] = $row['ScreenName'];
	$r_JointChampionName[] = $row['JointChampionName'];
	$r_Kills[] = $row['Kills'];
	$r_Deaths[] = $row['Deaths'];
	$r_Assists[] = $row['Assists'];
	$r_Lane[] = $row['Lane'];
	$r_TeamName[] = $row['TeamName'];
}

?>


</head>

<body>
  <div id="whitebox">
    <div class="caption">
      <strong>Update KDA</strong>
    </div>
    <form method="post" action="UpdateKDA.php">
    <?php
		
    if (!$GameIDerror){
			echo "<strong><span class=\"blue_text\">$b_TeamName[0]</span> VS <span class=\"red_text\">$r_TeamName[0]</span></strong><br />\n";
			
			echo '<div class="FloatBox KDA">'."\n";
			echo '<table><tr><td width="200">Player</td><td>Kills</td><td>Deaths</td><td>Assists</td></tr>'."\n";
			showTable($b_ScreenName, $b_JointChampionName, $b_Kills, $b_Deaths, $b_Assists);
			echo '</table>'."\n";
			echo '</div>'."\n";
			
			echo '<div class="FloatBox KDA">'."\n";
			echo '<table><tr><td width="200">Player</td><td>Kills</td><td>Deaths</td><td>Assists</td></tr>'."\n";
			showTable($r_ScreenName, $r_JointChampionName, $r_Kills, $r_Deaths, $r_Assists);
			echo '</table>'."\n";
			echo '</div>'."\n";
			
			echo '<div id="contClear"></div>'."\n";
				
			//relay old values for comparison
			for ($i = 0; $i < 5; $i++){
				echo '<input type="hidden" name="OldKills[]" value="'.$b_Kills[$i].'">'."\n";
			}
			for ($i = 0; $i < 5; $i++){
				echo '<input type="hidden" name="OldKills[]" value="'.$r_Kills[$i].'">'."\n";
			}
			for ($i = 0; $i < 5; $i++){
				echo '<input type="hidden" name="OldDeaths[]" value="'.$b_Deaths[$i].'">'."\n";
			}
			for ($i = 0; $i < 5; $i++){
				echo '<input type="hidden" name="OldDeaths[]" value="'.$r_Deaths[$i].'">'."\n";
			}
			for ($i = 0; $i < 5; $i++){
				echo '<input type="hidden" name="OldAssists[]" value="'.$b_Assists[$i].'">'."\n";
			}
			for ($i = 0; $i < 5; $i++){
				echo '<input type="hidden" name="OldAssists[]" value="'.$r_Assists[$i].'">'."\n";
			}
			for ($i = 0; $i < 5; $i++){
				echo '<input type="hidden" name="OldPlayerID[]" value="'.$b_PlayerID[$i].'">'."\n";
			}
			for ($i = 0; $i < 5; $i++){
				echo '<input type="hidden" name="OldPlayerID[]" value="'.$r_PlayerID[$i].'">'."\n";
			}
			echo '<input type="hidden" name="GameID" value="'.$GameID.'" />';
			echo '<input type="submit" />';
		}
		else{
			echo "No GameID Sent";
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

function showTable($SN, $CN, $Kills, $Deaths, $Assists){
	$max = sizeof($CN);
	for ($i = 0; $i < $max; $i++){
		echo "<tr>\n";
		echo '<td><img src="../ChampIcons/36px-'.$CN[$i].'Square.png" width="20" height="20" />'.$SN[$i].'</td>'."\n";
		echo '<td><input type="number" value="'.$Kills[$i].'" name="NewKills[]" min="0" max="99" /></td>'."\n";
		echo '<td><input type="number" value="'.$Deaths[$i].'" name="NewDeaths[]" min="0" max="99" /></td>'."\n";
		echo '<td><input type="number" value="'.$Assists[$i].'" name="NewAssists[]" min="0" max="99" /></td>'."\n";
		echo "</tr>\n";		
	}
}



?>







