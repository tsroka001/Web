<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update Items</title>
<link href="Admin.css" rel="stylesheet" type="text/css" />
<?php

require_once 'login.php';
mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($dbname);

$GameIDPostError = false;
$PlaInvPostError = false;

if (isset($_POST['GameID'])) $GameID = $_POST['GameID'];
else $GameIDPostError = true;

if (isset($_POST['PlaInv'])) $PlaInv = $_POST['PlaInv'];
else $PlaInvPostError = true;


if(!$GameIDPostError){
	
	$result = mysql_query("
	SELECT Player.PlayerID, PlayerInfo.ScreenName, Champion.JointChampionName
	FROM Player
	JOIN PlayerInfo ON Player.PlayerID = PlayerInfo.PlayerID
	JOIN Champion ON Player.ChampionID = Champion.ChampionID
	WHERE Player.GameID = $GameID
	ORDER BY PlayerInfo.TeamID ASC, Player.Lane ASC;
	");
	while ($row = mysql_fetch_array($result)) {
		$PlayerID[] = $row['PlayerID'];
		$ScreenName[] = $row['ScreenName'];
		$PlayerChampion[] = $row['JointChampionName'];
	}

	$result = mysql_query("
	SELECT ItemID, ItemName
	FROM Item
	ORDER BY ItemName
	");
	while ($row = mysql_fetch_array($result)) {
		$ItemID[] = $row['ItemID'];
		$ItemName[] = $row['ItemName'];
	}
	
		//continue queries for player items
	$result = mysql_query("
	SELECT Item.ItemID
	FROM GPItems
	JOIN Item ON GPItems.ItemID = Item.ItemID
	WHERE GPItems.GameID = $GameID
	");
	while ($row = mysql_fetch_array($result)) {
		$PlaInv[] = $row['ItemID'];
	}
	
	
	//convert ItemInv into 2d array
	$c = 0;
	for ($z = 0; $z<10; $z++){
		for ($x = 0; $x<6; $x++){
			$inventory[$z][$x] = $PlaInv[$c];
			$c++;
		}
	}
		
	//SQL Inserts HERE
	$c = 0;
	if(!$PlaInvPostError){
		for ($z = 0; $z<10; $z++){
			for ($x = 0; $x<6; $x++){
				$myInsQuery = "UPDATE `LoLStatsTest2`.`GPItems` SET `ItemID`= $PlaInv[$c] WHERE `GameID`='$GameID' and`PlayerID`='$PlayerID[$z]' and`ItemSlot`='".($x+1)."';";
				$result = mysql_query($myInsQuery);
				$iq1[$c] = $myInsQuery;
				$c++;				
			}
		}
	}
	else {
		//Code to execute if no sql updates occured
		$iq1[0] = "No SQL executed";
	}

	
	echo "</head>";
	echo "<div id=\"whitebox\">";
    echo "<div class=\"caption\">";
    echo "<strong>Update Items</strong>";
    echo "</div>";
	echo "<form method = \"post\" action = \"UpdateItems.php\">";
	echo "<body>\n";
	echo "<table>\n";
	echo "<tr>\n<td>Player</td>\n<td>Item1</td>\n<td>Item2</td>\n<td>Item3</td>\n<td>Item4</td>\n<td>Item5</td>\n<td>Item6</td>\n</tr>\n";
	$max = sizeof($ItemID);
	for($pla = 0; $pla< 10; $pla++){
	
		echo "<tr>\n";
		echo "<td> <img src=\"../ChampIcons/36px-$PlayerChampion[$pla]Square.png\" width=\"20\" height=\"20\" /> $ScreenName[$pla] </td>\n";
		for ($inum = 0; $inum<6; $inum++){
			echo "<td><select name=\"PlaInv[]\">\n";
			for( $ilist = 0; $ilist<$max; $ilist++){
				echo "<option ";
				if ( $inventory[$pla][$inum] == $ItemID[$ilist] ){
					echo "selected = \"selected\"";
				}
				echo "value = '$ItemID[$ilist]'>$ItemName[$ilist]\n";
			}
			echo "</select></td>\n";
		}
		echo "</tr>\n";
	}
	echo "<tr>\n<td></td>\n<td></td>\n<td></td>\n<td></td>\n<td></td>\n<td></td>\n<td><input type=\"submit\" /></td>\n</tr>\n";
	echo "<input type=\"hidden\" name=\"GameID\" value=\"$GameID\" />\n</form>";
	echo "<tr>\n<td></td>\n<td></td>\n<td></td>\n<td></td>\n<td></td>\n<td></td>\n<td>";
	echo <<<END
	<form method="post" action="AdminPanel.php">
    <input type="submit" value="Admin Panel"/>
    </form>
END;
	echo "</td>\n</tr>\n";
	echo "</table>\n";	
	echo "</br>";
}
else {
    echo "</head>";
	echo "<div id=\"whitebox\">";
    echo "<div class=\"caption\">";
    echo "<strong>Update Items</strong>";
    echo "</div>";
	echo "No Game Data Sent</br>";
	echo <<<END
	<form method="post" action="AdminPanel.php">
    <input type="submit" value="Admin Panel"/>
    </form>
END;
	echo '<div class="sql">';
	foreach ($iq1 as $out){
		echo $out."</br>\n";
	}
	echo '</div>';
}
echo "</div>";
?>


</body>

</html>