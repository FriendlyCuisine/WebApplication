<?php
include 'configuration.php';
$_SESSION['message'] = '';
$_SESSION['invalidEmail'] = '';
$_SESSION['badPassword'] = '';
$_SESSION['invalidPassword'] = '';

//--------------- User Registration - signup.php ---------------//
if(isset($_POST['signUp'])) {
  $email = $_POST['email'];
  if(!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    //Password must be 8 or more characters
    $password = trim($_POST['password']);
    if(strlen($password) >= 8) {
      if($_POST['password'] == $_POST['confirmpassword']) {

        $sql = $conn->prepare('SELECT Count(*) FROM user');
        $sql->execute();
        $count = $sql->fetchColumn();

        $userID = $count+1;

        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = sha1($_POST['password']);

        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['loggedin'] = true;

        $sql = "INSERT INTO user (userID, userFirstName, userLastName, userUsername, userEmail, userPassword) VALUES (:userID, :firstName, :lastName, :username, :email, :password)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);

        $stmt->execute();

        //If registration is successsful
        if($stmt->rowCount() > 0) {
          $sql = "SELECT userShowStatus, userAllowMessage, userProfanityFilter, userProfileImage FROM user WHERE userID = :userID";
          $stmt = $conn->prepare($sql);

          $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
          $stmt->execute();

          if($stmt->rowCount() == 1) {
            if($row = $stmt->fetchObject()) {
              $_SESSION['userID'] = $userID;
              $_SESSION['userShowStatus'] = $row->userShowStatus;
              $_SESSION['allowMessages'] = $row->userAllowMessage;
              $_SESSION['profanityFilter'] = $row->userProfanityFilter;
              $_SESSION['profileImage'] = $row->userProfileImage;
            }
          }
          $_SESSION['message'] = "Registration succesful! Added $username to the database!";
          header("location: dashboard.php");
        }
        else {
          $_SESSION['message'] = 'Username or email already in use!';
        }
      }
      else {
        $_SESSION['message'] = 'The passwords do not match!';
      }
    }
    else {
      $_SESSION['message'] = 'Password needs to be at least 8 characters!';
    }
  }
  else {
    $_SESSION['message'] = 'Please enter in a valid email address!';
  }
}

//--------------- User Login - login.php ---------------//
if(isset($_POST['logIn'])) {
  $username = $_POST['username'];
  $password = sha1($_POST['password']);

  $sql = "SELECT userID, userFirstname, userLastname, userEmail, userUsername, userShowStatus, userAllowMessage, userProfanityFilter, userProfileImage FROM user WHERE userUsername = :username and userPassword = :password";
  $stmt = $conn->prepare($sql);

  $stmt->bindParam(':username', $username, PDO::PARAM_STR);
  $stmt->bindParam(':password', $password, PDO::PARAM_STR);

  $stmt->execute();

     //If login is successsful, redirect to dashboard
     if($stmt->rowCount() == 1) {
       if($row = $stmt->fetchObject()) {
         session_start();
         $_SESSION['loggedin'] = true;
         $_SESSION['userID'] = $row->userID;
         $_SESSION['username'] = $row->userUsername;
         $_SESSION['firstName'] = $row->userFirstname;
         $_SESSION['lastName'] = $row->userLastname;
         $_SESSION['email'] = $row->userEmail;
         $_SESSION['userShowStatus'] = $row->userShowStatus;
         $_SESSION['allowMessages'] = $row->userAllowMessage;
         $_SESSION['profanityFilter'] = $row->userProfanityFilter;
         $_SESSION['profileImage'] = $row->userProfileImage;
         header("location: dashboard.php");
       }
     }
     else {
        $_SESSION['message'] = "Your Login Name or Password is invalid";
     }
}

