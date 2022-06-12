<?php
require_once('config.php');
session_start();
$messageBody = $_POST['messageBody'];
$userID = $_SESSION['userID'];
// Create connection
$db = $config['db'];
$conn = new mysqli($db['host'],$db['user'],$db['pass'],$db['database']);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
//add record to db
$sql = "INSERT INTO feedback (messageBody,userID)
VALUES ('{$messageBody}','{$userID}')";
if ($conn->query($sql) === TRUE) {
	echo "Message successful";
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
$_SESSION['message'] = 'Message sent!';
echo '<script>window.location = "index.php"</script>';
?>