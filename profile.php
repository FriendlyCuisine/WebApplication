<?php
    session_start();
    include 'controller.php';
    include 'session.php';
    $profileImage = "";
?>

<!DOCTYPE HTML>
<html lang="en">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<head>
    <title>Profile - Friendly Cuisine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="Friendly Cuisine">
    <?php include 'resources.php'; ?>
</head>
<header>
    <?php
        include 'header.php';
    ?>
</header>
<?php if($_SESSION['loggedin'] == true) { ?>
<body>
  <?php
  $userID = $_GET['id'];
  $sql = "SELECT * FROM User WHERE userID = :userID";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
  $stmt->execute();
  if($stmt->rowCount() == 1) {
    if($row = $stmt->fetchObject()) {
      $profileImage = $row->userProfileImage;
      $fullName = $row->userFirstName." ".$row->userLastName;
      $userBirthday = $row->userBirthday;
      $work = $row->userWork;
      $phone = $row->userPhone;
      $lastActive = $row->userLastActive;
      $desc = $row->userDesc;
    }
  }
  ?>
    <h1><?php echo $fullName; ?></h1>
    <?php echo '<img id="profileImage" name="profileImage" src="'.$profileImage.'">' ?>
    <br>
    <div id="profileIcon">
        <?php if($_SESSION['userID'] == $_GET['id']) { echo "<a href='profileEdit.php'><img class='profileIconApp' src='img/iconEdit.png'></a>"; }
        else {
          echo "<a href=''><img class='profileIconApp' src='img/iconEdit.png'></a>";
        } ?>
        <a href="message.php"><img class="profileIconApp" src="img/iconMessage.png"></a>
        <a href="friend.php"><img class="profileIconApp" src="img/iconFriend.png"></a>
    </div>
    <br><br>
    <div class="contentBody">
        <h2>Information</h2>
        <div class="container">
            <p><b>Name: </b>
                <?php echo $fullName; ?></p>
            <hr>
            <p><b>Birthday: </b>
                <?php echo $userBirthday; ?></p>
            <hr>
            <p><b>Work: </b>
                <?php echo $work; ?></p>
            <hr>
            <p><b>Phone: </b>
                <?php echo $phone; ?></p>
            <hr>
            <p><b>Last Active: </b>
                <?php echo $lastActive; ?></p>
        </div>
    </div>
    <br><br>
    <div class="contentBody">
        <h2>Description</h2>
        <div class="container">
            <p><?php echo $desc; ?></p>
        </div>
    </div>
    <br><br>
</body>
<?php } else {
  header("location: index.php");
} ?>
</html>
