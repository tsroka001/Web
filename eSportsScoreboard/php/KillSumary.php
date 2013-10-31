<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
body {
	height: 100%;
	width: 100%;
	margin: 0;
	background-repeat: repeat-x;
	background-attachment: scroll;
	font-family: Tahoma, Geneva, sans-serif;
	background-image: url(../Images/diaback.gif);
}

#container {
	position: relative;
	width: 960px;
	margin-right: auto;
	margin-left: auto;
	color: #FFF;
	background-color: #333;
}

#KillBox {
	
}

#KillBox table thead th {
	
}

#KillBox table tbody td {
	
}

.oddRow {
	background-color:#333;
}

.evenRow {
	background-color:#666;
}

</style>
<?php
$host="essbdata.ceutrbzsi5po.us-west-2.rds.amazonaws.com";
$port=3306;
$socket="";
$user="tsroka001";
$password="sqlQ!w2E#";
$dbname="LoLStatsTest2";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
	or die ('Could not connect to the database server' . mysqli_connect_error());



$query = "SELECT * FROM LoLStatsTest2.Game";


if ($stmt = $con->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($field1, $field2);
    while ($stmt->fetch()) {
        printf("%s, %s\n", $field1, $field2);
    }
    $stmt->close();
}

$con->close();

?>
</head>

<body>
	<div id="container">
  	<table>
    <thead>
    <tr>
    <th width="134px">Team
    </th>
    <th width="826px">Play
    </th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>1
    </td>
    <td>2
    </td>
    </tr>
    <tr>
    <td>1
    </td>
    <td>2
    </td>
    </tr>
    </tbody>
    </table>    
  </div>
</body>
</html>