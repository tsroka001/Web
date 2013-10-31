<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CreateGame</title>
<link href="Admin.css" rel="stylesheet" type="text/css" />
</head>

<?php
require_once 'login.php';
mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($dbname);

//fetch names of teams from database
$result = mysql_query("SELECT TeamID, TeamName FROM Team");
while ($row = mysql_fetch_array($result)) {
	$TeamID[] = $row['TeamID'];
	$TeamName[] = $row['TeamName'];
}

//fetch numbner of games entered into database 
//in order to chose a new unique game id to enter
$result = mysql_query("SELECT GameID FROM Game");
while ($row = mysql_fetch_array($result)) {
	$GameID[] = $row['GameID'];
}
?>

<body>
<div id="whitebox">
  <div class="caption">
  <strong>Create Game</strong>
  </div>
<form method="post" action="AddGameRoster.php">
<table border="0" cellspacing="0">
  <tbody>
    <tr>
      <td>MatchID (<?php echo (sizeof($GameID)+1);?> ):</td>
      <td><input type="text" name="GameID" value="<?php echo (sizeof($GameID)+1);?>"/></td>
    </tr>
    <tr>
      <td>Blue Team:</td>
      <td><select name="BlueTeamID"><br />
		<?php 
          $max = sizeof($TeamID);
          for($val = 0; $val< $max; $val++){
          echo "<option value=\"".($val+1)."\">$TeamName[$val]</option>\n";
          }
        ?>
        </select></td>
    </tr>
    <tr>
      <td>Red Team: <br /></td>
      <td><select name="RedTeamID">
		<?php 
          $max = sizeof($TeamID);
          for($val = 0; $val< $max; $val++){
          echo "<option value=\"".($val+1)."\">$TeamName[$val]</option>\n";
          }
        ?>
        </select></td>
    </tr>
    <tr>
      <td>Game Date:</td>
      <td><input type="date" name="date" /></td>
    </tr>
    <tr>
      <td>Game Time:</td>
      <td><input type="time" name="time" /></td>
    </tr>
    <tr>
      <td>Series:</td>
      <td><input type="number" name="seriesgame" size = "1" value="1"/> of <input type="number" name="serieslength" size = "1" value="1"/></td>
    </tr>
    <tr>
      <td>Season:</td>
      <td><input type="number" name="season" value="3"/></td>
    </tr>
    <tr>
      <td>Tournament:</td>
      <td><input type="text" name="tournament" value="LCS NA"/></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" /></td>
    </tr>
  </tbody>
</table>
</form>
</div>
</body>
</html>