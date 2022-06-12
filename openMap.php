<?php
require_once('config.php');
session_start();
$mapID = (int)$_GET['mapID'];
$tiles = array();
// Create connection
$db = $config['db'];
$conn = new mysqli($db['host'],$db['user'],$db['pass'],$db['database']);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$map = $conn->query("SELECT * FROM maps WHERE mapID = {$mapID};");
$map = $map->fetch_array(MYSQLI_ASSOC);
$mapSizeX = $map['mapSizeX'];
$mapSizeY = $map['mapSizeY'];
$mapType = $map['mapType'];
$mapName = $map['mapName'];
$count = 0;
for ($y=0; $y<$mapSizeY; $y++) {
	$temp = array();
	for ($x=0; $x<$mapSizeX; $x++) {
		array_push($temp,$map[$count]);
		$count++;
	}
	array_push($tiles,$temp);
}
?>
<html>
    <head>
        <title>Nutella Addict</title>
		<meta http-equiv="Cache-control" content="no-cache">
        <link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="icon" href="images/Nutella.ico">
        <script src="script.js"></script>
		<script src="block.js"></script>
    </head>
    <body onload="setZoom();createListener();" onscroll="checkTop()">
		<?php if (isset($_SESSION['userID'])){echo '<div id="userInformation"><p>' . $_SESSION['username'] . ' - (' . $_SESSION['userID'] . ')</p></div>';} ?>
        <p class="title"><?php echo $mapName; ?></p>
        <div id="menuBar">
			<button id="returnButton" onclick="window.open('loadMap.php','_self')"><i class="fa fa-remove"></i></button>
            <div class="menuItem" id="zoomItem">
                <button class="zoomButton" id="firstZoomButton" onclick="zoomIn()"><i class="fa fa-plus"></i></button>
                <button class="zoomButton" onclick="zoomOut()"><i class="fa fa-minus"></i></button>
            </div>
            <div class="menuItem">
                <p class="menuItemTitle">Size:  <?php echo $mapSizeX . ' x ' . $mapSizeY; ?></p>
            </div>
            <div class="menuItem">
                <p class="menuItemTitle">Type: <?php echo $mapType; ?></p>
            </div>
        </div>
		<?php
		echo '<br><br><br><table id="map">';
		for($y=0; $y<$mapSizeY; $y++){
			echo '<tr>';
			for($x=0; $x<$mapSizeX; $x++){
				echo '<td class="';
				if ($tiles[$y][$x] == 0){
					$tileVersion = rand(1,3);
					echo 'grass' . $tileVersion;
				} else if ($tiles[$y][$x] == 1){
					$shallow = false;
					//left
					if ($x == 0){
						if ($tiles[$y][$mapSizeX-1] != 1){
							$shallow = true;
						}
					} else{
						if ($tiles[$y][$x-1] != 1){
							$shallow = true;
						}
					}
					//right
					if ($x == $mapSizeX-1){
						if ($tiles[$y][0] != 1){
							$shallow = true;
						}
					} else{
						if ($tiles[$y][$x+1] != 1){
							$shallow = true;
						}
					}
					//top
					if ($y == 0){
						if ($tiles[0][$x] != 1){
							$shallow = true;
						}
					} else{
						if ($tiles[$y-1][$x] != 1){
							$shallow = true;
						}
					}
					//bottom
					if ($y == $mapSizeY-1){
						if ($tiles[$mapSizeY-1][$x] != 1){
							$shallow = true;
						}
					} else{
						if ($tiles[$y+1][$x] != 1){
							$shallow = true;
						}
					}
					if ($shallow == true){
						echo 'waterShallow';
					} else {
						$tileVersion = rand(1,4);
						echo 'waterDeep' . $tileVersion;
					}
				} else if ($tiles[$y][$x] == 2){
					$tileVersion = rand(1,2);
					echo 'stone' . $tileVersion;
				} else if ($tiles[$y][$x] == 3){
					$tileVersion = rand(1,3);
					echo 'forest' . $tileVersion;
				} else if ($tiles[$y][$x] == 4){
					echo 'mountain';
				} else{
					echo 'error';
				}
				echo '"></td>';
			}
			echo '</tr>';
		}
		echo '</table>';
		?>
	</body>
</html>