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
    <body>
		<?php if (isset($_SESSION['userID'])){echo '<div id="userInformation"><p>' . $_SESSION['username'] . ' - (' . $_SESSION['userID'] . ')</p></div>';} ?>
		<audio autoplay loop src="sounds/creditsShort.wav" type="audio/wav"></audio>
        <p class="title">Credits</p>
        <div class="centralBody" id="chatBody">
			<button class="homeButton" onclick="window.location='index.php';"><i class="fa fa-home"></i></button>
			<br><br>
			<div id="creditBox">
				<p>Developer: <span class="nameCredit">DubWine</span></p>
				<p>Music: <span class="nameCredit">DubWine</span></p>
				<p>Graphics: <span class="nameCredit">DubWine</span></p>
				<p>Web hosting: <span class="nameCredit">Hostinger</span></p>
				<p>Special thanks to: <span class="nameCredit">SnailDestroyer</span><br><span class="nameCredit">Professor</span></p>
			</div>
		</div>
</html>