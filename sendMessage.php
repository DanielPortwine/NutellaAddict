<?php
require_once('config.php');
session_start();
$messageTime = time();
$userID = $_SESSION['userID'];
$messageBody = $_POST['messageBody'];
// Create connection
$db = $config['db'];
$conn = new mysqli($db['host'],$db['user'],$db['pass'],$db['database']);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
//add record to db
$sql = "INSERT INTO chat (userID,messageTime,messageBody)
VALUES ('{$userID}','{$messageTime}','{$messageBody}')";
if ($conn->query($sql) === TRUE) {
	echo "Message successful";
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
echo '<script>window.location = "chat.php"</script>';
?>