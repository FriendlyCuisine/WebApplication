<?php
$userId = $_SESSION['userID'];
$isOwner = false;

// Check if owner of Restaurant //
$sql = "SELECT * FROM Restaurant WHERE userId = :userId AND restaurantID = :restaurantId";
$stmt = $conn->prepare($sql);

$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
$stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
$stmt->execute();

if($stmt->rowCount() == 1) {
  $isOwner = true;
}

$sql7 = "SELECT * FROM User JOIN RestaurantRequest ON User.userID = RestaurantRequest.userId WHERE RestaurantRequest.restaurantId = :restaurantId";
$stmt7 = $conn->prepare($sql7);

$stmt7->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
$stmt7->execute();

?>

<div id="rr" class="rr-window">
  <div>
    <a href="" title="Close" class="rr-close">close &times;</a>
    <h1>Verification Requests</h1>
    <?php if($isOwner) {
      if($stmt7->rowCount() > 0) {
        while($row3 = $stmt7->fetchObject()) {
          echo "<li style='margin-left:0px;'><div style='border:1px solid black;height:58px;padding-top:10px;padding-bottom:10px;padding-right:10px;margin-bottom:10px;'>";
          echo "<form action='' method='post' style='float:right;margin-top:15px;'><input type='hidden' name='restaurantId' value='".$restaurantId."'><input type='hidden' name='userId' value='".$row3->userID."'><input id='declineRequestBtn' name='declineRequestBtn' type='submit' value='Decline'></form>";
          echo "<form action='' method='post' style='float:right;margin-top:15px;margin-right:5px;'><input type='hidden' name='restaurantId' value='".$restaurantId."'><input type='hidden' name='userId' value='".$row3->userID."'><input id='acceptRequestBtn' name='acceptRequestBtn' type='submit' value='Accept'></form>";
          echo "<div style='width:100px;'><img style='clear:both;border-radius:25px;height: 30px; width 30px;' src='".$row3->userProfileImage."'><br>".$row3->userUsername."</div>";
          echo "</div></li>";
        }
      }
       else {
         echo "<span style='font-size:12px;'>You have no requests pending.</span>";
       }
    }
     ?>
  </div>
</div>
