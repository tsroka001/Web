<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Panel</title>
<link href="Admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <div id="whitebox">
    <div class="caption">
      <strong>Admin Panel</strong>
    </div>
    <form method="post" action="CreateGame.php">
    <input type="submit" value="Create Game" style="width:319px"/>
    </form>
    <form method="post" action="DeleteGame.php">
    <input type="submit" value="Delete Game" style="width:160px; color:red"/>
    <input type="text" name="GameID" value="Game ID"/>
    </form>
    <form method="post" action="PickOrder.php">
    <input type="submit" value="Pick Order" style="width:160px"/>
    <input type="text" name="GameID" value="Game ID"/>
    </form>
    <form method="post" action="ChampionSelect.php">
    <input type="submit" value="Champion Select" style="width:160px"/>
    <input type="text" name="GameID" value="Game ID"/>
    </form>
    <form method="post" action="UpdateSummoners.php">  
    <input type="submit" value="Set Summoners" style="width:160px"/>
    <input type="text" name="GameID" value="Game ID"/>
    </form>
    <form method="post" action="UpdateItems.php">
    <input type="submit" value="Update Items" style="width:160px"/>
    <input type="text" name="GameID" value="Game ID"/>
    </form>
    <form method="post" action="InsertPlay.php">
    <input type="submit" value="Insert Plays" style="width:160px"/>
    <input type="text" name="GameID" value="Game ID"/>
    </form>
    <form method="post" action="UpdateTowers.php">
    <input type="submit" value="Update Tower Health" style="width:160px"/>
    <input type="text" name="GameID" value="Game ID"/>
    </form>
    <form method="post" action="UpdateLevelCS.php">
    <input type="submit" value="Update Levels, CS & Gold" style="width:160px"/>
    <input type="text" name="GameID" value="Game ID"/>
    </form>
    <form method="post" action="GameState.php">
    <input type="submit" value="Update Game State" style="width:160px"/>
    <input type="text" name="GameID" value="Game ID"/>
    </form>
    <form method="post" action="SetWinnerLength.php">
    <input type="submit" value="Set Game Winner/Length" style="width:160px"/>
    <input type="text" name="GameID" value="Game ID"/>
    </form>
    <form method="get" action="Match.php">
    <input type="submit" value="View Game" style="width:160px"/>
    <input type"text" name="GameID" value="Game ID"/>
    </form>
    <form method="get" action="MatchSearch.php">
    <input type="submit" value="Search For Game" style="width:160px"/>
    <input type"text" name="GameID" value="Game ID"/>
    </form>
    <form method="post" action="InsertGame.php">
    <input type="submit" value="Insert Post Game" style="width:319px"/>
    </form>
  </div>
</body>

</html>