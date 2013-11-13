<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Player Gallery</title>
<link href="Admin.css" rel="stylesheet" type="text/css" />

<?php

//Login to Database
require_once 'login.php';
mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($dbname);

//fetch names of players
$result = mysql_query("
SELECT ScreenName, PlayerName, JointPlayerName 
FROM PlayerInfo
");
while ($row = mysql_fetch_array($result)) {
	$ScreenName[] = $row['ScreenName'];
	$PlayerName[] = $row['PlayerName'];
	$JointPlayerName[] = $row['JointPlayerName'];
}

?>

</head>
<body>
  <div id="whitebox">
    <div class="caption">
      Player Gallery
    </div>
    <?php
		$max = sizeof($ScreenName);
		for ( $i = 0; $i < $max; $i++ ){
			echo "<div class=\"PlayerPicture\"><img src=\"../Pictures/Players/$JointPlayerName[$i].jpg\" width=\"100\" height=\"200\" />$ScreenName[$i]<br />$PlayerName[$i]<br />$JointPlayerName[$i]</div>";
		}
    ?>
		<div id="contClear"></div>
    <div class="quickEscape">
      <form method="post" action="AdminPanel.php">
        <input type="submit" value="Admin Panel" style="width:193px"/>
      </form>
    </div>
	</div>

</body>
</html>