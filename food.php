<?php
session_start();
include 'controller.php';
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
  <title>Food & Drink - Friendly Cuisine</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="keywords" content="Friendly Cuisine">
  <?php include 'resources.php'; ?>
</head>

<header>
  <?php include 'header.php'; ?>
</header>
<?php if($_SESSION['loggedin'] == true) { ?>
<body>
  <?php if(!isset($_GET['r'])) { echo "<h1>Restaurants</h1>"; } ?>
  <div id="wrapper">
    <div class="restaurantWrapper">
      <?php include 'restaurant.php'; ?>
      <form action="" method="post">
        <input type="text" id="restaurantSearchInput" name="restaurantSearchInput" value="<?php if(isset($_GET['s'])){ echo $_GET['s']; } ?>" <?php if(!isset($_GET['s']) && !isset($_GET['r'])){ echo "autofocus"; } ?>>
        <input type="submit" id="searchRestaurantBtn" name="searchRestaurant" value="Search">
      </form>
      <?php include 'search.php'; ?>
      <?php include 'featured.php'; ?>
      <?php include 'createRestaurant.php'; ?>
      <br><br>
    </div>
  </div>
</body>
<?php } else {
  header("location: index.php");
} ?>
</html>
