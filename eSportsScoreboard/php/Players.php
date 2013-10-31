<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Players</title>
<link href="../ESSBhome.css" rel="stylesheet" type="text/css" />
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

<?php
date_default_timezone_set('EST');

require_once 'login.php';
mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($dbname);

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

?>

</head>
<body>

<div id="content">

  <div id="top">
  	<div id="banner">
    </div>
    
    <div id="topmenu">
    	<a href="../index.php">Home</a> 
      <a href="Scores.php">Scores</a> 
      <a href="Teams.php">Teams</a> 
      <a href="Players.php">Players</a>
      <a href="News.php">News</a>
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
  	<h1>Players</h1>
  </div>

  
  <div id="bot">
  bot
  </div>
  
  
</div>

</body>

</html>
<?php

function echoTopScores($Box){
	global $upcGameID, $upcBlueTeam, $upcRedTeam, $upcGameDate, $upcGameTime;
	$Box--;
	echo "<div onclick=\"location.href='Match.php?GameID=$upcGameID[$Box]';\" class=\"topScoreBox\">\n";
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