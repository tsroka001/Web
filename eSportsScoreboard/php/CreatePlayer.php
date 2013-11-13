<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="Admin.css" rel="stylesheet" type="text/css" />
<title>Create Player</title>

<?php

$senderror = false;
//Get Posted Variables
if (isset($_POST['GameID'])) $GameID = $_POST['GameID'];
else $senderror=true;

//Login to Database
require_once 'login.php';
mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($dbname);




?>

</head>

<body>
  <div id="whitebox">
    <div class="caption">
      <strong>Create Player</strong>
    </div>
    
    
    
    <div class="quickEscape">
      <form method="post" action="AdminPanel.php">
        <input type="submit" value="Admin Panel" style="width:193px"/>
      </form>
    </div>
	</div>

</body>
</html>