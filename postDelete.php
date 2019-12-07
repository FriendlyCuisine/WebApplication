<?php
    include 'controller.php';
    $get_id = $_GET['id'];
    $conn->query(
        "DELETE FROM
            post 
        WHERE 
            postID='$get_id'");

    header('location: dashboard.php');
?>

