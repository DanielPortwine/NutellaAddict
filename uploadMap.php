<?php
session_start();
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
    <body onload="setZoom()">
		<?php if (isset($_SESSION['userID'])){echo '<div id="userInformation"><p>' . $_SESSION['username'] . ' - (' . $_SESSION['userID'] . ')</p></div>';} ?>
		<audio autoplay loop src="sounds/creditsShort.wav" type="audio/wav"></audio>
        <p class="title">Map upload</p>
        <div class="centralBody">
			<button class="homeButton" onclick="window.location='mapSettings.php';"><i class="fa fa-arrow-left"></i></button>
            <p class="subtitle">Enter a name for your map:</p><br>
            <form class="chatMessage" method="post" action="addMap.php">
                <input class="coordinateBox" id="messageInput" type="text" maxlength="20" placeholder="name" name="mapName" autofocus required>
                <input class="submitButton" id="messageSend" type="submit" name="submit" value="Go">
            </form>
			<br>
			<p class="detail">First 10x10 section (preview):</p>
			<?php
			$tiles = $_SESSION['tiles'];
			$mapSizeX = $_SESSION['mapSizeX'];
			$mapSizeY = $_SESSION['mapSizeY'];
			echo '<table id="map">';
			for($y=0; $y<10; $y++){
				echo '<tr>';
				for($x=0; $x<10; $x++){
					if ($tiles[$y][$x] == 0){
						$tileVersion = rand(1,3);
						echo '<td class="grass' . $tileVersion . '"></td>';
					} else if ($tiles[$y][$x] == 1){
						echo '<td class="water"></td>';
					} else if ($tiles[$y][$x] == 2){
						$tileVersion = rand(1,2);
						echo '<td class="stone' . $tileVersion . '"></td>';
					} else if ($tiles[$y][$x] == 3){
						$tileVersion = rand(1,3);
						echo '<td class="forest' . $tileVersion . '"></td>';
					} else if ($tiles[$y][$x] == 4){
						$leftMountain = 0;
						$rightMountain = 0;
						$topMountain = 0;
						$bottomMountain = 0;
						//left
						if ($x == 0){
							if ($tiles[$y][$mapSizeX-1] == 4){
								$leftMountain = 1;
							}
						} else{
							if ($tiles[$y][$x-1] == 4){
								$leftMountain = 1;
							}
						}
						//right
						if ($x == $mapSizeX-1){
							if ($tiles[$y][0] == 4){
								$rightMountain = 1;
							}
						} else{
							if ($tiles[$y][$x+1] == 4){
								$rightMountain = 1;
							}
						}
						//top
						if ($y == 0){
							if ($tiles[0][$x] == 4){
								$topMountain = 1;
							}
						} else{
							if ($tiles[$y-1][$x] == 4){
								$topMountain = 1;
							}
						}
						//bottom
						if ($y == $mapSizeY-1){
							if ($tiles[$mapSizeY-1][$x] == 4){
								$bottomMountain = 1;
							}
						} else{
							if ($tiles[$y+1][$x] == 4){
								$bottomMountain = 1;
							}
						}
						//set the tile
						if ($leftMountain == 1 && $rightMountain == 1 && $topMountain == 1 && $bottomMountain == 1){
							echo '<td class="mountain12"></td>';
						} else if ($leftMountain == 1 && $rightMountain == 1 && $topMountain == 1 && $bottomMountain == 0){
							echo '<td class="mountain16"></td>';
						} else if ($leftMountain == 1 && $rightMountain == 1 && $topMountain == 0 && $bottomMountain == 1){
							echo '<td class="mountain13"></td>';
						} else if ($leftMountain == 1 && $rightMountain == 0 && $topMountain == 1 && $bottomMountain == 1){
							echo '<td class="mountain14"></td>';
						} else if ($leftMountain == 0 && $rightMountain == 1 && $topMountain == 1 && $bottomMountain == 1){
							echo '<td class="mountain15"></td>';
						} else if ($leftMountain == 0 && $rightMountain == 0 && $topMountain == 1 && $bottomMountain == 1){
							echo '<td class="mountain7"></td>';
						} else if ($leftMountain == 1 && $rightMountain == 1 && $topMountain == 0 && $bottomMountain == 0){
							echo '<td class="mountain6"></td>';
						} else if ($leftMountain == 0 && $rightMountain == 0 && $topMountain == 1 && $bottomMountain == 0){
							echo '<td class="mountain8"></td>';
						} else if ($leftMountain == 0 && $rightMountain == 0 && $topMountain == 0 && $bottomMountain == 1){
							echo '<td class="mountain9"></td>';
						} else if ($leftMountain == 0 && $rightMountain == 1 && $topMountain == 0 && $bottomMountain == 0){
							echo '<td class="mountain10"></td>';
						} else if ($leftMountain == 1 && $rightMountain == 0 && $topMountain == 0 && $bottomMountain == 0){
							echo '<td class="mountain11"></td>';
						} else if ($leftMountain == 1 && $rightMountain == 0 && $topMountain == 0 && $bottomMountain == 1){
							echo '<td class="mountain2"></td>';
						} else if ($leftMountain == 0 && $rightMountain == 1 && $topMountain == 0 && $bottomMountain == 1){
							echo '<td class="mountain3"></td>';
						} else if ($leftMountain == 0 && $rightMountain == 1 && $topMountain == 1 && $bottomMountain == 0){
							echo '<td class="mountain4"></td>';
						} else if ($leftMountain == 1 && $rightMountain == 0 && $topMountain == 1 && $bottomMountain == 0){
							echo '<td class="mountain5"></td>';
						} else{
							echo '<td class="mountain1"></td>';
						}
					} else{
						echo '<td class="error"></td>';
					}
				}
				echo '</tr>';
			}
			echo '</table>';
			?>
        </div>
    </body>
</html>