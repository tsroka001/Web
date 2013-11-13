<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../ESSBhome.css" rel="stylesheet" type="text/css" media="screen" />

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

require_once('recaptchalib.php');
	
// Get a key from https://www.google.com/recaptcha/admin/create
$publickey = "6LfQvOkSAAAAAGNnW3-JU51DI85wye43G1QkG2DO";
$privatekey = "6LfQvOkSAAAAABQEXSo46cNuA-cJT0zk7X3IZ4pC";

# the response from reCAPTCHA
$resp = null;
# the error code from reCAPTCHA, if any
$error = null;

# was there a reCAPTCHA response?
if ($_POST["recaptcha_response_field"]) {
	$resp = recaptcha_check_answer ($privatekey,
																	$_SERVER["REMOTE_ADDR"],
																	$_POST["recaptcha_challenge_field"],
																	$_POST["recaptcha_response_field"]);

	if ($resp->is_valid) {
		//Code to execute when successful captcha
		
		if (isset($_POST['user'])) $user = mysql_real_escape_string($_POST['user']);
		else $senderror=1;
		if (isset($_POST['comment'])) $comment = mysql_real_escape_string($_POST['comment']);
		else $senderror=1;
		
		mysql_query("INSERT INTO `LoLStatsTest2`.`GComments` (`GameID`, `User`, `Comment`, `Time`, `Date`) VALUES ('1', '". $user ."', '". $comment ."', CURTIME(), CURDATE());"); 
		
		
	}
	else {
		# set the error code so that we can display it
		$error = $resp->error;
	}
}


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

