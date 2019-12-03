<?php 

  session_start();
  if (!isset($_SESSION['isLoggedIn'])) {
    header("Location: https://shaha8.comp4ww3.com/welcome.html");
    exit();

  }

?>
