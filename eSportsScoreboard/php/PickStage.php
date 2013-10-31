<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
#content {
	
}

.ssss {
}
body {
	background-color: #333;	
}
#cont {
	background-image: url(../Images/pickArrow2.png);
	background-repeat: repeat-x;
	height: 120px;
	border: thin solid #FFF;
	width: 960px;
	background-position: center center;
	background-color: #FFF;
}

.icon {
	z-index: 2;
	position: absolute;
	clear: left;
}

.images {
	position:absolute;
  z-index: 1;
}

</style>
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

?>


</head>

<body>
</br></br></br>
<div id="cont">

<?php

$result = mysql_query("
SELECT JointChampionName
FROM Champion
JOIN PickOrder ON PickOrder.ChampionID = Champion.ChampionID
WHERE PickOrder.GameID = 2
");
while ($row = mysql_fetch_array($result)) {
  $ChampionPick[] = $row['JointChampionName'];
}

echo <<<END
<table cellpadding="5" cellspacing="0" style = "left : -20px;" >
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




?>

</div>

</body>
</html>