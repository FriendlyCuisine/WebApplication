<?php
session_start();
include 'controller.php';
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
  <title>Settings - Friendly Cuisine</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="keywords" content="Friendly Cuisine">
  <?php include 'resources.php'; ?>
</head>

<header>
  <?php include 'header.php'; ?>
  <?php include 'disableaccount.php'; ?>
  <script type="text/javascript">
  var fileToRead = document.getElementById("fileToUpload");

  fileToRead.addEventListener("change", function(event) {
      var files = fileToRead.files;
      if (files.length) {
          console.log("Filename: " + files[0].name);
          console.log("Type: " + files[0].type);
          console.log("Size: " + files[0].size + " bytes");
      }

  }, false);
  function myFunction() {
    document.getElementById("checkmark").src = "img/checkmark.png";
  }
  </script>
</header>
<?php if($_SESSION['loggedin'] == true) { ?>
<body>
  <h1>Account Settings</h1>
  <div id="wrapper">
    <div class="leftSection">
      <div class="settingsBoxWrapper">
        <div id="editUserCredentialsBar">
          Edit User Info
        </div>
        <div id="settingsBox">
          <form action="" method="post">
            <label for="firstName">First</label><br>
            <input type="text" id="firstName" name="firstName" value="<?php echo $_SESSION['firstName']; ?>"><br>
            <label for="lastName">Last</label><br>
            <input type="text" id="lastName" name="lastName" value="<?php echo $_SESSION['lastName']; ?>"><br>
            <label for="email">Email</label><br>
            <input type="text" id="email" name="email" value="<?php echo $_SESSION['email']; ?>">&nbsp;&nbsp;<span style="font-size: 13px;color: red;"><?php echo $_SESSION['invalidEmail']; ?></span><br>
            <input type="submit" id="updateCredentialsBtn" name="updateCredentials" value="Update">
          </form>
        </div>
      </div>
    </div>
    <div class="rightSection">
      <div class="settingsBoxWrapper">
        <div id="editUserProfilePicBar">
          Update Profile Pic
        </div>
        <div id="settingsBox">
          <?php echo '<img id="output" style="height: 70px; width: 70px;border-radius:35px;" src="'.$_SESSION['profileImage'].'">' ?><span><img style="vertical-align: text-bottom;" id="checkmark" src=""></span>
          <form action="upload.php" method="post" enctype="multipart/form-data"><br>
            <label id="fileBrowseBtn" for="fileToUpload"><img style="width: 30px; height:30px;vertical-align: middle;" src="img/uploadIcon.png"> Select from Computer</label>
            <input onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0]);myFunction();" type="file" name="fileToUpload" class="fileToUpload" id="fileToUpload"><br><br>
            <hr style="border-top: 1px solid rgba(0, 0, 0, 0.1);border-bottom: 1px solid rgba(255, 255, 255, 0.3);">
            <input type="submit" id="updateCredentialsBtn" name="updateProfilePic" value="Upload">
            <a href="settings.php"><button type="button" class="deleteButton"><span>Cancel</span></button></a>
          </form>
        </div>
      </div>
    </div>
    <br>
    <div class="leftSection">
      <div class="settingsBoxWrapper">
        <div id="editUserPasswordBar">
          Change Password
        </div>
        <div id="settingsBox">
          <form action="" method="post">
            <label for="firstName">Current Password</label><br>
            <input type="password" id="firstName" name="currentPassword" value="">&nbsp;&nbsp;<span style="font-size: 13px;color: red;"><?php echo $_SESSION['badPassword']; ?></span><br>
            <label for="lastName">New Password</label><br>
            <input type="password" id="lastName" name="newPassword" value="">&nbsp;&nbsp;<span style="font-size: 13px;color: red;"><?php echo $_SESSION['invalidPassword']; ?></span><br>
            <label for="email">Confirm New Password</label><br>
            <input type="password" id="email" name="newPasswordConfirm" value="">&nbsp;&nbsp;<span style="font-size: 13px;color: red;"><?php echo $_SESSION['invalidPassword']; ?></span><br>
            <input type="submit" id="updateCredentialsBtn" name="updatePassword" value="Change"><?php if(isset($_GET['p'])) { if($_GET['p'] == "1"){echo "<span style='font-size: 13px;color: green;'> Password Updated!</span>";}  } ?>
          </form>
        </div>
      </div>
    </div>
    <div class="rightSection">
      <div class="settingsBoxWrapper">
        <div id="editUserPrivacyBar">
          Privacy Options
        </div>
        <div id="settingsBox">
          <form action="" method="post">
            <label><input type="checkbox" id="privacyCheckbox" <?php if($_SESSION['userShowStatus'] == 1) echo "checked='checked'"; ?> name="showOnlineStatus" value="1"> Show Online Status</label><br>
            <label><input type="checkbox" id="privacyCheckbox" <?php if($_SESSION['profanityFilter'] == 1) echo "checked='checked'"; ?> name="profanityFilter" value="1"> Profanity Filter</label><br>
            <label><input type="checkbox" id="privacyCheckbox" <?php if($_SESSION['allowMessages'] == 1) echo "checked='checked'"; ?> name="allowMessages" value="1"> Allow Messaging</label><br>
            <input type="submit" id="updateCredentialsBtn" name="updatePrivacy" value="Submit">
          </form>
          <br><br><br>
          <div style="text-align:center;">
            <a href="#removeAccount">
              <button class="deleteButton"><span>Disable Account</span></button>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } else {
  header("location: index.php");
} ?>
</body>
</html>
