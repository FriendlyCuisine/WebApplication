<?php
session_start();
include 'controller.php';
?>
<!DOCTYPE HTML>
<html lang="en">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<head>
    <title>Friend's List - Friendly Cuisine</title>
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
    <h1>Friends</h1>

    <div class="contentBody">
        <div class="container">
            <!-- search friends -->
            <form method="post" action="search.php">
                <input type="text" name="search" placeholder="Search Friends..." size="60">
            </form>
        </div>
    </div>
    <br><br>
    <div class="contentBody">
        <div class="container">
            <?php
            $n = $_SESSION['userID'];
                $query = $conn->query(
                    "SELECT
                        user.userID,
                        user.userFirstName,
                        user.userLastName,
                        user.userProfileImage,
                        friend.friendID
                    FROM
                        user,
                        friend
                    WHERE
                        friend.friendID = '$n' AND user.userID = friend.myID
                    OR
                        friend.myID = '$n' AND user.userID = friend.friendID"
                 );
                while($row = $query->fetch()){
                    $friendName = $row['userFirstName']." ".$row['userLastName'];
                    $friendImage = $row['userProfileImage'];
                    $friendID = $row['friendID'];
            ?>
            <div>
                <div>
                    <a><img src="<?php echo $friendImage; ?>" style="width:50; height:50" class="img-circle"></a>
                </div>
                <div>
                    <div class="pull-right"><a href="friendDelete.php?id=<?php echo $friendID; ?>" class=""> Unfriend </a></div>
                    <div><?php echo $friendName; ?></div>
                </div>
            </div>
            <hr>
            <br><br>
            <?php } ?>
        </div>
    </div>
    <br><br>

</body>

</html>
