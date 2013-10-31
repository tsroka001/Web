<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pick Order</title>
<link href="Admin.css" rel="stylesheet" type="text/css" />

<?php

	$GameIDPostError = false;
	$ChampionPostError = false;
	
	if (isset($_POST['GameID'])) $GameID = $_POST['GameID'];
	else $GameIDPostError = true;
	if (isset($_POST['Champion'])) $Champion = $_POST['Champion'];
	else $ChampionPostError = true;
	
	require_once 'login.php';
	mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
	mysql_select_db($dbname);
	
  //update picks
  if(!$ChampionPostError){
		for ($val = 0; $val < 16; $val++){
		  mysql_query("UPDATE `LoLStatsTest2`.`PickOrder` SET `ChampionID`='$Champion[$val]' WHERE `GameID`='$GameID' and`PickID`='".(1+$val)."';");
	  	$iq1[$val] = "UPDATE `LoLStatsTest2`.`PickOrder` SET `ChampionID`='$Champion[$val]' WHERE `GameID`='$GameID' and`PickID`='".(1+$val)."';";
		}
	}
	//Get all champion Names
	$result = mysql_query("
	SELECT Champion.ChampionID, Champion.ChampionName
	FROM Champion
	ORDER BY ChampionName;
	");
	while ($row = mysql_fetch_array($result)) {
		$ChampionID[] = $row['ChampionID'];
		$ChampionName[] = $row['ChampionName'];
	}
	//Get Current Picks
	$result = mysql_query("
	SELECT Champion.ChampionID
	FROM Champion
	JOIN PickOrder ON PickOrder.ChampionID = Champion.ChampionID
	WHERE PickOrder.GameID = $GameID;
	");
	while ($row = mysql_fetch_array($result)) {
		$Pick[] = $row['ChampionID'];
	}
	
	$max = sizeof($ChampionID);

	function EchoOptions($pid){

		global $max, $ChampionID, $ChampionName, $Pick;
		for ($num = 0; $num < $max; $num++){
			echo "<option ";
			if ($ChampionID[$num] == $Pick[$pid]){
				echo "selected=\"selected\"";
			}
			echo "value = '$ChampionID[$num]'> $ChampionName[$num]</option>\n";
		}	
	}

?>
</head>

<body>

<div id="whitebox">
<div class="caption">
<strong>Picks Stage</strong>
</div>
<form method="post" action="PickOrder.php">

<table border="0" cellspacing=0 cellpadding=0>
<tr>
<td></td>
<td style: width="110px"><center>Blue Team</center></td>
<td style: width="110px"><center>Red Team</center></td>
</tr>

<tr>
<td class="blue_text">Ban</td>
<td><select name="Champion[]"><?php EchoOptions(0);?></select></td>
<td></td>
</tr>

<tr>
<td class="red_text">Ban</td>
<td></td>
<td><select name="Champion[]"><?php EchoOptions(1);?></select></td>
</tr>

<tr>
<td class="blue_text">Ban</td>
<td><select name="Champion[]"><?php EchoOptions(2);?></select></td>
<td></td>
</tr>

<tr>
<td class="red_text">Ban</td>
<td></td>
<td><select name="Champion[]"><?php EchoOptions(3);?></select></td>
</tr>

<tr>
<td class="blue_text">Ban</td>
<td><select name="Champion[]"><?php EchoOptions(4);?></select></td>
<td></td>
</tr>

<tr>
<td class="red_text">Ban</td>
<td></td>
<td><select name="Champion[]"><?php EchoOptions(5);?></select></td>
</tr>

<tr>
<td class="blue_text">Pick</td>
<td><select name="Champion[]"><?php EchoOptions(6);?></select></td>
<td></td>
</tr>

<tr>
<td class="red_text">Pick</td>
<td></td>
<td><select name="Champion[]"><?php EchoOptions(7);?></select></td>
</tr>

<tr>
<td class="red_text">Pick</td>
<td></td>
<td><select name="Champion[]"><?php EchoOptions(8);?></select></td>
</tr>

<tr>
<td class="blue_text">Pick</td>
<td><select name="Champion[]"><?php EchoOptions(9);?></select></td>
<td></td>
</tr>

<tr>
<td class="blue_text">Pick</td>
<td><select name="Champion[]"><?php EchoOptions(10);?></select></td>
<td></td>
</tr>

<tr>
<td class="red_text">Pick</td>
<td></td>
<td><select name="Champion[]"><?php EchoOptions(11);?></select></td>
</tr>

<tr>
<td class="red_text">Pick</td>
<td></td>
<td><select name="Champion[]"><?php EchoOptions(12);?></select></td>
</tr>

<tr>
<td class="blue_text">Pick</td>
<td><select name="Champion[]"><?php EchoOptions(13);?></select></td>
<td></td>
</tr>

<tr>
<td class="blue_text">Pick</td>
<td><select name="Champion[]"><?php EchoOptions(14);?></select></td>
<td></td>
</tr>

<tr>
<td class="red_text">Pick</td>
<td></td>
<td><select name="Champion[]"><?php EchoOptions(15);?></select></td>
</tr>

</table>

<input type="hidden" name="GameID" value="<?php echo $GameID;?>" />
	<input type="submit" style="width:160px" />
</form>

<form method="post" action="AdminPanel.php">
  <input type="submit" value="Admin Panel" style="width:160px"/>
</form>
		<div class="sql">
			<?php
      foreach ($iq1 as $out){
        echo $out."</br>\n";
      }
		?>
    </div>
</div>
</body>
</html>