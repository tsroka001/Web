<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update Towers</title>
<link href="Admin.css" rel="stylesheet" type="text/css" />

<?php
require_once 'login.php';
mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($dbname);

$GameIDPostError = false;
//$TowerHealthPostError = false;

if (isset($_POST['GameID'])) $GameID = $_POST['GameID'];
else $GameIDPostError = true;

if (isset($_POST['TowerHealth'])) $TowerHealth = $_POST['TowerHealth'];
else $TowerHealthPostError = true;




if(!$GameIDPostError) {
	if (!$TowerHealthPostError){
		//SQL Inserts
		for ( $tower = 0; $tower < 30; $tower++ ){
			$myInsQuery = "UPDATE `LoLStatsTest2`.`TowerHealth` SET `TowerHealth`=$TowerHealth[$tower] WHERE `GameID`='".$GameID."' and`TowerID`='".($tower+1)."';";
			$result = mysql_query($myInsQuery);
		}
	}
	//SQL Selects
	$result = mysql_query("
	SELECT TowerHealth 
	FROM TowerHealth 
	WHERE GameID = $GameID
	");
	while ($row = mysql_fetch_array($result)) {
		$TowerHealth[] = $row['TowerHealth'];
	}
}
?>

</head>

<body>
<div id="whitebox">
  <div class="caption">
    Update Towers
  </div>
  <div id="MapBackground">
    <form method="post" action="UpdateTowers.php">
      <div class="slider" style="top:684px; left:74px;"></div>
        
      <div class="slider" style="top:685px; left:78px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[1] ?>" />
      </div>
        
      <div class="slider" style="top:625px; left:91px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[2] ?>" />
      </div>
        
      <div class="slider" style="top:559px; left:85px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[3] ?>" />
      </div>
        
      <div class="slider" style="top:459px; left:98px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[4] ?>" />
      </div>
        
      <div class="slider" style="top:230px; left:70px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[5] ?>" />
      </div>
      
      <div class="slider" style="top:35px; left:250px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[6] ?>" />
      </div>
        
      <div class="slider" style="top:71px; left:426px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[7] ?>" />
      </div>
      
      <div class="slider" style="top:49px; left:547px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[8] ?>" />
      </div>
      
      <div class="slider" style="top:52px; left:639px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[9] ?>" />
      </div>
      
      <div class="slider" style="top:109px; left:679px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[10] ?>" />
      </div>
      
      <div class="slider" style="top:76px; left:739px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[11] ?>" />
      </div>
      
      <div class="slider" style="top:177px; left:651px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[12] ?>" />
      </div>
      
      <div class="slider" style="top:230px; left:598px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[13] ?>" />
      </div>
      
      <div class="slider" style="top:267px; left:524px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[14] ?>" />
      </div>
      
      <div class="slider" style="top:369px; left:495px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[15] ?>" />
      </div>
      
      <div class="slider" style="top:452px; left:351px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[16] ?>" />
      </div>
        
      <div class="slider" style="top:545px; left:297px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[17] ?>" />
      </div>
      
      <div class="slider" style="top:610px; left:234px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[18] ?>" />
      </div>
      
      <div class="slider" style="top:648px; left:189px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[19] ?>" />
      </div>
      
      <div class="slider" style="top:718px; left:148px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[20] ?>" />
      </div>
      
      <div class="slider" style="top:762px; left:201px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[21] ?>" />
      </div>
      
      <div class="slider" style="top:766px; left:277px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[22] ?>" />
      </div>
      
      <div class="slider" style="top:747px; left:403px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[23] ?>" />
      </div>
        
      <div class="slider" style="top:773px; left:581px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[24] ?>" />
      </div>
      
      <div class="slider" style="top:572px; left:778px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[25] ?>" />
      </div>
      
      <div class="slider" style="top:380px; left:740px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[26] ?>" />
      </div>
      
      <div class="slider" style="top:264px; left:765px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[27] ?>" />
      </div>
      
      <div class="slider" style="top:192px; left:767px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[28] ?>" />
      </div>
      
      <div class="slider" style="top:125px; left:744px;">
        <input type="range" name="TowerHealth[]" min="0" max="100" value="<?php echo $TowerHealth[29] ?>" />
      </div>
 
      <input type="hidden" name="GameID" value="<?php echo $GameID ?>" />
      
      <input type="submit" value="Update Towers" style="width:160px"/>
      
    </form>  
    
    <form method="post" action="AdminPanel.php">
      <input type="submit" value="Admin Panel" style="width:160px"/>
      <span class="slider" style="top:739px; left:102px;">
      <input type="range" name="TowerHealth[]2" min="0" max="100" value="<?php echo $TowerHealth[0] ?>" />
      </span>
    </form>
  </div>
</div>
</body>
</html>