<?php 
    include 'controller.php';
    include 'session.php';

	$myFriendID = $_POST['myFriendID'];
	$conn ->query(
        "INSERT INTO 
            friend (myID, myFriendID) 
        VALUES
            ('$session_id','$myFriendID')"
    );
 	header('location:friend.php'); 
?>