<?php
require_once('config.php');
session_start();
if (empty($_SESSION['userID'])){ 
	$_SESSION['message'] = 'You are not logged in!';
	echo '<script>window.location = "index.php"</script>';;
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
        <p class="title">Global chat</p>
        <div class="centralBody" id="chatBody">
			<button class="homeButton" onclick="window.location='index.php';"><i class="fa fa-home"></i></button>
			<div id="chat">
				<?php
				// Create connection
                $db = $config['db'];
				$conn = new mysqli($db['host'],$db['user'],$db['pass'],$db['database']);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}
				$query = $conn->query("SELECT * FROM chat");
				$rows = $query->num_rows;
				if ($rows > 100){
					$startValue = $rows - 100;
				} else {
					$startValue = 1;
				}
				for ($i=$startValue; $i<=$rows; $i++){
					$messageUserIDQuery = $conn->query("SELECT userID FROM chat WHERE messageID = '{$i}'");
					$messageUserIDResult = mysqli_fetch_row($messageUserIDQuery);
					$messageUserID = $messageUserIDResult[0];
					$messageUsernameQuery = $conn->query("SELECT username FROM users WHERE userID = '{$messageUserID}'");
					$messageUsernameResult = mysqli_fetch_row($messageUsernameQuery);
					$messageUsername = $messageUsernameResult[0];
					$messageTimestampQuery = $conn->query("SELECT messageTime FROM chat WHERE messageID = '{$i}'");
					$messageTimestampResult = mysqli_fetch_row($messageTimestampQuery);
					$messageTimestamp = gmdate("H:i:s", $messageTimestampResult[0]);
					$messageBodyQuery = $conn->query("SELECT messageBody FROM chat WHERE messageID = '{$i}'");
					$messageBodyResult = mysqli_fetch_row($messageBodyQuery);
					$messageBody = $messageBodyResult[0];
					echo '<p class="message"><span class="messageDetails">' . $messageTimestamp . ' - ' . $messageUsername . ':</span> ' . $messageBody . '</p>';
				}
				if ($rows == 0){
					echo '<br><br>';
				} else if ($rows == 1){
					echo '<br>';
				}
				?>
			</div>
			<form class="chatMessage" method="post" action="sendMessage.php">
				<input class="coordinateBox" id="messageInput" type="text" maxlength="100" placeholder="message" name="messageBody" autofocus required>
				<input class="submitButton" id="messageSend" type="submit" name="submit" value="Go">
			</form>
        </div>
    </body>
</html>