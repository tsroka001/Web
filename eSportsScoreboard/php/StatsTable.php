<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
body {
	font-family: Verdana, Geneva, sans-serif;
	font-size: large;
}

.datagrid table { 
	border-collapse: collapse; 
	text-align: left; 
} 
.datagrid {
	background: #fff; 
	overflow: hidden; 
	float:left;
	
}
.datagrid table td, .datagrid table th { 
	padding: 1px 1px; 
}
.datagrid table thead th {
	background-color:#006699; 
	color:#FFFFFF; 
	font-size: 10px; 
	font-weight: bold; 
	border-left: 1px solid #0070A8; 
} 
.datagrid table thead th:first-child { 
	border: none; 
}
.datagrid table tbody td { 
	color: #00557F; 
	border-left: 1px solid #E1EEF4;
	font-size: 12px;
	font-weight: normal; 
}
.datagrid table tbody .alt td { 
	background: #CCCCCC; 
	color: #00557F; 
}
.datagrid table tbody td:first-child { 
	border-left: none; 
}
.datagrid table tbody tr:last-child td { 
	border-bottom: none; 
}

.datagrid table tfoot td { 
	padding: 0; 
	font-size: 12px 
} 


#cont {
	width: 960px;	
}

</style>
<?php

require_once 'login.php';
mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($dbname);


	$GameID = 1;


//SQL
//SELECTS

