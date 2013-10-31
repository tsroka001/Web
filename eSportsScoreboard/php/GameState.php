<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Change Game State</title>
<link href="Admin.css" rel="stylesheet" type="text/css" />

<?php
$GameIDPostError = false;
$statePostError = false;

if (isset($_POST['GameID'])) $GameID = $_POST['GameID'];
else $GameIDPostError = true;
if (isset($_POST['state'])) $state = $_POST['state'];
else $statePostError = true;

require_once 'login.php';
mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($dbname);

if(!$statePostError){
	mysql_query("UPDATE `LoLStatsTest2`.`Game` SET `GameState`='$state' WHERE `GameID`='$GameID';");
}

?>
</head>

<body>
  <div id="whitebox">
    <div class="caption">
      <strong>Update Game State</strong>
    </div>
    Current Game:<?php echo $GameID;?>
    <form method="post" action="GameState.php">
    	<select name="state">
      	<option value = '1'>PreGame</option>
        <option value = '2'>Picks Stage</option>
        <option value = '3'>In Game</option>
        <option value = '4'>Post Game</option>
      </select>    
    	<input type="hidden" name="GameID" value="<?php echo $GameID;?>" />
			<input type="submit" style="width:160px" />
    </form>
    <form method="post" action="AdminPanel.php">
      <input type="submit" value="Admin Panel" style="width:160px"/>
  	</form>
    </div>
</body>
</html>