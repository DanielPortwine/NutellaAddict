<?php
require_once('config.php');
session_start();
if ($_SESSION['userID'] != 1){ echo '<script>window.location = "index.php"</script>';}
// Create connection
$db = $config['db'];
$conn = new mysqli($db['host'],$db['user'],$db['pass'],$db['database']);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$sql = $_POST['query'];
if ($conn->query($sql)) {
	$_SESSION['message'] = 'Query successful!';
	echo '<script>window.location = "db.php"</script>';
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>