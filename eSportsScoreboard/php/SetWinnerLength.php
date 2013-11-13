<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Winner/Length Update</title>
<link href="Admin.css" rel="stylesheet" type="text/css" />
<?php

$GameIDPostError = false;
$WinnerPostError = false;
$LengthPostError = false;

if (isset($_POST['GameID'])) $GameID = $_POST['GameID'];
else $GameIDPostError = true;
if (isset($_POST['Winner'])) $SetWinner = $_POST['Winner'];
else $WinnerPostError = true;
if (isset($_POST['Length'])) $SetLength = $_POST['Length'];
else $LengthPostError = true;

require_once 'login.php';
mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($dbname);
if (!$GameIDPostError && !$WinnerPostError && !$LengthPostError){
	//SQL Updates
	mysql_query("UPDATE `LoLStatsTest2`.`Game` SET `Winner`='$SetWinner', `GameLength`='$SetLength' WHERE `GameID`='$GameID';");
}
//Get GameData
$result = mysql_query("
SELECT Winner, 
GameLength, 
TeamA.TeamName AS TeamA, 
TeamB.TeamName AS TeamB, 
TeamA.TeamID AS TeamAID, 
TeamB.TeamID AS TeamBID
FROM Game
JOIN Team AS TeamA ON TeamA.TeamID = Game.TeamAID
JOIN Team AS TeamB ON TeamB.TeamID = Game.TeamBID
WHERE GameID = $GameID
");
while ($row = mysql_fetch_array($result)) {
	$Winner = $row['0'];
	$Length = $row['1'];
	$TeamA = $row['2'];
	$TeamB = $row['3'];
	$TeamAID = $row['4'];
	$TeamBID = $row['5'];
}

?>
</head>

<body>
  <div id="whitebox">
    <div class="caption">
      <strong>Winner/Length Update</strong>
    </div>
    <form method="post" action="SetWinnerLength.php">    
    <table>
    <tr>
    <td>Winner</td>
    <td><select name="Winner">
    	<option <?php if ($Winner[0] == $TeamAID){echo "selected=\"selected\"";}?> value="<?php echo $TeamAID;?>"><?php echo $TeamA;?></option>
			<option <?php if ($Winner[0] == $TeamBID){echo "selected=\"selected\"";}?> value="<?php echo $TeamBID;?>"><?php echo $TeamB;?></option>
      </select>
    </td>
    </tr>
    <tr>
    <td>Time</td>
    <td><input name="Length" value="<?php echo $Length;?>"/></td>
    </tr>
    <tr><input type="hidden" name="GameID" value="<?php echo $GameID;?>" />
    <td>
    </td>
    <td><input type="submit" value="Submit" style="width:160px"/>
    </td></form>
    </tr>
    </table>  
    
     <div class="quickEscape">
      <form method="post" action="AdminPanel.php">
        <input type="submit" value="Admin Panel" style="width:193px"/>
      </form>
    </div>        
	</div>
</body>
</html>