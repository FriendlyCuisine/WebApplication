<?php
include 'configuration.php';
$_SESSION['message'] = '';

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

        $sql = "INSERT INTO user (userID, userFirstName, userLastName, userUsername, userEmail, userPassword, Message_messageID) VALUES (:userID, :firstName, :lastName, :username, :email, :password, :userID)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);

        $stmt->execute();

        //If registration is successsful, redirect somewhere
        if($stmt->rowCount() > 0) {
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

  $sql = "SELECT userID, userFirstname, userLastname, userUsername FROM user WHERE userUsername = :username and userPassword = :password";
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
         header("location: dashboard.php");
       }
     }
     else {
        $_SESSION['message'] = "Your Login Name or Password is invalid";
     }
}

//--------------- Update user credentials - settings.php ---------------//
if(isset($_POST['updateCredentials'])) {
  $userID = $_SESSION['userID'];
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];

  $sql = "UPDATE user SET userFirstName = :firstName, userLastName = :lastName WHERE userID = :userID";
  $stmt = $conn->prepare($sql);

  $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
  $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
  $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);

  $stmt->execute();

  $_SESSION['firstName'] = $firstName;
  $_SESSION['lastName'] = $lastName;
  header("location: settings.php");
}
?>
