<?php
session_start();
include 'controller.php';
$userID = $_SESSION['userID'];
$id = $_GET['id'];
$conn ->query(
    "DELETE FROM
        friend
    WHERE
        friendID = '$id' and myID = '$userID'");
        header('location:friend.php');
?>
