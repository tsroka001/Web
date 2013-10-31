<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../ESSBhome.css" rel="stylesheet" type="text/css" media="screen" />

<link rel="stylesheet" href="../jquery-ui-1.10.3.custom/css/bgthm/jquery-ui-1.10.3.custom.css" />
<script src="../jquery-ui-1.10.3.custom/js/jquery-1.9.1.js"></script>
<script src="../jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />

<script type="text/javascript">var p="http",d="static";if(document.location.protocol=="https:"){p+="s";d="engine";}var z=document.createElement("script");z.type="text/javascript";z.async=true;z.src=p+"://"+d+".adzerk.net/ados.js";var s=document.getElementsByTagName("script")[0];s.parentNode.insertBefore(z,s);</script>
<script type="text/javascript">
var ados = ados || {};
ados.run = ados.run || [];
ados.run.push(function() {
/* load placement for account: snowghostx, site: eSportsScoreBoard, size: 160x600 - Wide Skyscraper*/
ados_add_placement(5486, 28063, "azk47928", 6);
/* load placement for account: snowghostx, site: eSportsScoreBoard, size: 728x90 - Leaderboard*/
ados_add_placement(5486, 28063, "azk65761", 4);
ados_load();
});</script>

<title>Player</title>

<?php
date_default_timezone_set('EST');

require_once '../php/login.php';
mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($dbname);

$get = htmlspecialchars($_GET["PlayerID"]);	  
if (!empty($get)){
	$PlayerID = $get;
}
else{
	$PlayerID = 1;
}


// Query upcoming games data
$result = mysql_query("
	SELECT GameID, Team.TeamCall AS BlueTeam, TeamB.TeamCall AS RedTeam, GameDate, GameTime
	FROM Game
	JOIN Team ON Team.TeamID = Game.TeamAID
	JOIN Team AS TeamB ON TeamB.TeamID = Game.TeamBID
	ORDER BY GameDate DESC
	LIMIT 6;
	");
while ($row = mysql_fetch_array($result)) {
	$upcGameID[] = $row['GameID'];
	$upcBlueTeam[] = $row['BlueTeam'];
	$upcRedTeam[] = $row['RedTeam'];
	$upcGameDate[] = $row['GameDate'];
	$upcGameTime[] = $row['GameTime'];
}

$result = mysql_query("
	SELECT 
	SUM(Player.Kills) AS K, 
	SUM(Player.Deaths) AS D, 
	SUM(Player.Assists) AS A, 
	AVG(Player.Kills) AS AK, 
	AVG(Player.Deaths) AS AD, 
	AVG(Player.Assists) AS AA, 
	COUNT(Player.GameID) AS Games,
	PlayerInfo.ScreenName,
	PlayerInfo.PlayerName,
	PlayerInfo.Role
	FROM Player
	JOIN PlayerInfo ON Player.PlayerID = PlayerInfo.PlayerID
	WHERE Player.PlayerID = $PlayerID
	");
$row = mysql_fetch_row($result);
$Kills = $row['0'];
$Deaths = $row['1'];
$Assists = $row['2'];
$AvKills = $row['3'];
$AvDeaths = $row['4'];
$AvAssists = $row['5'];
$Games = $row['6'];
$ScreenName = $row['7'];
$PlayerName = $row['8'];
$Role = $row['9'];


?>



</head>

<body>

<div id="content">

  <div id="top">
  	<div id="banner"></div>
    
    <div id="topmenu">
    	<a href="../index.php">Home</a>  Scores  Teams  Players  Database  News  <?php echo $GameID; ?>
    </div>
    
    <div id ="scoreBoxContainer">
    	<?php echoTopScores(1);?>
      <?php echoTopScores(2);?>
      <?php echoTopScores(3);?>
      <?php echoTopScores(4);?>
      <?php echoTopScores(5);?>
      <?php echoTopScores(6);?>
    </div>
    
  </div>
  
  <div id="TopAd">
    <div id="azk65761"></div>
  </div>
  
  <div id="mid">
  <div class="ImgBox">
  <img src="../Images/player_icon.png" width="209" height="255" />
  </div>
  <div class="PlaContBox">
  <?php
	echo "<p>$ScreenName</p><p>$PlayerName</p><p>Role: $Role</p><p>Kills: $Kills</p><p>Deaths: $Deaths</p><p>Assists: $Assists</p>";
	?>
  recent performances
  </div>  
  <div id="contClear"></div>
  
 </div>
</div>




</body>
</html>

<?php

function echoTopScores($Box){
	global $upcGameID, $upcBlueTeam, $upcRedTeam, $upcGameDate, $upcGameTime;
	$Box--;
	echo "<div onclick=\"location.href='../php/Match.php?GameID=$upcGameID[$Box]';\" class=\"topScoreBox\">\n";
	echo "<div class =\"DateBox\">";
	echo date('D M j', strtotime($upcGameDate[$Box]));
	echo date(' g:ia T', strtotime($upcGameTime[$Box]))."\n";
	echo "</div>\n";
	echo "<div class=\"TeamBox\">\n";
	echo "<img src=\"../TeamLogos/$upcBlueTeam[$Box].png\" width=\"22\" height=\"22\" align=\"texttop\" />";
	echo "vs";
	echo "<img src=\"../TeamLogos/$upcRedTeam[$Box].png\" width=\"22\" height=\"22\" align=\"texttop\" />";
	echo "</div>\n";
	echo "</div>\n";
}

?>