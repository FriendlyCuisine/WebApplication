<?php
session_start();
include 'controller.php';
include 'session.php';
?>

<!DOCTYPE HTML>
<html lang="en">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<head>
    <title>Profile Edit - Friendly Cuisine</title>
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
                        userID = '$session_id'");
                $row = $query->fetch();
                $userID = $row['userID'];
			?>

            <form action="" method="post">
                <!--            <form action="profileEditSave.php" method="post">-->
                <!--            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">-->
                <input type="hidden" name="userID" value="<?php echo $userID; ?>">
                First Name:<br><input type="text" name="userFirstName" value="<?php echo $row['userFirstName']; ?>">
                <hr>
                Last Name:<br><input type="text" name="userLastName" value="<?php echo $row['userLastName']; ?>">
                <hr>
                Birthday:<br><input type="text" name="userBirthday" value="<?php echo $row['userBirthday']; ?>">
                <hr>
                Work:<br><input type="text" name="userWork" value="<?php echo $row['userWork']; ?>">
                <hr>
                Phone:<br><input type="text" name="userPhone" value="<?php echo $row['userPhone']; ?>">
                <hr>
                <br><br>
                Description:<br><textarea name="userDesc" rows="10" cols="55" value=""><?php echo $row['userDesc']; ?> </textarea>
                <br><br><br>
                <hr>
                <br>
                <center>
                    <button type="submit" name="cancel" value="cancel" onClick="history.back()">Cancel</button>
                    <button type="submit" name="save" value="save">Save</button>
                </center>
            </form>

            <!--
            <?php
                //validation removed..
                if ($_GET['cancel'] == 'cancel') {
                    // Action
                    print('cancel pressed');
                };
                 if ($_GET['save'] == 'save') {
                    // Action
                    print('save pressed');
                };
            ?>
-->

        </div>
    </div>
    <br><br>


</body>

</html>
