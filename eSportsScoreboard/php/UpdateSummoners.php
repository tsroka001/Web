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

$senderror = 0;

if (isset($_POST['GameID'])) $GameID = $_POST['GameID'];
else $senderror=1;

if (isset($_POST['Player0A'])) $Player0A = $_POST['Player0A'];
else $senderror=1;
if (isset($_POST['Player1A'])) $Player1A = $_POST['Player1A'];
else $senderror=1;
if (isset($_POST['Player2A'])) $Player2A = $_POST['Player2A'];
else $senderror=1;
if (isset($_POST['Player3A'])) $Player3A = $_POST['Player3A'];
else $senderror=1;
if (isset($_POST['Player4A'])) $Player4A = $_POST['Player4A'];
else $senderror=1;
if (isset($_POST['Player5A'])) $Player5A = $_POST['Player5A'];
else $senderror=1;
if (isset($_POST['Player6A'])) $Player6A = $_POST['Player6A'];
else $senderror=1;
if (isset($_POST['Player7A'])) $Player7A = $_POST['Player7A'];
else $senderror=1;
if (isset($_POST['Player8A'])) $Player8A = $_POST['Player8A'];
else $senderror=1;
if (isset($_POST['Player9A'])) $Player9A = $_POST['Player9A'];
else $senderror=1;
if (isset($_POST['Player0B'])) $Player0B = $_POST['Player0B'];
else $senderror=1;
if (isset($_POST['Player1B'])) $Player1B = $_POST['Player1B'];
else $senderror=1;
if (isset($_POST['Player2B'])) $Player2B = $_POST['Player2B'];
else $senderror=1;
if (isset($_POST['Player3B'])) $Player3B = $_POST['Player3B'];
else $senderror=1;
if (isset($_POST['Player4B'])) $Player4B = $_POST['Player4B'];
else $senderror=1;
if (isset($_POST['Player5B'])) $Player5B = $_POST['Player5B'];
else $senderror=1;
if (isset($_POST['Player6B'])) $Player6B = $_POST['Player6B'];
else $senderror=1;
if (isset($_POST['Player7B'])) $Player7B = $_POST['Player7B'];
else $senderror=1;
if (isset($_POST['Player8B'])) $Player8B = $_POST['Player8B'];
else $senderror=1;
if (isset($_POST['Player9B'])) $Player9B = $_POST['Player9B'];
else $senderror=1;

$result = mysql_query("
SELECT Player.PlayerID
FROM Player
JOIN PlayerInfo ON Player.PlayerID = PlayerInfo.PlayerID
WHERE Player.GameID = $GameID;
");
while ($row = mysql_fetch_array($result)) {
	$PlayerID[] = $row['PlayerID'];
}

if( $senderror == 0){
	mysql_query("UPDATE `LoLStatsTest2`.`Player` SET `SummonerA`='$Player0A', `SummonerB`='$Player0B' WHERE `GameID`='$GameID' and`PlayerID`='$PlayerID[0]';");
	mysql_query("UPDATE `LoLStatsTest2`.`Player` SET `SummonerA`='$Player1A', `SummonerB`='$Player1B' WHERE `GameID`='$GameID' and`PlayerID`='$PlayerID[1]';");
	mysql_query("UPDATE `LoLStatsTest2`.`Player` SET `SummonerA`='$Player2A', `SummonerB`='$Player2B' WHERE `GameID`='$GameID' and`PlayerID`='$PlayerID[2]';");
	mysql_query("UPDATE `LoLStatsTest2`.`Player` SET `SummonerA`='$Player3A', `SummonerB`='$Player3B' WHERE `GameID`='$GameID' and`PlayerID`='$PlayerID[3]';");
	mysql_query("UPDATE `LoLStatsTest2`.`Player` SET `SummonerA`='$Player4A', `SummonerB`='$Player4B' WHERE `GameID`='$GameID' and`PlayerID`='$PlayerID[4]';");
	mysql_query("UPDATE `LoLStatsTest2`.`Player` SET `SummonerA`='$Player5A', `SummonerB`='$Player5B' WHERE `GameID`='$GameID' and`PlayerID`='$PlayerID[5]';");
	mysql_query("UPDATE `LoLStatsTest2`.`Player` SET `SummonerA`='$Player6A', `SummonerB`='$Player6B' WHERE `GameID`='$GameID' and`PlayerID`='$PlayerID[6]';");
	mysql_query("UPDATE `LoLStatsTest2`.`Player` SET `SummonerA`='$Player7A', `SummonerB`='$Player7B' WHERE `GameID`='$GameID' and`PlayerID`='$PlayerID[7]';");
	mysql_query("UPDATE `LoLStatsTest2`.`Player` SET `SummonerA`='$Player8A', `SummonerB`='$Player8B' WHERE `GameID`='$GameID' and`PlayerID`='$PlayerID[8]';");
	mysql_query("UPDATE `LoLStatsTest2`.`Player` SET `SummonerA`='$Player9A', `SummonerB`='$Player9B' WHERE `GameID`='$GameID' and`PlayerID`='$PlayerID[9]';");
}

$result = mysql_query("
SELECT PlayerInfo.ScreenName, Player.SummonerA, Player.SummonerB
FROM Player
JOIN PlayerInfo ON Player.PlayerID = PlayerInfo.PlayerID
WHERE Player.GameID = $GameID;
");
while ($row = mysql_fetch_array($result)) {
	$ScreenName[] = $row['ScreenName'];
	$SummonerA[] = $row['SummonerA'];
	$SummonerB[] = $row['SummonerB'];
}

$result = mysql_query("
SELECT Summoner
FROM Summoners;
");
while ($row = mysql_fetch_array($result)) {
	$Summoners[] = $row['Summoner'];
}




echo <<<END
</head>

<body>
  <div id="whitebox">
    <div class="caption">
      <strong>Update Summoners</strong>
    </div>
<form method="post" action="UpdateSummoners.php">
<table>
<tr>
<td>Player</td>
<td>SummonerA</td>
<td>SummonerB</td>
</tr>
END;


$max = sizeof($Summoners);
for($val = 0; $val< 10; $val++){

	echo "<tr>\n";
	echo "<td>$ScreenName[$val]</td>\n";
	echo "<td> <select name=\"Player".$val."A\"> \n";
	  for($var = 0; $var< $max; $var++){
		  echo "<option ";
		  if ($SummonerA[$val] == $Summoners[$var]){
			 echo " selected=\"selected\"";
		  }
		  echo " value=\"$Summoners[$var]\">$Summoners[$var]\n";
	  }
	echo "</select></td>\n";
	echo "<td> <select name=\"Player".$val."B\"> \n";
	  for($var = 0; $var< $max; $var++){
		  echo "<option ";
		  if ($SummonerB[$val] == $Summoners[$var]){
			 echo " selected=\"selected\"";
		  }
		  echo " value=\"$Summoners[$var]\">$Summoners[$var]\n";
	  }
	echo "</select></td>\n";
	echo "</tr>\n";
}
echo <<<END
</table>
<input type="hidden" name="GameID" value="$GameID" />
<input type="submit" />
</form>
<form method="post" action="AdminPanel.php">
<input type="submit" value="Admin Panel"/>
</form>
<div class="sql">
SQL executed
</div>
</div>
</body>
END;
?>
</html>