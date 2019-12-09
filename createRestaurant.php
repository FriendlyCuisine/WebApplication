<?php
include "configuration.php";

if(!isset($_GET['s']) && !isset($_GET['r'])) {

  $userID = $_SESSION['userID'];
  $sql = "SELECT * FROM Restaurant WHERE userId = :userID";
  $stmt = $conn->prepare($sql);

  $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
  $stmt->execute();
  if($stmt->rowCount() == 1) {
    if($row = $stmt->fetchObject()) {
      echo "<div id='createRestaurantWrapper'>";
      echo "<div id='createRestauranBox'>";
      echo "<div style='text-align:center;background-color:#eee;'><span style='font-size:18px;font-weight:400;'>Restaurant Manager</span></div>";
      echo "<div id='showManageRestaurant' style='margin:auto;width:150px;border:text-align:center;padding:20px;'><button id='showManageRestaurantBtn' onclick='showManageRestaurant();'>Manage Restaurant</button></div>";
      echo "<div id='manageRestaurantForm'>";
      echo "<form action='' method='post'>";
      echo "<label for='newRestaurantName'>Restaurant Name</label><br>";
      echo "<input name='newRestaurantName' type='text' id='newRestaurantName' value='".$row->restaurantName."'><br>";
      echo "<br>";
      echo "<label for='newRestaurantDesc'>Restaurant Description</label><br>";
      echo "<textarea name='newRestaurantDesc' style='width:300px;height:130px;resize:none;' id='newRestaurantDesc'>".$row->restaurantDesc."</textarea><br>";
      echo "<br>";
      echo "<label for='newRestaurantLat'>Latitude</label> ";
      echo "<input name='newRestaurantLat' type='text' id='newRestaurantLat' value='".$row->restaurantX."'>";
      echo "<br>";
      echo "<label for='newRestaurantLong'>Longitude</label> ";
      echo "<input name='newRestaurantLong' type='text' id='newRestaurantLong' value='".$row->restaurantY."'><br>";
      echo "<br>";
      echo "<input type='submit' id='manageRestaurantBtn' name='manageRestaurantBtn' value='Update'>";

      echo "</form>";
      echo "</div>";
      echo "</div>";
      echo "</div>";
      echo "</div>";
    }
  }
  else {
    echo "<div id='createRestaurantWrapper'>";
    echo "<div id='createRestauranBox'>";
    echo "<div style='text-align:center;background-color:#eee;'><span style='font-size:18px;font-weight:400;'>Restaurant Manager</span></div>";
    echo "<div id='showCreateRestaurant' style='margin:auto;width:130px;border:text-align:center;padding:20px;'><button id='showCreateRestaurantBtn' onclick='showCreateRestaurant();'>Add Restaurant</button></div>";
    echo "<div id='createRestaurantForm'>";
    echo "<form action='' method='post'>";
    echo "<label for='newRestaurantName'>Restaurant Name*</label><br>";
    echo "<input name='newRestaurantName' type='text' id='newRestaurantName'>";
    echo "<br>";
    echo "<label for='newRestaurantDesc'>Restaurant Description*</label><br>";
    echo "<textarea name='newRestaurantDesc' style='width:300px;height:130px;resize:none;' id='newRestaurantDesc'></textarea>";
    echo "<br>";
    echo "<input type='checkbox' id='newRestaurantAgree' required> <label for='newRestaurantAgree'>When submitting you hereby declare that this restaurant is totally fake!</label><br>";
    echo "<input type='submit' name='createRestaurantBtn' value='Add'> * required";

    echo "</form>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
  }
}

 ?>