//--------------- Update user credentials - settings.php ---------------//
if(isset($_POST['updateCredentials'])) {
  $email = $_POST['email'];
  if(!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    $userID = $_SESSION['userID'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];

    $sql = "UPDATE user SET userFirstName = :firstName, userLastName = :lastName, userEmail = :email WHERE userID = :userID";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
    $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);

    $stmt->execute();

    $_SESSION['firstName'] = $firstName;
    $_SESSION['lastName'] = $lastName;
    $_SESSION['email'] = $email;
    header("location: settings.php");
  }
  else {
    $_SESSION['invalidEmail'] = "Invalid email";
  }
}

//--------------- Update user Password - settings.php ---------------//
if(isset($_POST['updatePassword'])) {
  $currentPassword = sha1($_POST['currentPassword']);
  $username = $_SESSION['username'];

  $sql = "SELECT * FROM user WHERE userUsername = :username and userPassword = :password";
  $stmt = $conn->prepare($sql);

  $stmt->bindParam(':username', $username, PDO::PARAM_STR);
  $stmt->bindParam(':password', $currentPassword, PDO::PARAM_STR);

  $stmt->execute();

  if($stmt->rowCount() == 1) {
    $newPassword = trim($_POST['newPassword']);
    if(strlen($newPassword) >= 8) {
      $newPassword = sha1($newPassword);
      if($_POST['newPassword'] == $_POST['newPasswordConfirm']) {
        $userID = $_SESSION['userID'];

        $sql = "UPDATE user SET userPassword = :password WHERE userID = :userID";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':password', $newPassword, PDO::PARAM_STR);

        $stmt->execute();
        $_SESSION['isPasswordUpdated'] = "Updated";
        header("location: settings.php?p=1");
      }
       else {
         $_SESSION['invalidPassword'] = "Not matching!";
       }
    }
    else {
      $_SESSION['invalidPassword'] = "Too short!";
    }
  }
  else {
    $_SESSION['badPassword'] = "Invalid Password";
  }
}

//--------------- Update user privacy - settings.php ---------------//
if(isset($_POST['updatePrivacy'])) {
  $userID = $_SESSION['userID'];

  $showOnlineStatus = isset($_POST['showOnlineStatus']) ? $_POST['showOnlineStatus'] : 0;
  $profanityFilter = isset($_POST['profanityFilter']) ? $_POST['profanityFilter'] : 0;
  $allowMessages = isset($_POST['allowMessages']) ? $_POST['allowMessages'] : 0;

  $sql = "UPDATE user SET userShowStatus = :userShowStatus, userProfanityFilter = :userProfanityFilter, userAllowMessage = :userAllowMessage WHERE userID = :userID";

  $stmt = $conn->prepare($sql);

  $stmt->bindParam(':userShowStatus', $showOnlineStatus, PDO::PARAM_INT);
  $stmt->bindParam(':userProfanityFilter', $profanityFilter, PDO::PARAM_INT);
  $stmt->bindParam(':userAllowMessage', $allowMessages, PDO::PARAM_INT);
  $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);

  $stmt->execute();
  if($stmt->rowCount() == 1) {
    $_SESSION['userShowStatus'] = $showOnlineStatus;
    $_SESSION['profanityFilter'] = $profanityFilter;
    $_SESSION['allowMessages'] = $allowMessages;
  }
}

//--------------- Update changes in profileEdit.php ---------------//
if(isset($_POST['save'])) {
    $userID = $_POST['userID'];
    $userFirstName = $_POST['userFirstName'];
    $userLastName = $_POST['userLastName'];
    $userBirthday = $_POST['userBirthday'];
    $userWork= $_POST['userWork'];
    $userPhone = $_POST['userPhone'];
    $userDesc = $_POST['userDesc'];  

    $conn->query(
            "UPDATE 
                user 
            SET 
                userFirstName = '$userFirstName',
                userLastName = '$userLastName',
                userBirthday ='$userBirthday',
                userWork ='$userWork', 
                userPhone ='$userPhone', 
                userDesc ='$userDesc' 
            WHERE 
                userID = '$userID'"
    );
    header("Location:profile.php?id=" . $_SESSION['userID']);
  }


?>
