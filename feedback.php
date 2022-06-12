<?php
session_start();
if (empty($_SESSION['userID'])){
	$_SESSION['message'] = 'You are not logged in!';
	echo '<script>window.location = "index.php"</script>';
}
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
		<p class="title">Feedback</p>
		<div class="centralBody">
			<button class="homeButton" onclick="window.location='index.php';"><i class="fa fa-home"></i></button>
			<p class="subtitle">Enter your feedback:</p>
			<p class="detail">Max number of characters is 200</p><br>
			<form class="formInput" method="post" action="sendFeedback.php">
				<textarea class="formTextArea" maxlength="200" rows="10" cols="30" placeholder="message" name="messageBody" autofocus required></textarea><br>
				<input class="submitButton" name="submit" type="submit" value="Go">
			</form>
		</div>
	</body>
</html>