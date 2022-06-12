<?php
require_once('config.php');
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
//generate salt
$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
$salt = '';
for ($i=0; $i<128; $i++) {
	$salt .= $characters[rand(0,35)];
}
//generate hashed password
$hashedPass = hash('sha512',$salt . $password);
// Create connection
$db = $config['db'];
$conn = new mysqli($db['host'],$db['user'],$db['pass'],$db['database']);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
//add record to db
$sql = "INSERT INTO users (username,email,password,salt)
VALUES ('{$username}','{$email}','{$hashedPass}','{$salt}')";
if ($conn->query($sql) === TRUE) {
	echo "Account created successfully";
	$userID = $conn->insert_id;
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
$_SESSION['message'] = 'Your userID is: ' . $userID;
echo '<script>window.location = "loginPage.php"</script>';
?>