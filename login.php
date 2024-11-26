<?php
session_start();
include './inc/dbh.php';
if ($_SESSION && $_SESSION['user']) {
  header('Location: ./index.php');
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Provil | login</title>

  <link rel="stylesheet" href="./css/style.css">
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
  <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js" integrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
  <script src="./js/index.js"></script>

</head>

<body>

  <header>
    <form id="login" action="" method="post">
      <input type="text" name="username" value="" placeholder="username">
      <input type="password" name="password" value="" placeholder="password">
      <input id="loginButton" type="submit" name="" value="login">
    </form>
    <div class="alert"></div>
  </header>

</body>

<script type="text/javascript">
  $('#login').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
      url: "./inc/login-backend.php",
      method: "POST",
      data: new FormData(this),
      contentType: false,
      dataType: "json",
      processData: false,
      success: function(data) {
        if (data[0] == 'yes') {
          $('.alert').html('Je bent aangemeld');
          $('.alert').css({
            'background-color': '#69be6c',
            'padding': '20px'
          });
          $('.alert').slideDown("Slow");
          setTimeout(function() {
            $('.alert').slideUp("Slow");
            $('.alert').css({
              'padding': '0px'
            });
          }, 2000);
          setTimeout(function() {
            window.location.href = "./admin.php";
          }, 2500);
        } else {
          $('.alert').html(data[1]);
          $('.alert').css({
            'background-color': '#dd625d',
            'padding': '20px'
          });
          $('.alert').slideDown("Slow");
          setTimeout(function() {
            $('.alert').slideUp("Slow");
            $('.alert').css({
              'padding': '0px'
            });
          }, 2000);
        }
      }
    })
  });
</script>

</html>