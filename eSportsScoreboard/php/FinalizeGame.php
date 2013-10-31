<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Finalize Game</title>
<link href="Admin.css" rel="stylesheet" type="text/css" />

<?php

$playerList = array();
$positionArray = array('TOP','JNG','MID','ADC','SUP');

require_once 'login.php';
mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($dbname);

if (isset($_POST['BlueTOP'])) $playerList[0] = $_POST['BlueTOP'];
else $senderror=1;
if (isset($_POST['BlueJNG'])) $playerList[1] = $_POST['BlueJNG'];
else $senderror=1;
if (isset($_POST['BlueMID'])) $playerList[2] = $_POST['BlueMID'];
else $senderror=1;
if (isset($_POST['BlueADC'])) $playerList[3] = $_POST['BlueADC'];
else $senderror=1;
if (isset($_POST['BlueSUP'])) $playerList[4] = $_POST['BlueSUP'];
else $senderror=1;
if (isset($_POST['RedTOP'])) $playerList[5] = $_POST['RedTOP'];
else $senderror=1;
if (isset($_POST['RedJNG'])) $playerList[6] = $_POST['RedJNG'];
else $senderror=1;
if (isset($_POST['RedMID'])) $playerList[7] = $_POST['RedMID'];
else $senderror=1;
if (isset($_POST['RedADC'])) $playerList[8] = $_POST['RedADC'];
else $senderror=1;
if (isset($_POST['RedSUP'])) $playerList[9] = $_POST['RedSUP'];
else $senderror=1;

if (isset($_POST['GameID'])) $GameID = $_POST['GameID'];
else $senderror=1;

//create player entires
for($player = 0; $player <10; $player++){
  $playerPos = ($player % 5);
  $myInsQuery = "INSERT INTO `LoLStatsTest2`.`Player` (`GameID`, `PlayerID`, `ChampionID`, `Kills`, `Deaths`, `Assists`, `Level`, `CreepScore`, `Gold`, `Towers`, `Lane`) VALUES ($GameID, $playerList[$player], 0, 0, 0, 0, 1, 0, '*', 0, '$positionArray[$playerPos]');";
  $iq1[$player] = $myInsQuery;
	$result = mysql_query($myInsQuery);
}

//Create Bans
for($item = 1; $item <17; $item++){
  $myInsQuery = "INSERT INTO `LoLStatsTest2`.`PickOrder` (`GameID`, `PickID`, `ChampionID`) VALUES ($GameID, '$item', '0');";
  $iq2[$item] = $myInsQuery;
	$result = mysql_query($myInsQuery);
}

//create item files
$z = 0;
for($player = 0; $player <10; $player++){
  for($val = 1; $val< 7; $val++){
    $myInsQuery = "INSERT INTO `LoLStatsTest2`.`GPItems` (`GameID`, `PlayerID`, `ItemSlot`, `ItemID`) VALUES ($GameID, $playerList[$player], $val, 1);";
    $iq3[$z] = $myInsQuery;
		$z++;
		$result = mysql_query($myInsQuery);
  }
}

//Create Tower Health Table
for($tower = 1; $tower < 31; $tower++){
	$myInsQuery = "INSERT INTO `LoLStatsTest2`.`TowerHealth` (`GameID`, `TowerID`, `TowerHealth`) VALUES ($GameID, $tower, 100);";
	$iq4[$tower] = $myInsQuery;
	$result = mysql_query($myInsQuery);
}

?>

</head>
<body>
  <div id="whitebox">
    <div class="caption">
      <strong>Finalize Game</strong>
    </div>
    <form method="post" action="Match.php?gameID=<?php echo $GameID;?>">
      <input type="submit" value="View Game"/>
    </form>
    <br/>
    <form method="post" action="InsertPlay.php">
      <input type="hidden" name="GameID" value="<?php echo $GameID;?>" />
    <input type="submit" value="Enter Plays Here"/>
    </form>
    <br/>
    <form method="post" action="AdminPanel.php">
      <input type="submit" value="Admin Panel"/>
    </form>
    <div class="sql">
			<?php
      foreach ($iq1 as $out){
        echo $out."</br>\n";
      }
      foreach ($iq2 as $out){
        echo $out."</br>\n";
      }
      foreach ($iq3 as $out){
        echo $out."</br>\n";
      }
      foreach ($iq4 as $out){
        echo $out."</br>\n";
      }
		?>
    </div>
  </div>
</body>
</html>