$result = mysql_query("
  SELECT PlayerInfo.PlayerID, 
  PlayerInfo.ScreenName,  
  Champion.ChampionName, 
  Champion.JointChampionName,
  Player.SummonerA,
  Player.SummonerB,
  Player.Level,
  Player.Kills, 
  Player.Deaths, 
  Player.Assists,
  Player.CreepScore,
  Player.Gold,
  Player.Towers,
  Player.Lane,
  PlayerInfo.TeamID,
  Team.TeamName,
  Team.TeamNameJoint,
  Team.TeamCall
  FROM PlayerInfo 
  JOIN Player ON Player.PlayerID = PlayerInfo.PlayerID
  JOIN Champion ON Champion.ChampionID = Player.ChampionID
  JOIN Team ON PlayerInfo.TeamID = Team.TeamID
  WHERE Player.GameID = $GameID
  ORDER BY PlayerInfo.TeamID ASC, Player.Lane ASC;
");
while ($row = mysql_fetch_array($result)) {
  $PlayerID[] = $row['PlayerID'];///////////////////////////////   PlayerID    
  $ScreenName[] = $row['ScreenName'];///////////////////////////   ScreenName
  $ChampionName[] = $row['ChampionName'];///////////////////////   ChampionName
  $JointChampionName[] = $row['JointChampionName'];/////////////   JointChampionName
  $SummonerA[] = $row['SummonerA'];/////////////////////////////   SummonerA
  $SummonerB[] = $row['SummonerB'];/////////////////////////////   SummonerB
  $Level[] = $row['Level'];/////////////////////////////////////   Level
  $Kills[] = $row['Kills'];/////////////////////////////////////   Kills
  $Deaths[] = $row['Deaths'];///////////////////////////////////   Deaths
  $Assists[] = $row['Assists'];/////////////////////////////////   Assists
  $CreepScore[] = $row['CreepScore'];///////////////////////////   CreepScore
  $Gold[] = $row['Gold'];///////////////////////////////////////   Gold
  $Towers[] = $row['Towers'];///////////////////////////////////   Towers
  $PlayerLane[] = $row['Lane'];/////////////////////////////////   Lane
  $TeamName[] = $row['TeamName'];///////////////////////////////   TeamName
  $TeamJointName[] = $row['TeamJointName'];/////////////////////   TeamJoinName
  $TeamCall[] = $row['TeamCall'];///////////////////////////////   TeamCall
}

$result = mysql_query("
  SELECT Item.JointItemName
  FROM Item
  JOIN GPItems
  WHERE Item.ItemID = GPItems.ItemID AND GPItems.GameID = $GameID");
while ($row = mysql_fetch_array($result)) {
  $Item[] = $row['JointItemName'];
}

$result = mysql_query("
	SELECT TeamAID,
	TeamBID,
	GameState,
	GameDate,
	GameTime,
	Season,
	Tournament,
	Winner,
	GameLength
	FROM Game
	WHERE GameID = $GameID;");
while ($row = mysql_fetch_array($result)) {
	$BlueTeamID[] = $row['TeamAID'];
	$RedTeamID[] = $row['TeamBID'];
	$GameState[] = $row['GameState'];
	$GameDate[] = $row['GameDate'];
	$GameTime[] = $row['GameTime'];
	$Season[] = $row['Season'];
	$Tournament[] = $row['Tournament'];
  $Winner[] = $row['Winner'];
	$GameLength[] = $row['GameLength'];
}

?>

</head>
<body>
<div id="cont">
<div class="datagrid">
<table>
<thead>
<tr>
<th style = "width:22px"></th>
<th style = "width:100px"> Player</th>
<th style = "width:44px"></th>
<th style = "width:22px"> K</th>
<th style = "width:22px"> D</th>
<th style = "width:22px"> A</th>
<th style = "width:22px"> KDA</th>
<th style = "width:22px"> L</th>
<th style = "width:22px"> CS</th>
<th style = "width:120px"> Items</th>
</tr>
</thead>
<tbody>

<tr>
<?php DisplayTablePlayer(0) ?>
</tr>

<tr class="alt">
<?php DisplayTablePlayer(1) ?>
</tr>

<tr>
<?php DisplayTablePlayer(2) ?>
</tr>

<tr class="alt">
<?php DisplayTablePlayer(3) ?>
</tr>

<tr>
<?php DisplayTablePlayer(4) ?>
</tr>

</tbody>
</table>
</div>

<div class="datagrid">
<table>
<thead>
<tr>
<th style = "width:22px"></th>
<th style = "width:100px"> Player</th>
<th style = "width:44px"></th>
<th style = "width:22px"> K</th>
<th style = "width:22px"> D</th>
<th style = "width:22px"> A</th>
<th style = "width:22px"> KDA</th>
<th style = "width:22px"> L</th>
<th style = "width:22px"> CS</th>
<th style = "width:120px"> Items</th>
</tr>
</thead>
<tbody>

<tr>
<?php DisplayTablePlayer(5) ?>
</tr>

<tr class="alt">
<?php DisplayTablePlayer(6) ?>
</tr>

<tr>
<?php DisplayTablePlayer(7) ?>
</tr>

<tr class="alt">
<?php DisplayTablePlayer(8) ?>
</tr>

<tr>
<?php DisplayTablePlayer(9) ?>
</tr>

</tbody>
</table>
</div>

</div>
</body>

</html>

<?php 

function echoChampion($PlayerNum){
	global $JointChampionName;	
	echo "<img src=\"../ChampIcons/36px-".$JointChampionName[$PlayerNum]."Square.png\" width=\"20\" height=\"20\" />";
}

function echoPlayer($PlayerNum){
	global $ScreenName;
	echo $ScreenName[$PlayerNum];
}

function echoSummoners($PlayerNum){
	global $SummonerA, $SummonerB;
	echo "<img src=\"../SummonerIcons/20px-".$SummonerA[$PlayerNum].".png\" width=\"20\" height=\"20\" /><img src=\"../SummonerIcons/20px-".$SummonerB[$PlayerNum].".png\" width=\"20\" height=\"20\" /></td>";
}

function echoKills($PlayerNum){
	global $Kills;
	echo $Kills[$PlayerNum];
}

function echoDeaths($PlayerNum){
	global $Deaths;
	echo $Deaths[$PlayerNum];
}

function echoAssists($PlayerNum){
	global $Assists;
	echo $Assists[$PlayerNum];
}

function echoKDA($PlayerNum){
	global $Kills, $Deaths, $Assists;
	if ($Deaths[$PlayerNum] != 0){
		echo (($Kills[$PlayerNum] + $Assists[$PlayerNum])/$Deaths[$PlayerNum]);
	}
	else{
		echo ($Kills[$PlayerNum] + $Assists[$PlayerNum]);
	}
}

function echoLevel($PlayerNum){
	global $Level;
	echo $Level[$PlayerNum];
}

function echoCS($PlayerNum){
	global $CreepScore;
	echo $CreepScore[$PlayerNum];
}

function echoItems($PlayerNum){
	global $Item;
	for ($i = $PlayerNum*6; $i < ($PlayerNum*6 + 6); $i++){
		echo "<img src=\"../ItemIcons/32px-".$Item[$i].".gif\" width=\"20\" height=\"20\" />";
	}
}

function DisplayTablePlayer($PNum){
	echo "<td>";
	echoChampion($PNum);
	echo "</td>";
	echo "<td>";
	echoPlayer($PNum);
	echo "</td>";
	echo "<td>";
	echoSummoners($PNum);
	echo "</td>";
	echo "<td>";
	echoKills($PNum);
	echo "</td>";
	echo "<td>";
	echoDeaths($PNum);
	echo "</td>";
	echo "<td>";
	echoAssists($PNum);
	echo "</td>";
	echo "<td>";
	echoKDA($PNum);
	echo "</td>";
	echo "<td>";
	echoLevel($PNum);
	echo "</td>";
	echo "<td>";
	echoCS($PNum);
	echo "</td>";
	echo "<td>";
	echoItems($PNum);
	echo "</td>";
}
?>
