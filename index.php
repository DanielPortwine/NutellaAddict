<?php
session_start();
if (isset($_SESSION['message'])){ echo '<p id="messageBox">' . $_SESSION['message'] . '</p>'; unset($_SESSION['message']);}
?>
<html>
	<head>
		<title>Nutella Addict</title>
		<meta http-equiv="Cache-control" content="no-cache">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" href="images/Nutella.ico">
		<script src="script.js"></script>
		<script src="block.js"></script>
	</head>
	<body <?php if (isset($_SESSION['message'])){ echo 'onload="hideMessage()"';} ?>>
		<?php if (isset($_SESSION['userID'])){echo '<div id="userInformation"><p>' . $_SESSION['username'] . ' - (' . $_SESSION['userID'] . ')</p></div>';} ?>
		<audio autoplay loop src="sounds/creditsShort.wav" type="audio/wav"></audio>
		<p class="title">Home</p>
		<div class="centralBody">
			<div id="mainMenu">
				<button class="mainButton" onclick="window.location='mapSettings.php';">Generate map</button>
				<button class="mainButton" onclick="window.location='loadMap.php';">Load a map</button>
				<button class="mainButton" onclick="window.location='chat.php';">Global chat</button>
                <?php if (empty($_SESSION['userID'])) { ?>
                    <button class="mainButton" onclick="window.location='newAccount.php';">Create an account</button>
                    <button class="mainButton" onclick="window.location='loginPage.php';">Login</button>
                <?php } else { ?>
				    <button class="mainButton" onclick="window.location='logout.php';">Logout</button>
                <?php } ?>
				<button class="mainButton" onclick="window.location='feedback.php';">Feedback</button>
				<?php if (isset($_SESSION['userID']) && $_SESSION['userID'] == 1) { ?>
                    <button class="mainButton" onclick="window.location=`viewFeedback.php`;">View Feedback</button>
                    <button class="mainButton" onclick="window.location=`users.php`;">Users</button>
                    <button class="mainButton" onclick="window.location=`db.php`;">Database</button>
                <?php } ?>
				<button class="mainButton" onclick="window.location='credits.php';">Credits</button>
				<br><br>
				<button class="mainButton" onclick="window.open('https://www.nutella.com/en/uk');">Nutella's Site</button>
			</div>
		</div>
	</body>
</html>