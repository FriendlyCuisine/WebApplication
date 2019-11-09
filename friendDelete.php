<?php
include 'controller.php';
$id = $_GET['id'];
	$conn ->query(
        "DELETE FROM 
            friend 
        WHERE 
            friendID = '$id'");
	header('location:friend.php');
?>
