<?php
require_once('config.php');
// Create connection
$db = $config['db'];
$conn = new mysqli($db['host'],$db['user'],$db['pass'],$db['database']);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$userExists = $conn->query("SELECT username FROM users WHERE userID = {$_POST['userID']}");
$userResult = mysqli_fetch_row($userExists);
$username = $userResult[0];
$getSalt = $conn->query("SELECT salt FROM users WHERE userID = {$_POST['userID']}");
$saltResult = mysqli_fetch_row($getSalt);
$getPassword = $conn->query("SELECT password FROM users WHERE userID = {$_POST['userID']}");
$passResult = mysqli_fetch_row($getPassword);
if ($userExists->num_rows > 0){
	if (hash('sha512',$saltResult[0] . $_POST['password']) == $passResult[0]){
		session_start();
		$_SESSION['userID'] = $_POST['userID'];
		$_SESSION['username'] = $username;
	} else {
		$_SESSION['message'] = 'Login failed!';
	}
} else {
	$_SESSION['message'] = 'Login failed!';
	echo $conn->error . '<br>';
}
$conn->close();
echo '<script>window.location = "index.php"</script>';;
?>