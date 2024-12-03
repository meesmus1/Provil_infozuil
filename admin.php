<?php
session_start();
include './inc/dbh.php';
if (!$_SESSION || !$_SESSION['user']) {
  header('Location: ./index.php');
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provil | admin</title>
</head>
<body>
    
</body>
</html>


