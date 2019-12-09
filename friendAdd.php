<?php
include 'controller.php';
    session_start();
    $n = $_SESSION['userID'];

	$myFriendID = $_POST['myFriendID'];
	$conn ->query(
        "INSERT INTO
            Friend (myID, friendID)
        VALUES
            ('$n','$myFriendID')"
    );
 	header('location:friend.php');
?>
