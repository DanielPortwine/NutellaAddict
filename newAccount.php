<?php
session_start();
if (isset($_SESSION['userID']))	{
	$_SESSION['message'] = 'You are already logged in!';
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
		<script src="script.js"></script>
		<script src="block.js"></script>
	</head>
	<body>
		<?php if (isset($_SESSION['userID'])){echo '<div id="userInformation"><p>' . $_SESSION['username'] . ' - (' . $_SESSION['userID'] . ')</p></div>';} ?>
		<audio autoplay loop src="sounds/creditsShort.wav" type="audio/wav"></audio>
		<p class="title">Create account</p>
		<div class="centralBody">
			<button class="homeButton" onclick="window.location='index.php';"><i class="fa fa-home"></i></button>
			<p class="subtitle">Enter your details:</p><br>
			<form class="formInput" method="post" action="addUser.php">
				<input class="formTextBox" name="username" type="text" maxlength="20" placeholder="username" autofocus required>
				<input class="formTextBox" name="email" type="email" maxlength="70" placeholder="email" required>
				<input class="formTextBox" id="passwordBox" name="password" type="password" maxlength="30" placeholder="password" required>
				<button class="passwordShowHideButton" id="passwordButton" onclick="showHidePassword()"><i class="fa fa-eye-slash"></i></button><br>
				<input class="submitButton" name="submit" type="submit" value="Go">
			</form>
		</div>
	</body>
</html>