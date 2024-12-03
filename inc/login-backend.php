<?php
session_start();
include "./dbh.php";

// Array with length 2. First element is refresh or not (yes or no), second element is the message
$message = array('');

$username = $_POST['username'];
$password = $_POST['password'];

if (empty($username) || empty($password)) {
    $message[0] = 'no';
    $message[1] = 'Niet alle velden ingevuld';
} else {
    // Gebruik prepared statements om SQL-injecties te voorkomen
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows < 1) {
        $message[0] = 'no';
        $message[1] = 'Geen gebruiker gevonden';
    } else {
        $row = $result->fetch_assoc();
        // Verifieer het ingevoerde wachtwoord met het gehashte wachtwoord in de database
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $username;
            $message[0] = 'yes';
            $message[1] = $username;
        } else {
            $message[0] = 'no';
            $message[1] = 'Wachtwoord incorrect';
        }
    }
    $stmt->close();
}
echo json_encode($message);
?>
