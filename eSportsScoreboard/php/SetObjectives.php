<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Set Objectives</title>
<link href="Admin.css" rel="stylesheet" type="text/css" />
<?php

$senderror = false;
//Get Posted Variables
if (isset($_POST['GameID'])) $GameID = $_POST['GameID'];
else $senderror=true;
if (isset($_POST['Team'])) $Team = $_POST['Team'];
else $senderror=true;
if (isset($_POST['ObjID'])) $ObjID = $_POST['ObjID'];
else $senderror=true;
if (isset($_POST['Type'])) $Type = $_POST['Type'];
else $senderror=true;
if (isset($_POST['Time'])) $Time = $_POST['Time'];
else $senderror=true;

//Login to Database
require_once 'login.php';
mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($dbname);

//Query Objectives Count
$result = mysql_query("
SELECT (COUNT(Type)+1) AS Num FROM Objectives WHERE GameID = $GameID
");
while ($row = mysql_fetch_array($result)) {
	$NumObj = $row['0'];
}

//If all values posted successfully execute sql insert
if(!$senderror){
	$myInsQuery = "INSERT INTO `LoLStatsTest2`.`Objectives` (`GameID`, `TeamID`, `ObjID`, `Type`, `Time`) VALUES ($GameID, '$Team', '$ObjID', '$Type', '$Time');";
	mysql_query($myInsQuery);
}

//fetch names of teams from database
$result = mysql_query("
(SELECT Team.TeamID, Team.TeamName
FROM Team
JOIN Game ON Game.TeamAID = Team.TeamID
WHERE GameID = $GameID)
UNION ALL
(SELECT Team.TeamID, Team.TeamName
FROM Team
JOIN Game ON Game.TeamBID = Team.TeamID
WHERE GameID = $GameID)
");
while ($row = mysql_fetch_array($result)) {
	$TeamID[] = $row['TeamID'];
	$TeamName[] = $row['TeamName'];
}


?>

</head>

<body>
  <div id="whitebox">
    <div class="caption">
      <strong>Update Player Subs</strong>
    </div>
    <?php echo "GameID: $GameID";?>
		<form method="post" action="SetObjectives.php">
    <table>
    <thead>
    <tr>
    <td>Team</td>
    <td>Type</td>
    <td>Time</td>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td><select name="Team">
       		<?php 
							echo "\n";
              $max = sizeof($TeamID);
              for($val = 0; $val< $max; $val++){
              echo "<option value=\"$TeamID[$val]\">$TeamName[$val]</option>\n";
              }
          ?>
        </select></td>
    <td><select name="Type">
       		<option value = "Dragon">Dragon</option>
          <option value = "Baron">Baron</option>
          <option value = "Tower">Tower</option>
          <option value = "Inhibitor">Inhibitor</option>
          <option value = "First Blood">First Blood</option>
        </select></td>
    <td><input type="text" name="Time" value="00:00"/></td>
    </tr>
    <tr>
    <td><input type="hidden" name="ObjID" value="<?php echo $NumObj; ?>" /></td>
    <td><input type="hidden" name="GameID" value="<?php echo $GameID; ?>" /></td>
    <td><input type="submit" /></td>
    </tr>
    </tbody>
    </table>
    </form>
    <div class="quickEscape">
      <form method="post" action="AdminPanel.php">
        <input type="submit" value="Admin Panel" style="width:193px"/>
      </form>
    </div>
	</div>

</body>
</html>