//Blue Team Stats
$result = mysql_query("
	SELECT PlayerInfo.PlayerID, 
	PlayerInfo.ScreenName, 
	PlayerInfo.PlayerName,
	PlayerInfo.JointPlayerName,  
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
	Team.TeamName,
	Team.TeamNameJoint,
	Team.TeamCall,
	I1.ItemName AS Item1S,
	I1.JointItemName AS Item1L,
	I2.ItemName AS Item2S,
	I2.JointItemName AS Item2L,
	I3.ItemName AS Item3S,
	I3.JointItemName AS Item3L,
	I4.ItemName AS Item4S,
	I4.JointItemName AS Item4L,
	I5.ItemName AS Item5S,
	I5.JointItemName AS Item5L,
	I6.ItemName AS Item6S,
	I6.JointItemName AS Item6L
	FROM Player
	JOIN PlayerInfo ON Player.PlayerId = PlayerInfo.PlayerId
	JOIN Game ON Game.GameID = Player.GameID
	JOIN Champion ON Champion.ChampionID = Player.ChampionID
	JOIN Team ON Player.TeamID = Team.TeamID
	JOIN GPItems AS GI1 ON GI1.PlayerID = Player.PlayerID AND GI1.GameID = Player.GameID AND GI1.ItemSlot = 1
	JOIN Item AS I1 ON GI1.ItemID = I1.ItemID
	JOIN GPItems AS GI2 ON GI2.PlayerID = Player.PlayerID AND GI2.GameID = Player.GameID AND GI2.ItemSlot = 2
	JOIN Item AS I2 ON GI2.ItemID = I2.ItemID
	JOIN GPItems AS GI3 ON GI3.PlayerID = Player.PlayerID AND GI3.GameID = Player.GameID AND GI3.ItemSlot = 3
	JOIN Item AS I3 ON GI3.ItemID = I3.ItemID
	JOIN GPItems AS GI4 ON GI4.PlayerID = Player.PlayerID AND GI4.GameID = Player.GameID AND GI4.ItemSlot = 4
	JOIN Item AS I4 ON GI4.ItemID = I4.ItemID
	JOIN GPItems AS GI5 ON GI5.PlayerID = Player.PlayerID AND GI5.GameID = Player.GameID AND GI5.ItemSlot = 5
	JOIN Item AS I5 ON GI5.ItemID = I5.ItemID
	JOIN GPItems AS GI6 ON GI6.PlayerID = Player.PlayerID AND GI6.GameID = Player.GameID AND GI6.ItemSlot = 6
	JOIN Item AS I6 ON GI6.ItemID = I6.ItemID
	WHERE Game.GameID = $GameID AND Game.TeamAID = Player.TeamID
	ORDER BY Player.Lane ASC
");
while ($row = mysql_fetch_array($result)) {
  $b_PlayerID[] = $row['PlayerID'];  
  $b_ScreenName[] = $row['ScreenName'];
	$b_PlayerName[] = $row['PlayerName'];
	$b_JointPlayerName[] = $row['JointPlayerName'];
  $b_ChampionName[] = $row['ChampionName'];
  $b_JointChampionName[] = $row['JointChampionName'];
  $b_SummonerA[] = $row['SummonerA'];
  $b_SummonerB[] = $row['SummonerB'];
  $b_Level[] = $row['Level'];
  $b_Kills[] = $row['Kills'];
  $b_Deaths[] = $row['Deaths'];
  $b_Assists[] = $row['Assists'];
  $b_CreepScore[] = $row['CreepScore'];
  $b_Gold[] = $row['Gold'];
  $b_TeamName[] = $row['TeamName'];
  $b_TeamJointName[] = $row['TeamJointName'];
  $b_TeamCall[] = $row['TeamCall'];
	$b_Item1S[] = $row['Item1S'];
	$b_Item1L[] = $row['Item1L'];
	$b_Item2S[] = $row['Item2S'];
	$b_Item2L[] = $row['Item2L'];
	$b_Item3S[] = $row['Item3S'];
	$b_Item3L[] = $row['Item3L'];
	$b_Item4S[] = $row['Item4S'];
	$b_Item4L[] = $row['Item4L'];
	$b_Item5S[] = $row['Item5S'];
	$b_Item5L[] = $row['Item5L'];
	$b_Item6S[] = $row['Item6S'];
	$b_Item6L[] = $row['Item6L'];
}

//Red Team Stats
$result = mysql_query("
	SELECT PlayerInfo.PlayerID, 
	PlayerInfo.ScreenName, 
	PlayerInfo.PlayerName,
	PlayerInfo.JointPlayerName,  
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
	Team.TeamName,
	Team.TeamNameJoint,
	Team.TeamCall,
	I1.ItemName AS Item1S,
	I1.JointItemName AS Item1L,
	I2.ItemName AS Item2S,
	I2.JointItemName AS Item2L,
	I3.ItemName AS Item3S,
	I3.JointItemName AS Item3L,
	I4.ItemName AS Item4S,
	I4.JointItemName AS Item4L,
	I5.ItemName AS Item5S,
	I5.JointItemName AS Item5L,
	I6.ItemName AS Item6S,
	I6.JointItemName AS Item6L
	FROM Player
	JOIN PlayerInfo ON Player.PlayerId = PlayerInfo.PlayerId
	JOIN Game ON Game.GameID = Player.GameID
	JOIN Champion ON Champion.ChampionID = Player.ChampionID
	JOIN Team ON Player.TeamID = Team.TeamID
	JOIN GPItems AS GI1 ON GI1.PlayerID = Player.PlayerID AND GI1.GameID = Player.GameID AND GI1.ItemSlot = 1
	JOIN Item AS I1 ON GI1.ItemID = I1.ItemID
	JOIN GPItems AS GI2 ON GI2.PlayerID = Player.PlayerID AND GI2.GameID = Player.GameID AND GI2.ItemSlot = 2
	JOIN Item AS I2 ON GI2.ItemID = I2.ItemID
	JOIN GPItems AS GI3 ON GI3.PlayerID = Player.PlayerID AND GI3.GameID = Player.GameID AND GI3.ItemSlot = 3
	JOIN Item AS I3 ON GI3.ItemID = I3.ItemID
	JOIN GPItems AS GI4 ON GI4.PlayerID = Player.PlayerID AND GI4.GameID = Player.GameID AND GI4.ItemSlot = 4
	JOIN Item AS I4 ON GI4.ItemID = I4.ItemID
	JOIN GPItems AS GI5 ON GI5.PlayerID = Player.PlayerID AND GI5.GameID = Player.GameID AND GI5.ItemSlot = 5
	JOIN Item AS I5 ON GI5.ItemID = I5.ItemID
	JOIN GPItems AS GI6 ON GI6.PlayerID = Player.PlayerID AND GI6.GameID = Player.GameID AND GI6.ItemSlot = 6
	JOIN Item AS I6 ON GI6.ItemID = I6.ItemID
	WHERE Game.GameID = $GameID AND Game.TeamBID = Player.TeamID
	ORDER BY Player.Lane ASC
");
while ($row = mysql_fetch_array($result)) {
  $r_PlayerID[] = $row['PlayerID'];  
  $r_ScreenName[] = $row['ScreenName'];
	$r_PlayerName[] = $row['PlayerName'];
	$r_JointPlayerName[] = $row['JointPlayerName'];
  $r_ChampionName[] = $row['ChampionName'];
  $r_JointChampionName[] = $row['JointChampionName'];
  $r_SummonerA[] = $row['SummonerA'];
  $r_SummonerB[] = $row['SummonerB'];
  $r_Level[] = $row['Level'];
  $r_Kills[] = $row['Kills'];
  $r_Deaths[] = $row['Deaths'];
  $r_Assists[] = $row['Assists'];
  $r_CreepScore[] = $row['CreepScore'];
  $r_Gold[] = $row['Gold'];
  $r_TeamName[] = $row['TeamName'];
  $r_TeamJointName[] = $row['TeamJointName'];
  $r_TeamCall[] = $row['TeamCall'];
	$r_Item1S[] = $row['Item1S'];
	$r_Item1L[] = $row['Item1L'];
	$r_Item2S[] = $row['Item2S'];
	$r_Item2L[] = $row['Item2L'];
	$r_Item3S[] = $row['Item3S'];
	$r_Item3L[] = $row['Item3L'];
	$r_Item4S[] = $row['Item4S'];
	$r_Item4L[] = $row['Item4L'];
	$r_Item5S[] = $row['Item5S'];
	$r_Item5L[] = $row['Item5L'];
	$r_Item6S[] = $row['Item6S'];
	$r_Item6L[] = $row['Item6L'];
}

//Current Game Information
$result = mysql_query("
	SELECT Game.TeamAID,
	Game.TeamBID,
	Game.GameState,
	Game.GameDate,
	Game.GameTime,
	Game.Season,
	Game.Tournament,
	Game.Winner,
	Game.GameLength,
	Game.VODLink
	FROM Game
	WHERE Game.GameID = $GameID");
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
	$VOD[] = $row['VODLink'];

}

$result = mysql_query("
	SELECT TeamID, Time
	FROM Objectives
	WHERE GameID = $GameID AND Type='First Blood'");
while ($row = mysql_fetch_array($result)) {
	$FBTeam[] = $row['TeamID'];
	$FBTime[] = $row['Time'];
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

//Query Objectives Stats
$result = mysql_query("
(
SELECT (
SELECT COUNT(Objectives.Type) 
FROM Objectives 
JOIN Game ON Game.TeamAID = Objectives.TeamID AND Objectives.GameID = Game.GameID
WHERE Objectives.GameID = $GameID AND Objectives.Type = 'Dragon' AND Objectives.TeamID = Game.TeamAID
) AS Dragon , (
SELECT COUNT(Objectives.Type) 
FROM Objectives 
JOIN Game ON Game.TeamAID = Objectives.TeamID AND Objectives.GameID = Game.GameID
WHERE Objectives.GameID = $GameID AND Objectives.Type = 'Baron' AND Objectives.TeamID = Game.TeamAID
) AS Baron ,  (
SELECT COUNT(Objectives.Type) 
FROM Objectives 
JOIN Game ON Game.TeamAID = Objectives.TeamID AND Objectives.GameID = Game.GameID
WHERE Objectives.GameID = $GameID AND Objectives.Type = 'Tower' AND Objectives.TeamID = Game.TeamAID
) AS Tower ,  (
SELECT COUNT(Objectives.Type) 
FROM Objectives 
JOIN Game ON Game.TeamAID = Objectives.TeamID AND Objectives.GameID = Game.GameID
WHERE Objectives.GameID = $GameID AND Objectives.Type = 'Inhibitor' AND Objectives.TeamID = Game.TeamAID
) AS Inhibitor ,  (
SELECT COUNT(Objectives.Type) 
FROM Objectives 
JOIN Game ON Game.TeamAID = Objectives.TeamID AND Objectives.GameID = Game.GameID
WHERE Objectives.GameID = $GameID AND Objectives.Type = 'First Blood' AND Objectives.TeamID = Game.TeamAID
) AS FirstBlood
) UNION ALL (
SELECT (
SELECT COUNT(Objectives.Type) 
FROM Objectives 
JOIN Game ON Game.TeamBID = Objectives.TeamID AND Objectives.GameID = Game.GameID
WHERE Objectives.GameID = $GameID AND Objectives.Type = 'Dragon' AND Objectives.TeamID = Game.TeamBID
) AS Dragon , (
SELECT COUNT(Objectives.Type) 
FROM Objectives 
JOIN Game ON Game.TeamBID = Objectives.TeamID AND Objectives.GameID = Game.GameID
WHERE Objectives.GameID = $GameID AND Objectives.Type = 'Baron' AND Objectives.TeamID = Game.TeamBID
) AS Baron ,  (
SELECT COUNT(Objectives.Type) 
FROM Objectives 
JOIN Game ON Game.TeamBID = Objectives.TeamID AND Objectives.GameID = Game.GameID
WHERE Objectives.GameID = $GameID AND Objectives.Type = 'Tower' AND Objectives.TeamID = Game.TeamBID
) AS Tower ,  (
SELECT COUNT(Objectives.Type) 
FROM Objectives 
JOIN Game ON Game.TeamBID = Objectives.TeamID AND Objectives.GameID = Game.GameID
WHERE Objectives.GameID = $GameID AND Objectives.Type = 'Inhibitor' AND Objectives.TeamID = Game.TeamBID
) AS Inhibitor ,  (
SELECT COUNT(Objectives.Type) 
FROM Objectives 
JOIN Game ON Game.TeamBID = Objectives.TeamID AND Objectives.GameID = Game.GameID
WHERE Objectives.GameID = $GameID AND Objectives.Type = 'First Blood' AND Objectives.TeamID = Game.TeamBID
) AS FirstBlood
)
");
while ($row = mysql_fetch_array($result)) {
	$NumDragon[] = $row['Dragon'];
	$NumBaron[] = $row['Baron'];
	$NumTower[] = $row['Tower'];
	$NumInhibitor[] = $row['Inhibitor'];
	$NumFirstBlood[] = $row['FirstBlood'];
}

//Get Pick Order
$result = mysql_query("
	SELECT JointChampionName
	FROM Champion
	JOIN PickOrder ON PickOrder.ChampionID = Champion.ChampionID
	WHERE PickOrder.GameID = $GameID
	");
while ($row = mysql_fetch_array($result)) {
	$ChampionPick[] = $row['JointChampionName'];
}


//Convert GameTime to seconds for further use
//note: $GameLength is a string in the format of MM:SS
$LengthSec = (((int)(substr($GameLength[0], 0, 2)) * 60) + (int)substr($GameLength[0], 3, 4));

//Combine arrays from queries
$PlayerID = array_merge($b_PlayerID, $r_PlayerID);
$ScreenName = array_merge($b_ScreenName, $r_ScreenName);
$PlayerName = array_merge($b_PlayerName, $r_PlayerName);
$JointPlayerName = array_merge($b_JointPlayerName, $r_JointPlayerName);
$ChampionName = array_merge($b_ChampionName, $r_ChampionName);
$JointChampionName = array_merge($b_JointChampionName, $r_JointChampionName);
$SummonerA = array_merge($b_SummonerA, $r_SummonerA);
$SummonerB = array_merge($b_SummonerB, $r_SummonerB);
$Level = array_merge($b_Level, $r_Level);
$Kills = array_merge($b_Kills, $r_Kills);
$Deaths = array_merge($b_Deaths, $r_Deaths);
$Assists = array_merge($b_Assists, $r_Assists);
$CreepScore = array_merge($b_CreepScore, $r_CreepScore);
$Gold = array_merge($b_Gold, $r_Gold);
$TeamName = array_merge($b_TeamName, $r_TeamName);
$TeamJointName = array_merge($b_TeamJointName, $r_TeamJointName);
$TeamCall = array_merge($b_TeamCall, $r_TeamCall); 
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
  
  	<div id="mid_content">
    
        <div class="TourneyLogo">
        <img src="../Images/NACL.png" width="400" height="120" />
        </div>
        
        <div class="TeamInfo FloatLeft">      	
          <div class="TeamLogo">
          <img src="../TeamLogos/<?php echo $TeamCall[0];?>.png" width="120" height="120" />
          </div>
          <div class="TeamWL">
          	<div class="GameOutcome"><?php if ($BlueTeamID[0] == $Winner[0]){ echo 'Win'; } else { echo 'Loss';}?></div>
          	<div class="TeamCall"><?php echo $TeamCall[0];?></div>
          	<div class="WL">99W-99L</div>
          </div>
        </div>
        
        <div class="TeamInfo FloatRight">
          <div class="TeamLogo">
          <img src="../TeamLogos/<?php echo $TeamCall[5];?>.png" width="120" height="120" />
          </div>
          <div class="TeamWL">
          	<div class="GameOutcome"><?php if ($RedTeamID[0] == $Winner[0]){ echo 'Win'; } else { echo 'Loss';}?></div>
          	<div class="TeamCall"><?php echo $TeamCall[5];?></div>
          	<div class="WL">99W-99L</div>
          </div>
        </div>
        
    		<div id="contClear"></div>
    
        <div class="yel_head">
        	<div class="yel_a"></div>
          <div class="yel_b">Overview</div>
          <div class="yel_c"></div>
        </div>
        
        <div class="OverviewContent">
        	<div class="OverviewPicBox">
          	<div class="OverviewPlayer"><img src="../Pictures/Players/<?php echo $JointPlayerName[0]; ?>.jpg" width="80" height="160" /></div>
          	<div class="OverviewPlayer"><img src="../Pictures/Players/<?php echo $JointPlayerName[1]; ?>.jpg" width="80" height="160" /></div>
          	<div class="OverviewPlayer"><img src="../Pictures/Players/<?php echo $JointPlayerName[2]; ?>.jpg" width="80" height="160" /></div>
          	<div class="OverviewPlayer"><img src="../Pictures/Players/<?php echo $JointPlayerName[3]; ?>.jpg" width="80" height="160" /></div>
          	<div class="OverviewPlayer"><img src="../Pictures/Players/<?php echo $JointPlayerName[4]; ?>.jpg" width="80" height="160" /></div>
          	<div id="contClear"></div>
            <div class="OverviewNameBox Blue">
            	<div class="ONBa"></div>
            	<div class="ONBb"><?php echo $TeamName[0];?></div>
              <div class="ONBc"></div>
            </div>
            <div id="contClear"></div>
            <div class="OvreviewStatsBox">
							<div class="OSBStat">
              	<div class="OSBStatNum">
                	<?php echo Kills(0)+Kills(1)+Kills(2)+Kills(3)+Kills(4); ?>
                </div>
                <div class="OSBStatSub">
                	Kills
                </div>
              </div>
              <div class="OSBStat">
              	<div class="OSBStatNum">
                	<?php echo Deaths(0)+Deaths(1)+Deaths(2)+Deaths(3)+Deaths(4); ?>
                </div>
                <div class="OSBStatSub">
                	Deaths
                </div>
              </div>
              <div class="OSBStat">
              	<div class="OSBStatNum">
                	<?php echo Assists(0)+Assists(1)+Assists(2)+Assists(3)+Assists(4); ?>
                </div>
                <div class="OSBStatSub">
                	Assists
                </div>
              </div>
              <div class="OSBStat">
              	<div class="OSBStatNum">
                	<?php echo (Gold(0)+Gold(1)+Gold(2)+Gold(3)+Gold(4)).'K'; ?>
                </div>
                <div class="OSBStatSub">
                	Gold
                </div>
              </div>
              <div class="OSBStat">
              	<div class="OSBStatNum">
                	<?php echo $NumTower[0] ?>
                </div>
                <div class="OSBStatSub">
                	Towers
                </div>
              </div>
              <div class="OSBStat">
              	<div class="OSBStatNum">
                	<?php echo $NumInhibitor[0] ?>
                </div>
                <div class="OSBStatSub">
                	Inhibitors
                </div>
              </div>
              <div class="OSBStat">
              	<div class="OSBStatNum">
                	<?php echo $NumDragon[0] ?>
                </div>
                <div class="OSBStatSub">
                	Dragons
                </div>
              </div>
              <div class="OSBStat">
              	<div class="OSBStatNum">
                	<?php echo $NumBaron[0] ?>
                </div>
                <div class="OSBStatSub">
                	Barons
                </div>
              </div>
              <?php	echoWinFB(1)?>
            </div>
          </div>
        </div>
        
        
        
              
        <div class="VS">
          <img src="../Images/Versus.png" width="100" height="100" />
        </div>
        
        
        <div class="OverviewContent">
        	<div class="OverviewPicBox">
          	<div class="OverviewPlayer"><img src="../Pictures/Players/<?php echo $JointPlayerName[5]; ?>.jpg" width="80" height="160" /></div>
          	<div class="OverviewPlayer"><img src="../Pictures/Players/<?php echo $JointPlayerName[6]; ?>.jpg" width="80" height="160" /></div>
          	<div class="OverviewPlayer"><img src="../Pictures/Players/<?php echo $JointPlayerName[7]; ?>.jpg" width="80" height="160" /></div>
          	<div class="OverviewPlayer"><img src="../Pictures/Players/<?php echo $JointPlayerName[8]; ?>.jpg" width="80" height="160" /></div>
          	<div class="OverviewPlayer"><img src="../Pictures/Players/<?php echo $JointPlayerName[9]; ?>.jpg" width="80" height="160" /></div>
          	<div id="contClear"></div>
            <div class="OverviewNameBox Red">
            	<div class="ONBa"></div>
            	<div class="ONBb"><?php echo $TeamName[5];?></div>
              <div class="ONBc"></div>
            </div>
            <div id="contClear"></div>
            <div class="OvreviewStatsBox">
							<div class="OSBStat">
              	<div class="OSBStatNum">
                	<?php echo Kills(5)+Kills(6)+Kills(7)+Kills(8)+Kills(9); ?>
                </div>
                <div class="OSBStatSub">
                	Kills
                </div>
              </div>
              <div class="OSBStat">
              	<div class="OSBStatNum">
                	<?php echo Deaths(5)+Deaths(6)+Deaths(7)+Deaths(8)+Deaths(9); ?>
                </div>
                <div class="OSBStatSub">
                	Deaths
                </div>
              </div>
              <div class="OSBStat">
              	<div class="OSBStatNum">
                	<?php echo Assists(5)+Assists(6)+Assists(7)+Assists(8)+Assists(9); ?>
                </div>
                <div class="OSBStatSub">
                	Assists
                </div>
              </div>
              <div class="OSBStat">
              	<div class="OSBStatNum">
                	<?php echo (Gold(5)+Gold(6)+Gold(7)+Gold(8)+Gold(9)).'K'; ?>
                </div>
                <div class="OSBStatSub">
                	Gold
                </div>
              </div>
              <div class="OSBStat">
              	<div class="OSBStatNum">
                	<?php echo $NumTower[1] ?>
                </div>
                <div class="OSBStatSub">
                	Towers
                </div>
              </div>
              <div class="OSBStat">
              	<div class="OSBStatNum">
                	<?php echo $NumInhibitor[1] ?>
                </div>
                <div class="OSBStatSub">
                	Inhibitors
                </div>
              </div>
              <div class="OSBStat">
              	<div class="OSBStatNum">
                	<?php echo $NumDragon[1] ?>
                </div>
                <div class="OSBStatSub">
                	Dragons
                </div>
              </div>
              <div class="OSBStat">
              	<div class="OSBStatNum">
                	<?php echo $NumBaron[1] ?>
                </div>
                <div class="OSBStatSub">
                	Barons
                </div>
              </div>
              <?php	echoWinFB(2)?>
            </div>
          </div>
        </div>
        
        
        
        <div id="contClear"></div>
                
        <div class="yel_head">
        	<div class="yel_a"></div>
          <div class="yel_b">Scoreboard</div>
          <div class="yel_c"></div>
        </div>
        
        <div class="TableContent">
        	<div class="TableTeamCall FloatLeft"><div class="rotate Blue TableTeamCallText"><?php echo $TeamCall[0]; ?></div></div>
          <div class="datagrid">
          <table><thead><tr><th style = "width: 566px; text-align: center;">Game Stats</th><th style = "width: 220px; text-align: center;">Season Stats</th></tr></thead></table>
            <table>
            <?php DisplayTableHeader() ?>
            <tbody>          
            <tr>						<?php DisplayTablePlayer(0) ?></tr>          
            <tr class="alt"><?php DisplayTablePlayer(1) ?></tr>
            <tr>						<?php DisplayTablePlayer(2) ?></tr>
            <tr class="alt"><?php DisplayTablePlayer(3) ?></tr>          
            <tr>						<?php DisplayTablePlayer(4) ?></tr> 
            <tr class="alt"><?php DisplayTableTeam(1) ?></tr>         
            </tbody>
            </table>
          </div>
          <div class="TableTeamCall FloatLeft"><div class="rotate Red TableTeamCallText"><?php echo $TeamCall[5]; ?></div></div>
          <div class="datagrid">          
            <table>
            <?php DisplayTableHeader() ?>
            <tbody>          
            <tr>         	  <?php DisplayTablePlayer(5) ?></tr>          
            <tr class="alt"><?php DisplayTablePlayer(6) ?></tr>          
            <tr>            <?php DisplayTablePlayer(7) ?></tr>          
            <tr class="alt"><?php DisplayTablePlayer(8) ?></tr>          
            <tr>            <?php DisplayTablePlayer(9) ?></tr>
            <tr class="alt"><?php DisplayTableTeam(2) ?></tr>
            </tbody>
            </table>          
            
          </div>
          
          <div id="contClear"></div>
        </div>
        <div class="yel_head">
          <div class="yel_a"></div>
          <div class="yel_b">Picks & Bans</div>
          <div class="yel_c"></div>
        </div>        

        <div id="Picks">
        	<div id="POBox">
          	<div id="POTeams">
            	<div id="POTeamsBlank"></div>
              <div class="POTeamBox">
              	<div class="rotate Blue POTeamText"><?php echo $TeamCall[0]; ?></div>
              </div>
              <div class="POTeamBox">
              	<div class="rotate Red POTeamText"><?php echo $TeamCall[5]; ?></div>
              </div> 
            </div>
            <div id="POBans">
            	<div id="POBanTag">
              	<div class="PickLabel">
                	<div class="PLa"></div>
                  <div class="PLb"> &nbsp&nbsp Bans &nbsp&nbsp </div>
                  <div class="PLc"></div>
                </div>             	
              </div>
              <div id="POBanTable">
              	<div class="POIcon" style="background-image:url('../ChampIcons/<?php echo $ChampionPick[0] ?>.png');">
                <img src="../Images/banned.png" width="49" height="49" /></div>
                <div class="POIcon" style="background-image:url('../Images/ArrowThrough.png');">
                </div>
                <div class="POIcon" style="background-image:url('../ChampIcons/<?php echo $ChampionPick[2] ?>.png');">
                <img src="../Images/banned.png" width="49" height="49" /></div>
                <div class="POIcon" style="background-image:url('../Images/ArrowThrough.png');">
                </div>
                <div class="POIcon" style="background-image:url('../ChampIcons/<?php echo $ChampionPick[4] ?>.png');">
                <img src="../Images/banned.png" width="49" height="49" /></div>
                <div class="POIcon" >
                </div>
                <div class="POIcon" >
                </div>
                <div class="POIcon" style="background-image:url('../ChampIcons/<?php echo $ChampionPick[1] ?>.png');">
                <img src="../Images/banned.png" width="49" height="49" /></div>
                <div class="POIcon" style="background-image:url('../Images/ArrowThrough.png');">
                </div>
                <div class="POIcon" style="background-image:url('../ChampIcons/<?php echo $ChampionPick[3] ?>.png');">
                <img src="../Images/banned.png" width="49" height="49" /></div>
                <div class="POIcon" style="background-image:url('../Images/ArrowThrough.png');">
                </div>
                <div class="POIcon" style="background-image:url('../ChampIcons/<?php echo $ChampionPick[5] ?>.png');">
                <img src="../Images/banned.png" width="49" height="49" /></div>
              </div>
            </div>
            <div id="POPicks">
            	<div id="POPickTag">
              	<div class="PickLabel">
                	<div class="PLa"></div>
                  <div class="PLb"> &nbsp&nbsp Picks &nbsp&nbsp </div>
                  <div class="PLc"></div>
                </div>
              </div>
              <div id="POPickTable">
              	<div class="POIcon" style="background-image:url('../ChampIcons/<?php echo $ChampionPick[6] ?>.png');">
                </div>
                <div class="POIcon" style="background-image:url('../Images/LineThrough.png');">
                </div>
                <div class="POIcon" style="background-image:url('../Images/ArrowThrough.png');">
                </div>
                <div class="POIcon" style="background-image:url('../ChampIcons/<?php echo $ChampionPick[9] ?>.png');">
                </div>
                <div class="POIcon" style="background-image:url('../ChampIcons/<?php echo $ChampionPick[10] ?>.png');">
                </div>
                <div class="POIcon" style="background-image:url('../Images/LineThrough.png');">
                </div>
                <div class="POIcon" style="background-image:url('../Images/ArrowThrough.png');">
                </div>
                <div class="POIcon" style="background-image:url('../ChampIcons/<?php echo $ChampionPick[13] ?>.png');">
                </div>
                <div class="POIcon" style="background-image:url('../ChampIcons/<?php echo $ChampionPick[14] ?>.png');">
                </div>
                <div class="POIcon" >
                </div>
                <div class="POIcon" >
                </div>
                <div class="POIcon" style="background-image:url('../ChampIcons/<?php echo $ChampionPick[7] ?>.png');">
                </div>
                <div class="POIcon" style="background-image:url('../ChampIcons/<?php echo $ChampionPick[8] ?>.png');">
                </div>
                <div class="POIcon" style="background-image:url('../Images/LineThrough.png');">
                </div>
                <div class="POIcon" style="background-image:url('../Images/ArrowThrough.png');">
                </div>
                <div class="POIcon" style="background-image:url('../ChampIcons/<?php echo $ChampionPick[11] ?>.png');">
                </div>
                <div class="POIcon" style="background-image:url('../ChampIcons/<?php echo $ChampionPick[12] ?>.png');">
                </div>
                <div class="POIcon" style="background-image:url('../Images/LineThrough.png');">
                </div>
                <div class="POIcon" style="background-image:url('../Images/ArrowThrough.png');">
                </div>
                <div class="POIcon" style="background-image:url('../ChampIcons/<?php echo $ChampionPick[15] ?>.png');">
                </div>

              </div>
            </div>
          </div>
          
          <div id="contClear"></div>
          
          <div id="CommonContainer">
          	<div id="ComLabel">
         				<div class="PickLabel">
                	<div class="PLa"></div>
                  <div class="PLb"> &nbsp&nbsp Player Top Picks &nbsp&nbsp </div>
                  <div class="PLc"></div>
                </div>
            </div>
                <div id="contClear"></div>
          	<div class="ComTeam">
            	<?php echoTopPicks(0);
							echoTopPicks(1);
							echoTopPicks(2);
							echoTopPicks(3);
							echoTopPicks(4); ?>              
            </div>
            <div class="ComTeam">
            	<?php echoTopPicks(5);
							echoTopPicks(6);
							echoTopPicks(7);
							echoTopPicks(8);
							echoTopPicks(9); ?>
            </div>
          </div>
          
          
        </div>

        
        <div class="yel_head">
        	<div class="yel_a"></div>
          <div class="yel_b">VOD</div>
          <div class="yel_c"></div>
        </div>        
        
				<div id="VOD">
        	<?php
						if ( (substr($VOD[0], 0, 6)) == 'No VOD'){
							echo "No VOD available for this match.";
						}
						else{					
							if ( (substr($VOD[0], 0, 1)) != '<'){
								//Youtube VOD
								echo '<iframe src="//www.youtube.com/embed/'.$VOD[0].'" width="855" height="480" frameborder="0" allowfullscreen></iframe>';
							}
							else {
								//Twitch VOD
								echo "<object bgcolor='#000000' data='http://www.twitch.tv/widgets/archive_embed_player.swf' height='480' id='clip_embed_player_flash' type='application/x-shockwave-flash' width='855'>".$VOD[0];
							}
						}
					?>
        	
        </div>
        
      	<div id="contClear"></div>
    
   			 <div class="yel_head">
        	<div class="yel_a"></div>
          <div class="yel_b">Game Comments</div>
          <div class="yel_c"></div>
        </div> 
      
    <form action="" method="post">
    <div id="comlist">
    
      <?php      
        $result = mysql_query("
          SELECT * FROM GComments");
        while ($row = mysql_fetch_array($result)) {
          $CID[] = $row['CommentID'];
          $GID[] = $row['GameID'];
          $USR[] = $row['User'];
          $CMT[] = $row['Comment'];
        }
        $max = sizeof($CID);
        echo "<table style=\"cell-padding:3px; font-size:small\">";
        for ($i = 0; $i < $max; $i++){
          echo "<tr><td style=\"text-align:right; color:#FFFAD0\">$USR[$i]</td><td style=\"color:#FFF\">-</td><td style=\"color:#FFF\">$CMT[$i]</td></tr>";
        }
        echo "</table>";
      ?>
      
    </div>
    <div id="cptcha">
    
      <?php      
      echo recaptcha_get_html($publickey, $error);      
      ?>
      
    </div> 
    
    <div id="submitField"><input type="submit" value="submit" /></div> 
    <div id="userField">Username:<input type="text" size=20 maxlength=20 name="user" placeholder="username"/><br/></div>
    <br />
    <div id="commentField">Comment:<br /><textarea size=128 maxlength=128 cols=64 rows="4" name="comment" placeholder="comment"/></textarea></div>
    <div id="contClear"></div>
    </form>      
  	</div>
  </div>
  <div id="bot">
  Notes:
  <ul>
    <li>add popular piuck to pick section in map section </li>
    <li>add first tower predictions and tower killing speeds as well as inhibs add season totals, add kill participation create popular picks section</li>
  	<li>add tournament brackets / schedules</li>
    <li>in stats table add team totals + draons barons</li>
    <li>add player rank in player profiles</li>
    <li>fix huge list of missing rounding </li>
    <li>Replace towers with structures</li>
    <li>Add leaguepedia links on player profiles</li>
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

function Kills($PlayerNum){
	global $Kills;
	return $Kills[$PlayerNum];
}

function Deaths($PlayerNum){
	global $Deaths;
	return $Deaths[$PlayerNum];
}

function Assists($PlayerNum){
	global $Assists;
	return $Assists[$PlayerNum];
}

function KDA($PlayerNum){
	global $Kills, $Deaths, $Assists;
	if ($Deaths[$PlayerNum] != 0){
		return round((($Kills[$PlayerNum] + $Assists[$PlayerNum])/$Deaths[$PlayerNum]), 2);
	}
	else{
		return round(($Kills[$PlayerNum] + $Assists[$PlayerNum]), 2);
	}
}

function KP($PlayerNum){
	global $Kills, $Deaths, $Assists;
	if ($PlayerNum < 5){
		return round((float)(($Kills[$PlayerNum]+$Assists[$PlayerNum])/($Kills[0]+$Kills[1]+$Kills[2]+$Kills[3]+$Kills[4])) * 100 ) . '%';
	}
	else{
		return round((float)(($Kills[$PlayerNum]+$Assists[$PlayerNum])/($Kills[5]+$Kills[6]+$Kills[7]+$Kills[8]+$Kills[9])) * 100 ) . '%';
	}
}

function Level($PlayerNum){
	global $Level;
	return $Level[$PlayerNum];
}

function CS($PlayerNum){
	global $CreepScore;
	return $CreepScore[$PlayerNum];
}

function echoItems($PlaNum){
	global  $b_Item1S, 	$b_Item1L,	$b_Item2S,	$b_Item2L,	$b_Item3S,	$b_Item3L,
					$b_Item4S,	$b_Item4L,	$b_Item5S,	$b_Item5L,	$b_Item6S,	$b_Item6L,
					$r_Item1S, 	$r_Item1L,	$r_Item2S,	$r_Item2L,	$r_Item3S,	$r_Item3L,
					$r_Item4S,	$r_Item4L,	$r_Item5S,	$r_Item5L,	$r_Item6S,	$r_Item6L;
	if ($PlaNum < 5){
		echo "<img src=\"../ItemIcons/32px-".$b_Item1L[$PlaNum].".gif\" width=\"20\" height=\"20\" />";
		echo "<img src=\"../ItemIcons/32px-".$b_Item2L[$PlaNum].".gif\" width=\"20\" height=\"20\" />";
		echo "<img src=\"../ItemIcons/32px-".$b_Item3L[$PlaNum].".gif\" width=\"20\" height=\"20\" />";
		echo "<img src=\"../ItemIcons/32px-".$b_Item4L[$PlaNum].".gif\" width=\"20\" height=\"20\" />";
		echo "<img src=\"../ItemIcons/32px-".$b_Item5L[$PlaNum].".gif\" width=\"20\" height=\"20\" />";
		echo "<img src=\"../ItemIcons/32px-".$b_Item6L[$PlaNum].".gif\" width=\"20\" height=\"20\" />";
	}
	else{
		$PlaNum = ($PlaNum - 5);
		echo "<img src=\"../ItemIcons/32px-".$r_Item1L[$PlaNum].".gif\" width=\"20\" height=\"20\" />";
		echo "<img src=\"../ItemIcons/32px-".$r_Item2L[$PlaNum].".gif\" width=\"20\" height=\"20\" />";
		echo "<img src=\"../ItemIcons/32px-".$r_Item3L[$PlaNum].".gif\" width=\"20\" height=\"20\" />";
		echo "<img src=\"../ItemIcons/32px-".$r_Item4L[$PlaNum].".gif\" width=\"20\" height=\"20\" />";
		echo "<img src=\"../ItemIcons/32px-".$r_Item5L[$PlaNum].".gif\" width=\"20\" height=\"20\" />";
		echo "<img src=\"../ItemIcons/32px-".$r_Item6L[$PlaNum].".gif\" width=\"20\" height=\"20\" />";
	}
}

function Gold($PlayerNum){
	global $Gold;
	if ( $Gold[$PlayerNum] > 999 ){
		return round(($Gold[$PlayerNum]/1000), 1)."K";
	}
	else{
		return $Gold[$PlayerNum];
	}
}

function GPM($PlayerNum){
	global $Gold, $LengthSec;
	return round(($Gold[$PlayerNum]/($LengthSec/60)), 0);
}

function DisplayTableHeader(){
	echo <<<END
	<thead>
	<tr>
	<th style = "width:20px"></th>
	<th style = "width:100px; text-align: center;"> Player</th>
	<th style = "width:40px; text-align: center;">S</th>
	<th style = "width:20px; text-align: center;"> K</th>
	<th style = "width:20px; text-align: center;"> D</th>
	<th style = "width:20px; text-align: center;"> A</th>
	<th style = "width:30px; text-align: center;"> KDA</th>
	<th style = "width:35px; text-align: center;"> KP</th>
	<th style = "width:20px; text-align: center;"> L</th>
	<th style = "width:25px; text-align: center;"> CS</th>
	<th style = "width:40px; text-align: center;"> G</th>
	<th style = "width:40px; text-align: center;"> GPM</th>
	<th style = "width:120px; text-align: center;"> Items</th>
	<th style = "width:20px; text-align: center;"> KPG</th>
	<th style = "width:20px; text-align: center;"> DPG</th>
	<th style = "width:20px; text-align: center;"> APG</th>
	<th style = "width:35px; text-align: center;"> KDA</th>
	<th style = "width:25px; text-align: center;"> ACS</th>
	<th style = "width:40px; text-align: center;"> AG</th>
	<th style = "width:40px; text-align: center;"> AGPM</th>
	</tr>
	</thead>
END;
}

function DisplayTablePlayer($PNum){
	echo "<td>";
	echoChampion($PNum);
	echo "</td>\n";
	echo "<td>";
	echoPlayer($PNum);
	echo "</td>\n";
	echo "<td>";
	echoSummoners($PNum);
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo Kills($PNum);
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo Deaths($PNum);
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo Assists($PNum);
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo KDA($PNum);
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo KP($PNum);
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo Level($PNum);
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo CS($PNum);
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo Gold($PNum); //Game Gold
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo GPM($PNum); //GPM
	echo "</td>\n";
	echo "<td>";
	echoItems($PNum);//6 items
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo Kills($PNum);//Season Kill Per Game Average
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo Deaths($PNum);//Season Deaths per Game Average
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo Assists($PNum);//Season Assists per Game Average
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo KDA($PNum);//Season KDA
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo CS($PNum); //Season Average CS per Game
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo Gold($PNum); //Season Average gold per game
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo GPM($PNum); //Season Gold per Minute
	echo "</td>\n";
}

//Display Team Totals in the stats table
function DisplayTableTeam($TeamNum){	
	if ( $TeamNum == 1 ){
		$PID = array(0,1,2,3,4);
	}
	else{
		$PID = array(5,6,7,8,9);
	}
	global $TeamCall;
	echo "<td>";
	echo '<img src="../TeamLogos/'.$TeamCall[$PID[0]].'.png" width="20" height="20" />';
	echo "</td>\n";
	echo "<td>";
	echo "Team Totals:";
	echo "</td>\n";
	echo "<td>";
	//No Summoners
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo Kills($PID[0])+Kills($PID[1])+Kills($PID[2])+Kills($PID[3])+Kills($PID[4]);
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo Deaths($PID[0])+Deaths($PID[1])+Deaths($PID[2])+Deaths($PID[3])+Deaths($PID[4]);
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo Assists($PID[0])+Assists($PID[1])+Assists($PID[2])+Assists($PID[3])+Assists($PID[4]);
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo (KDA($PID[0])+KDA($PID[1])+KDA($PID[2])+KDA($PID[3])+KDA($PID[4]))/5;
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	// NO KP
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	//No Levels maybe average level eventually
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo CS($PID[0])+CS($PID[1])+CS($PID[2])+CS($PID[3])+CS($PID[4]);
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo (Gold($PID[0])+Gold($PID[1])+Gold($PID[2])+Gold($PID[3])+Gold($PID[4])).'K'; //Game Gold
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo GPM($PID[0])+GPM($PID[1])+GPM($PID[2])+GPM($PID[3])+GPM($PID[4])+GPM($PID[5]); //GPM
	echo "</td>\n";
	echo "<td>";
	//no items
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo Kills($PNum);//Season Kill Per Game Average
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo Deaths($PNum);//Season Deaths per Game Average
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo Assists($PNum);//Season Assists per Game Average
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo KDA($PNum);//Season KDA
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo CS($PNum); //Season Average CS per Game
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo Gold($PNum); //Season Average gold per game
	echo "</td>\n";
	echo "<td style = \"text-align: center;\">";
	echo GPM($PNum); //Season Gold per Minute
	echo "</td>\n";
}

function TopPicks($teamnum){ //finish after making a functioning mysql query to obtain results
	global $TeamName;
	echo '<p>Player Top Picks</p>';
	echo '<div class="PicksTable">';
	echo '<table><tr><td width="200em">';
	
}

function echoOverview(){
	//insert team a vs team b with logos <br/> team records / winner / top performers (K/A/G/CS) / torunament / standings? tower score dragons barons
	
}

function echoObjectives(){
	global $NumDragon, $NumBaron, $NumTower, $NumFirstBlood;
	echo "Dragons $NumDragon[0] Barons $NumBaron[0] Towers $NumTower[0] First Blood $NumFirstBlood[0]<br/>";
	echo "Dragons $NumDragon[1] Barons $NumBaron[1] Towers $NumTower[1] First Blood $NumFirstBlood[1]";

}

function echoWinFB($TeamNum){
	global $BlueTeamID, $RedTeamID, $Winner, $GameLength, $FBTeam, $FBTime;
	if ($TeamNum == 1){
		//Execute code bor blue team
		if ($BlueTeamID[0] == $FBTeam[0]){		
			//Blue Team got FB
			echo '<div class="OSBaddon">First Blood in '.$FBTime[0].'</div>';
		}
		if ($BlueTeamID[0] == $Winner[0]){
			//Blue Team WON
			echo '<div class="OSBaddon">Victory in '.$GameLength[0].'</div>';
		}
	}
	else{
		//Execute code bor blue team
		if ($RedTeamID[0] == $FBTeam[0]){		
			//Blue Team got FB
			echo '<div class="OSBaddon">First Blood in '.$FBTime[0].'</div>';
		}
		if ($RedTeamID[0] == $Winner[0]){
			//Blue Team WON
			echo '<div class="OSBaddon">Victory in '.$GameLength[0].'</div>';
		}
	}
}

function echoTopPicks($PID){
	global $ScreenName, $TeamCall;	
	
	echo '<div class="ComTeamID">';
	if ( $PID == 1){
		echo '<div class="rotate Blue POTeamText">'.$TeamCall[$PID].'</div>';
	}
	if ( $PID == 6 ){
		echo '<div class="rotate Red POTeamText">'.$TeamCall[$PID].'</div>';
	}
	echo <<<END
		</div>
		<div class="ComPlayer">
			$ScreenName[$PID]
		</div>
		<div class="ComChampPool">
			<div class="ComChamp">
				<img src="../ChampIcons/Ahri.png" />
				<div class="ComChampText">56%</div>
			</div>
			<div class="ComChamp">
				<img src="../ChampIcons/Akali.png" />
				<div class="ComChampText">23%</div>
			</div>
			<div class="ComChamp">
				<img src="../ChampIcons/Alistar.png" />
				<div class="ComChampText">10%</div>
			</div>
		</div>
		<div id="contClear"></div>
END;
}



?>


