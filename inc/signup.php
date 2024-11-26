<?php

include './dbh.php';

$response = array();

$username = $_POST['username'];
$password = $_POST['password'];

$password = password_hash($password, PASSWORD_DEFAULT);

$id = generateUUID();
$sql = "INSERT INTO `users`(`id`, `username`, `password`) VALUES (?,?,?)";
$statement = $conn->prepare($sql);
$statement->bind_param('sss', $id, $username, $password);
$statement->execute();

echo json_encode($response);

?>