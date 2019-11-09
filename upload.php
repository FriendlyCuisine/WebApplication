<?php
session_start();
include "configuration.php";
$target_dir = "img/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if real image
if(isset($_POST["updateProfilePic"])) {
    if($_FILES['fileToUpload']['error'] > 0) {
      //echo "You need to select an image!";
      //$uploadOk = 0;
      //header("location: index.php");
    } else {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
          echo "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
      } else {
          echo "File is not an image.";
          $uploadOk = 0;
      }
    }
}

// If too large
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Validate image
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Upload image
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
  $userID = $_SESSION['userID'];
  $target_file = $target_dir . rand() . $userID . "." . $imageFileType;
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $_SESSION['profileImage'] = $target_file;
    $sql = "UPDATE user SET userProfileImage = :profileImage WHERE userID = :userID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':profileImage', $target_file, PDO::PARAM_STR);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);

    $stmt->execute();
    header("location: settings.php");
  }
  else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>
