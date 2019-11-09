<?php
    session_start();
    include 'controller.php';
    include 'session.php';
?>

<!DOCTYPE HTML>
<html lang="en">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<head>
    <title>Profile - Friendly Cuisine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="Friendly Cuisine">
    <?php include 'resources.php'; ?>
</head>
<header>
    <?php 
        include 'header.php'; 
    ?>
</header>

<body>
    <h1><?php echo $_SESSION['firstName']." ".$_SESSION['lastName'];?></h1>
    <?php echo '<img id="profileImage" name="profileImage" ;" src="'.$_SESSION['profileImage'].'">' ?>
    <br>
    <div id="profileIcon">
        <a href="profileEdit.php"><img class="profileIconApp" src="img/iconEdit.png"></a>
        <a href="message.php"><img class="profileIconApp" src="img/iconMessage.png"></a>
        <a href="friend.php"><img class="profileIconApp" src="img/iconFriend.png"></a>
    </div>
    <br><br>
    <div class="contentBody">
        <h2>Information</h2>
        <div class="container">
            <?php
                $query = $conn->query(
                    "SELECT 
                        * 
                    FROM 
                        user 
                    WHERE 
                        userID = '$session_id'"
                );
                $row = $query->fetch();
                $userID = $row['userID'];
			?>
            <p><b>Name: </b>
                <?php echo $row['userFirstName']." ".$row['userLastName']; ?></p>
            <hr>
            <p><b>Birthday: </b>
                <?php echo $row['userBirthday']; ?></p>
            <hr>
            <p><b>Work: </b>
                <?php echo $row['userWork']; ?></p>
            <hr>
            <p><b>Phone: </b>
                <?php echo $row['userPhone']; ?></p>
            <hr>
            <p><b>Last Active: </b>
                <?php echo $row['userLastActive']; ?></p>
        </div>
    </div>
    <br><br>
    <div class="contentBody">
        <h2>Description</h2>
        <div class="container">
            <p><?php echo $row['userDesc']; ?></p>
        </div>
    </div>
    <br><br>

</body>

</html>
