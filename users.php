<?php
require_once('config.php');
session_start();
if ($_SESSION['userID'] != 1){ echo '<script>window.location = "index.php"</script>';;}
// Create connection
$db = $config['db'];
$conn = new mysqli($db['host'],$db['user'],$db['pass'],$db['database']);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$users = $conn->query("SELECT * FROM users");
$rows = $users->num_rows;
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
		<p class="title">Users</p>
		<div class="centralBody">
			<button class="homeButton" onclick="window.location='index.php';"><i class="fa fa-home"></i></button>
			<table id="usersTable">
				<tr>
					<th class="tableHeader">ID</th>
					<th class="tableHeader">username</th>
					<th class="tableHeader">email</th>
				</tr>
				<?php
					for ($i=2; $i<=$rows; $i++){
						$username = $conn->query("SELECT username FROM users WHERE userID = '{$i}'");
						$usernameResult = mysqli_fetch_row($username);
						$username = $usernameResult[0];
						$email = $conn->query("SELECT email FROM users WHERE userID = '{$i}'");
						$emailResult = mysqli_fetch_row($email);
						$email = $emailResult[0];
						echo '<tr class="tableRow"><td id="userIDColumn">' . $i . '</td><td id="usersUsernameColumn">' . $username . '</td><td id="emailColumn">' . $email . '</td></tr>';
					}
				?>
			</table>
		</div>
	</body>
</html>