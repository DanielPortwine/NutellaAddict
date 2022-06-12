<?php
session_start();
$start = microtime(true);
if ($_POST['y'] * $_POST['x'] <= 25){
	$_SESSION['message'] = 'Area not big enough!';
	echo '<script>window.location = "mapSettings.php"</script>';
} else if ($_POST['y'] <= 5){
	$_SESSION['message'] = 'y not big enough!';
	echo '<script>window.location = "mapSettings.php"</script>';
} else if ($_POST['x'] <= 5){
	$_SESSION['message'] = 'x not big enough!';
	echo '<script>window.location = "mapSettings.php"</script>';
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
		<?php if (isset($_SESSION['userID'])) { echo '<div id="userInformation"><p>' . $_SESSION['username'] . ' - (' . $_SESSION['userID'] . ')</p></div>'; } ?>
		<audio autoplay loop src="sounds/creditsShort.wav" type="audio/wav"></audio>
        <div id="menuBar">
			<button id="returnButton" onclick="window.open('mapSettings.php','_self')"><i class="fa fa-remove"></i></button>
            <div class="menuItem" id="zoomItem">
                <button class="zoomButton" id="firstZoomButton" onclick="zoomIn()"><i class="fa fa-plus"></i></button>
                <button class="zoomButton" onclick="zoomOut()"><i class="fa fa-minus"></i></button>
            </div>
			<?php if ($_POST['y'] * $_POST['x'] <= 1000) { ?>
				<button class="menuItem" id="uploadButton" onclick="window.location=`uploadMap.php`;"><i class="fa fa-save"></i></button>
			<?php } ?>
            <div class="menuItem">
                <p class="menuItemTitle">Size:  <?php echo $_POST["x"] . ' x ' . $_POST["y"]; ?></p>
            </div>
            <div class="menuItem">
                <?php
                if ($_POST['mapType'] == 1){
                    $mapType = 'Islands';
                } else if ($_POST['mapType'] == 2){
                    $mapType = 'Balanced';
                } else if ($_POST['mapType'] == 3){
                    $mapType = 'Lakes';
                } else if ($_POST['mapType'] == 4){
					$mapType = 'Custom';
				} else if ($_POST['mapType'] == 5 || $_POST['mapType'] == 6){
                    $mapType = 'Experiment';
                } else{
                    $mapType = 'error';
                }
                ?>
                <p class="menuItemTitle">Type: <?php echo $mapType; ?></p>
            </div>
            <div class="menuItem" id="timeTakenBox">
                <p class="menuItemTitle" id="timeBox">Time: </p>
            </div>
            <div class="menuItem" id="timeTakenBox">
                <p class="menuItemTitle">Settings:  <?php echo $_POST["a"] . ' : ' . $_POST['b'] . ' : ' . $_POST['c'] . ' : ' . $_POST['d'] . ' : ' . $_POST['e']; ?></p>
            </div>
        </div>
        <?php
        if(isset($_POST['submit'])){
            $tiles = array();
            $mapSizeX = $_POST['x'];
            $mapSizeY = $_POST['y'];
            $grassChance = 0.4;
            $stoneChance = 0.2;
            $forestChance = 0.2;
            $mountainChance = 0.1;
        
            //random generation of land/water
            function generateLand(){
                global $tiles;
                global $mapSizeX;
                global $mapSizeY;
                for ($y=0; $y<$mapSizeY; $y++){
                    $row = array();
                    for ($x=0; $x<$mapSizeX; $x++){
                        $tile = rand(0,1); //0 = land, 1 = water
                        array_push($row,$tile);
                    }
                    array_push($tiles,$row);
                }
            }
            
            //forms the 'nice' looking land
            function cellAut($strength,$tile,$landRequired,$waterRequired){
                global $tiles;
                global $mapSizeX;
                global $mapSizeY;
                $tempTiles = $tiles; //stores the original tiles array
                for ($y=0; $y<$mapSizeY; $y++){
					//top row
					if ($y == 0){
						$yCheckAbove = $mapSizeY - 1;
					} else{
						$yCheckAbove = $y - 1;
					}
					//bottom row
					if ($y == $mapSizeY - 1){
						$yCheckBelow = 0;
					} else{
						$yCheckBelow = $y + 1;
					}
					for ($x=0; $x<$mapSizeX; $x++){
						//left column
						if ($x == 0){
							$xCheckLeft = $mapSizeX - 1;
						} else{
							$xCheckLeft = $x - 1;
						}
						//right column
						if ($x == $mapSizeX - 1){
							$xCheckRight = 0;
						} else{
							$xCheckRight = $x + 1;
						}
						
						if ((($landRequired == 1 && $tempTiles[$y][$x] != 1) || $landRequired == 0) && (($waterRequired == 1 && $tempTiles[$y][$x] == 1) || $waterRequired == 0)){
							$count = 0;
							//up left
							if ($tempTiles[$yCheckAbove][$xCheckLeft] == $tile){
								$count++;
							}
							//up middle
							if ($tempTiles[$yCheckAbove][$x] == $tile){
								$count++;
							}
							//up right
							if ($tempTiles[$yCheckAbove][$xCheckRight] == $tile){
								$count++;
							}
							//middle left
							if ($tempTiles[$y][$xCheckLeft] == $tile){
								$count++;
							}
							//middle right
							if ($tempTiles[$y][$xCheckRight] == $tile){
								$count++;
							}
							//down left
							if ($tempTiles[$yCheckBelow][$xCheckLeft] == $tile){
								$count++;
							}
							if ($tempTiles[$yCheckBelow][$x] == $tile){
								$count++;
							}
							if ($tempTiles[$yCheckBelow][$xCheckRight] == $tile){
								$count++;
							}
							//check if the number of surrounding tiles of land is more than the strength
							if ($count >= $strength){
								$tiles[$y][$x] = $tile;
							}
							else{
								if ($tile == 0 && $landRequired == 0){
									$tiles[$y][$x] = 1;
								} else if ($tile == 1 && $waterRequired == 0){
									$tiles[$y][$x] = 0;
								}
							}
						}
					}
				}
            }
            
            //randomly adds tile types
            function fillLand(){
                global $tiles;
                global $mapSizeX;
                global $mapSizeY;
                global $grassChance;
                global $stoneChance;
                global $forestChance;
                global $mountainChance;
                $grassAmount = round(100 * $grassChance);
                $stoneAmount = round(100 * $stoneChance);
                $forestAmount = round(100 * $forestChance);
                $mountainAmount = round(100 * $mountainChance);
                $tilesQuantities = array();
                for ($i=0; $i<$grassAmount; $i++){
                    array_push($tilesQuantities,0);
                }
                for ($i=0; $i<$stoneAmount; $i++){
                    array_push($tilesQuantities,2);
                }
                for ($i=0; $i<$forestAmount; $i++){
                    array_push($tilesQuantities,3);
                }
                for ($i=0; $i<$mountainAmount; $i++){
                    array_push($tilesQuantities,4);
                }
                for ($y=0; $y<$mapSizeY; $y++){
                    for ($x=0; $x<$mapSizeX; $x++){
                        if ($tiles[$y][$x] == 0){
                            $tiles[$y][$x] = $tilesQuantities[rand(0,count($tilesQuantities)-1)];
                        }
                    }
                }
            }
            
            //outputs the map
            function showMap(){
                global $tiles;
                global $mapSizeX;
                global $mapSizeY;
                echo '<table id="map">';
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
								$tileVersion = rand(2,4);
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
            }
            
            //adds random land tiles to water tiles
            function add($s,$t){
                global $tiles;
                global $mapSizeX;
                global $mapSizeY;
                for ($y=0; $y<$mapSizeY; $y++){
                    for ($x=0; $x<$mapSizeX; $x++){
                        if ($tiles[$y][$x] == 1){
                            $do = rand(0,$s);
                            if ($do == 1){
                                $tiles[$y][$x] = $t;
                            }
                        }
                    }
                }
            }
            
            //perform map generating cellular automata
            function mapGenerate($a,$b,$c,$d,$e,$f,$tile){
                cellAut($a,$tile,0,0);
				cellAut($b,$tile,0,0);
                for ($i=0; $i<$c; $i++){
                    cellAut(3,$tile,0,0);
                }
                for ($i=0; $i<$d; $i++){
                    if ($tile == 0){
                        add(1,0);
                    } else if ($tile == 1){
                        add(1,1);
                    }
                    cellAut(4,$tile,0,0);
                    cellAut(6,$tile,0,0);
                    cellAut(4,$tile,0,0);
                    for ($i=0; $i<$e; $i++){
                        cellAut(4,$tile,0,0);
                    }
                }
				for ($i=0; $i<$f; $i++){
					cellAut(1,$tile,0,1);
				}
            }
			
			//cellular automata on land tiles to form 'nice' looking land
			function terraformLand($a,$b,$c,$d,$e,$f,$tile){
				for ($i=0; $i<$a; $i++){
                    cellAut($e,$tile,1,0);
                }
                for ($i=0; $i<$b; $i++){
                    cellAut($f,$tile,1,0);
                }
                for ($i=0; $i<$c; $i++){
                    cellAut(6,$tile,1,0);
					cellAut(5,$tile,1,0);
                    for ($x=0; $x<$d; $x++){
                        cellAut(3,$tile,1,0);
                    }
                }
			}
            
			//begin
			generateLand();
			mapGenerate($_POST['a'],$_POST['b'],$_POST['c'],$_POST['d'],$_POST['e'],$_POST['f'],$_POST['tileToUse']);
			fillLand();
			terraformLand(1,0,0,0,3,7,2);
			terraformLand(1,0,0,0,2,7,3);
			terraformLand(1,2,0,0,5,3,4);
			terraformLand(1,0,0,0,3,7,0);
			echo '<br><br><br>';
			showMap();
			$end = microtime(true);
			$time = $end - $start;
			echo '<script>document.getElementById("timeBox").innerHTML = "Time: ' . $time . 's";</script>';
			$_SESSION['tiles'] = $tiles;
			$_SESSION['mapSizeY'] = $mapSizeY;
			$_SESSION['mapSizeX'] = $mapSizeX;
			$_SESSION['mapType'] = $mapType;
        }
        ?>
    </body>
</html>