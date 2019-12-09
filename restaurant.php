<?php
include "configuration.php";

if(isset($_GET['r'])) {

  // Check if user has already reviewed restaurant
  $hasVoted = false;
  $isMember = false;
  $isRequested = false;
  $isOwner = false;
  $restaurantOwner = null;
  $restaurantOwnerId = null;

  $userId = $_SESSION['userID'];
  $restaurantId = $_GET['r'];

  // Get RestaurantVote data
  $sql = "SELECT * FROM RestaurantVote WHERE User_userID = :userID AND Restaurant_restaurantID = :restaurantId";
  $stmt = $conn->prepare($sql);

  $stmt->bindParam(':userID', $userId, PDO::PARAM_INT);
  $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
  $stmt->execute();

  // Get Review data (Join User and RestaurantVote tables)
  $sql1 = "SELECT * FROM User JOIN RestaurantVote ON User.userID = RestaurantVote.User_userID WHERE RestaurantVote.Restaurant_restaurantID = :restaurantId ORDER BY RestaurantVote.restaurantVoteID DESC";
  $stmt1 = $conn->prepare($sql1);

  $stmt1->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
  $stmt1->execute();

  // Get restaurant members data //
  $sql2 = "SELECT * FROM User JOIN RestaurantMember ON User.userID = RestaurantMember.userId WHERE RestaurantMember.restaurantId = :restaurantId ORDER BY RAND() DESC LIMIT 3";
  $stmt2 = $conn->prepare($sql2);

  $stmt2->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
  $stmt2->execute();

  // Check RestaurantMember //
  $sql3 = "SELECT * FROM RestaurantMember WHERE restaurantId = :restaurantId AND userId = :userId";
  $stmt3 = $conn->prepare($sql3);

  $stmt3->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
  $stmt3->bindParam(':userId', $userId, PDO::PARAM_INT);
  $stmt3->execute();

  if($stmt3->rowCount() == 1) {
    $isMember = true;
  }

  // Check RestaurantRequest //
  $sql4 = "SELECT * FROM RestaurantRequest WHERE restaurantId = :restaurantId AND userId = :userId";
  $stmt4 = $conn->prepare($sql4);

  $stmt4->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
  $stmt4->bindParam(':userId', $userId, PDO::PARAM_INT);
  $stmt4->execute();

  if($stmt4->rowCount() == 1) {
    $isRequested = true;
  }

  // Check if owner of Restaurant //
  $sql5 = "SELECT * FROM Restaurant WHERE userId = :userId AND restaurantID = :restaurantId";
  $stmt5 = $conn->prepare($sql5);

  $stmt5->bindParam(':userId', $userId, PDO::PARAM_INT);
  $stmt5->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
  $stmt5->execute();

  if($stmt5->rowCount() == 1) {
    $isOwner = true;
  }

  // Get all member requests
  $sql6 = "SELECT * FROM RestaurantRequest WHERE restaurantID = :restaurantId";
  $stmt6 = $conn->prepare($sql6);

  $stmt6->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
  $stmt6->execute();

  // User & Restaurant JOIN
  $sql7 = "SELECT * FROM User JOIN Restaurant ON User.userID = Restaurant.userId WHERE Restaurant.restaurantID = :restaurantId";
  $stmt7 = $conn->prepare($sql7);

  $stmt7->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
  $stmt7->execute();

  if($row = $stmt7->fetchObject()) {
    $restaurantOwner = $row->userUsername;
    $restaurantOwnerId = $row->userID;
  }


  //If already reviewed
  if($stmt->rowCount() == 1) {
    $hasVoted = true;
    $_SESSION['message'] = "Thanks for the review!";
  }

  // Render Restaurant Data
  $sql = "SELECT * FROM Restaurant WHERE restaurantID = :restaurantId";
  $stmt = $conn->prepare($sql);

  $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_STR);
  $stmt->execute();

  if($stmt->rowCount() == 1) {
    if($row = $stmt->fetchObject()) {
      echo "<h1>".$row->restaurantName."</h1>";
      echo "<div id='restaurantSection'>";

      echo "<div id='left'>";
      echo "<div id='restaurantBox'>";
      echo "<img style='width: 200px;height: 200px;' src='".$row->restaurantImage."'><br><span style='font-size:20px;'>".$row->restaurantName."</span> <span style='font-size:10px;'>(<a href='profile.php?id=".$restaurantOwnerId."'>".$restaurantOwner."</a>)</span><br>";
      echo "<span style='font-size:12px;'>".$row->restaurantDesc."</span><br><br>".number_format($row->restaurantRating,1)." out of 5 (".$row->restaurantVote.")<br>";

      for($x = 1; $x <= number_format($row->restaurantRating,0); $x++) {
        echo "<img style='width: 25px;height: 25px;' src='img/star-filled.png'>";
      }


      $negativeStar = (5 - number_format($row->restaurantRating,0));
      for ($x = 1; $x <= $negativeStar; $x++) {
        echo "<img style='width: 25px;height: 25px;' src='img/star.png'>";
      }
      echo "</div>";
      echo "<div id='restaurantRateWrapper'>";
      echo "<div id='restaurantRateTitle'>Rate & Review</div>";
      if(!$hasVoted) {
        echo "<div>";
        echo "<form id='voteForm' action='' method='post'>";
        echo "<label for='one'><img onmouseover='hoverStar1()' onclick='clickStar1();show();' onmouseout='unHoverStar1()' id='star1' src='img/star.png'></label><input type='radio' class='input-hidden' id='one' name='restaurantVote' value='1'>";
        echo "<label for='two'><img onmouseover='hoverStar2()' onclick='clickStar2();show();' onmouseout='unHoverStar2()' id='star2' src='img/star.png'></label><input type='radio' class='input-hidden' id='two' name='restaurantVote' value='2'>";
        echo "<label for='three'><img onmouseover='hoverStar3()' onclick='clickStar3();show();' onmouseout='unHoverStar3()' id='star3' src='img/star.png'></label><input type='radio' class='input-hidden' id='three' name='restaurantVote' value='3'>";
        echo "<label for='four'><img onmouseover='hoverStar4()' onclick='clickStar4();show();' onmouseout='unHoverStar4()' id='star4' src='img/star.png'></label><input type='radio' class='input-hidden' id='four' name='restaurantVote' value='4'>";
        echo "<label for='five'><img onmouseover='hoverStar5()' onclick='clickStar5();show();' onmouseout='unHoverStar5()' id='star5' src='img/star.png'></label><input type='radio' class='input-hidden' id='five' name='restaurantVote' value='5'><br>";
        echo "<textarea id='reviewCommentTextBox' name='f'></textarea><br><div id='reviewSubmitBtn'><input type='submit' name='rateRestaurant' value='Rate!'></div>";
        echo "</form>";
        echo "</div>";
      }
      echo $_SESSION['message'];
      echo "</div>";
      echo "</div>";

      echo "<div id='right'>";
      ?>
    <div id='mapWrapper'>
      <div id='restaurantMapTitle'>
        Map
      </div>
      <br>
      <div id="map">

      </div>
    </div>
    <div id='restaurantGroupWrapper'>
      <div id='restaurantGroupTitle'>
        Verified Members <span style="font-size:14px;">(<?php echo $stmt2->rowCount(); ?>)</span>
      </div>
      <div id="memberWrapper">
      <?php
      if($stmt2->rowCount() >= 1) {
        while($row2 = $stmt2->fetchObject()) {
          echo "<a href='profile.php?id=".$row2->userID."'><img style='width:44px;height:44px;' src='".$row2->userProfileImage."'></a>&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        if($stmt2->rowCount() > 4) {
          echo "<span style='font-size:12px;'><a href='#'>view all</a></span>";
        }
      }
      else {
        echo "<span style='font-size:12px;'>No members found.</span>";
      }

       ?>
     </div>
     <hr id='restaurantHr'>
      <div id='requestWrapper'>
        <?php
        if($isOwner) {
          include 'restaurantRequest.php';
          echo "<a href='food.php?r=".$restaurantId."#rr'><button style='cursor: pointer;' id='checkRequest'>Requests (".$stmt6->rowCount().")</button></a> ";
          echo "<button id='restaurantChat'>Group Chat</button>";
        }
        if($isMember) {
          echo "<form action='' method='post'>";
          echo "<input type='submit' id='isMemberBtn' value='Status: Verified'> ";
          echo "<button id='restaurantChat'>Group Chat</button>";
          echo "</form>";
        }
        if($isRequested) {
          echo "<form action='' method='post'>";
          echo "<input type='submit' id='requestedBtn' value='Membership Requested'>";
          echo "</form>";
        }
        if(!$isMember && !$isRequested && !$isOwner) {
          echo "<form action='' method='post'>";
          echo "<input type='hidden' name='restaurantRequestUserId' value='".$_SESSION['userID']."'>";
          echo "<input type='hidden' name='restaurantRequestRestaurantId' value='".$_GET['r']."'>";
          echo "<input type='submit' id='requestMembershipBtn' name='requestMembership' value='Request Membership'>";
          echo "</form>";
        }
        ?>
      </div>
    </div>
      <script type="text/javascript">

      var X = <?php echo json_encode($row->restaurantX, JSON_HEX_TAG); ?>;
      var Y = <?php echo json_encode($row->restaurantY, JSON_HEX_TAG); ?>;

      var map = L.map('map').setView([X, Y], 9);

        L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=jLwQnnttjgDR2evKsHfv', {
          attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',
        }).addTo(map);
        var marker = L.marker([X, Y]).addTo(map);
      </script>

      <?php
      echo "</div>";

      echo "</div>";

      echo "<div id='restaurantReviewSection'>";
      if($stmt1->rowCount() > 0) {
        echo "<span id='reviewTitle'>Reviews</span> (".$row->restaurantVote.")";
        echo "<div id='restaurantReviewBox'>";
        while($row = $stmt1->fetchObject()) {
          echo "<div id='userCommentLeft'><a href='profile.php?id=".$row->userID."'><img style='border-radius:25px;height: 50px; width 50px;' src='".$row->userProfileImage."'><br>".$row->userUsername."</a></div>";
          echo "<div id='userCommentRight'>".$row->restaurantReview."<br>";

          for ($x = 1; $x <= $row->restaurantVote; $x++) {
            echo "<img style='width: 25px;height: 25px;' src='img/star-filled.png'>";
          }

          $negativeStar = (5 - $row->restaurantVote);

          for ($x = 1; $x <= $negativeStar; $x++) {
            echo "<img style='width: 25px;height: 25px;' src='img/star.png'>";
          }
          echo "</div>";
        }
        echo "</div>";
      }
      else {
        echo "No reviews yet.";
      }
      echo "</div>";
    }
  }
  else {
    echo "<h1>Restaurants</h1>";
    echo "Restaurant not found!";
    echo "<br><br>";
  }
}

?>
