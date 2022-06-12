<?php
require_once('config.php');
session_start();
// Create connection
$db = $config['db'];
$conn = new mysqli($db['host'],$db['user'],$db['pass'],$db['database']);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$maps = $conn->query("SELECT * FROM maps");
$maps = $maps->fetch_all(MYSQLI_ASSOC);
$rows = $maps->num_rows;
?>
<html>
	<head>
		<title>Nutella Addict</title>
		<meta http-equiv="Cache-control" content="no-cache">
        <link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="icon" href="images/Nutella.ico">
		<script src="block.js"></script>
	</head>
	<body>
		<?php if (isset($_SESSION['userID'])){echo '<div id="userInformation"><p>' . $_SESSION['username'] . ' - (' . $_SESSION['userID'] . ')</p></div>';} ?>
		<audio autoplay loop src="sounds/creditsShort.wav" type="audio/wav"></audio>
		<p class="title">Maps</p>
		<div class="centralBody">
			<button class="homeButton" onclick="window.location='index.php';"><i class="fa fa-home"></i></button>
			<form id="mapLoadSettings" method="get" action="openMap.php">
				<input class="coordinateBox" id="mapIDInput" type="text" maxlength="7" placeholder="mapID" name="mapID" autofocus required>
				<input class="submitButton" id="messageSend" type="submit" name="submit" value="Go">
			</form>
			<div id="maps">
				<?php
				foreach ($maps as $map){
					$mapID = $map['mapID'];
					$mapTypeQuery = $conn->query("SELECT mapType FROM maps WHERE mapID = {$mapID}");
					$mapTypeResult = mysqli_fetch_row($mapTypeQuery);
					$mapType = $mapTypeResult[0];
					$mapNameQuery = $conn->query("SELECT mapName FROM maps WHERE mapID = {$mapID}");
					$mapNameResult = mysqli_fetch_row($mapNameQuery);
					$mapName = $mapNameResult[0];
					$mapUserIDQuery = $conn->query("SELECT userID FROM maps WHERE mapID = {$mapID}");
					$mapUserIDResult = mysqli_fetch_row($mapUserIDQuery);
					$mapUserID = $mapUserIDResult[0];
					$mapUsernameQuery = $conn->query("SELECT username FROM users WHERE userID = {$mapUserID}");
					$mapUsernameResult = mysqli_fetch_row($mapUsernameQuery);
					$mapUsername = $mapUsernameResult[0];
					$mapXQuery = $conn->query("SELECT mapSizeX FROM maps WHERE mapID = {$mapID}");
					$mapXResult = mysqli_fetch_row($mapXQuery);
					$mapX = $mapXResult[0];
					$mapYQuery = $conn->query("SELECT mapSizeY FROM maps WHERE mapID = {$mapID}");
					$mapYResult = mysqli_fetch_row($mapYQuery);
					$mapY = $mapYResult[0];
					echo '
					<div class="mapItem" id="map' . $mapID . '" onclick="document.getElementById(`mapIDInput`).value = `' . $mapID . '`;">
						<p class="mapTitle">' . $mapID . ' - ' . $mapName . '</p>
						<table class="mapDetails"><tr>
							<td class="creatorTitle">' . $mapUsername . '</td>
							<td class="mapDimensions">' . $mapX . ' x ' . $mapY . '</td>
							<td class="mapType">' . $mapType . '</td>
						</tr></table>
					</div>
					';
				}
				?>
			</div>
		</div>
	</body>
</html>