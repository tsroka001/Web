<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Player Search</title>
<link href="Admin.css" rel="stylesheet" type="text/css" />
<?php

$NameSend = true;
$SNSend = true;
$TeamSend = true;
$queryComplete = false;
//Get Posted Variables
if (isset($_POST['Name'])) $Name = $_POST['Name'];
else $NameSend=false;
if (isset($_POST['ScreenName'])) $ScreenName = $_POST['ScreenName'];
else $SNSend=false;
if (isset($_POST['TeamName'])) $TeamName = $_POST['TeamName'];
else $TeamSend=false;

//Login to Database
require_once 'login.php';
mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($dbname);

if($NameSend){
	$result = mysql_query("
	SELECT PlayerInfo.PlayerID, 
	PlayerInfo.PlayerName, 
	PlayerInfo.ScreenName, 
	Team.TeamName, 
	PlayerInfo.Role 
	FROM PlayerInfo 
	JOIN Team ON Team.TeamID = PlayerInfo.TeamID
	WHERE PlayerName LIKE '%$Name%'
	ORDER BY PlayerInfo.PlayerName ASC
	");
	while ($row = mysql_fetch_array($result)) {
		$q_PID[] = $row['PlayerID'];
		$q_PN[] = $row['PlayerName'];
		$q_PSN[] = $row['ScreenName'];
		$q_TeamName[] = $row['TeamName'];
		$q_Role[] = $row['Role'];
	}
	$queryComplete = true;
}

if($ScreenName){
	$result = mysql_query("
	SELECT PlayerInfo.PlayerID, 
	PlayerInfo.PlayerName, 
	PlayerInfo.ScreenName, 
	Team.TeamName, 
	PlayerInfo.Role 
	FROM PlayerInfo 
	JOIN Team ON Team.TeamID = PlayerInfo.TeamID
	WHERE ScreenName LIKE '%$ScreenName%'
	ORDER BY PlayerInfo.ScreenName ASC
	");
	while ($row = mysql_fetch_array($result)) {
		$q_PID[] = $row['PlayerID'];
		$q_PN[] = $row['PlayerName'];
		$q_PSN[] = $row['ScreenName'];
		$q_TeamName[] = $row['TeamName'];
		$q_Role[] = $row['Role'];
	}
	$queryComplete = true;
}

if($TeamName){
	$result = mysql_query("
	SELECT PlayerInfo.PlayerID, 
	PlayerInfo.PlayerName, 
	PlayerInfo.ScreenName, 
	Team.TeamName, 
	PlayerInfo.Role 
	FROM PlayerInfo 
	JOIN Team ON Team.TeamID = PlayerInfo.TeamID
	WHERE TeamName LIKE '%$TeamName%'
	ORDER BY  Team.TeamName ASC, PlayerInfo.Role ASC
	");
	while ($row = mysql_fetch_array($result)) {
		$q_PID[] = $row['PlayerID'];
		$q_PN[] = $row['PlayerName'];
		$q_PSN[] = $row['ScreenName'];
		$q_TeamName[] = $row['TeamName'];
		$q_Role[] = $row['Role'];
	}
	$queryComplete = true;
}

?>


</head>

<body>
  <div id="whitebox">
    <div class="caption">
      <strong>Player Search</strong>
    </div>

		<form method="post" action="PlayerSearch.php">
    	<input type="text" name="Name" style="width:193px"/>
      <input type="submit" value="Search By Name" style="width:193px"/>
    </form>
		<form method="post" action="PlayerSearch.php">
    	<input type="text" name="ScreenName" style="width:193px"/>
      <input type="submit" value="Search By ScreenName" style="width:193px"/>
    </form>
    <form method="post" action="PlayerSearch.php">
    	<input type="text" name="TeamName" style="width:193px"/>
      <input type="submit" value="Search By Team Name" style="width:193px"/>
    </form>
    <br />
    
    <?php
		if($queryComplete) DisplayResults();		
		?>
    
    <div class="quickEscape">
      <form method="post" action="AdminPanel.php">
        <input type="submit" value="Admin Panel" style="width:193px"/>
      </form>
    </div>
	</div>

</body>

<?php
function DisplayResults(){
	global $q_PID, $q_PN, $q_PSN, $q_TeamName, $q_Role;
	echo "<table>\n<tr>\n<td width = \"60px\">PlayerID</td>\n<td width = \"200px\">Player Name</td>\n<td width = \"200px\">ScreenName</td>\n
				<td width = \"200px\">Team Name</td>\n<td width = \"50px\">Role</td>\n</tr>\n";
	$max = sizeof($q_PID);
	for	($i = 0; $i < $max; $i++) {
		if ($i % 2 == 0)	echo "<tr class=\"alt\">\n";
		else echo "<tr>\n";
		echo "<td>$q_PID[$i]</td>\n<td>$q_PN[$i]</td>\n<td>$q_PSN[$i]</td>\n<td>$q_TeamName[$i]</td>\n<td>$q_Role[$i]</td>\n</tr>\n";
	}				
	echo "</table>";
}




