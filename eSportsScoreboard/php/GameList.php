<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="Admin.css" rel="stylesheet" type="text/css" />

<?php

require_once 'login.php';
mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($dbname);

$result = mysql_query("
	SELECT Game.GameID, BlueTeam.TeamName AS Blue, RedTeam.TeamName AS Red, Game.GameState, WinTeam.TeamName AS Winner, Game.GameTime, Game.GameDate, Game.Tournament, Game.Region, Game.GameLength
	FROM Game
	JOIN Team AS BlueTeam ON BlueTeam.TeamID = Game.TeamAID
	JOIN Team AS RedTeam ON RedTeam.TeamID = Game.TeamBID
	JOIN Team AS WinTeam ON WinTeam.TeamID = Game.Winner
	");
while ($row = mysql_fetch_array($result)) {
	$GameID[] = $row['GameID'];
	$BlueTeam[] = $row['Blue'];
	$RedTeam[] = $row['Red'];
	$GameDate[] = $row['GameDate'];
	$GameTime[] = $row['GameTime'];
	$Winner[] = $row['Winner'];
	$GameState[] = $row['GameState'];
	$Torunament[] = $row['Tournament'];
	$Region[] = $row['Region'];
	$GameLength[] = $row['GameLength'];
}



?>



</head>
<body>
  <div id="whitebox">
    <div class="caption">
      <strong>Finalize Game</strong>
    </div>
		
    <table cellpadding="6px">
    <thead>
    <tr>
    <td>GameID</td>
    <td>Blue Team</td>
    <td>Red Team</td>
    <td>Game Date</td>
    <td>Game Time</td>
    <td>Game Winner</td>
    <td>Game State</td>
    <td>Torunament</td>
    <td>Region</td>
    <td>GameLength</td>
    </tr>
    </thead>
    <tbody>
    <?php
		$max = sizeof($GameID);
		for($i = 0; $i < $max; $i++){
			echo "<tr>";
			echo "<td>$GameID[$i]</td>";
			echo "<td>$BlueTeam[$i]</td>";
			echo "<td>$RedTeam[$i]</td>";
			echo "<td>$GameDate[$i]</td>";
			echo "<td>$GameTime[$i]</td>";
			echo "<td>$Winner[$i]</td>";
			echo "<td>$GameState[$i]</td>";
			echo "<td>$Torunament[$i]</td>";
			echo "<td>$Region[$i]</td>";
			echo "<td>$GameLength[$i]</td>";
			echo "</tr>";
		}
    ?>
    
    </tbody>
    </table>
    
    </div>
  </div>
</body>
</html>