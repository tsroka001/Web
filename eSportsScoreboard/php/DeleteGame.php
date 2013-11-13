<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Delete Game</title>
<link href="Admin.css" rel="stylesheet" type="text/css" />
<?php

require_once 'login.php';
mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($dbname);

if (isset($_POST['GameID'])) $GameID = $_POST['GameID'];

$myInsQuery = "DELETE FROM `LoLStatsTest2`.`Player` WHERE `GameID`='$GameID';";
$result = mysql_query($myInsQuery);
$myInsQuery = "DELETE FROM `LoLStatsTest2`.`Game` WHERE `GameID`='$GameID';";
$result = mysql_query($myInsQuery);
$myInsQuery = "DELETE FROM `LoLStatsTest2`.`PickOrder` WHERE `GameID`='$GameID';";
$result = mysql_query($myInsQuery);
$myInsQuery = "DELETE FROM `LoLStatsTest2`.`GPItems` WHERE `GameID` = '$GameID';";
$result = mysql_query($myInsQuery);
$myInsQuery = "DELETE FROM `LoLStatsTest2`.`TowerHealth` WHERE `GameID`='$GameID';";
$result = mysql_query($myInsQuery);
$myInsQuery = "DELETE FROM `LoLStatsTest2`.`Assists` WHERE `GameID`='$GameID';";
$result = mysql_query($myInsQuery);
$myInsQuery = "DELETE FROM `LoLStatsTest2`.`Plays` WHERE `GameID`='$GameID';";
$result = mysql_query($myInsQuery);
$myInsQuery = "DELETE FROM `LoLStatsTest2`.`Objectives` WHERE `GameID`='$GameID';";
$result = mysql_query($myInsQuery);
?>
</head>

<body>
  <div id="whitebox">
    <div class="caption">
      <strong>Delete Game</strong>
    </div>
    <p>Game <?php echo $GameID; ?> deleted!</p>
    <form method="post" action="AdminPanel.php">
    <input type="submit" value="Admin Panel"/>
    </form>
  </div>
</body>
</html>
