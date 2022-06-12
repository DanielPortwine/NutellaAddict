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
$messages = $conn->query("SELECT * FROM feedback");
$rows = $messages->num_rows;
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
			<table id="feedbackTable">
				<tr>
					<th class="tableHeader">Username</th>
					<th class="tableHeader">Message</th>
				</tr>
				<?php
					for ($i=1; $i<=$rows; $i++){
						$message = $conn->query("SELECT messageBody FROM feedback WHERE messageID = '{$i}'");
						$messageResult = mysqli_fetch_row($message);
						$messageBody = $messageResult[0];
						$user = $conn->query("SELECT userID FROM feedback WHERE messageID = '{$i}'");
						$userResult = mysqli_fetch_row($user);
						$userID = $userResult[0];
						$username = $conn->query("SELECT username FROM users WHERE userID = '{$userID}'");
						$usernameResult = mysqli_fetch_row($username);
						$username = $usernameResult[0];
						echo '<tr class="feedbackTableRow"><td id="usernameColumn">' . $username . '</td><td id="messageColumn">' . $messageBody . '</td></tr>';
					}
				?>
			</table>
		</div>
	</body>
</html>