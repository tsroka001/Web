<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../ESSBhome.css" rel="stylesheet" type="text/css" media="screen" />

  <link rel="stylesheet" href="../jquery-ui-1.10.3.custom/css/bgthm/jquery-ui-1.10.3.custom.css" />
  <script src="../jquery-ui-1.10.3.custom/js/jquery-1.9.1.js"></script>
  <script src="../jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.js"></script>
  <script>
  $(function() {
    $( "#tabs" ).tabs();
  });
  </script>

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

require_once 'login.php';
mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($dbname);

$get = htmlspecialchars($_GET["GameID"]);	  
if (!empty($get)){
	$GameID = $get;
}
else{
	$GameID = 1;
}

date_default_timezone_set('EST');

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

//Current Items Info
$result = mysql_query("
  SELECT Item.JointItemName
  FROM Item
  JOIN GPItems
  WHERE Item.ItemID = GPItems.ItemID AND GPItems.GameID = $GameID");
while ($row = mysql_fetch_array($result)) {
  $Item[] = $row['JointItemName'];
}

//Current Game Information
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

//Get Tower HP
$result = mysql_query("
	SELECT TowerHealth 
	FROM TowerHealth 
	WHERE GameID = $GameID
	");
	while ($row = mysql_fetch_array($result)) {
		$TowerHealth[] = $row['TowerHealth'];
	}

//Convert GameTime to seconds for further use
$LengthSec = (((int)(substr($GameLength[0], 0, 2)) * 60) + (int)substr($GameLength[0], 3, 4));

	
?>

<title><?php echo $TeamCall[0]?> vs. <?php echo $TeamCall[5]?></title>

</head>
<body>

<div id="content">

  <div id="top">
  	<div id="banner"></div>
    
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
  	<div id="TeamTopPic"><img src="../Pictures/<?php echo $TeamCall[0]?>_Team.jpg" width="473" height="164" /> <img src="../Pictures/<?php echo $TeamCall[5]?>_Team.jpg" width="473" height="164" />
      <div id="TeamsTop"><img src="../TeamLogos/<?php echo $TeamCall[0]?>.png" width="134" height="134" /><img src="../Images/Versus.png" width="80" height="80" /><img src="../TeamLogos/<?php echo $TeamCall[5]?>.png" width="134" height="134" />
      </div>
      <div id="BlueTeam"><?php echo $TeamName[0]?> 
      </div>
      <div id="RedTeam"><?php echo $TeamName[5]?> 
      </div>
    </div>

    <div id="tabs">
      <ul>
        <li><a href="#tabs-1">Scoreboard</a></li>
        <li><a href="#tabs-2">Picks</a></li>
        <li><a href="#tabs-3">Map</a></li>
        <li><a href="#tabs-4">VOD</a></li>
      </ul>
      <div id="tabs-1">
        <div class="datagrid">
        	<table><thead><tr><th style = "width: 567px; text-align: center;">Game Stats</th><th style = "width: 320px; text-align: center;">Season Stats</th></tr></thead></table>
          <table>
          <thead>
          <tr>
          <th style = "width:22px"></th>
          <th style = "width:100px; text-align: center;"> Player</th>
          <th style = "width:44px; text-align: center;">S</th>
          <th style = "width:20px; text-align: center;"> K</th>
          <th style = "width:20px; text-align: center;"> D</th>
          <th style = "width:20px; text-align: center;"> A</th>
          <th style = "width:30px; text-align: center;"> KDA</th>
          <th style = "width:30px; text-align: center;"> KP</th>
          <th style = "width:20px; text-align: center;"> L</th>
          <th style = "width:25px; text-align: center;"> CS</th>
          <th style = "width:40px; text-align: center;"> G</th>
          <th style = "width:40px; text-align: center;"> GPM</th>
          <th style = "width:120px; text-align: center;"> Items</th>
          <th style = "width:5px"></th>
          <th style = "width:30px; text-align: center;"> TK</th>
          <th style = "width:30px; text-align: center;"> TD</th>
          <th style = "width:30px; text-align: center;"> TA</th>
          <th style = "width:30px; text-align: center;"> KDA</th>
          <th style = "width:20px; text-align: center;"> KPG</th>
          <th style = "width:20px; text-align: center;"> DPG</th>
          <th style = "width:20px; text-align: center;"> APG</th>
          <th style = "width:25px; text-align: center;"> ACS</th>
          <th style = "width:40px; text-align: center;"> AG</th>
          <th style = "width:40px; text-align: center;"> AGPM</th>
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
          </br>
          <div class="datagrid">
					<table>
          <thead>
          <tr>
          <th style = "width:22px"></th>
          <th style = "width:100px; text-align: center;"> Player</th>
          <th style = "width:44px; text-align: center;">S</th>
          <th style = "width:20px; text-align: center;"> K</th>
          <th style = "width:20px; text-align: center;"> D</th>
          <th style = "width:20px; text-align: center;"> A</th>
          <th style = "width:30px; text-align: center;"> KDA</th>
          <th style = "width:30px; text-align: center;"> KP</th>
          <th style = "width:20px; text-align: center;"> L</th>
          <th style = "width:25px; text-align: center;"> CS</th>
          <th style = "width:40px; text-align: center;"> G</th>
          <th style = "width:40px; text-align: center;"> GPM</th>
          <th style = "width:120px; text-align: center;"> Items</th>
          <th style = "width:5px"></th>
          <th style = "width:30px; text-align: center;"> TK</th>
          <th style = "width:30px; text-align: center;"> TD</th>
          <th style = "width:30px; text-align: center;"> TA</th>
          <th style = "width:30px; text-align: center;"> KDA</th>
          <th style = "width:20px; text-align: center;"> KPG</th>
          <th style = "width:20px; text-align: center;"> DPG</th>
          <th style = "width:20px; text-align: center;"> APG</th>
          <th style = "width:25px; text-align: center;"> ACS</th>
          <th style = "width:40px; text-align: center;"> AG</th>
          <th style = "width:40px; text-align: center;"> AGPM</th>
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
          
          <table><thead><tr><th>
          Legend: S:Summoners | K:Kills | D:Deaths | A:Assists | KDA: Kills and Assists to Deaths Ratio | KP:Kill Participation | L:Champion Level | CS: Creepscore | G:Gold Earned | GPM: Gold Earned per Minute | TK: Total Kills this Season | TD: Total Deaths this Season | TA: Total Assists this Season | KPG: Average Kills per Game | DPG: Average Deaths per Game | APG: Average Assists per Game | AG: Average Gold per Game | AGPM: Average Gold per Minute this Season
        	</th></tr></thead></table>
        </div>
        <div id="contClear"></div>
      </div>
      <div id="tabs-2">
        <div id="pickOrder">
          <?php displayPicks($GameID);?>
        </div>
        <p>Player Top Picks</p>
        <div class="PicksTable">
        <table>
          <tr>
            <td width="200em">Dignitas</td><td></td><td></td><td></td><td></td>
          </tr>
          <tr>
            <td>Kiwikid</td><td></td><td><img src="../ChampIcons/Singed.png" width="50" height="50" /></td><td><img src="../ChampIcons/Elise.png" width="50" height="50" /></td><td><img src="../ChampIcons/Renekton.png" width="50" height="50" /></td>
          </tr>
          <tr>
            <td>Crumbz</td><td></td><td><img src="../ChampIcons/Nasus.png" width="50" height="50" /></td><td><img src="../ChampIcons/XinZhao.png" width="50" height="50" /></td><td><img src="../ChampIcons/Vi.png" width="50" height="50" /></td>
          </tr>
          <tr>
            <td>Scarra</td><td></td><td><img src="../ChampIcons/Gragas.png" width="50" height="50" /></td><td><img src="../ChampIcons/Diana.png" width="50" height="50" /></td><td><img src="../ChampIcons/Kayle.png" width="50" height="50" /></td>
          </tr>
          <tr>
            <td>Imaqtpie</td><td></td><td><img src="../ChampIcons/Draven.png" width="50" height="50" /></td><td><img src="../ChampIcons/Caitlyn.png" width="50" height="50" /></td><td><img src="../ChampIcons/Ezreal.png" width="50" height="50" /></td>
          </tr>
          <tr>
            <td>Patoy</td><td></td><td><img src="../ChampIcons/Alistar.png" width="50" height="50" /></td><td><img src="../ChampIcons/Zyra.png" width="50" height="50" /></td><td><img src="../ChampIcons/Thresh.png" width="50" height="50" /></td>
          </tr>
        </table>
        </div>
        <div class="PicksTable">
        <table>
          <tr>
            <td width="200em">Cloud 9 HyperX</td><td></td><td></td><td></td><td></td>
          </tr>
          <tr>
            <td>Balls</td><td></td><td><img src="../ChampIcons/Rumble.png" width="50" height="50" /></td><td><img src="../ChampIcons/Elise.png" width="50" height="50" /></td><td><img src="../ChampIcons/Kennen.png" width="50" height="50" /></td>
          </tr>
          <tr>
            <td>Meteos</td><td></td><td><img src="../ChampIcons/Nasus.png" width="50" height="50" /></td><td><img src="../ChampIcons/Zac.png" width="50" height="50" /></td><td><img src="../ChampIcons/Elise.png" width="50" height="50" /></td>
          </tr>
          <tr>
            <td>Hai</td><td></td><td><img src="../ChampIcons/Zed.png" width="50" height="50" /></td><td><img src="../ChampIcons/Jayce.png" width="50" height="50" /></td><td><img src="../ChampIcons/Kennen.png" width="50" height="50" /></td>
          </tr>
          <tr>
            <td>Sneaky</td><td></td><td><img src="../ChampIcons/Ashe.png" width="50" height="50" /></td><td><img src="../ChampIcons/Draven.png" width="50" height="50" /></td><td><img src="../ChampIcons/Ezreal.png" width="50" height="50" /></td>
          </tr>
          <tr>
            <td>Lemonnation</td><td></td><td><img src="../ChampIcons/Zyra.png" width="50" height="50" /></td><td><img src="../ChampIcons/Thresh.png" width="50" height="50" /></td><td><img src="../ChampIcons/Sona.png" width="50" height="50" /></td>
          </tr>
        </table>
        </div>
        <div id="contClear"></div>
      </div>
      <div id="tabs-3">
        
        
        
        
        
        
        
        
        <div id="minimap">
    <!-- Blue Nexus -->
    <div class="meter-wrap" style="top:754px; left:119px;">
        <div class="BIicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[0]; ?>%;">
        </div>
    </div>
    <!-- Blue Top Nexus Tower -->
<div class="meter-wrap" style="top:715px; left:118px;">
        <div class="BTicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[1]; ?>%;">
        </div>
    </div>
    <!-- Blue Top Inhib -->
<div class="meter-wrap" style="top:647px; left:97px;">
        <div class="BIicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[2]; ?>%;">
        </div>
    </div>
    <!-- Blue Top 3 -->
<div class="meter-wrap" style="top:590px; left:92px;">
        <div class="BTicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[3]; ?>%;">
        </div>
    </div>
    <!-- Blue Top 2 -->
<div class="meter-wrap" style="top:441px; left:118px;">
        <div class="BTicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[4]; ?>%;">
        </div>
    </div>
    <!-- Blue Top 1 -->
<div class="meter-wrap" style="top:250px; left:85px;">
        <div class="BTicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[5]; ?>%;">
        </div>
    </div>
    <!-- Red Top 1 -->
<div class="meter-wrap" style="top:57px; left:196px;">
        <div class="RTicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[6]; ?>%;">
        </div>
    </div>
    <!-- Red Top 2 -->
<div class="meter-wrap" style="top:93px; left:443px;">
        <div class="RTicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[7]; ?>%;">
        </div>
    </div>
    <!-- Red Top 3 -->
<div class="meter-wrap" style="top:72px; left:578px;">
        <div class="RTicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[8]; ?>%;">
        </div>
    </div>
    <!-- Red Top Inhib -->
<div class="meter-wrap" style="top:71px; left:642px;">
        <div class="RIicon">
</div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[9]; ?>%;">
        </div>
    </div>
    <!-- Red Top Nexus Tower -->
<div class="meter-wrap" style="top:99px; left:704px;">
        <div class="RTicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[10]; ?>%;">
        </div>
    </div>
    <!-- Red Mid Inhib -->
    <div class="meter-wrap" style="top:184px; left:664px;">
        <div class="RIicon">
</div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[11]; ?>%;">
        </div>
    </div>
    <!-- Red Mid 3 -->
    <div class="meter-wrap" style="top:229px; left:623px;">
        <div class="RTicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[12]; ?>%;">
        </div>
    </div>
    <!-- Red Mid 2 -->
    <div class="meter-wrap" style="top:292px; left:550px;">
        <div class="RTicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[13]; ?>%;">
        </div>
    </div>
    <!-- Red Mid 1 -->
    <div class="meter-wrap" style="top:373px; left:519px;">
        <div class="RTicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[14]; ?>%;">
        </div>
    </div>
    <!-- Blue Mid 1 -->
    <div class="meter-wrap" style="top:487px; left:343px;">
        <div class="BTicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[15]; ?>%;">
        </div>
    </div>
    <!-- Blue Mid 2 -->
    <div class="meter-wrap" style="top:574px; left:309px;">
        <div class="BTicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[16]; ?>%;">
        </div>
    </div>
    <!-- Blue Mid 3 -->
    <div class="meter-wrap" style="top:638px; left:242px;">
        <div class="BTicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[17]; ?>%;">
        </div>
    </div>
    <!-- Blue Mid Inhib -->
    <div class="meter-wrap" style="top:668px; left:205px;">
        <div class="BIicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[18]; ?>%;">
        </div>
    </div>
    <!-- Blue Bot Nexus Tower-->
    <div class="meter-wrap" style="top:764px; left:156px;">
        <div class="BTicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[19]; ?>%;">
        </div>
    </div>
    <!-- Blue Bot Inhib-->
    <div class="meter-wrap" style="top:778px; left:219px;">
        <div class="BIicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[20]; ?>%;">
        </div>
    </div>
    <!-- Blue Bot 3-->
    <div class="meter-wrap" style="top:778px; left:255px;">
        <div class="BTicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[21]; ?>%;">
        </div>
    </div>
    <!-- Blue Bot 2-->
    <div class="meter-wrap" style="top:767px; left:425px;">
        <div class="BTicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[22]; ?>%;">
        </div>
    </div>
    <!-- Blue Bot 1-->
    <div class="meter-wrap" style="top:792px; left:595px;">
        <div class="BTicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[23]; ?>%;">
        </div>
    </div>
    <!-- Red Bot 1-->
<div class="meter-wrap" style="top:599px; left:788px;">
        <div class="RTicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[24]; ?>%;">
        </div>
    </div>
    <!-- Red Bot 2-->
<div class="meter-wrap" style="top:399px; left:758px;">
        <div class="RTicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[25]; ?>%;">
        </div>
    </div>
    <!-- Red Bot 3-->
<div class="meter-wrap" style="top:278px; left:776px;">
        <div class="RTicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[26]; ?>%;">
        </div>
    </div>
    <!-- Red Bot Inhib-->
<div class="meter-wrap" style="top:199px; left:770px;">
        <div class="RIicon">
</div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[27]; ?>%;">
        </div>
    </div>
    <!-- Red Bot Nexus Turret-->
<div class="meter-wrap" style="top:126px; left:736px;">
        <div class="RTicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[28]; ?>%;">
        </div>
    </div>   
    <!-- Red Nexus -->
    <div class="meter-wrap" style="top:93px; left:741px;">
        <div class="RIicon">
        </div>
        <div class="meter-value health" style="width:<?php echo $TowerHealth[29]; ?>%;">
        </div>
  </div>
</div>
        
        
        
        
        
        
        
        
        
        
        
      </div>
      <div id="tabs-4">
      	<iframe src="//www.youtube.com/embed/9lOUiIyHpHU" name="utube" width="896" height="503" frameborder="0" id="utube" allowfullscreen></iframe>
      </div>
    </div>
       <br />
       <br />

       
  </div>
  
  <div id="bot">
  Notes:
  <ul>
    <li>add popular piuck to pick section in map section </li>
    <li>add first tower predictions and tower killing speeds as well as inhibs add season totals, add kill participation create popular picks section</li>
  	<li>add tournament brackets / schedules</li>
    <li>add insert gold module</li>
    <li>add player rank in player profiles</li>
    <li>fix huge list of missing rounding </li>
  </ul>
  </div>
  
</div>
</br>
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


function displayPicks($Game){

	$result = mysql_query("
	SELECT JointChampionName
	FROM Champion
	JOIN PickOrder ON PickOrder.ChampionID = Champion.ChampionID
	WHERE PickOrder.GameID = $Game
	");
	while ($row = mysql_fetch_array($result)) {
		$ChampionPick[] = $row['JointChampionName'];
	}
	
	echo <<<END
	<table cellpadding="3" cellspacing="0" >
	<tr>
	<td valign="top" width = "50px" height="50px"><img src="../ChampIcons/$ChampionPick[0].png" width="50" height="50" class="images" /><img src="../Images/banned.png" width="50" height="50" class="icon" /></td>
	<td valign="top" width = "50px" height="50px"></td>
	<td valign="top" width = "50px" height="50px"><img src="../ChampIcons/$ChampionPick[2].png" width="50" height="50" class="images" /><img src="../Images/banned.png" width="50" height="50" class="icon" /></td>
	<td valign="top" width = "50px" height="50px"></td>
	<td valign="top" width = "50px" height="50px"><img src="../ChampIcons/$ChampionPick[4].png" width="50" height="50" class="images" /><img src="../Images/banned.png" width="50" height="50" class="icon" /></td>
	<td valign="top" width = "50px" height="50px"></td>
	<td valign="top" width = "50px" height="50px"><img src="../ChampIcons/$ChampionPick[6].png" width="50" height="50" class="images" /></td>
	<td valign="top" width = "50px" height="50px"></td>
	<td valign="top" width = "50px" height="50px"></td>
	<td valign="top" width = "50px" height="50px"><img src="../ChampIcons/$ChampionPick[4].png" width="50" height="50" class="images" /></td>
	<td valign="top" width = "50px" height="50px"><img src="../ChampIcons/$ChampionPick[10].png" width="50" height="50" class="images" /></td>
	<td valign="top" width = "50px" height="50px"></td>
	<td valign="top" width = "50px" height="50px"></td>
	<td valign="top" width = "50px" height="50px"><img src="../ChampIcons/$ChampionPick[13].png" width="50" height="50" class="images" /></td>
	<td valign="top" width = "50px" height="50px"><img src="../ChampIcons/$ChampionPick[14].png" width="50" height="50" class="images" /></td>
	</tr>
	<tr>
	<td valign="top"width = "50px" height="50px"></td>
	<td valign="top"width = "50px" height="50px"><img src="../ChampIcons/$ChampionPick[1].png" width="50" height="50" class="images" /><img src="../Images/banned.png" width="50" height="50" class="icon" /></td>
	<td valign="top"width = "50px" height="50px"></td>
	<td valign="top"width = "50px" height="50px"><img src="../ChampIcons/$ChampionPick[3].png" width="50" height="50" class="images" /><img src="../Images/banned.png" width="50" height="50" class="icon" /></td>
	<td valign="top"width = "50px" height="50px"></td>
	<td valign="top"width = "50px" height="50px"><img src="../ChampIcons/$ChampionPick[5].png" width="50" height="50" class="images" /><img src="../Images/banned.png" width="50" height="50" class="icon" /></td>
	<td valign="top"width = "50px" height="50px"></td>
	<td valign="top"width = "50px" height="50px"><img src="../ChampIcons/$ChampionPick[7].png" width="50" height="50" class="images" /></td>
	<td valign="top"width = "50px" height="50px"><img src="../ChampIcons/$ChampionPick[8].png" width="50" height="50" class="images" /></td>
	<td valign="top"width = "50px" height="50px"></td>
	<td valign="top"width = "50px" height="50px"></td>
	<td valign="top"width = "50px" height="50px"><img src="../ChampIcons/$ChampionPick[11].png" width="50" height="50" class="images" /></td>
	<td valign="top"width = "50px" height="50px"><img src="../ChampIcons/$ChampionPick[12].png" width="50" height="50" class="images" /></td>
	<td valign="top"width = "50px" height="50px"></td>
	<td valign="top"width = "50px" height="50px"></td>
	<td valign="top"width = "50px" height="50px"><img src="../ChampIcons/$ChampionPick[15].png" width="50" height="50" class="images" /></td>
	</tr>
	</table>
END;

}

function echoChampion($PlayerNum){
	global $JointChampionName;	
	echo "<img src=\"../ChampIcons/36px-".$JointChampionName[$PlayerNum]."Square.png\" width=\"20\" height=\"20\" />";
}

function echoPlayer($PlayerNum){
	global $ScreenName, $PlayerID;
	echo "<a href=\"../PlayerInfo/Player.php?PlayerID=$PlayerID[$PlayerNum]\">$ScreenName[$PlayerNum]</a>";
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
		echo round((($Kills[$PlayerNum] + $Assists[$PlayerNum])/$Deaths[$PlayerNum]), 2);
	}
	else{
		echo round(($Kills[$PlayerNum] + $Assists[$PlayerNum]), 2);
	}
}

function echoKP($PlayerNum){
	global $Kills, $Deaths, $Assists;
	if ($PlayerNum < 5){
		echo round((float)(($Kills[$PlayerNum]+$Assists[$PlayerNum])/($Kills[0]+$Kills[1]+$Kills[2]+$Kills[3]+$Kills[4])) * 100 ) . '%';
	}
	else{
		echo round((float)(($Kills[$PlayerNum]+$Assists[$PlayerNum])/($Kills[5]+$Kills[6]+$Kills[7]+$Kills[8]+$Kills[9])) * 100 ) . '%';
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

function echoGold($PlayerNum){
	global $Gold;
	if ( $Gold[$PlayerNum] > 999 ){
		echo ($Gold[$PlayerNum]/1000)."K";
	}
	else{
		echo $Gold[$PlayerNum];
	}
}

function echoGPM($PlayerNum){
	global $Gold, $LengthSec;
	echo round(($Gold[$PlayerNum]/($LengthSec/60)), 0);
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
	echo "<td style = \"text-align: center;\">";
	echoKills($PNum);
	echo "</td>";
	echo "<td style = \"text-align: center;\">";
	echoDeaths($PNum);
	echo "</td>";
	echo "<td style = \"text-align: center;\">";
	echoAssists($PNum);
	echo "</td>";
	echo "<td style = \"text-align: center;\">";
	echoKDA($PNum);
	echo "</td>";
	echo "<td style = \"text-align: center;\">";
	echoKP($PNum);
	echo "</td>";
	echo "<td style = \"text-align: center;\">";
	echoLevel($PNum);
	echo "</td>";
	echo "<td style = \"text-align: center;\">";
	echoCS($PNum);
	echo "</td>";
	echo "<td style = \"text-align: center;\">";
	echoGold($PNum); //Game Gold
	echo "</td>";
	echo "<td style = \"text-align: center;\">";
	echoGPM($PNum); //GPM
	echo "</td>";
	echo "<td>";
	echoItems($PNum);//6 items
	echo "</td>";
	echo "<td>";//Blank spot after Items
	echo "</td>";//^^^^^^^^^^^^^
  echo "<td style = \"text-align: center;\">";
	echoKills($PNum);//Total Season Kills
	echo "</td>";
	echo "<td style = \"text-align: center;\">";
	echoDeaths($PNum);//Total Season Deaths
	echo "</td>";
	echo "<td style = \"text-align: center;\">";
	echoAssists($PNum);//Total Season Assists
	echo "</td>";
	echo "<td style = \"text-align: center;\">";
	echoKDA($PNum);//Season KDA
	echo "</td>";
	echo "<td style = \"text-align: center;\">";
	echoKills($PNum);//Season Kill Per Game Average
	echo "</td>";
	echo "<td style = \"text-align: center;\">";
	echoDeaths($PNum);//Season Deaths per Game Average
	echo "</td>";
	echo "<td style = \"text-align: center;\">";
	echoAssists($PNum);//Season Assists per Game Average
	echo "</td>";
	echo "<td style = \"text-align: center;\">";
	echoCS($PNum); //Season Average CS per Game
	echo "</td>";
	echo "<td style = \"text-align: center;\">";
	echo "*"; //Season Average gold per game
	echo "</td>";
	echo "<td style = \"text-align: center;\">";
	echo "*"; //Season Gold per Minute
	echo "</td>";
}
?>