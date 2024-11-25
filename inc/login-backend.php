<?php
session_start();
include "./dbh.php";

// Array with length 2. First element is refresh or not (yes or no), second element
// is the message that will be displayed
$message = array('');

$username = $_POST['username'];
$password = $_POST['password'];

if (empty($username) || empty($password)) {
  $message[0] = 'no';
  $message[1] = 'Niet alle velden ingevuld';
} else {
  $sql = "SELECT * FROM users WHERE username='$username'";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result);
  if ($resultCheck < 1){
    $message[0] = 'no';
    $message[1] = 'Geen gebruiker gevonden';
  } else {
    if ($row = mysqli_fetch_assoc($result)) {
      if ($password != $row['password']) {
        $message[0] = 'no';
        $message[1] = 'Wachtwoord incorrect';
      } elseif ($password == $row['password']) {
        $_SESSION['user'] = $username;
        $message[0] = 'yes';
        $message[1] = $username;
      }
    }
  }
}
echo json_encode($message);
