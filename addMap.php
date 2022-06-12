<?php
require_once('config.php');
session_start();
$tiles = $_SESSION['tiles'];
$mapSizeX = $_SESSION['mapSizeX'];
$mapSizeY = $_SESSION['mapSizeY'];
$mapType = $_SESSION['mapType'];
$mapName = $_POST['mapName'];
$userID = $_SESSION['userID'];
unset($_SESSION['tiles']);
$tiles1 = array();
for ($y=0; $y<$mapSizeY; $y++){
	for ($x=0; $x<$mapSizeX; $x++){
		array_push($tiles1,$tiles[$y][$x]);
	}
}
// Create connection
$db = $config['db'];
$conn = new mysqli($db['host'],$db['user'],$db['pass'],$db['database']);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}//add record to db
$sql = "INSERT INTO maps (mapName,userID,mapSizeY,mapSizeX,mapType)
VALUES ('{$mapName}','{$userID}','{$mapSizeY}','{$mapSizeX}','{$mapType}')";
$conn->query($sql);
$mapID = $conn->insert_id;
echo $mapID;
for ($i=0; $i<$mapSizeX*$mapSizeY; $i++){
	$sql = "UPDATE maps SET `{$i}` = {$tiles1[$i]} WHERE mapID = {$mapID};";
	$conn->query($sql);
}
$conn->close();
$_SESSION['message'] = 'Map saved with mapID: ' . $mapID;
echo '<script>window.location = "mapSettings.php"</script>';
?>