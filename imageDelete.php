<?php
    include 'controller.php';
    $get_id = $_GET['id'];
    $conn->query(
        "DELETE FROM
            Image 
        WHERE 
            imageID='$get_id'");

    header('location: dashboard.php');
?>