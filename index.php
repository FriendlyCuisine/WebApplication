<?php
session_start();
include 'controller.php';
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
  <title>Friendly Cuisine</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="keywords" content="Friendly Cuisine">
  <?php include 'resources.php'; ?>
</head>

<header>
  <?php
  include 'header.php';
  include 'login.php';
  include 'signup.php';
  ?>
</header>

<body>
  <img id="fc-logo" src="img/fc-logo.png">
</body>
</html>
