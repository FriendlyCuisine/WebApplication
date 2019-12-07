<?php
    include 'controller.php';
    include 'session.php';
    $postContent = $_POST['postContent'];
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
            '$session_id')"
    );

    header('location: dashboard.php');
?>