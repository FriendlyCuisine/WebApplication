<?php
include "configuration.php";

$sql = "SELECT * FROM Restaurant ORDER BY restaurantRating DESC LIMIT 4";
$stmt = $conn->prepare($sql);

$stmt->execute();

$sql1 = "SELECT * FROM Restaurant ORDER BY restaurantID DESC LIMIT 4";
$stmt1 = $conn->prepare($sql1);

$stmt1->execute();

if(!isset($_GET['s']) && !isset($_GET['r'])) {
  echo "<div id='restaurantSearchBoxWrapper'>";
  echo "<div id='topRatedSection'>";
  echo "<div id='topRatedBoxWrapper'>";
  echo "<div style='background-color:#eee;'><span style='font-size:18px;font-weight:400;'>Top Rated</span></div>";

  if($stmt->rowCount() == 4) {
    while($row = $stmt->fetchObject()) {
      echo "<a href='food.php?r=".$row->restaurantID."'><img style='margin-top:3px;width:40px;height:40px;' src='$row->restaurantImage'><br>";
      echo $row->restaurantName."</a><br>";
    }
  }

  echo "</div>";
  echo "</div>";

  echo "<div id='newestSection'>";
  echo "<div id='newestBoxWrapper'>";
  echo "<div style='background-color:#eee;'><span style='width:200px;font-size:18px;font-weight:400;'>Newest</span></div>";

  if($stmt1->rowCount() == 4) {
    while($row = $stmt1->fetchObject()) {
      echo "<a href='food.php?r=".$row->restaurantID."'><img style='margin-top:3px;width:40px;height:40px;' src='$row->restaurantImage'><br>";
      echo $row->restaurantName."</a><br>";
    }
  }

  echo "</div>";
  echo "</div>";
  echo "</div>";
}

?>
