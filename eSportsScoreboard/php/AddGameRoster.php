<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AddGameRoster</title>
<link href="Admin.css" rel="stylesheet" type="text/css" />

<?php

//Set Predefined Variables
$GameID=0;
$BlueTeamID=0;
$RedTeamID=0;
$date=0;
$time=0;
$seriesgame=0;
$season=0;
$tournament=0;
$senderror=0;

$positionArray = array('TOP','JNG','MID','ADC','SUP');
$teamArray = array('Blue','Red');

//Get Posted Variables
if (isset($_POST['GameID'])) $GameID = $_POST['GameID'];
else $senderror=1;
if (isset($_POST['BlueTeamID'])) $BlueTeamID = $_POST['BlueTeamID'];
else $senderror=2;
if (isset($_POST['RedTeamID'])) $RedTeamID = $_POST['RedTeamID'];
else $senderror=3;
if (isset($_POST['date'])) $date = $_POST['date'];
else $senderror=4;
if (isset($_POST['time'])) $time = $_POST['time'];
else $senderror=5;
if (isset($_POST['seriesgame'])) $seriesgame = $_POST['seriesgame'];
else $senderror=6;
if (isset($_POST['season'])) $season = $_POST['season'];
else $senderror=7;
if (isset($_POST['tournament'])) $tournament = $_POST['tournament'];
else $senderror=8;

//Login to Database
require_once 'login.php';
mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($dbname);

//SQL Queries
$result = mysql_query("SELECT PlayerID FROM PlayerInfo WHERE TeamID = $BlueTeamID");
while ($row = mysql_fetch_array($result)) {
	$BlueID[] = $row['PlayerID'];
}
$result = mysql_query("SELECT ScreenName FROM PlayerInfo WHERE TeamID = $BlueTeamID");
while ($row = mysql_fetch_array($result)) {
	$BlueSN[] = $row['ScreenName'];
}
$result = mysql_query("SELECT PlayerID FROM PlayerInfo WHERE TeamID = $RedTeamID");
while ($row = mysql_fetch_array($result)) {
	$RedID[] = $row['PlayerID'];
}
$result = mysql_query("SELECT ScreenName FROM PlayerInfo WHERE TeamID = $RedTeamID");
while ($row = mysql_fetch_array($result)) {
	$RedSN[] = $row['ScreenName'];
}

//SQL Inserts
$myInsQuery = "INSERT INTO `LoLStatsTest2`.`Game` (`GameID`, `TeamAID`, `TeamBID`, `GameState`, `GameDate`, `GameTime`, `Season`, `Tournament`, `BestOfGame`, `Winner`, `GameLength`) VALUES ($GameID, '$BlueTeamID', '$RedTeamID', '1', '$date', '$time', '$season', '$tournament', '$seriesgame', '0', '00:00');";
if($senderror==0)	 { 
  $result = mysql_query($myInsQuery);
  if (!$result) die ("Database access failed: " . mysql_error());
}
?>

</head>
<body>

  <div id="whitebox">
    <div class="caption">
      <strong>Update Game Roster</strong>
    </div>
  <form method="post" action="FinalizeGame.php">
  <table border="0" cellspacing="0">
    <tr>
      <td>Position</td>
      <td>Blue Team</td>
      <td>Red Team</td>
    </tr>
    <?php
	  /*
	  Run a for loop through each position
	    Run a for loop for each team
		  determine which team is being handled and set max to equal the number of player on that team
		  Run a for loop for each player on that team
		    if the player in the team is the started of the current position mark him as "selected"
	  */
    for($position = 0; $position < 5; $position++){ 
   	  echo"<tr>\n";
	  echo"<td>$positionArray[$position]</td>";
	  for($team = 0; $team < 2; $team++){
	    echo"<td><select name=\"$teamArray[$team]$positionArray[$position]\">";
		if($team == 0) $max = sizeof($BlueSN);
		else $max = sizeof($RedSN);
		for($val = 0; $val< $max; $val++){
		  if($val == $position) echo "<option selected = \"selected\" ";
		  else echo "<option ";  
		  if($team == 0) echo "value=\"$BlueID[$val]\">$BlueSN[$val]</option>\n";
		  else echo "value=\"$RedID[$val]\">$RedSN[$val]</option>\n";
		}
		echo"</select>\n</td>\n";
	  }
	  echo"</tr>\n";
	}
    ?>
    <tr>
      <td><input type="hidden" name="GameID" value="<?php echo $GameID; ?>" /></td>
      <td></td>
      <td><input type="submit" /></td>
    </tr>
  </table>
  </form>
</div>
</body>
</html>