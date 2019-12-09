<?php
session_start();
    include 'controller.php';
    $postContent = $_POST['postContent'];
    $n = $_SESSION['userID'];
    $conn->query(
        "INSERT INTO
            post (
                postContent,
                postDatePosted,
                userID
            )
        VALUES (
            '$postContent',
            NOW(),
            '$n')"
    );

    header('location: dashboard.php');
?>
