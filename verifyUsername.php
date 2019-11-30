<?php
include('configuration.php');
if (!empty($_REQUEST['username'])){
    $stmt = $conn->prepare("SELECT * FROM user WHERE userUsername=? ");
    $stmt->execute([$_REQUEST['username']]);

    if($stmt->rowCount() > 0){
        echo 'true';die();
    }

}

echo 'false';