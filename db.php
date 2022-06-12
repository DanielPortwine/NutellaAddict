<?php
session_start();
if (isset($_SESSION['message'])){ echo '<p id="messageBox">' . $_SESSION['message'] . '</p>'; unset($_SESSION['message']);}
if ($_SESSION['userID'] != 1){ echo '<script>window.location = "index.php"</script>';;}
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
	<body onload="hideMessage();">
		<?php if (isset($_SESSION['userID'])){echo '<div id="userInformation"><p>' . $_SESSION['username'] . ' - (' . $_SESSION['userID'] . ')</p></div>';} ?>
		<audio autoplay loop src="sounds/creditsShort.wav" type="audio/wav"></audio>
		<p class="title">Database</p>
		<div class="centralBody">
			<button class="homeButton" onclick="window.location='index.php';"><i class="fa fa-home"></i></button>
			<p class="subtitle">Enter your SQL query:</p><br>
			<form class="formInput" method="post" action="sendQuery.php">
				<input class="formTextBox" type="text" placeholder="query" name="query" autofocus required></input><br>
				<input class="submitButton" name="submit" type="submit" value="Go">
			</form>
		</div>
	</body>
</html>