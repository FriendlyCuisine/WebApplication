<?php
include "configuration.php";

if(isset($_GET['s'])) {
  echo "Results for '<i>".$_GET['s']."'</i><br><br>";

  $search = $_GET['s'];

  if($search == ":popular" || $search == ":newest" || $search == "") {
    if($search == ":popular") {
      $sql = "SELECT * FROM Restaurant ORDER BY restaurantRating DESC";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      while($row = $stmt->fetch()) {
        echo "<div id='searchResultsSection'><div id='searchLeft'><a href='food.php?r=".$row['restaurantID']."'><img style='width: 60px;height: 60px;' src='".$row['restaurantImage']."'></div><div id='searchRight'>".$row['restaurantName']."</a><br>".$row['restaurantDesc']."</div><br></div>";
      }
    }
    if($search == ":newest") {
      $sql = "SELECT * FROM Restaurant ORDER BY restaurantID DESC";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      while($row = $stmt->fetch()) {
        echo "<div id='searchResultsSection'><div id='searchLeft'><a href='food.php?r=".$row['restaurantID']."'><img style='width: 60px;height: 60px;' src='".$row['restaurantImage']."'></div><div id='searchRight'>".$row['restaurantName']."</a><br>".$row['restaurantDesc']."</div><br></div>";
      }
    }
    if($search == "") {
      header("location: food.php");
    }
  } else {
    $sql = "SELECT * FROM Restaurant WHERE restaurantName LIKE :search OR restaurantDesc LIKE :search";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':search', '%'.$search.'%');
    $stmt->execute();
    while($row = $stmt->fetch()) {
      echo "<div id='searchResultsSection'><div id='searchLeft'><a href='food.php?r=".$row['restaurantID']."'><img style='width: 60px;height: 60px;' src='".$row['restaurantImage']."'></div><div id='searchRight'>".$row['restaurantName']."</a><br>".$row['restaurantDesc']."</div><br></div>";
    }
    if($stmt->rowCount() == 0) {
      echo "Not found";
    }
  }

}
?>
