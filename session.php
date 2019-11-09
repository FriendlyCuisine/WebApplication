<?php

    if (!isset($_SESSION['userID'])){
        header('location: index.php');
    }

    $session_id = $_SESSION['userID'];
    $session_query = $conn->query(
        "SELECT
            *
        FROM
            user
        WHERE
            userID = '$session_id'"
    );
    $user_row = $session_query->fetch();
    $userUsername = $user_row['userFirstName']." ".$user_row['userLastName'];
    $userProfileImage = $user_row['userProfileImage'];

?>
